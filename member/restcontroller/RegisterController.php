<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){
    $action = $_POST['action']??'';
    switch($action){
        case 'generateCode':
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/phoneCodeService.php';
            $mobileNumber = $_POST['mobileNumber']??'';
            echo generateCode($mobileNumber);
            break;
        case 'verifyCode':
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/phoneCodeService.php';
            $inputCode = $_POST['inputCode'] ?? '';
            if(verifyCode($inputCode)){
                echo "true";
            } else{
                echo "false";
            }
            break;

        case 'idcheck' : 
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/inputMemberInfoService.php';
            $id = $_POST['id'] ?? '';
            echo idDuplicateCheck($id);
            break;

        case 'newMember' :
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/registerConfirmedService.php';
            $memberValue = $_POST['member'] ?? '';
            echo verifyMemberInfo($memberValue);
            break;

        default :
            echo "잘못된 요청";
            break;
    }
} else {
    echo "잘못된 http method";
}


?>