<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/member/repository/MemberRepository.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/member/domain/Member.php';

function verifyMemberInfo($memberValue){
    $member = new Member();
    $memberDB = new MemberDB();
    $jsonResult = $member->setMember($memberValue); // {"result":"succeed", "message":"pass"}
    $resultObj = json_decode($jsonResult);
    $result = $resultObj->result;
    if($result=="succeed"){
        $resultObj->dbResult = $memberDB->insertMember($member);
    }
    return json_encode($resultObj); //{"result":"succeed", "message":"pass", "dbResult":"success"}
}

?>