<?php
    class DbConnect {
        $host = "host.docker.internal";
        $user = "root";
        $password = "0000";
        $dbName = "hrdtest";
        $port = 3306;
    
        $conn = new mysqli($host,$user,$password);
        if(!$conn){
            echo "could not connected";
            die("could not connected" . $conn->connect_error);
        }
    
        if(!$conn->select_db($dbName)){
            $sql = "CREATE DATABASE `$dbName`;";
            if($conn->query($sql)===true){
                echo "db created";
            } else {
                echo "db could not created".$conn->error;
            }
        }
    
        $sql = "USE '$dbName';";
        $tableName = "member";
        $sql = "DESC `$tableName`;";
        $memberTableExistCheck = $conn->query($sql);
        $tableResult = mysqli_fetch_all($memberTableExistCheck, MYSQLI_ASSOC);
    
        if($tableResult==null){
            createMemberTable($conn);
        }
    
        function createMemberTable($conn){
            $scriptPath = '../db/member.sql';
            $sqlScript = file_get_contents($scriptPath);
            $conn->query($sqlScript);
        }
        mysqli_close($conn);
    }
?>