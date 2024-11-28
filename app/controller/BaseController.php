<?php
class BaseController
{
    protected function checkLogin()
    {
        date_default_timezone_set('America/Lima');
        session_start();
        if (!isset($_SESSION['correo'])) {
            header('Location: /gestion/app/view/login/login.php');
            exit();
        }
        return $_SESSION['nombres'];
    }
    protected function loadView($view, $data = [], $additionalCss = [], $additionalJs = [], $title = 'Sistema')
    {
        extract($data);
        $viewPath = __DIR__ . '/../view/' . str_replace('.', '/', $view) . '.php';
        include __DIR__ . '/../view/templates/layout.php';
    }
}
