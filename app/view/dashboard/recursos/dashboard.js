document.addEventListener("DOMContentLoaded", function () {
    fetch('/gestion/app/controller/DashboardController.php?action=getData')  
        .then(response => response.json())  
        .then(data => {
            const comprasPorMes = data.comprasPorMes;  
            const ventasPorMes = data.ventasPorMes;  

            const meses = [];
            const totalCompras = [];
            const totalVentas = [];
            let totalMes = 0;
            let totalMesAnterior = 0;  

            comprasPorMes.forEach(function (compra) {
                const mes = compra.mes;
                const anio = compra.anio;
                meses.push(getMonthName(mes) + " " + anio); 
                totalCompras.push(compra.total_compras); 
                totalMes += Number(compra.total_compras);  
            });

            ventasPorMes.forEach(function (venta) {
                totalVentas.push(venta.total_ventas);  
                totalMes += Number(venta.total_ventas); 
            });

           
            const totalMesFormatted = totalMes.toFixed(2); 
            document.getElementById("total-gain").textContent = "S/ " + totalMesFormatted;

            const diferencia = totalMes - totalMesAnterior;  
            const porcentaje = totalMesAnterior > 0 ? ((diferencia / totalMesAnterior) * 100).toFixed(2) : 0;
            
           
            const porcentajeElement = document.getElementById("percentage-change");
            if (totalMes > totalMesAnterior) {
                porcentajeElement.innerHTML = `<i class="bi bi-arrow-up"></i> ${porcentaje}%`;
                porcentajeElement.classList.add('text-success');
                porcentajeElement.classList.remove('text-danger');
            } else if (totalMes < totalMesAnterior) {
                porcentajeElement.innerHTML = `<i class="bi bi-arrow-down"></i> ${porcentaje}%`;
                porcentajeElement.classList.add('text-danger');
                porcentajeElement.classList.remove('text-success');
            } else {
                porcentajeElement.innerHTML = `<i class="bi bi-arrow-right"></i> 0%`;  // No hay cambio
                porcentajeElement.classList.add('text-secondary');
                porcentajeElement.classList.remove('text-success', 'text-danger');
            }

            const profit_loss_chart_options = {
                series: [
                    { name: "Ganancias", data: totalVentas }, 
                    { name: "Compras", data: totalCompras }   
                ],
                chart: { type: "bar", height: 200 },
                plotOptions: {
                    bar: { horizontal: false, columnWidth: "55%", endingShape: "rounded" }
                },
                colors: ["#0d6efd", "#dc3545"], 
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ["transparent"] },
                xaxis: { categories: meses }, 
                fill: { opacity: 1 },
                tooltip: {
                    y: { formatter: function (val) { return "S/ " + Number(val).toFixed(2); } } 
                }
            };

            const profit_loss_chart = new ApexCharts(document.querySelector("#profit-loss-chart"), profit_loss_chart_options);
            profit_loss_chart.render();
        })
        .catch(error => {
            console.error('Error al obtener los datos:', error);
        });
});

function getMonthName(month) {
    const months = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];
    return months[month - 1];
}



    // // Inicializar el gráfico de ventas si el elemento existe
    // const salesElement = document.querySelector("#sales-chart");
    // if (salesElement) {
    //     const sales_chart = new ApexCharts(salesElement, sales_chart_options);
    //     sales_chart.render();
    // } else {
    //     console.warn("El elemento #sales-chart no existe en el DOM.");
    // }
