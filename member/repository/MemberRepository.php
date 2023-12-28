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

    function insertMember($member){
        $member['smsAgreed'] = $member['smsAgreed'] ? 1 : 0;
        $member['mailAgreed'] = $member['mailAgreed'] ? 1 : 0;
        $DbConnect = new DbConnect();
        $query = "INSERT INTO " . $this->tableName . " (id, `password`, email, mobileNumber, telNumber, postalCode, `address`, additionalAddress, smsAgreed, mailAgreed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssii"
                        ,$member['id']
                        , $member['pw']
                        , $member['email']
                        , $member['mobileNumber']
                        , $member['telNumber']
                        , $member['postalCode']
                        , $member['address']
                        , $member['additionalAddress']
                        , $member['smsAgreed']
                        , $member['mailAgreed']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            echo "success";
        } else {
            echo "fail".$stmt->error;
        }
        $stmt->close();
        $this->conn->close();
    }

 }
?>
