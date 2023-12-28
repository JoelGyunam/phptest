<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/member/repository/MemberRepository.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/member/domain/Member.php';

function verifyMemberInfo($memberValue){
    $member = new Member();
    $memberDB = new MemberDB();
    $jsonResult = $member->setMember($memberValue);
    $result = json_decode($jsonResult)->result;
    print_r($memberValue);
    if($result=="succeed"){
        $memberDB->insertMember($memberValue);
    }
    return $jsonResult;
}

?>