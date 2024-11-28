    <?php
    require_once __DIR__ . '/model/ConsumiblesVencidos.php'; 

    $consumiblesVencidosModel = new ConsumiblesVencidos();

    $consumiblesVencidosModel->reducirStockProductosVencidos();

    echo "Stock de productos vencidos reducido a 0.";
    ?>
