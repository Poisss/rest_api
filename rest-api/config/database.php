<?php
    class Database{
        private $host="localhost";
        private $db_name="api_db";
        private $username="root";
        private $password="";
        private $port="3307";
        public $conn;

        public function getConnection(){
            $this->conn=null;
            try{
                $this->conn=new PDO("mysql:host=".$this->host.";dbname=".$this->db_name.";port=".$this->port,$this->username,$this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Ошибка подключения".$exception->getMessage();
            }
            return $this->conn;
        }
    }
?>