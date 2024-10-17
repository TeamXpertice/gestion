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

    // El método `loadView` acepta parámetros adicionales para CSS, JS y el título
    protected function loadView($view, $data = [], $additionalCss = [], $additionalJs = [], $title = 'Sistema') {
        extract($data); // Extrae las variables de $data para ser usadas en las vistas

        // Ruta a la vista que queremos cargar
        $viewPath = __DIR__ . '/../view/' . str_replace('.', '/', $view) . '.php';

        // Incluimos el layout principal, que se encargará de cargar el header, footer y la vista
        include __DIR__ . '/../view/templates/layout.php';
    }
}



?>
