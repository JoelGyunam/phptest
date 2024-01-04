<?php 

class LoginService{
    function tryLogin($memberValue){
        require_once $_SERVER["DOCUMENT_ROOT"].'/member/domain/Member.php';
        require_once $_SERVER["DOCUMENT_ROOT"].'/member/repository/MemberRepository.php';
        $memberRepository = new MemberRepository();
        $member = new Member();
        $member->id = $memberValue['id'];
        $member->hashedPw = hash('sha256',$memberValue['password']);

        $dbArr = $memberRepository->findByIdAndPassword($member);

        if(count($dbArr)==1){
            require_once $_SERVER["DOCUMENT_ROOT"] . "/member/service/sessionService.php";
            $sessionService = new SessionService();
            $uid = $dbArr[0]['uid'];
            $id = $dbArr[0]['id'];
            $name = $dbArr[0]['name'];
            $mobileNumber = $dbArr[0]['mobileNumber'];
            $sessionService->loginSession($uid,$id,$name,$mobileNumber);
            return "success";
        } else {
            return "fail";
        }
    }

    function getLoginUserInfo($uid){
        require_once $_SERVER["DOCUMENT_ROOT"].'/member/repository/MemberRepository.php';
        require_once $_SERVER["DOCUMENT_ROOT"].'/member/dto/LoginUserInfoDto.php';

        $memberRepository = new MemberRepository();
        $response = $memberRepository->findByUid($uid);
        $loginUserInfoDto = new LoginUserInfoDto();
        $loginUserInfoDto->setValues(
            $response['name']
            ,$response['id']
            ,$response['password']
            ,$response['uid']
            ,$response['email']
            ,$response['mobileNumber']
            ,$response['telNumber']
            ,$response['postalCode']
            ,$response['address']
            ,$response['additionalAddress']
            ,$response['smsAgreed']
            ,$response['mailAgreed']
            ,$response['regDttm']
            ,$response['modDttm']
            );
        return  $loginUserInfoDto;
    }

}

?>