<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){
    $action = $_POST['action']??'';
    switch($action){
        case 'generateCode':
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/phoneCodeService.php';
            $mobileNumber = $_POST['mobileNumber'] ?? '';
            echo generateCode($mobileNumber);
            break;

        case 'verifyCode':
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/phoneCodeService.php';
            $inputCode = $_POST['inputCode'] ?? '';
            if(verifyCode($inputCode)){
                echo "true";
            } else{
                echo "false";
            }
            break;

        case 'idcheck' : 
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/inputMemberInfoService.php';
            $id = $_POST['id'] ?? '';
            $resultArr = array("result" => idDuplicateCheck($id));
            $response = json_encode($resultArr);
            echo $response;
            break;

        case 'newMember' :
            require_once $_SERVER["DOCUMENT_ROOT"] . '/member/service/registerConfirmedService.php';
            $memberValue = $_POST['member'] ?? '';
            $resultObj = verifyMemberInfo($memberValue);
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

        default :
            echo "잘못된 요청";
            break;
    }
} else if($_SERVER['REQUEST_METHOD']=='DELETE') {
    parse_str(file_get_contents("php://input"),$deleteVars);
    $sess = $deleteVars['sess'];
    switch($sess){
        case 'delete':
            require_once $_SERVER["DOCUMENT_ROOT"] . "/member/service/sessionService.php";
            $sessionService = new SessionService();
            $sessionService->destroySession();
            break;
    }
} else {
    echo "잘못된 http method";
}


?>