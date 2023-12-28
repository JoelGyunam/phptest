<?php 
session_start();

function generateCode($mobileNumber){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/member/domain/Member.php';
    $mobileCode = '123456';
    $_SESSION['phoneVerificationCode'] = $mobileCode;
    $_SESSION['phoneNumber'] = $mobileNumber;
}

function verifyCode($inputCode){
    if(isset($_SESSION['phoneVerificationCode']) 
    && $_SESSION['phoneVerificationCode']==$inputCode){
        return true;
    } else return false;
}
?>