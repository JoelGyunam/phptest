<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/member/domain/Member.php';

function verifyMemberInfo($memberValue){
    $member = new Member();
    return $member->setMember($memberValue);
}

?>