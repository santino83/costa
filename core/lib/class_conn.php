<?php

namespace Costa;

use PDO;

class class_conn extends class_config{

    private $conn;

    public function __construct(){

        //$this->Crea_Connection_string();
    }


    public function crea_connection_string(){

        try{

            $string = "mysql:host=" . class_config::$db_server .";port=3306;dbname=" . class_config::$db_name  .";charset=utf8";

            $option =array( PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES UTF8",
                PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES, true
            );

            $this->conn = new PDO($string,Class_Config::$db_user,Class_Config::$db_pass,$option);

        }catch(PDOException $e){
            error_log("<!-- ERRORE DI CONNESSIONE !!!! ->".$e->getMessage());
            die();
        }

        return $this->conn;
    }

    public function connetti(){

        return $this->conn;
    }
}
