

document.addEventListener('DOMContentLoaded', function () {
    $('#categoria_bien_id').select2({
        placeholder: "Seleccione una categoría",
        allowClear: true,
        width: '100%' 
    });
    // Crear Categoría
    const formCrearCategoria = document.getElementById('formCrearCategoria');
    if (formCrearCategoria) {
        formCrearCategoria.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/gestion/app/controller/CategoriaBienesController.php?action=crearCategoria', {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => handleResponse(data, 'Categoría creada exitosamente.'))
                .catch((error) => showError('Ocurrió un error inesperado. Intenta de nuevo.', error));
        });
    }

    // Editar Bien
    const modalEditarBien = document.getElementById('modalEditarBien');
    if (modalEditarBien) {
        document.querySelectorAll('button[data-bs-target="#modalEditarBien"]').forEach((button) => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const descripcion = this.getAttribute('data-descripcion');
                const proveedor = this.getAttribute('data-proveedor') || 'Sin datos';
                const modelo = this.getAttribute('data-modelo') || 'Sin datos';
                const serieCodigo = this.getAttribute('data-serie_codigo') || 'Sin datos';
                const marca = this.getAttribute('data-marca') || 'Sin datos';
                const estado = this.getAttribute('data-estado') || 'Sin datos';
                const dimensiones = this.getAttribute('data-dimensiones') || 'Sin datos';
                const color = this.getAttribute('data-color') || 'Sin datos';
                const tipoMaterial = this.getAttribute('data-tipo_material') || 'Sin datos';
                const estadoFisico = this.getAttribute('data-estado_fisico_actual') || 'Sin datos';
                const cantidad = this.getAttribute('data-cantidad');
                const coste = this.getAttribute('data-coste') || 'Sin datos';
                const observacion = this.getAttribute('data-observacion') || 'Sin datos';
                const categoriaId = this.getAttribute('data-categoria_id');

                // Asigna los valores a los campos del formulario
                document.getElementById('bienId').value = id;
                document.getElementById('categoria_bien_id').value = categoriaId;
                document.getElementById('descripcion_bien').value = descripcion;
                document.getElementById('nombre_proveedor').value = proveedor;
                document.getElementById('modelo').value = modelo;
                document.getElementById('serie_codigo').value = serieCodigo;
                document.getElementById('marca').value = marca;
                document.getElementById('estado').value = estado;
                document.getElementById('dimensiones').value = dimensiones;
                document.getElementById('color').value = color;
                document.getElementById('tipo_material').value = tipoMaterial;
                document.getElementById('estado_fisico_actual').value = estadoFisico;
                document.getElementById('cantidad').value = cantidad;
                document.getElementById('coste').value = coste;
                document.getElementById('observacion').value = observacion;
            });
        });
    }

    // Crear Bien
    const formCrearBien = document.getElementById('formCrearBien');
    if (formCrearBien) {
        formCrearBien.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/gestion/app/controller/BienController.php?action=crearBien', {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.message,
                            confirmButtonText: 'Aceptar',
                        }).then(() => {
                            window.location.href = '/gestion/app/controller/BienController.php?action=listarBienes';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonText: 'Aceptar',
                        });
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error inesperado. Intenta de nuevo.',
                        confirmButtonText: 'Aceptar',
                    });
                    console.error('Error:', error);
                });
        });
    }

    // Editar Bien
    const formEditarBien = document.getElementById('formEditarBien');
    if (formEditarBien) {
        formEditarBien.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/gestion/app/controller/BienController.php?action=editarBien', {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualización exitosa!',
                            text: data.message,
                            confirmButtonText: 'Aceptar',
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonText: 'Aceptar',
                        });
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error inesperado. Intenta de nuevo.',
                        confirmButtonText: 'Aceptar',
                    });
                    console.error('Error:', error);
                });
        });
    }

    // Eliminar Bien
    window.eliminarBien = function (id) {
        if (!id) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'ID no válido para eliminar el bien.',
                confirmButtonText: 'Aceptar',
            });
            return;
        }

        Swal.fire({
            title: '¿Está seguro?',
            text: 'Esta acción eliminará el bien permanentemente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/gestion/app/controller/BienController.php?action=eliminarBien', {
                    method: 'POST',
                    body: new URLSearchParams({ id }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: data.message,
                                confirmButtonText: 'Aceptar',
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message,
                                confirmButtonText: 'Aceptar',
                            });
                        }
                    })
                    .catch((error) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error inesperado. Intenta de nuevo.',
                            confirmButtonText: 'Aceptar',
                        });
                        console.error('Error:', error);
                    });
            }
        });
    };

    // Manejar respuestas genéricas
    function handleResponse(data, successMessage) {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: successMessage || data.message,
                confirmButtonText: 'Aceptar',
            }).then(() => location.reload());
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Algo salió mal.',
                confirmButtonText: 'Aceptar',
            });
        }
    }

    // Manejar errores genéricos
    function showError(message, error = null) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonText: 'Aceptar',
        });
        if (error) console.error('Error:', error);
    }
});

$(document).ready(function () {
    const table = $('#tablaBienes').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Listado de Bienes',
                exportOptions: {
                    columns: ':visible:not(:last-child)',
                },
            },
            {
                extend: 'print',
                title: 'Listado de Bienes',
                exportOptions: {
                    columns: ':visible:not(:last-child)',
                },
            },
        ],
        responsive: true,
        columnDefs: [
            { targets: [-1], orderable: false, searchable: false },
            { targets: [2, 4, 5], visible: false },
        ],
        language: {
            url: '/gestion/public/js/SpanishDataTable1.10.21/Spanish.json',
        },
    });

    $('#toggleColumnFilters').on('change', function () {
        $('#columnFilters').toggle(this.checked);
    });

    // Generar botones dinámicamente
    table.columns().every(function (index) {
        const column = this;
        const columnTitle = $(column.header()).text();

        $('#columnFilters').append(`
            <input type="checkbox" id="filter-column-${index}" class="toggle-column" data-column-index="${index}" ${
            column.visible() ? 'checked' : ''
        } />
            <label for="filter-column-${index}">${columnTitle}</label>
        `);
    });

    // Controlar visibilidad de columnas al hacer clic
    $('#columnFilters').on('change', '.toggle-column', function () {
        const columnIndex = $(this).data('column-index');
        const isVisible = $(this).is(':checked');
        table.column(columnIndex).visible(isVisible);
    });
});

