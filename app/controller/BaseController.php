<?php
class BaseController {
    protected function checkLogin() {
        date_default_timezone_set('America/Lima');
        session_start();
        if (!isset($_SESSION['correo'])) { 
            header('Location: /gestion/app/view/login/login.php');
            exit();
        }
        return $_SESSION['nombres'];
    }

    protected function loadView($view, $data = []) {
        extract($data);
        include __DIR__ . '/../view/templates/header.php';
        $viewPath = __DIR__ . '/../view/' . str_replace('.', '/', $view) . '.php';
        include $viewPath;
        include __DIR__ . '/../view/templates/footer.php';
    }
}


?>
