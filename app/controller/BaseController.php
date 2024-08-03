<?php
class BaseController {
    protected function checkLogin() {
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: /gestion/app/view/login/login.php');
            exit();
        }
        return $_SESSION['username'];
    }

    protected function loadView($view, $data = []) {
        extract($data);
        include __DIR__ . '/../view/templates/header.php';
        $viewPath = __DIR__ . '/../view/' . str_replace('.', '/', $view) . '.php';
        //var_dump($viewPath); 
        include $viewPath;
        include __DIR__ . '/../view/templates/footer.php';
    }
}
?>
