<?php 
require_once $_SERVER["DOCUMENT_ROOT"].'/member/domain/Member.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/member/repository/MemberRepository.php';

class LoginService{
    function tryLogin($memberValue){
        $memberDb = new MemberDB();
        $member = new Member();
        $member->id = $memberValue['id'];
        $member->hashedPw = hash('sha256',$memberValue['password']);

        $dbArr = $memberDb->findByIdAndPassword($member);

        if(count($dbArr)==1){
            require_once $_SERVER["DOCUMENT_ROOT"] . "/member/service/sessionService.php";
            $sessionService = new SessionService();
            $uid = $dbArr[0]['uid'];
            $id = $dbArr[0]['id'];
            $sessionService->loginSession($uid,$id);
            return "success";
        } else {
            return "fail";
        }
    }
}

?>