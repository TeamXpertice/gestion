$(document).ready(function() {
    var table = $('#comprasTable').DataTable({
        language: {
            url: "/gestion/public/js/SpanishDataTable1.10.21/Spanish.json"
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar a Excel',
                title: 'Registro de Compras'
            },
            {
                extend: 'pdfHtml5',
                text: 'Exportar a PDF',
                title: 'Registro de Compras',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: 'Imprimir',
                title: 'Compras Registradas',
                customize: function (win) {
                    // Total gasto del día
                    var totalGasto = JSON.parse('<?php echo json_encode(number_format($totalGasto, 2)); ?>');

                    // Totales por método de pago
                    var resumenMetodos = JSON.parse('<?php echo json_encode(array_filter($totalesPorMetodo, function($total) { return $total > 0; })); ?>');

                    // Añadir contenido personalizado
                    $(win.document.body).prepend(
                        '<div style="margin-bottom: 20px; text-align: center;">' +
                            '<h2>Resumen de Compras</h2>' +
                            '<p><strong>Total del Día: </strong>' + totalGasto + ' Soles</p>' +
                        '</div>'
                    );

                    $(win.document.body).append(
                        '<div class="summary mt-4">' +
                            '<h3>Resumen por Método de Pago</h3>' +
                            Object.keys(resumenMetodos).map(function(metodo) {
                                var total = resumenMetodos[metodo];
                                var alertClass = metodo === 'Efectivo' ? 'primary' :
                                                 metodo === 'Visa' ? 'success' :
                                                 metodo === 'Yape' ? 'warning' : 
                                                 metodo === 'Plin' ? 'info' : 
                                                 'secondary';
                                return '<div style="margin: 10px 0; font-weight: bold;">' +
                                        '<span style="color: ' + alertClass + '">' + metodo + ':</span> ' +
                                        total.toFixed(2) + ' Soles' +
                                       '</div>';
                            }).join('') +
                        '</div>'
                    );

                    $(win.document.body).css({
                        'font-family': 'Arial, sans-serif',
                        'text-align': 'center'
                    });
                }
            }
        ]
    });
});
