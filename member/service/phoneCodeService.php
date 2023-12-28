<?php 
include $_SERVER["DOCUMENT_ROOT"].'/member/domain/Member.php';

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
?>