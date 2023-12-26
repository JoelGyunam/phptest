<?php 
include "../../../domain/member/Member.php";
session_start();

function generateCode($mobileNumber){
    $mobileCode = '123456';
    $_SESSION['phoneVerificationCode'] = $mobileCode;
    $_SESSION['phoneNumber'] = $mobileNumber;
    $member = new Member();
    $member->setMobileNumber($mobileNumber);
    $member->setMobileCode($mobileCode);

}

function verifyCode($inputCode){
    if(isset($_SESSION['phoneVerificationCode']) 
    && $_SESSION['phoneVerificationCode']==$inputCode){
        return true;
    } else return false;
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $action = $_POST['action']??'';
    switch($action){
        case 'generateCode':
            $mobileNumber = $_POST['mobileNumber']??'';
            generateCode($mobileNumber);
            break;
        case 'verifyCode':
            $inputCode = $_POST['inputCode'] ?? '';
            if(verifyCode($inputCode)){
                echo "true";
            } else{
                echo "false";
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