<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Administrador.php';

class AdministradorController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new Administrador();
    }

    public function showAdministradores()
    {
        $nombre = $this->checkLogin();
        $administradores = $this->model->getAdministradoresHabilitados();

        $this->loadView(
            'configuracion.administracion',
            [
                'administradores' => $administradores,
                'nombre' => $nombre
            ],
            [],
            [
                '/gestion/app/view/configuracion/recursos/js/administracion.min.js'
            ],
            'Gestión de Administradores'
        );
    }

    // Crear administrador
    public function crearAdministrador()
    {
        $datos = [
            'nombres' => $_POST['nombres'] ?? null,
            'apellidos' => $_POST['apellidos'] ?? null,
            'correo' => $_POST['correo'] ?? null,
            'contrasena' => password_hash($_POST['contrasena'] ?? '', PASSWORD_BCRYPT),
            'dni' => $_POST['dni'] ?? null,
            'celular' => $_POST['celular'] ?? null,
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? null,
            'direccion' => $_POST['direccion'] ?? null,
            'ocupacion' => $_POST['ocupacion'] ?? null,
        ];

        foreach ($datos as $campo => $valor) {
            if (!$valor) {
                echo json_encode(['status' => 'error', 'message' => "El campo {$campo} es obligatorio."]);
                exit;
            }
        }
        if ($this->model->existeCorreoODni($datos['correo'], $datos['dni'])) {
            echo json_encode(['status' => 'error', 'message' => 'El correo o DNI ya están registrados.']);
            exit;
        }
        $this->model->crear($datos);

        echo json_encode(['status' => 'success', 'message' => 'Administrador creado exitosamente.']);
    }

    public function editarAdministrador()
    {
        $id = $_POST['id'];
        $datos = [
            'nombres' => $_POST['nombres'] ?? null,
            'apellidos' => $_POST['apellidos'] ?? null,
            'correo' => $_POST['correo'] ?? null,
            'dni' => $_POST['dni'] ?? null,
            'celular' => $_POST['celular'] ?? null,
            'direccion' => $_POST['direccion'] ?? null,
            'ocupacion' => $_POST['ocupacion'] ?? null,
        ];

        if ($_POST['password_new']) {
            $password_old = $_POST['password_old'];
            $password_new = $_POST['password_new'];

            $admin = $this->model->getAdministradorEditar($id);
            if (!password_verify($password_old, $admin['contrasena'])) {
                echo json_encode(['status' => 'error', 'message' => 'Contraseña actual incorrecta.']);
                exit;
            }

            $datos['contrasena'] = password_hash($password_new, PASSWORD_BCRYPT);
        }

        $this->model->editar($id, $datos);
        echo json_encode(['status' => 'success', 'message' => 'Administrador actualizado correctamente.']);
    }
    // Deshabilitar administrador
    public function deshabilitarAdministrador()
    {
        session_start();
        $idActual = $_SESSION['id']; 
        $idDeshabilitar = $_POST['id'] ?? null;

        if ($idActual == $idDeshabilitar) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No puedes deshabilitar tu propia cuenta.'
            ]);
            exit;
        }

        $this->model->deshabilitar($idDeshabilitar);

        echo json_encode([
            'status' => 'success',
            'message' => 'Administrador deshabilitado exitosamente.'
        ]);
    }
}
$action = $_GET['action'] ?? 'showAdministradores';
$controller = new AdministradorController();
$controller->$action($_GET['id'] ?? null);
