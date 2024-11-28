<?php
require_once 'BaseModel.php';

class ArsenalVenta extends BaseModel
{
    // Obtener todas las categorías de consumibles
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     // Obtener los consumibles por categoría (simples y compuestos)
     public function getConsumiblesPorCategoria($categoriaId)
     {
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
     
         // Comprobar el valor de precio para cada consumible compuesto
         foreach ($consumibles as &$consumible) {
             if ($consumible['es_compuesto'] == 1) {
                 $consumible['cantidad_maxima'] = $this->calcularCantidadMaximaCompuesto($consumible['id']);
             }
         }
     
         // Verifica el valor de precio antes de enviarlo
         error_log(print_r($consumibles, true)); // Esto imprimirá los datos en el log de errores de PHP para revisión
     
         return $consumibles;
     }
     
    
    // Obtener los componentes de un consumible compuesto
    private function getComponentesDeCompuesto($consumibleId)
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
        $stmt->bindParam(':consumibleId', $consumibleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        
        
      
        // Calcular la cantidad máxima que se puede crear de un consumible compuesto
        public function calcularCantidadMaximaCompuesto($consumibleId)
        {
            $componentes = $this->obtenerComponentesRecursivos($consumibleId);
            $cantidadMaxima = PHP_INT_MAX;
    
            foreach ($componentes as $componente) {
                $stockDisponible = $this->obtenerStockConsumibleSimple($componente['componente_id']);
                $cantidadPosible = floor($stockDisponible / $componente['cantidad_necesaria']);
                $cantidadMaxima = min($cantidadMaxima, $cantidadPosible);
            }
    
            return $cantidadMaxima;
        }
    
        // Obtener el stock total de un consumible simple sumando todos sus lotes
        private function obtenerStockConsumibleSimple($consumibleId)
        {
            $sql = "
                SELECT SUM(l.cantidad) AS stock_total
                FROM compras_consumibles cc
                JOIN lotes l ON cc.id = l.compras_consumibles_id
                WHERE cc.consumible_id = :consumibleId AND l.cantidad > 0
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':consumibleId', $consumibleId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['stock_total'] ?? 0;
        }
   // Función recursiva para obtener los componentes de un consumible compuesto
   private function obtenerComponentesRecursivos($consumibleId)
   {
       $sql = "
           SELECT c.id AS componente_id, c.nombre, c.es_compuesto, cc.cantidad AS cantidad_necesaria
           FROM consumible_componentes cc
           JOIN consumibles c ON cc.id_componente = c.id
           WHERE cc.id_consumible = :consumibleId
       ";
       $stmt = $this->db->prepare($sql);
       $stmt->bindParam(':consumibleId', $consumibleId, PDO::PARAM_INT);
       $stmt->execute();
       $componentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

       $componentes_finales = [];

       foreach ($componentes as $componente) {
           if ($componente['es_compuesto'] == 1) {
               // Recursivamente obtener los componentes del compuesto
               $subcomponentes = $this->obtenerComponentesRecursivos($componente['componente_id']);
               foreach ($subcomponentes as $subcomponente) {
                   // Sumar la cantidad necesaria en base a la cantidad del compuesto actual
                   $subcomponente['cantidad_necesaria'] *= $componente['cantidad_necesaria'];
                   $componentes_finales[] = $subcomponente;
               }
           } else {
               // Agregar el componente simple
               $componentes_finales[] = $componente;
           }
       }

       return $componentes_finales;
   }
 
  // Obtener el stock total de un consumible simple sumando todos sus lotes
  private function getStockTotal($consumibleId)
  {
      $sql = "SELECT SUM(l.cantidad) AS stock_total
              FROM lotes l
              WHERE l.consumible_id = :consumibleId AND l.cantidad > 0";

      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':consumibleId', $consumibleId, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result['stock_total'] ?? 0;  // Devolvemos 0 si no hay stock
  }

  

   


// Método para obtener componentes de un producto compuesto
public function obtenerComponentesDeConsumibleCompuesto($consumibleId)
{
    $sql = "
        SELECT 
            c.id AS componente_id, 
            c.nombre, 
            c.es_compuesto, 
            cc.cantidad AS cantidad_necesaria
        FROM 
            consumible_componentes cc
        JOIN 
            consumibles c ON cc.id_componente = c.id
        WHERE 
            cc.id_consumible = :consumibleId
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':consumibleId', $consumibleId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


   



















   public function registrarVenta($productos, $metodoPago)
{
    try {
        $this->db->beginTransaction();
        $totalVenta = 0;
        
        // Calcular el total de la venta
        foreach ($productos as $producto) {
            $totalVenta += $producto['precio'] * $producto['cantidad'];
        }

        // Insertar la venta principal
        $sqlVenta = "INSERT INTO ventas (total, metodo_pago, fecha, created_at) VALUES (:total, :metodo_pago, CURDATE(), NOW())";
        $stmtVenta = $this->db->prepare($sqlVenta);
        $stmtVenta->bindParam(':total', $totalVenta);
        $stmtVenta->bindParam(':metodo_pago', $metodoPago);
        $stmtVenta->execute();
        $ventaId = $this->db->lastInsertId();

        // Procesar cada producto en la venta
        foreach ($productos as $producto) {
            // Verifica si `es_compuesto` está definido
            if (!isset($producto['es_compuesto'])) {
                error_log("El producto {$producto['id']} no tiene la clave 'es_compuesto'.");
                throw new Exception("El producto {$producto['id']} no tiene la clave 'es_compuesto'.");
            }
        
            // Insertar el detalle de la venta
            $sqlDetalle = "INSERT INTO ventas_detalles (venta_id, consumible_id, cantidad, precio_unitario) 
                           VALUES (:venta_id, :consumible_id, :cantidad, :precio_unitario)";
            $stmtDetalle = $this->db->prepare($sqlDetalle);
            $stmtDetalle->bindParam(':venta_id', $ventaId);
            $stmtDetalle->bindParam(':consumible_id', $producto['id']);
            $stmtDetalle->bindParam(':cantidad', $producto['cantidad']);
            $stmtDetalle->bindParam(':precio_unitario', $producto['precio']);
            $stmtDetalle->execute();
        
            // Descontar stock según el tipo
            if ($producto['es_compuesto']) {
                $this->descontarComponentes($producto['id'], $producto['cantidad']);
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

// Método para descontar componentes de un producto compuesto
public function descontarComponentes($consumibleId, $cantidadNecesaria)
{
    // Obtener los componentes del producto compuesto
    $sql = "
        SELECT c.id AS componente_id, cc.cantidad AS cantidad_necesaria
        FROM consumible_componentes cc
        JOIN consumibles c ON cc.id_componente = c.id
        WHERE cc.id_consumible = :consumible_id
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':consumible_id', $consumibleId, PDO::PARAM_INT);
    $stmt->execute();
    $componentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($componentes as $componente) {
        $cantidadTotalNecesaria = $cantidadNecesaria * $componente['cantidad_necesaria'];

        if ($this->esCompuesto($componente['componente_id'])) {
            // Si el componente es compuesto, llamada recursiva
            $this->descontarComponentes($componente['componente_id'], $cantidadTotalNecesaria);
        } else {
            // Descontar stock para componentes simples
            $this->descontarStock($componente['componente_id'], $cantidadTotalNecesaria);
        }
    }
}

private function esCompuesto($consumibleId)
{
    $sql = "SELECT es_compuesto FROM consumibles WHERE id = :consumible_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':consumible_id', $consumibleId, PDO::PARAM_INT);
    $stmt->execute();
    return (bool)$stmt->fetchColumn();
}




// Método para descontar el stock de un consumible simple
public function descontarStock($consumibleId, $cantidadDescontar)
{
    $sql = "
        SELECT id, cantidad 
        FROM lotes 
        WHERE compras_consumibles_id IN (
            SELECT id FROM compras_consumibles WHERE consumible_id = :consumible_id
        ) AND cantidad > 0 
        ORDER BY fecha_vencimiento ASC
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':consumible_id', $consumibleId, PDO::PARAM_INT);
    $stmt->execute();
    $lotes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($lotes as $lote) {
        if ($cantidadDescontar <= 0) break;

        $cantidadADescontar = min($lote['cantidad'], $cantidadDescontar);
        $cantidadDescontar -= $cantidadADescontar;

        $sqlUpdate = "UPDATE lotes SET cantidad = cantidad - :cantidad WHERE id = :lote_id";
        $stmtUpdate = $this->db->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':cantidad', $cantidadADescontar, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':lote_id', $lote['id'], PDO::PARAM_INT);

        if (!$stmtUpdate->execute()) {
            throw new Exception("Error al descontar el stock del lote {$lote['id']}");
        }
    }

    if ($cantidadDescontar > 0) {
        throw new Exception("No hay suficiente stock para el producto con ID: {$consumibleId}.");
    }
}




   
}
?>
