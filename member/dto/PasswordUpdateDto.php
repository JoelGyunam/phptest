<?php 
class PasswordUpdateDto{
    public $uid;
    public $id;
    public $encPassword;
    public $message; // valid, notMatched, regexFail, noUserInfo

    function __construct($uid, $id, $password, $passwordConfirm){
        if($uid=="" || $id==""){
            $this->message = "noUserInfo";
            return;
        } else {
            $this->uid = $uid;
            $this->id = $id;
        }
        
        if($password != $passwordConfirm){
            $this->message = "notMatched";
            return;
        }
        if(!$this->pwRegex($password)){
            $this->message = "regexFail";
            return;
        }
        $this->message = "valid";
        $this->encPassword = hash("sha256",$password);
    }

    function setUserInfo($uid,$id){
        $this->uid = $uid;
        $this->id = $id;
    }

    function pwRegex($str){
        $pattern = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,15}$/';
        return preg_match($pattern, $str) === 1;
    }

}

?>