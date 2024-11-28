function handleResponse(response) {
    if (response.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.message,
        }).then(() => {
            location.reload();
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message,
        });
    }
}

document.getElementById('formCrearCategoria').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('/gestion/app/controller/CategoriaController.php?action=crearCategoria', {
        method: 'POST',
        body: formData,
    })
        .then((res) => res.json())
        .then(handleResponse);
});

document.getElementById('formEditCategoria').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('/gestion/app/controller/CategoriaController.php?action=editarCategoria', {
        method: 'POST',
        body: formData,
    })
        .then((res) => res.json())
        .then(handleResponse);
});

document.getElementById('formDeleteCategoria').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('/gestion/app/controller/CategoriaController.php?action=eliminarCategoria', {
        method: 'POST',
        body: formData,
    })
        .then((res) => res.json())
        .then(handleResponse);
});

const editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', (event) => {
    const button = event.relatedTarget;
    document.getElementById('edit-id').value = button.getAttribute('data-id');
    document.getElementById('edit-nombre').value = button.getAttribute('data-nombre');
});

const deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', (event) => {
    const button = event.relatedTarget;
    document.getElementById('delete-id').value = button.getAttribute('data-id');
    document.getElementById('deleteMessage').textContent = `¿Está seguro de que desea eliminar la categoría "${button.getAttribute('data-nombre')}"?`;
});
