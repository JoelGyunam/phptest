<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/member/repository/MemberRepository.php';

class InputMemberService{
    function idDuplicateCheck($id){
        $memberRepository = new MemberRepository();
        $idRowCount = $memberRepository->countById($id);
        if($idRowCount==0){
            $result = 'available';
        } else {
            $result = "unavailable";
        }
        return $result;
    }

    function addNewMember($memberValue){
        require_once $_SERVER['DOCUMENT_ROOT'].'/member/repository/MemberRepository.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/member/domain/Member.php';
        $member = new Member();
        $memberRepository = new MemberRepository();
        $member->setMember($memberValue);
        $jsonResult = $member->registerValidChecker();  // {"result":"succeed", "message":"pass"}
        $resultObj = json_decode($jsonResult);
        $result = $resultObj->result;
        if($result=="succeed"){
            $resultObj->dbResult = $memberRepository->insertMember($member);
        }
        return json_encode($resultObj); //{"result":"succeed", "message":"pass", "dbResult":"success"}
    }

    function mobileNumberDuplicateCheck($mobilePhone){
        $memberRepository = new MemberRepository();
        $idRowCount = $memberRepository->countByMobileNumber($mobilePhone);
        if($idRowCount==0){
            $result = 'available';
        } else {
            $result = "unavailable";
        }
        return $result;
    }
}



?>