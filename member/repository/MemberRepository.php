<?php 
 require_once "../../../db/DBConnect.php";

 class MemberDB extends DbConnect{

    $tableName = 'member';

    function findById($id){
        $query = "SELECT * FROM $tableName WHERE `id`=$id;";
        $result = $conn->query($query);
        return $result->num_rows;
    }
 }
?>
