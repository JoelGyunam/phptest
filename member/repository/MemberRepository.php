<?php
// require_once '/home/web/frontend/db/DBConnect.php';
require_once(getenv('BASE_PATH').'/db/DBConnect.php');

 class MemberDB extends DbConnect{

    protected $tableName = 'member';

    function findById($id){
        $query = "SELECT * FROM $this->tableName WHERE `id`=$id;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows;
    }
 }


?>
