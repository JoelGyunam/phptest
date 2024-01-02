<?php 

class SessionService{
    function destroySession(){
        session_start();
        session_destroy();
    }

    function loginSession($uid,$id){
        session_start();
        $_SESSION['uid'] = $uid;
        $_SESSION['id'] = $id;
    }
}


?>