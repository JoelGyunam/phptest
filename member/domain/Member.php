<?php 

class Member {
    
    public $name;
    public $id;
    public $idDuplicationCheck;
    public $password;
    public $email;
    public $mobileCode;
    public $mobileNumber;
    public $telNumber;
    public $postalCode;
    public $address;
    public $additionalAddress;
    public $smsAgreed;
    public $mailAgreed;
    public $regDttm;
    public $modDttm;

    public function setMobileNumber($mobileNumber){
        $this->mobileNumber = $mobileNumber;
    }

    public function setMobileCode($mobileCode){
        $this->mobileCode = $mobileCode;
    }
    
    function setMember($memberValue){
        require_once $_SERVER["DOCUMENT_ROOT"].'/member/service/inputMemberInfoService.php';
        session_start();
        $this->name = $memberValue["name"];
        $this->id = $memberValue["id"];
        $this->idDuplicationCheck = idDuplicateCheck($this->id);
        $this->password = $memberValue["pw"];
        $this->passwordConfirm = $memberValue["pwConfirm"];
        $this->email = $memberValue["email"];
        $this->mobileNumber = $_SESSION['phoneNumber'];
        $this->telNumber = $memberValue["telNumber"];
        $this->postalCode = $memberValue["postalCode"];
        $this->address = $memberValue["address"];
        $this->additionalAddress = $memberValue["additionalAddress"];
        $this->smsAgreed = $memberValue["smsAgreed"];
        $this->mailAgreed = $memberValue["mailAgreed"];

        return $this->registerValidChecker($memberValue);
    }

    function getMember(){
        return json_encode($this->toArray(),JSON_UNESCAPED_UNICODE);
    }

    /*
    *   valid_fail : null or 정규식 검사 탈락
    *   duplicatedId : 중복된 id
    *   session_end : 세션 종료
    *   succeed : 통과
    */
    function registerValidChecker($memberValue){
        if($this->name == ""){       
            $message = "이름을 입력해 주세요.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);
        }
        if($this->id == ""){       
            $message = "아이디를 입력해 주세요.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);
        }
        if(!$this->idRegex($this->id)){
            $message = "사용할 수 없는 ID 형식입니다.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);
        }
        if($this->idDuplicationCheck != "available"){
            $message = "이미 사용중인 ID 입니다.";
            $resultArr = array("result" => "duplicatedId", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);
        }
     
        if(!$this->pwRegex($this->password)){
            $message = "사용할 수 없는 비밀번호입니다.";
            $resultArr = array("result" => "valid_fail", "message" => $message);   
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);    
        }

        if($memberValue["pw"] == $memberValue["pwConfirm"]){
                $this->password = hash('sha256', $this->password);
        } else {
            $message = "비밀번호가 일치하지 않습니다.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);   
        }

        if($this->password = "" || $this->passwordConfirm==""){
            $message = "비밀번호를 입력해 주세요.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);   
        }

        if($this->mobileNumber == null || $this->mobileNumber == ""){
            $message = "세션이 종료되었습니다.";
            $resultArr = array("result" => "session_end", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);   
        }

        if($this->email == ""){
            $message = "이메일을 입력해 주세요.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);   
        }

        if(!$this->emailRegex($this->email)){
            $message = "사용할 수 없는 이메일 형식입니다.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);
        }

        if($this->telNumber != "" && !$this->telNumberRegex($this->telNumber)){
            $message = "일반전화 번호를 확인해 주세요.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);   
        }

        if($this->postalCode == "" || $this->address == ""){
            $message = "주소를 입력해 주세요.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);      
        }

        if($this->smsAgreed == ""){
            $message = "SMS 수신여부를 확인해주세요.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);
        }

        if($this->mailAgreed == ""){
            $message = "메일 수신여부를 확인해주세요.";
            $resultArr = array("result" => "valid_fail", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);      
        }
                
        else {
            $message = "pass";
            $resultArr = array("result" => "succeed", "message" => $message);
            return json_encode($resultArr,JSON_UNESCAPED_UNICODE);
        }
    }

    function idRegex($str){
        $pattern = '/^[a-z][a-z0-9]{3,14}$/';
        return preg_match($pattern, $str) === 1;
    }

    function pwRegex($str){
        $pattern = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,15}$/';
        return preg_match($pattern, $str) === 1;
    }

    function emailRegex($str){
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        return preg_match($pattern, $str) === 1;
    }
    function telNumberRegex($str){
        $pattern = '/^0(2|3[1-3]|4[1-4]|5[1-5]|6[1-4])[1-9]\d{2,3}\d{4}$/';
        return preg_match($pattern, $str) === 1;
    }
        
    private function toArray() {
        return get_object_vars($this);
    }
} 


?>