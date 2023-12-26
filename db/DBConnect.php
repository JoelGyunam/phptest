<?php
    class DbConnect {
        protected $host = "host.docker.internal";
        protected $user = "root";
        protected $password = "0000";
        protected $dbName = "hrdtest";
        protected $port = 3306;
        public $conn;

        function __construct(){
            $this->conn = new mysqli($this->host,$this->user,$this->password,$this->dbName);
            if($this->conn->connect_error){
                echo "could not connected";
                die("could not connected" . $this->conn->connect_error);
            }
            $this->checkOrCreateDb();
            $this->checkOrCreateTable();
        }
    
        private function checkOrCreateDb(){
            if(!$this->conn->select_db($this->dbName)){
                $sql = "CREATE DATABASE `$this->dbName`;";
                if($this->conn->query($sql)===true){
                    echo "db created";
                } else {
                    echo "db could not created".$this->conn->error;
                }
            }
            $this->conn->select_db($this->dbName);
        }
    
        private function checkOrCreateTable(){
            $tableName = "member";
            $sql = "DESC `$tableName`;";
            $result = $this->conn->query($sql);
            if($result == false){
                $this->createMemberTable();
            }
        }
        
        private function createMemberTable(){
            $scriptPath = '/home/web/frontend/db/member.sql';
            $sqlScript = file_get_contents($scriptPath);
            if($this->conn->multi_query($sqlScript)===true){
                echo "Table Created";
            } else {
                echo "Error Creating table" . $this->conn->error;
            }
        }

        function __desctruct(){
            $this->conn->close();
        }
    }
?>