<?php 
session_start();
class VerificationService{
    
    function generatePhoneCode($mobileNumber,$type){
        // $type -> new:회원가입 시, find:아이디/비밀번호 찾기 시
        require_once $_SERVER['DOCUMENT_ROOT'] . '/member/service/sessionService.php';
        $sessionService = new SessionService();
        $sessionService->resetSession();

        if($type=="new"){
            require_once $_SERVER['DOCUMENT_ROOT'] . '/member/repository/MemberRepository.php';
            $memberRepository = new MemberRepository();
            $countByMobileNumber = $memberRepository->countByMobileNumber($mobileNumber);
            if($countByMobileNumber!=0){
                return "existedMobileNumber";
            }
        }
        $mobileCode = '123456';
        $_SESSION['verificationCode'] = $mobileCode;
        $_SESSION['mobileNumber'] = $mobileNumber;
        return "success";
    }
    
    function verifyPhoneCode($inputCode,$mobileNumber){
        if(isset($_SESSION['verificationCode']) 
            && $_SESSION['verificationCode']==$inputCode
            && $_SESSION['mobileNumber']==$mobileNumber
        ){
            return "success";
        } else return "fail";
    }

    function generateEmailCode($email){
        $code = '123456';
        $_SESSION['verificationCode'] = $code;
        $_SESSION['email'] = $email;
    }
    
    function verifyEmailCode($inputCode,$email){
        if(isset($_SESSION['verificationCode']) 
            && $_SESSION['verificationCode']==$inputCode
            && $_SESSION['email']==$email
        ){
            return "success";
        } else return "fail";
    }

    function findId($memberFindDto){
        require_once $_SERVER['DOCUMENT_ROOT'] . '/member/repository/MemberRepository.php';
        $memberRepository = new MemberRepository();
        $method = $memberFindDto->method;
        if($method=="phone"){
            $response = $memberRepository->findIdByNameAndPhone($memberFindDto);
            if(count($response)==0){
                return "notMatched";
            } else if(count($response)!=1) {
                return "manyResults";
            } else {
                $this->generatePhoneCode($memberFindDto->number,"find");
                $_SESSION["id"]= $response[0]['id'];
                $_SESSION["name"]= $response[0]['name'];
                return "success";
            }
        } else if($method=="email"){
            $response = $memberRepository->findIdByNameAndEmail($memberFindDto);
            if(count($response)==0){
                return "notMatched";
            } else if(count($response)!=1) {
                return "manyResults";
            } else {
                $this->generateEmailCode($response[0]['email']);
                $_SESSION["id"]= $response[0]['id'];
                $_SESSION["name"]= $response[0]['name'];
                return "success";
            }
        }
    }

    function findPw($memberFindDto){
        require_once $_SERVER['DOCUMENT_ROOT'] . '/member/repository/MemberRepository.php';
        $memberRepository = new MemberRepository();
        if($memberFindDto->method=="phone"){
            $response = $memberRepository->findPwByIdAndNameAndPhone($memberFindDto);
            if(count($response)==0){
                return "notMatched";
            } else if (count($response)!=1){
                return "manyResults";
            } else {
                //이름,아이디,휴대폰번호 일치하는 uid와 id session에 넣고, 비밀번호 재설정 시 해당 정보로 업데이트 함. 
                $this->generatePhoneCode($memberFindDto->number,"find");
                $_SESSION["findUid"] = $response[0]['uid'];
                $_SESSION["id"]= $response[0]['id'];
                return "success";
            }
        };
        if($memberFindDto->method=="email"){
            $response = $memberRepository->findByIdAndNameAndEmail($memberFindDto);
            if(count($response)==0){
                return "notMatched";
            } else if(count($response)!=1){
                return "manyResults";
            } else {
                $this->generateEmailCode($response[0]['email']);
                $_SESSION["findUid"] = $response[0]['uid'];
                $_SESSION["id"]= $response[0]['id'];
                return "success";
            }
        }
    }
}
?>