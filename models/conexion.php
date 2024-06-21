<?php

class Conexion {
    private $con;

    public function __construct()
    {
        $this->con= new mysqli('localhost','root','','db_gestion');
    }

    public function getUsers(){
        $quary= $this->con->query('SELECT * FROM usuario');

        $retorno =[];

        $i=0;

        while($fila = $quary->fetch_assoc()){
            $retorno[$i] = $fila;
            $i++;
        }
        return $retorno;
    }
}


?>