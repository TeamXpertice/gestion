<?php
require ('models/conexion.php');

$con= new Conexion();

$usuarios =$con->getUsers();

require ('views/V_verUsuarios.php');
?>