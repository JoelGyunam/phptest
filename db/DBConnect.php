<?php
    class DbConnect {
        protected $host;
        protected $user;
        protected $password = "0000";
        protected $dbName = "hrdtest";
        protected $port = 3306;
        public $conn;

        function __construct(){
            $this->host = file_exists('/.dockerenv') ? "host.docker.internal" : "localhost";
            $this->user = file_exists('/.dockerenv') ? "root" : "localroot";
            $this->conn = new mysqli($this->host,$this->user,$this->password);
            if($this->conn->connect_error){
                die("could not connected" . $this->conn->connect_error);
            }
            $this->checkOrCreateDb();
            $this->checkOrCreateTable();
        }
    
        private function checkOrCreateDb(){
            $dbExists = $this->conn->query("SHOW DATABASES LIKE '$this->dbName';");
            if($dbExists && $dbExists->num_rows == 0){
                $sql = "CREATE DATABASE IF NOT EXISTS `$this->dbName`;";
                if($this->conn->query($sql)===true){
                    $this->conn->select_db($this->dbName);
                } else{
                    error_log("DB is not existed").$this->conn->error;
                }
            } else {
                $this->conn->select_db($this->dbName);
            }
        }
    
        private function checkOrCreateTable(){
            $tableName = "member";
            $sql = "SHOW TABLES LIKE '$tableName';";
            $result = $this->conn->query($sql);
            if($result == false || $result->num_rows == 0){
                $this->createMemberTable();
            }
        }
        
        private function createMemberTable(){
            $scriptPath = getenv('BASE_PATH').'/db/member.sql';
            $sqlScript = file_get_contents($scriptPath);
            if($this->conn->multi_query($sqlScript)===true){
                echo "Table Created";
            } else {
                echo "Error Creating table" . $this->conn->error;
            }
        }

        function __destruct(){
            $this->conn->close();
        }
    }
?>