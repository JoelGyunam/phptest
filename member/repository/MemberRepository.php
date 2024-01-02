
<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/db/DBConnect.php');
 class MemberDB extends DbConnect{

    protected $tableName = 'member';

    function findById($id){
        $dbConnect = new DbConnect();
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
        $dbConnect = new DbConnect();
        if($member->smsAgreed=="true"){
            $member->smsAgreed = 1;
        } else {
            $member->smsAgreed = 0;
        }

        if($member->mailAgreed=="true"){
            $member->mailAgreed = 1;
        } else {
            $member->mailAgreed = 0;
        }
        $query = "INSERT INTO " . $this->tableName . " (id, password, email, mobileNumber, telNumber, postalCode, address, additionalAddress, smsAgreed, mailAgreed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssii"
                        ,$member->id
                        , $member->hashedPw
                        , $member->email
                        , $member->mobileNumber
                        , $member->telNumber
                        , $member->postalCode
                        , $member->address
                        , $member->additionalAddress
                        , $member->smsAgreed
                        , $member->mailAgreed);
        $result = $stmt->execute();

        if($result){
            return "success";
        } else {
            return "fail".$stmt->error;
        }
    }

    function findByIdAndPassword($member){
        $dbConnect = new DbConnect();

        $id = $member->id;
        $hashedPw = $member->hashedPw;

        $query ="SELECT `uid`,`id` FROM $this->tableName WHERE `id` = ? AND `password` = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss",$id,$hashedPw);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = [];
        while($row = $result->fetch_assoc()){
            $response[] = ['uid' => $row['uid'], 'id' => $row['id']];
        }
        return $response;
    }

 }
?>
