$('#ventasTable').DataTable({
    dom: 'Bfrtip',
    language: {
        url: "/gestion/public/js/SpanishDataTable1.10.21/Spanish.json"
    },
    buttons: [
        {
            extend: 'excelHtml5',
            text: 'Exportar a Excel',
            title: 'Registro de Ventas',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'print',
            text: 'Imprimir',
            title: 'Registro de Ventas',
            exportOptions: {
                columns: ':visible'
            },
            customize: function (win) {
                $(win.document.body).css('font-family', 'Arial, sans-serif');
                $(win.document.body).css('color', '#333');
                $(win.document.body).css('background-color', '#ffffff');
                $(win.document.body).find('h1').css('text-align', 'center');
                $(win.document.body).append(
                    '<h2 style="text-align: center; color: #124072; font-weight: 600;">Registro de Ventas</h2>'
                );

                $(win.document.body).append(
                    '<div style="margin-top: 20px; text-align: center; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">' +
                        '<h4 style="font-size: 20px; color: #124072; font-weight: bold;">Totales del Día</h4>' +
                        '<p style="font-size: 18px; color: #333;"><strong>Total del Día:</strong> ' + $('#totalDia').text() + ' Soles</p>' +
                        '<div style="display: flex; justify-content: center; gap: 10px;">' +
                            '<div style="padding: 10px; background-color: #17a2b8; color: white; border-radius: 5px; width: 150px;"><strong>Efectivo:</strong> ' + $('.metodo-efectivo').text() + ' Soles</div>' +
                            '<div style="padding: 10px; background-color: #28a745; color: white; border-radius: 5px; width: 150px;"><strong>Visa:</strong> ' + $('.metodo-visa').text() + ' Soles</div>' +
                        '</div>' +
                        '<div style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">' +
                            '<div style="padding: 10px; background-color: #ffc107; color: white; border-radius: 5px; width: 150px;"><strong>Yape:</strong> ' + $('.metodo-yape').text() + ' Soles</div>' +
                            '<div style="padding: 10px; background-color: #17c671; color: white; border-radius: 5px; width: 150px;"><strong>Plin:</strong> ' + $('.metodo-plin').text() + ' Soles</div>' +
                        '</div>' +
                    '</div>'
                );

                $(win.document.body).append('<hr style="border: 1px solid #ccc; margin: 30px 0;">');
                $(win.document.body).find('table').css('width', '100%');
                $(win.document.body).find('table').css('border-collapse', 'collapse');
                $(win.document.body).find('table').find('th').css('background-color', '#124072');
                $(win.document.body).find('table').find('th').css('color', 'white');
                $(win.document.body).find('table').find('th').css('padding', '10px 0px');
                $(win.document.body).find('table').find('td').css('padding', '12px 10px');
                $(win.document.body).find('table').find('td').css('border', '1px solid #ddd');
                $(win.document.body).find('table').find('td').css('text-align', 'center');
                $(win.document.body).find('table tbody tr:nth-child(odd)').css('background-color', '#f8f9fa');
            }
        }
    ],
    footerCallback: function (row, data, start, end, display) {
        var api = this.api();
        var total = api
            .column(3, { page: 'current' }) 
            .data()
            .reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);
        
        $(api.column(3).footer()).html('Total: ' + total.toFixed(2) + ' Soles');
        $('#totalDia').text(total.toFixed(2));
    }
});
