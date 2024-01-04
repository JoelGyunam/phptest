
<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/db/DBConnect.php');
 class MemberRepository extends DbConnect{

    protected $tableName = 'member';

    function countById($id){
        $dbConnect = new DbConnect();
        $query = "SELECT * FROM $this->tableName WHERE id = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = [];

        while($row = $result->fetch_assoc()){
            $response[] = [
                'uid' => $row['uid']
                ,'name'=> $row['name']
                ,'id'=> $row['id']
                ,'password'=> $row['password']
                ,'email'=> $row['email']
                ,'mobileNumber'=> $row['mobileNumber']
                ,'telNumber'=> $row['telNumber']
                ,'postalCode'=> $row['postalCode']
                ,'address'=> $row['address']
                ,'additionalAddress'=> $row['additionalAddress']
                ,'smsAgreed'=> $row['smsAgreed']
                ,'mailAgreed'=> $row['mailAgreed']
                ,'regDttm'=> $row['regDttm']
                ,'modDttm' => $row['modDttm']]; 
        }
        return count($response);
    }

    function countByMobileNumber($mobileNumber){
        $dbConnect = new DbConnect();
        $query = "SELECT * FROM $this->tableName WHERE mobileNumber = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s",$mobileNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = [];

        while($row = $result->fetch_assoc()){
            $response[] = [
                'uid' => $row['uid']
                ,'name'=> $row['name']
                ,'id'=> $row['id']
                ,'password'=> $row['password']
                ,'email'=> $row['email']
                ,'mobileNumber'=> $row['mobileNumber']
                ,'telNumber'=> $row['telNumber']
                ,'postalCode'=> $row['postalCode']
                ,'address'=> $row['address']
                ,'additionalAddress'=> $row['additionalAddress']
                ,'smsAgreed'=> $row['smsAgreed']
                ,'mailAgreed'=> $row['mailAgreed']
                ,'regDttm'=> $row['regDttm']
                ,'modDttm' => $row['modDttm']]; 
        }
        return count($response);
    }

    function findByUid($uid){
        $dbConnect = new DbConnect();
        $query = "SELECT * FROM $this->tableName WHERE `uid` = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s",$uid);
        $stmt->execute();
        $result = $stmt->get_result();
        $response=[];

        while($row = $result->fetch_assoc()){
            $response = [
                'uid' => $row['uid']
                ,'name'=> $row['name']
                ,'id'=> $row['id']
                ,'password'=> $row['password']
                ,'email'=> $row['email']
                ,'mobileNumber'=> $row['mobileNumber']
                ,'telNumber'=> $row['telNumber']
                ,'postalCode'=> $row['postalCode']
                ,'address'=> $row['address']
                ,'additionalAddress'=> $row['additionalAddress']
                ,'smsAgreed'=> $row['smsAgreed']
                ,'mailAgreed'=> $row['mailAgreed']
                ,'regDttm'=> $row['regDttm']
                ,'modDttm' => $row['modDttm']]; 
        }
        return $response;
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
        $query = "INSERT INTO " . $this->tableName . " (name,id, password, email, mobileNumber, telNumber, postalCode, address, additionalAddress, smsAgreed, mailAgreed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssssssii"
                        ,$member->name
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

        $query = "SELECT `uid`,`id`, `name`, `mobileNumber` FROM $this->tableName WHERE `id` = ? AND `password` = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss",$id,$hashedPw);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = [];
        while($row = $result->fetch_assoc()){
            $response[] = ['uid' => $row['uid'], 'id' => $row['id'], 'name' => $row['name'], 'mobileNumber' => $row['mobileNumber']];
        }
        return $response;
    }

    function findIdByNameAndPhone($memberFindDto){
        $dbConnect = new DbConnect();

        $query = "SELECT `uid`,`id`,`name` FROM $this->tableName WHERE `name` = ? AND `mobileNumber` = ?;";
        $stmt = $this->conn->prepare($query);

        $name = $memberFindDto->name;
        $number = $memberFindDto->number;

        $stmt->bind_param("ss",$name, $number);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = [];
        while($row = $result->fetch_assoc()){
            $response[] = ['uid'=>$row['uid'],'id'=>$row['id'],'name'=>$row['name']];
        }
        return $response;
    }

    function findIdByNameAndEmail($memberFindDto){
        $dbConnect = new DbConnect();

        $query = "SELECT `uid`,`id`,`name`,`email` FROM $this->tableName WHERE `name` = ? AND `email` = ?;";
        $stmt = $this->conn->prepare($query);

        $name = $memberFindDto->name;
        $email = $memberFindDto->number;
        
        $stmt->bind_param("ss",$name, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = [];
        while($row = $result->fetch_assoc()){
            $response[] = ['uid'=>$row['uid'],'id'=>$row['id'],'name'=>$row['name'],'email'=>$row['email']];
        }
        return $response;
    }

    function findPwByIdAndNameAndPhone($memberFindDto){
        $dbConnect = new DbConnect();

        $query = "SELECT `uid`,`id`,`name` FROM $this->tableName WHERE `name` = ? AND `id` = ? AND `mobileNumber` = ?;";
        $stmt = $this->conn->prepare($query);

        $name = $memberFindDto->name;
        $id = $memberFindDto->id;
        $number = $memberFindDto->number;

        $stmt->bind_param("sss",$name, $id, $number);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = [];
        while($row = $result->fetch_assoc()){
            $response[] = ['uid'=>$row['uid'],'id'=>$row['id'],'name'=>$row['name']];
        }
        return $response;
    }

    function findByIdAndNameAndEmail($memberFindDto){
        $dbConnect = new DbConnect();
        
        $query = "SELECT `uid`,`id`,`name`,`email` FROM $this->tableName WHERE `name` = ? AND `id` = ? AND `email` = ?;";
        $stmt = $this->conn->prepare($query);

        $name = $memberFindDto->name;
        $id = $memberFindDto->id;
        $email = $memberFindDto->number;

        $stmt->bind_param("sss",$name,$id,$email);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = [];
        while($row = $result->fetch_assoc()){
            $response[] = ['uid'=>$row['uid'], 'id'=>$row['id'],'name'=>$row['name'],'email'=>$row['email']];
        }
        return $response;
    }

    function updatePassword($passwordUpdateDto){
        $dbConnect = new DbConnect();
        $query = "UPDATE $this->tableName SET `password` = ?, `modDttm` = current_timestamp() WHERE `uid` = ? AND `id` = ?;";

        $stmt = $this->conn->prepare($query);
        $password = $passwordUpdateDto->encPassword;
        $uid = $passwordUpdateDto->uid;
        $id = $passwordUpdateDto->id;
        
        $stmt->bind_param("sis",$password,$uid,$id);
        $result = $stmt->execute();
        return $result;
    }
    
    function updateMemberInfo($modifyUserInfoDto){
        $dbConnect = new DbConnect();
        $query = "UPDATE $this->tableName 
            SET
             `id` = ?
             ,`email` = ?
             ,`password` = ?
             ,`telNumber` = ?
             ,`postalCode` = ?
             ,`address` = ?
             ,`additionalAddress` = ?
             ,`smsAgreed` = ?
             ,`mailAgreed` = ?
             ,`modDttm` = current_timestamp()
             WHERE `uid` = ? AND `mobileNumber` = ? ;";
        $stmt = $this->conn->prepare($query);

        if($modifyUserInfoDto->smsAgreed == "true"){
            $smsAgreed = 1;
        } else $smsAgreed = 0;

        if($modifyUserInfoDto->mailAgreed == "true"){
            $mailAgreed = 1;
        } else $mailAgreed = 0;

        $stmt->bind_param("sssssssiiis"
            ,$modifyUserInfoDto->id
            ,$modifyUserInfoDto->email
            ,$modifyUserInfoDto->hashedPw
            ,$modifyUserInfoDto->telNumber
            ,$modifyUserInfoDto->postalCode
            ,$modifyUserInfoDto->address
            ,$modifyUserInfoDto->additionalAddress
            ,$modifyUserInfoDto->smsAgreed
            ,$modifyUserInfoDto->mailAgreed
            ,$modifyUserInfoDto->uid
            ,$modifyUserInfoDto->mobileNumber
        );

        $result = $stmt->execute();
        return $result;
    }
 }
?>
