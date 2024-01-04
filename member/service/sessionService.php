<?php 

class SessionService{
    function resetSession(){
        $_SESSION = array();
    }

    function loginSession($uid,$id,$name,$mobileNumber){
        if(session_status()== PHP_SESSION_NONE){
            session_start();
        }        $_SESSION['uid'] = $uid;
        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['mobileNumber'] = $mobileNumber;
    }
}


?>