<?php
session_start();
session_destroy();
header('Location: app/controller/loginController.php?action=login');
exit();
?>
