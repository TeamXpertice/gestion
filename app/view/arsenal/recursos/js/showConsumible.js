let consumiblesSeleccionados = {};
function guardarConsumiblesSeleccionados() {
    if (Object.keys(consumiblesSeleccionados).length > 0) {
        actualizarVistaPrevia();
        $('#modalConsumibles').removeClass('show').css('display', 'none');

    }
}
function borrarConsumiblesSeleccionados() {
    consumiblesSeleccionados = {};
    actualizarVistaPrevia();
    document.querySelectorAll('#listaConsumibles input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}

const toggleButton = document.getElementById('toggleCompuestos');
const cardCompuestos = document.getElementById('cardCompuestos');
const cardSimples = document.getElementById('cardSimples');
const cardSimplesCol = cardSimples.classList;
const cardCompuestosCol = cardCompuestos.classList;

window.addEventListener('DOMContentLoaded', function () {
    cardCompuestos.style.display = 'none';
    cardSimplesCol.add('col-md-12');
    cardSimplesCol.remove('col-md-6');
});

toggleButton.addEventListener('click', function () {
    const isVisible = cardCompuestos.style.display !== 'none';
    cardCompuestos.style.display = isVisible ? 'none' : 'block';
    toggleButton.textContent = isVisible ? 'Mostrar Compuestos' : 'Ocultar Compuestos';

    if (isVisible) {
        cardSimplesCol.remove('col-md-8');
        cardSimplesCol.add('col-md-12');
    } else {
        cardSimplesCol.remove('col-md-12');
        cardSimplesCol.add('col-md-8');
    }
});

function calcularGanancia() {
    var precioUnitario = parseFloat(document.getElementById('precio_unitario').value);
    var stock = parseInt(document.getElementById('stock').value);
    var costeTotal = parseFloat(document.getElementById('coste').value);

    if (isNaN(precioUnitario) || isNaN(stock) || isNaN(costeTotal) || precioUnitario <= 0 || stock <= 0 || costeTotal <= 0) {
        return;
    }
    var gananciaBruta = (precioUnitario * stock) - costeTotal;
    var porcentajeGanancia = ((gananciaBruta / costeTotal) * 100).toFixed(2);
    document.getElementById('gananciaProducto').innerHTML = `Ganancia: S/. ${gananciaBruta.toFixed(2)} (${porcentajeGanancia}%)`;
}

document.getElementById('precio_unitario').addEventListener('input', calcularGanancia);
document.getElementById('stock').addEventListener('input', calcularGanancia);
document.getElementById('coste').addEventListener('input', calcularGanancia);

function agregarDias(id, dias) {
    var fechaInput = document.getElementById(id);
    var fechaActual = new Date(fechaInput.value);
    if (isNaN(fechaActual.getTime())) {
        fechaActual = new Date();
    }
    fechaActual.setDate(fechaActual.getDate() + dias);
    var fechaFormateada = fechaActual.toISOString().split('T')[0];
    fechaInput.value = fechaFormateada;
}

function cargarConsumiblesPorCategoria(categoriaId) {
    if (!categoriaId) {
        document.getElementById('listaConsumibles').innerHTML = '<p>Seleccione una categoría para ver los consumibles.</p>';
        return;
    }

    fetch(`/gestion/app/controller/ArsenalController.php?action=obtenerConsumiblesPorCategoria&categoria_id=${categoriaId}`)
        .then(response => response.json())
        .then(data => {
            const listaConsumibles = document.getElementById('listaConsumibles');
            listaConsumibles.innerHTML = ''; 

            if (data.length > 0) {
                const productosAgrupados = {};
                data.forEach(consumible => {
                    if (!productosAgrupados[consumible.id]) {
                        productosAgrupados[consumible.id] = {
                            id: consumible.id,
                            nombre: consumible.nombre,
                            precio: consumible.precio,
                            lotes: []
                        };
                    }
                    productosAgrupados[consumible.id].lotes.push({ stock: consumible.stock });
                });

                Object.values(productosAgrupados).forEach(producto => {
                    const div = document.createElement('div');
                    div.classList.add('mb-2');

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = `consumible_${producto.id}`;
                    checkbox.value = producto.id;
                    checkbox.classList.add('mr-2');

                    const inputCantidad = document.createElement('input');
                    inputCantidad.type = 'number';
                    inputCantidad.min = 1;
                    inputCantidad.value = 1;
                    inputCantidad.classList.add('ml-2');

                    checkbox.addEventListener('change', function () {
                        if (this.checked) {
                            consumiblesSeleccionados[producto.id] = {
                                id: producto.id,
                                nombre: producto.nombre,
                                cantidad: inputCantidad.value,
                                precio: producto.precio,
                                lotes: producto.lotes
                            };
                        } else {
                            delete consumiblesSeleccionados[producto.id];
                        }
                        actualizarVistaPrevia();
                    });

                    inputCantidad.addEventListener('input', function () {
                        if (checkbox.checked) {
                            consumiblesSeleccionados[producto.id].cantidad = this.value;
                            actualizarVistaPrevia();
                        }
                    });

                    div.appendChild(checkbox);
                    div.appendChild(document.createTextNode(`${producto.nombre} - Precio: S/. ${producto.precio}`));
                    div.appendChild(inputCantidad);
                    listaConsumibles.appendChild(div);
                });
            } else {
                listaConsumibles.innerHTML = '<p>No hay consumibles en esta categoría.</p>';
            }
        })
        .catch(error => {
            console.error('Error al cargar los consumibles:', error);
            document.getElementById('listaConsumibles').innerHTML = '<p>Error al cargar los consumibles.</p>';
        });
}


function actualizarVistaPrevia() {
    const vistaPrevia = document.getElementById('vistaPreviaSeleccion');
    vistaPrevia.innerHTML = '';

    if (Object.keys(consumiblesSeleccionados).length > 0) {
        Object.values(consumiblesSeleccionados).forEach(consumible => {
            const item = document.createElement('div');
            item.textContent = `${consumible.nombre} - Cantidad: ${consumible.cantidad} - Precio Unitario: S/. ${consumible.precio}`;
            const loteDetalles = consumible.lotes.map((lote, index) =>
                `${index + 1}° Lote - Stock: ${lote.stock}`
            ).join(' | ');

            const loteInfo = document.createElement('small');
            loteInfo.textContent = `Detalles de lotes: ${loteDetalles}`;
            item.appendChild(document.createElement('br'));
            item.appendChild(loteInfo);

            vistaPrevia.appendChild(item);
        });
    } else {
        vistaPrevia.innerHTML = '<p>No hay consumibles seleccionados.</p>';
    }
}


$(document).ready(function () {
    function inicializarTabla(selector) {
        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().destroy();
            $(selector).empty(); // Limpia cualquier rastro previo
        }
        $(selector).DataTable({
            language: { url: "/gestion/public/js/SpanishDataTable1.10.21/Spanish.json" },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    title: 'Consumibles_Registrados',
                    className: 'btn-excel'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimir',
                    title: 'Consumibles Registrados',
                    exportOptions: { columns: ':not(:last-child)' },
                    className: 'btn-print'
                }
            ]
        });
    }

    inicializarTabla('#tablaConsumiblesSimples');
    inicializarTabla('#tablaCompuestos');

    
    document.querySelector('form').addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('/gestion/app/controller/ArsenalController.php?action=CrearConsumibleSimple', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Consumible creado!',
                        text: 'El consumible se ha creado exitosamente.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '/gestion/app/controller/ArsenalController.php?action=showConsumible';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al crear el consumible.'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema con la solicitud.'
                });
            });
    });

    document.getElementById('formConsumibleCompuesto').addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        formData.append('componentes', JSON.stringify(consumiblesSeleccionados));

        fetch(this.action, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Consumible compuesto guardado',
                        text: 'El consumible compuesto se ha guardado exitosamente.',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        setTimeout(() => {
                            location.reload();
                        }, 50);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.error || 'Ocurrió un error al guardar el consumible.'
                    });
                }
            })
            .catch(error => console.error('Error al enviar el formulario:', error));
    });
    $('#addCategoriaBtn').on('click', function () {
        const nuevaCategoria = $('#nuevaCategoria').val();
        if (nuevaCategoria) {
            fetch('/gestion/app/controller/ArsenalController.php?action=addCategoria', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `nombre=${encodeURIComponent(nuevaCategoria)}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Categoría agregada!',
                            text: 'La categoría se ha agregado exitosamente.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al agregar la categoría.'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema con la solicitud.'
                    });
                });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Campo vacío',
                text: 'Por favor, ingresa el nombre de la categoría.'
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const toggleCompuestos = document.getElementById('toggleCompuestos');
        const compuestosRows = document.querySelectorAll('.compuesto');

        function toggleCompuestosVisibility() {
            compuestosRows.forEach(row => {
                row.style.display = toggleCompuestos.checked ? 'table-row' : 'none';
            });
        }

        toggleCompuestosVisibility();
        toggleCompuestos.addEventListener('change', toggleCompuestosVisibility);
    });


});
