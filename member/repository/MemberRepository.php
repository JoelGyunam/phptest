<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/db/DBConnect.php');
 class MemberDB extends DbConnect{

    protected $tableName = 'member';

    function findById($id){

        $DbConnect = new DbConnect();

        $query = "SELECT * FROM $this->tableName WHERE `id`=$id;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows;
    }
 }
?>
