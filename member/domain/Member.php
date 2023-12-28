<?php 
require_once $_SERVER["DOCUMENT_ROOT"].'/member/service/inputMemberInfoService.php';
class Member {
    private $name;
    private $id;
    private $idDpublicationCheck;
    private $password;
    private $email;
    private $mobileCode;
    private $mobileNumber;
    private $telNumber;
    private $postalCode;
    private $address;
    private $additionalAddress;
    private $smsAgreed;
    private $mailAgreed;
    private $regDttm;
    private $modDttm;

    public function setMobileNumber($mobileNumber){
        $this->mobileNumber = $mobileNumber;
    }

    public function setMobileCode($mobileCode){
        $this->mobileCode = $mobileCode;
    }
    
    public function setMember($member){
        
        // $this->name = $member["name"];
        $this->id = $member["id"];
        $this->idDpublicationCheck = idDuplicateCheck($id);

        if($this->name == ""){       
            $message = "이름을 입력해 주세요.";
            $resultArr = array("result" => "fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);
        }

        else {
            $message = "ok";
            $resultArr = array("result" => "succeed", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);
        }
        
    }

    public function getMember(){
        return $this->name;
    }

}
?>