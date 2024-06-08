<?php
include_once(__DIR__."/config.php");

class Connection{

    private $driver = "mysql";
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $errCode = null;
    private $errMsg = null;
    private static $pdo;

    public function __construct(){
        try{
            if(Connection::$pdo == null){
                Connection::$pdo=new PDO("{$this->driver}:host={$this->host};dbname={$this->dbName};charset=utf8",$this->user, $this->pass);
            }
        } catch (PDOException $e){
            die($e->getMessage());
        }
    }

    public function cleanError(){
        $this->errCode = null;
        $this->errMsg = null;
    }

    public function getErrCode(){
        return $this->errCode;
    }

    public function getErrMsg(){
        return $this->errMsg;
    }

    public function getPdo(){
        return Connection::$pdo;
    }

    public function setErrCode($code){
        $this->errCode = $code;
    }

    public function setErrMsg($message){
        $this->errMsg = $message;
    }

    public function getDateTimeFromSpain($date_es){
        $format = 'd/m/Y H:i:s';
        $date = date_create_from_format($format, $date_es);
        return $date->format('Y-m-d H:i:s');
    }

    public function getDateTimeToSpain($date){
        $format = 'Y-m-d H:i:s';
        $date = date_create_from_format($format, $date);
        return $date->format('d/m/Y H:i:s');
    }

    public function getDateFromSpain($date_es){
        $format = 'd/m/Y';
        $date = date_create_from_format($format, $date_es);
        return $date->format('d/m/Y');
    }

    public function getDateToSpain($date){
        $format = 'Y-m-d';
        $date = date_create_from_format($format, $date);
        return $date->format('d/m/Y');
    }
}
?>