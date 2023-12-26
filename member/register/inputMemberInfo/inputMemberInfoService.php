<?php 
require_once "../../repository/MemberRepository.php";

// id 중복 확인

$memberDb = new MemberDB();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $action = $_POST[`action`]??'';
    switch($action){
        case 'idDupCheck' :
            $id = $_POST['id']??'';
            $idRowCount = findById($id);
            break;
        default :
            echo "잘못된 요청";
            break;
    }
} else {
    echo "잘못된 http method";
}
?>