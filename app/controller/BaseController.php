<?php

class BaseController {
    protected function loadView($view, $data = []) {
        extract($data);
        include "../view/templates/header.php";
        include "../view/$view.php";
        include "../view/templates/footer.php";
    }

    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
}
?>
