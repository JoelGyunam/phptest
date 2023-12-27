<?php 
if($_SERVER['REQUEST_METHOD']=='POST'){
    $action = $_POST['action']??'';
    switch($action){
        case 'newMember':
            $member = $_POST['member']??'';
            echo var_dump($member);
            break;
        default :
            echo "잘못된 요청";
            break;
    }
} else {
    echo "잘못된 http method";
}
?>