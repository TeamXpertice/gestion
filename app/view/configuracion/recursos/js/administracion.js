function handleResponse(response, successMessage, reload = true) {
    if (response.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: successMessage || response.message,
            confirmButtonText: 'Aceptar',
        }).then(() => {
            if (reload) location.reload();
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message,
            confirmButtonText: 'Aceptar',
        });
    }
}
function sendRequest(url, method, body, successMessage, reload = true) {
    fetch(url, { method, body })
        .then((response) => response.json())
        .then((data) => handleResponse(data, successMessage, reload))
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
document.getElementById('formCrearAdministrador').addEventListener('submit', function (e) {
    e.preventDefault(); 

    const formData = new FormData(this);
    sendRequest(
        '/gestion/app/controller/AdministradorController.php?action=crearAdministrador',
        'POST',
        formData,
        'Administrador creado exitosamente.'
    );
});
document.getElementById('formEditarAdministrador').addEventListener('submit', function (e) {
    e.preventDefault(); 

    const formData = new FormData(this);
    sendRequest(
        '/gestion/app/controller/AdministradorController.php?action=editarAdministrador',
        'POST',
        formData,
        'Administrador editado exitosamente.'
    );
});
document.getElementById('correo').addEventListener('blur', function () {
    const correo = this.value;

    fetch('/gestion/app/controller/AdministradorController.php?action=validarCorreoODni', {
        method: 'POST',
        body: new URLSearchParams({ correo }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'error') {
                this.setCustomValidity('Este correo ya está registrado.');
                Swal.fire('Error', data.message, 'error');
            } else {
                this.setCustomValidity('');
            }
        })
        .catch((error) => console.error('Error:', error));
});
document.getElementById('dni').addEventListener('blur', function () {
    const dni = this.value;

    fetch('/gestion/app/controller/AdministradorController.php?action=validarCorreoODni', {
        method: 'POST',
        body: new URLSearchParams({ dni }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'error') {
                this.setCustomValidity('Este DNI ya está registrado.');
                Swal.fire('Error', data.message, 'error');
            } else {
                this.setCustomValidity('');
            }
        })
        .catch((error) => console.error('Error:', error));
});
function deshabilitarAdministrador(button) {
    const id = button.getAttribute('data-id');
    const currentUserId = document.getElementById('current-user-id').value; // Asume que el ID del usuario actual está en un input oculto

    if (id === currentUserId) {
        Swal.fire({
            icon: 'error',
            title: 'Acción no permitida',
            text: 'No puedes deshabilitar tu propia cuenta.',
            confirmButtonText: 'Aceptar',
        });
        return;
    }

    Swal.fire({
        title: '¿Está seguro?',
        text: 'Esta acción deshabilitará al administrador.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, deshabilitar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            sendRequest(
                '/gestion/app/controller/AdministradorController.php?action=deshabilitarAdministrador',
                'POST',
                new URLSearchParams({ id }),
                'Administrador deshabilitado exitosamente.'
            );
        }
    });
}
document.getElementById('editModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const modal = this;

    modal.querySelector('#edit-id').value = button.getAttribute('data-id');
    modal.querySelector('#edit-nombres').value = button.getAttribute('data-nombres');
    modal.querySelector('#edit-apellidos').value = button.getAttribute('data-apellidos');
    modal.querySelector('#edit-correo').value = button.getAttribute('data-correo');
    modal.querySelector('#edit-dni').value = button.getAttribute('data-dni');
    modal.querySelector('#edit-celular').value = button.getAttribute('data-celular');
    modal.querySelector('#edit-direccion').value = button.getAttribute('data-direccion');
    modal.querySelector('#edit-ocupacion').value = button.getAttribute('data-ocupacion');
});
document.getElementById('edit-password-old').addEventListener('blur', function () {
    const passwordOld = this.value;
    const id = document.getElementById('edit-id').value;

    if (passwordOld.trim() === '') return;

    fetch('/gestion/app/controller/AdministradorController.php?action=validarPassword', {
        method: 'POST',
        body: new URLSearchParams({ id, password_old: passwordOld }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    confirmButtonText: 'Aceptar',
                });
                document.getElementById('edit-password-old').setCustomValidity(data.message);
            } else {
                document.getElementById('edit-password-old').setCustomValidity('');
            }
        })
        .catch((error) => console.error('Error:', error));
});
