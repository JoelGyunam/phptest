<?php 
session_start();
// echo session_id();
// print_r($_SESSION);
if($_SERVER['REQUEST_METHOD']=='POST'){
    $action = $_POST['action']??'';
    switch($action){
        case 'generateCode':
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/verifyCodeService.php';
            $verificationService = new VerificationService();
            $mobileNumber = $_POST['mobileNumber'] ?? '';
            $result = $verificationService->generatePhoneCode($mobileNumber,"new");
            $response = json_encode(array("result"=>$result));
            echo $response;
            break;

        case 'verifyCode':
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/verifyCodeService.php';
            $verificationService = new VerificationService();
            $inputCode = $_POST['inputCode'] ?? '';
            $numberOrMail = $_POST['numberOrMail'] ?? '';
            $type = $_POST['type'] ??'';
            if($type == "phone"){
                $result = $verificationService->verifyPhoneCode($inputCode,$numberOrMail);
            } else if($type == "email"){
                $result = $verificationService->verifyEmailCode($inputCode,$numberOrMail);
            }
            $response = json_encode(array("result"=>$result));
            echo $response;
            break;

        case 'idcheck' : 
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/inputMemberService.php';
            $inputMemberService = new InputMemberService();
            $id = $_POST['id'] ?? '';
            $resultArr = array("result" => $inputMemberService->idDuplicateCheck($id));
            $response = json_encode($resultArr);
            echo $response;
            break;

        case 'newMember' :
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/inputMemberService.php';
            $inputMemberService = new InputMemberService();

            $memberValue = $_POST['member'] ?? '';
            $resultObj = $inputMemberService->addNewMember($memberValue);
            echo $resultObj;
            break;

        case 'login' : 
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/loginService.php';
            $memberValue = $_POST['member'] ?? '';
            $loginService = new LoginService();
            $result = $loginService->tryLogin($memberValue);
            $response = json_encode(array("result"=>$result)); //{"result":"success"}
            echo $response;
            break;

        case 'generateVerifCode' : 
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/verifyCodeService.php';
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/dto/MemberFindDto.php';
            $memberFindDto = new MemberFindDto();
            $verificationService = new VerificationService();

            $idOrPw = $_POST['idOrPw'];
            $memberValue = $_POST['memberValue'];
            $memberFindDto->name = $memberValue['name'];
            $memberFindDto->method = $memberValue['method'];
            $memberFindDto->number = $memberValue['number'];

            if($idOrPw=="id"){
                $result = $verificationService->findId($memberFindDto);
            }
            
            if($idOrPw=="pw"){
                $memberFindDto->id = $memberValue['id'];
                $result = $verificationService->findPw($memberFindDto);
            }

            $response = json_encode(array("result"=>$result)); //{"result":"success}
            echo $response;
            break;

        default :
            echo "잘못된 요청";
            break;
    }
} else if($_SERVER['REQUEST_METHOD']=='GET'){
    $action = $_GET['action']??'';
    switch($action){
        case 'logout' : 
            require_once $_SERVER["DOCUMENT_ROOT"] . "/member/service/sessionService.php";
            $sessionService = new SessionService();
            $sessionService->logout();
            $response = json_encode(array("goto"=>'/'));
            echo $response;
            break;
    }
} else if($_SERVER['REQUEST_METHOD']=='DELETE') {
    parse_str(file_get_contents("php://input"),$deleteVars);
    $sess = $deleteVars['sess'];
    switch($sess){
        case 'delete':
            require_once $_SERVER["DOCUMENT_ROOT"] . "/member/service/sessionService.php";
            $sessionService = new SessionService();
            $sessionService->resetSession();
            break;
    }
} else if($_SERVER['REQUEST_METHOD']=='UPDATE'){
    parse_str(file_get_contents("php://input"),$updateVars);
    $action = $updateVars['action'];
    switch($action){
        case 'pw' : 
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/dto/PasswordUpdateDto.php';
            $pwObj = $updateVars['pwObj'];
            $uid = $pwObj['uid'];
            $id = $pwObj['id'];
            $pw = $pwObj['pw'];
            $pwConfirm = $pwObj['pwConfirm'];
            $pwUpdateDto = new PasswordUpdateDto($uid,$id,$pw,$pwConfirm);

            require_once $_SERVER["DOCUMENT_ROOT"] . "/member/service/updateMemberInfoService.php";
            $updateMemberInfoService = new UpdateMemberInfoService();
            $result = $updateMemberInfoService->updatePassword($pwUpdateDto);
            $response = json_encode(array("result"=>$result));
            echo $response; 
            break;

        case 'memberInfo' :
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/updateMemberInfoService.php';
            $memberValue = $updateVars['member'] ?? '';
            $updateMemberInfoService = new UpdateMemberInfoService();
            $result = $updateMemberInfoService->updateUserInfo($memberValue);
            $response = json_encode(array("result"=>$result));
            echo $response; // {"result":"updated/noChanges/dbFail"}
    }
} 
else {
    echo "잘못된 http method";
}


?>