document.addEventListener('DOMContentLoaded', function () {
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

    const formEditarCategoria = document.getElementById('formEditarCategoria');
    if (formEditarCategoria) {
        formEditarCategoria.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/gestion/app/controller/CategoriaBienesController.php?action=editarCategoria', {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => handleResponse(data, 'Categoría actualizada exitosamente.'))
                .catch((error) => showError('Ocurrió un error inesperado. Intenta de nuevo.', error));
        });
    }

    const editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nombre').value = nombre;
        });
    }
});
function eliminarCategoriaBien(button) {
    const id = button.getAttribute('data-id');
    const nombre = button.getAttribute('data-nombre');

    if (!id) {
        showError('ID no válido para eliminar la categoría.');
        return;
    }

    Swal.fire({
        title: '¿Está seguro?',
        text: `¿Deseas eliminar la categoría "${nombre}"? Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/gestion/app/controller/CategoriaBienesController.php?action=eliminarCategoria', {
                method: 'POST',
                body: new URLSearchParams({ id }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Categoría eliminada exitosamente.',
                            confirmButtonText: 'Aceptar',
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'No se pudo eliminar la categoría. Verifica que no tenga bienes asociados.',
                            confirmButtonText: 'Aceptar',
                        });
                    }
                })
                .catch((error) => showError('Ocurrió un error inesperado. Intenta de nuevo.', error));
        }
    });
}

function showError(message, error = null) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        confirmButtonText: 'Aceptar',
    });
    if (error) console.error('Error:', error);
}
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

