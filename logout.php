<?php
session_start();
session_unset();
session_destroy();
header("Location: /gestion/app/view/login/login.php");
exit;
?>
