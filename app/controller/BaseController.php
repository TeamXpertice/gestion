<?php

class BaseController {
    protected function loadView($view, $data = []) {
        extract($data);
        $viewPath = str_replace('.', '/', $view);
        include $_SERVER['DOCUMENT_ROOT'] . "/gestion/app/view/templates/header.php";
        include $_SERVER['DOCUMENT_ROOT'] . "/gestion/app/view/{$viewPath}.php";
        include $_SERVER['DOCUMENT_ROOT'] . "/gestion/app/view/templates/footer.php";
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    protected function checkLogin() {
        session_start();
        if (!isset($_SESSION['username'])) {
            $this->redirect('/gestion/app/view/login/login.php');
        }
    }
}
?>
