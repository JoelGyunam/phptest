<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/db/DBConnect.php');
 class MemberDB extends DbConnect{

    protected $tableName = 'member';

    function findById($id){

        $DbConnect = new DbConnect();

        $query = "SELECT * FROM $this->tableName WHERE id = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = [];

        while($row = $result->fetch_assoc()){
            $response[] = ['uid' => $row['uid'], 'id' => $row['id']]; 
        }

        return count($response);
    }
 }
?>
