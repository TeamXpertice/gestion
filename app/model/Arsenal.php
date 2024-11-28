<?php
require_once 'BaseModel.php';

class Arsenal extends BaseModel
{
    public function getBienes()
    {
        $stmt = $this->db->query("SELECT * FROM bienes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    public function commit()
    {
        return $this->db->commit();
    }

    public function rollback()
    {
        return $this->db->rollBack();
    }

    public function inTransaction()
    {
        return $this->db->inTransaction();
    }
    public function getConsumibles()
    {
        $stmt = $this->db->query("SELECT 
                                    c.nombre AS nombre,
                                    c.descripcion_consumible AS descripcion_consumible,
                                    l.cantidad AS cantidad, 
                                    l.fecha_vencimiento AS fecha_vencimiento,
                                    l.precio_unitario AS precio_unitario
                                  FROM 
                                    consumibles c
                                  LEFT JOIN 
                                    compras_consumibles cc ON c.id = cc.consumible_id
                                  LEFT JOIN 
                                    lotes l ON cc.id = l.compras_consumibles_id
                                  WHERE 
                                    c.es_compuesto = 0  -- Solo consumibles simples
                                  ORDER BY 
                                    c.nombre, l.fecha_vencimiento ASC;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getConsumiblesCompuestos()
    {
        $sql = "
            SELECT 
                c.id, 
                c.nombre, 
                c.descripcion_consumible,
                c.precio_sugerido, 
                GROUP_CONCAT(
                    CONCAT(
                        '{\"nombre\":\"', comp.nombre, 
                        '\",\"cantidad_necesaria\":', cc.cantidad, 
                        ',\"stock\":', l.cantidad, 
                        '}'
                    ) SEPARATOR ','
                ) AS componentes
            FROM 
                consumibles c
            JOIN 
                consumible_componentes cc ON c.id = cc.id_consumible
            JOIN 
                consumibles comp ON cc.id_componente = comp.id
            LEFT JOIN 
                compras_consumibles compr ON comp.id = compr.consumible_id
            LEFT JOIN 
                lotes l ON compr.id = l.compras_consumibles_id
            WHERE 
                c.es_compuesto = 1
            GROUP BY 
                c.id, c.nombre, c.descripcion_consumible, c.precio_sugerido
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Convertir el campo `componentes` en un array JSON válido
        foreach ($result as &$row) {
            $row['componentes'] = '[' . $row['componentes'] . ']';
        }
    
        return $result;
    }
    
    
    public function getConsumiblesPorCategoria($categoriaId)
{
    try {
        $sql = "
        SELECT 
            c.id, 
            c.nombre, 
            l.cantidad AS stock, 
            CASE 
                WHEN c.es_compuesto = 1 THEN c.precio_sugerido 
                ELSE l.precio_unitario 
            END AS precio,
            l.fecha_vencimiento,
            c.es_compuesto 
        FROM consumibles c
        LEFT JOIN compras_consumibles cc ON c.id = cc.consumible_id
        LEFT JOIN lotes l ON cc.id = l.compras_consumibles_id
        WHERE c.categoria_id = :categoriaId AND (c.es_compuesto = 1 OR l.cantidad > 0)
        ORDER BY c.id, l.fecha_vencimiento ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categoriaId', $categoriaId, PDO::PARAM_INT);
        $stmt->execute();
        $consumibles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($consumibles as &$consumible) {
            if ($consumible['es_compuesto'] == 1) {
                $componentes = $this->getComponentesDeCompuesto($consumible['id']);
                $cantidadMaxima = null;

                foreach ($componentes as $componente) {
                    if ($componente['stock'] <= 0) {
                        $cantidadMaxima = 0;
                        break;
                    }

                    $cantidadPosible = floor($componente['stock'] / $componente['cantidad_necesaria']);

                    if ($cantidadMaxima === null || $cantidadPosible < $cantidadMaxima) {
                        $cantidadMaxima = $cantidadPosible;
                    }
                }

                $consumible['cantidad_maxima'] = $cantidadMaxima;
            }
        }

        return $consumibles;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}

    
public function getComponentesDeCompuesto($consumibleId)
{
    $sql = "
    SELECT c.id, c.nombre, l.cantidad AS stock, l.precio_unitario AS precio, cc.cantidad AS cantidad_necesaria
    FROM consumibles c
    JOIN consumible_componentes cc ON c.id = cc.id_componente
    JOIN compras_consumibles compr ON c.id = compr.consumible_id
    JOIN lotes l ON compr.id = l.compras_consumibles_id
    WHERE cc.id_consumible = :consumibleId
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':consumibleId', $consumibleId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    
    public function descontarStock($consumibleId, $cantidadDescontar)
    {
        // Obtención de los lotes de stock disponibles
        $sqlLote = "SELECT id, cantidad FROM lotes 
                    WHERE compras_consumibles_id IN (
                        SELECT id FROM compras_consumibles WHERE consumible_id = :consumible_id
                    ) AND cantidad > 0 
                    ORDER BY fecha_vencimiento ASC";
    
        $stmtLote = $this->db->prepare($sqlLote);
        $stmtLote->bindParam(':consumible_id', $consumibleId, PDO::PARAM_INT);
        $stmtLote->execute();
        $lotes = $stmtLote->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($lotes as $lote) {
            if ($cantidadDescontar <= 0) break;
    
            // Si hay suficiente stock, descontamos
            $cantidadADescontar = min($lote['cantidad'], $cantidadDescontar);
            $cantidadDescontar -= $cantidadADescontar;
    
            // Actualizamos el stock de los lotes
            $sqlUpdate = "UPDATE lotes SET cantidad = cantidad - :cantidad WHERE id = :lote_id";
            $stmtUpdate = $this->db->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':cantidad', $cantidadADescontar, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':lote_id', $lote['id'], PDO::PARAM_INT);
    
            if (!$stmtUpdate->execute()) {
                throw new Exception("Error al descontar el stock del lote {$lote['id']}");
            }
        }
    
        if ($cantidadDescontar > 0) {
            throw new Exception("No hay suficiente stock para completar la venta.");
        }
    }
    
    public function registrarVenta($productos, $metodoPago)
    {
        try {
            $this->db->beginTransaction();
            $totalVenta = 0;
            foreach ($productos as $producto) {
                $totalVenta += $producto['precio'] * $producto['cantidad'];
            }

            $sqlVenta = "INSERT INTO ventas (total, metodo_pago, fecha, created_at) VALUES (:total, :metodo_pago, CURDATE(), NOW())";
            $stmtVenta = $this->db->prepare($sqlVenta);
            $stmtVenta->bindParam(':total', $totalVenta);
            $stmtVenta->bindParam(':metodo_pago', $metodoPago);
            $stmtVenta->execute();
            $ventaId = $this->db->lastInsertId();

            foreach ($productos as $producto) {
                $sqlDetalle = "INSERT INTO ventas_detalles (venta_id, consumible_id, cantidad, precio_unitario) 
                               VALUES (:venta_id, :consumible_id, :cantidad, :precio_unitario)";
                $stmtDetalle = $this->db->prepare($sqlDetalle);
                $stmtDetalle->bindParam(':venta_id', $ventaId);
                $stmtDetalle->bindParam(':consumible_id', $producto['id']);
                $stmtDetalle->bindParam(':cantidad', $producto['cantidad']);
                $stmtDetalle->bindParam(':precio_unitario', $producto['precio']);
                $stmtDetalle->execute();

                if ($producto['es_compuesto']) {  
                    foreach ($producto['componentes'] as $componente) {
                        if (isset($componente['cantidad_necesaria'])) {
                            $cantidadDescontar = $producto['cantidad'] * $componente['cantidad_necesaria'];
                            $this->descontarStock($componente['id'], $cantidadDescontar);
                        } else {
                            error_log("El componente {$componente['id']} no tiene la clave 'cantidad_necesaria'");
                            throw new Exception("El componente {$componente['id']} no tiene la clave 'cantidad_necesaria'");
                        }
                    }
                } else {
                    $this->descontarStock($producto['id'], $producto['cantidad']);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            return false;
        }
    }
  
    public function getAllCategorias()
    {
        $sql = "SELECT * FROM categorias";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function crearConsumibleSimple($nombre, $marca, $unidad_medida, $categoria, $descripcion, $observacion, $stock, $precio_unitario, $fecha_ingreso, $fecha_vencimiento)
    {
        try {
            $this->db->beginTransaction();
            $sqlConsumible = "INSERT INTO consumibles (nombre, marca, unidad_medida, categoria_id, descripcion_consumible, observacion, es_compuesto)
                              VALUES (?, ?, ?, ?, ?, ?, 0)";
            $stmtConsumible = $this->db->prepare($sqlConsumible);
            $stmtConsumible->bindValue(1, $nombre);
            $stmtConsumible->bindValue(2, $marca);
            $stmtConsumible->bindValue(3, $unidad_medida);
            $stmtConsumible->bindValue(4, $categoria);
            $stmtConsumible->bindValue(5, $descripcion);
            $stmtConsumible->bindValue(6, $observacion);

            if (!$stmtConsumible->execute()) {
                throw new Exception("Error al insertar el consumible simple: " . implode(", ", $stmtConsumible->errorInfo()));
            }
            $consumible_id = $this->db->lastInsertId();
            $sqlCompra = "INSERT INTO compras_consumibles (consumible_id, cantidad, costo_unitario, total, fecha_ingreso, fecha_vencimiento)
                          VALUES (?, ?, ?, ?, ?, ?)";
            $stmtCompra = $this->db->prepare($sqlCompra);
            $stmtCompra->bindValue(1, $consumible_id);
            $stmtCompra->bindValue(2, $stock);
            $stmtCompra->bindValue(3, $precio_unitario);
            $stmtCompra->bindValue(4, $precio_unitario * $stock);
            $stmtCompra->bindValue(5, $fecha_ingreso);
            $stmtCompra->bindValue(6, $fecha_vencimiento);

            if (!$stmtCompra->execute()) {
                throw new Exception("Error al insertar la compra: " . implode(", ", $stmtCompra->errorInfo()));
            }
            $compra_id = $this->db->lastInsertId();
            $sqlLote = "INSERT INTO lotes (compras_consumibles_id, cantidad, costo_total, precio_unitario, fecha_ingreso, fecha_vencimiento)
                        VALUES (?, ?, ?, ?, ?, ?)";
            $stmtLote = $this->db->prepare($sqlLote);
            $stmtLote->bindValue(1, $compra_id);
            $stmtLote->bindValue(2, $stock);
            $stmtLote->bindValue(3, $precio_unitario);
            $stmtLote->bindValue(4, $precio_unitario);
            $stmtLote->bindValue(5, $fecha_ingreso);
            $stmtLote->bindValue(6, $fecha_vencimiento);

            if (!$stmtLote->execute()) {
                throw new Exception("Error al insertar el lote: " . implode(", ", $stmtLote->errorInfo()));
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            return false;
        }
    }
    public function crearConsumibleCompuesto($nombre, $categoria, $descripcion, $observacion, $precio_sugerido, $componentes)
    {
        try {
            $this->db->beginTransaction();
            $sqlConsumible = "INSERT INTO consumibles (nombre, categoria_id, descripcion_consumible, observacion, precio_sugerido, es_compuesto)
                              VALUES (?, ?, ?, ?, ?, 1)";
            $stmtConsumible = $this->db->prepare($sqlConsumible);
            $stmtConsumible->bindValue(1, $nombre);
            $stmtConsumible->bindValue(2, $categoria);
            $stmtConsumible->bindValue(3, $descripcion);
            $stmtConsumible->bindValue(4, $observacion);
            $stmtConsumible->bindValue(5, $precio_sugerido);

            if (!$stmtConsumible->execute()) {
                throw new Exception("Error al insertar el consumible compuesto: " . implode(", ", $stmtConsumible->errorInfo()));
            }
            $consumible_id = $this->db->lastInsertId();

            foreach ($componentes as $componente) {
                if (!isset($componente['id']) || !isset($componente['cantidad'])) {
                    throw new Exception("Faltan datos para el componente (id_componente o cantidad).");
                }

                $componente_id = $componente['id'];
                $cantidad = $componente['cantidad'];

                if (empty($componente_id) || empty($cantidad)) {
                    throw new Exception("Datos incompletos para el componente: id_componente o cantidad vacíos.");
                }
                $sqlComponente = "INSERT INTO consumible_componentes (id_consumible, id_componente, cantidad)
                                  VALUES (?, ?, ?)";
                $stmtComponente = $this->db->prepare($sqlComponente);
                $stmtComponente->bindValue(1, $consumible_id);
                $stmtComponente->bindValue(2, $componente_id);
                $stmtComponente->bindValue(3, $cantidad);

                if (!$stmtComponente->execute()) {
                    throw new Exception("Error al insertar el componente: " . implode(", ", $stmtComponente->errorInfo()));
                }
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            return false;
        }
    }
    // Dentro de getVentasPorFecha
    public function getVentasPorFecha($selectedDate)
    {
        $sql = "
            SELECT 
                v.id as venta_id,
                c.nombre as nombre_consumible,  
                cat.nombre as categoria,  
                vd.cantidad as cantidad_total, 
                v.total as total,
                v.fecha as fecha,
                v.metodo_pago as metodo_pago
            FROM ventas v
            JOIN ventas_detalles vd ON v.id = vd.venta_id
            JOIN consumibles c ON vd.consumible_id = c.id
            JOIN categorias cat ON c.categoria_id = cat.id
            WHERE v.fecha = :selectedDate
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':selectedDate', $selectedDate);
        $stmt->execute();
        
        $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $ventas;
    }
    
    
    public function getAllConsumibles()
    {
        $sql = "SELECT * FROM consumibles";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addCategoria($nombre)
    {
        try {
            $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':nombre' => $nombre]);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al agregar la categoría: " . $e->getMessage());
            return false;
        }
    }

    public function deleteConsumible($id)
    {
        $sql = "DELETE FROM consumibles WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    public function getBienById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM bienes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
