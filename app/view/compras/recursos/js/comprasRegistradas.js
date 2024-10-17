
$(document).ready(function() {
    var table = $('#comprasTable').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Excel',
                title: 'Compras_Registradas'
            },
            {
                extend: 'pdf',
                text: 'PDF',
                title: 'Compras_Registradas',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: 'Imprimir',
                title: 'Compras Registradas',
                customize: function (win) {
                    try {
                        var totalGasto = JSON.parse('<?php echo json_encode(number_format($totalGasto, 2)); ?>');
                        console.log('Total Gasto:', totalGasto);
                    } catch (error) {
                        console.error('Error al procesar totalGasto:', error);
                    }
                    
                    try {
                        var resumenMetodos = JSON.parse('<?php echo json_encode(array_filter($totalesPorMetodo, function($total) { return $total > 0; })); ?>');
                        console.log('Resumen Métodos:', resumenMetodos);
                    } catch (error) {
                        console.error('Error al procesar resumenMetodos:', error);
                    }
                    
                    $(win.document.body).append(
                        '<div class="alert alert-info mt-4">' +
                            '<strong>Total del Día: </strong>' + totalGasto + ' Soles' +
                        '</div>' +
                        '<h2 class="mt-4">Resumen por Método de Pago</h2>' +
                        '<div class="mt-4">' +
                            Object.keys(resumenMetodos).map(function(metodo) {
                                var total = resumenMetodos[metodo];
                                var alertClass = metodo === 'Efectivo' ? 'primary' : 
                                                 metodo === 'Visa' ? 'success' : 
                                                 metodo === 'Yape' ? 'warning' :
                                                 metodo === 'Plin' ? 'danger' :  
                                                 'info';
                                return '<div class="alert alert-' + alertClass + ' mt-2">' +
                                        '<strong>' + metodo + ':</strong> ' +
                                        total.toFixed(2) + ' Soles' +
                                       '</div>';
                            }).join('')
                        + '</div>'
                    );
                }
            }
        ]
    });
});