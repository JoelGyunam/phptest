<?php 

function destroySession(){
    session_start();
    session_destroy();
}

?>