<?php
require_once '/home/web/frontend/member/repository/MemberRepository.php';

$memberDb = new MemberDB();

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $action = $_POST['action'] ?? '';
    switch($action){
        case "idcheck" :
            $id = $_POST['id'] ?? '';
            $idRowCount = $memberDb->findById($id);
            if($idRowCount==0){
                echo "available";
            } else {
                echo "unavailable";
            }
            break;
        default :
            echo "잘못된 요청";
            break;
    }
} else {
    echo "잘못된 http method";
}

?>