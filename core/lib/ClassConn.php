<?php

namespace Costaplus;

use PDO;

class ClassConn{

    private $conn;

    /**
     * @var string
     */
    private $server;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;


    public function __construct(){

        //$this->Crea_Connection_string();
    }


    public function crea_connection_string(){

        try{

            $dsn = "mysql:host=" . $this->server .";port=".$this->port.";dbname=" . $this->name  .";charset=utf8";

            $option =array( PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES UTF8",
                PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES, true
            );

            $this->conn = new PDO($dsn, $this->user,$this->password,$option);

        }catch(PDOException $e){
            error_log("<!-- ERRORE DI CONNESSIONE !!!! ->".$e->getMessage());
            die();
        }

        return $this->conn;
    }

    public function connetti(){

        return $this->conn;
    }

    /**
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param string $server
     * @return ClassConn
     */
    public function setServer($server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return ClassConn
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ClassConn
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return ClassConn
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return ClassConn
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

}
