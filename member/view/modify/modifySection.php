<?php
if(!isset($_SESSION['uid'])){
	echo "<script>window.location.href='/';</script>";
	return;
}
$uid = $_SESSION['uid'];
require_once $_SERVER['DOCUMENT_ROOT'].'/member/service/loginService.php';
$loginService = new LoginService();
$inputFill = $loginService->getLoginUserInfo($uid);
$telNumberArr = telNumberToArray($inputFill->telNumber);
function telNumberToArray($number) {
    $length = strlen($number);
    $formattedNumber = [];

    if ($length == 9 && strpos($number, "02") === 0) {
        // 02-XXX-XXXX
        $formattedNumber = [substr($number, 0, 2), substr($number, 2, 3), substr($number, 5)];
    } elseif ($length == 10) {
        if (strpos($number, "02") === 0) {
            // 02-XXXX-XXXX
            $formattedNumber = [substr($number, 0, 2), substr($number, 2, 4), substr($number, 6)];
        } else {
            // XXX-XXX-XXXX
            $formattedNumber = [substr($number, 0, 3), substr($number, 3, 3), substr($number, 6)];
        }
    } elseif ($length == 11) {
        // XXX-XXXX-XXXX
        $formattedNumber = [substr($number, 0, 3), substr($number, 3, 4), substr($number, 7)];
    } else {
        // 기본 형식
        $formattedNumber = [$number,"",""];
    }

    return $formattedNumber;
}


?>

<div id="container" class="container-full">
    <div id="content" class="content">
        <div class="inner">

            <div class="tit-box-h3">
				<h3 class="tit-h3">내정보수정</h3>
				<div class="sub-depth">
					<span><i class="icon-home"><span>홈</span></i></span>
					<strong>내정보수정</strong>
				</div>
			</div>
            <div class="section-content">
				<table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
					<caption class="hidden">강의정보</caption>
					<colgroup>
						<col style="width:15%">
						<col style="*">
					</colgroup>

					<tbody>
						<tr>
							<th scope="col"><span class="icons">*</span>이름</th>
							<td><span><?php echo $_SESSION['name'] ?></span></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>아이디</th>
							<td><input id="id" type="text" class="input-text" style="width:302px" placeholder="영문자로 시작하는 4~15자의 영문소문자, 숫자" value="<?php echo $inputFill->id?>"><a id="idCheckBtn" href="javascript:idDuplicationChecker()" class="btn-s-tin ml10">중복확인</a></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>비밀번호</th>
							<td><input id="pw" type="password" class="input-text" style="width:302px" placeholder="8-15자의 영문자/숫자 혼합"></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>비밀번호 확인</th>
							<td><input id="pwConfirm" type="password" class="input-text" style="width:302px"></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>이메일주소</th>
							<td>
								<input id="email" type="text" class="input-text" style="width:138px" value="<?php $mailPart = explode("@",$inputFill->email); echo $mailPart[0] ?>"> @ <input id="emailDomain" type="text" class="input-text" style="width:138px" value="<?php echo  $mailPart[1]?>">
								<select id="emailDomainSelect" class="input-sel" style="width:160px">
									<option value="manual">선택입력</option>
									<option value="gmail.com">gmail.com</option>
									<option value="naver.com">naver.com</option>
									<option value="kakao.com">kakao.com</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>휴대폰 번호</th>
							<td id="mobileNumber">
								<?php $phone = $_SESSION['mobileNumber']; $formattedPhone = substr($phone,0,3)."-".substr($phone,3,4)."-".substr($phone,7); echo $formattedPhone?>
							</td>
						</tr>
						<tr>
							<th scope="col"><span class="icons"></span>일반전화 번호</th>
							<td><input id="telNumberBegin" type="text" class="input-text" style="width:88px" maxlength="3" value="<?php echo $telNumberArr[0]?>"> - <input id="telNumberCenter" type="text" class="input-text" style="width:88px" maxlength="4" value="<?php echo $telNumberArr[1]?>"> - <input id="telNumBerLast" type="text" class="input-text" style="width:88px" maxlength="4" value="<?php echo $telNumberArr[2]?>"></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>주소</th>
							<td>
								<p>
									<label>우편번호 <input id="postalCode" type="text" class="input-text ml5" style="width:242px" value="<?php echo  $inputFill->postalCode?>" disabled></label><a id="findAddressBtn" class="btn-s-tin ml10" onclick="execDaumPostcode()">주소찾기</a>
								</p>
								<p class="mt10">
									<label>기본주소 <input id="address" type="text" class="input-text ml5" style="width:719px" value="<?php echo  $inputFill->address?>" disabled></label>
								</p>
								<p class="mt10">
									<label>상세주소 <input id="additionalAddress" type="text" class="input-text ml5" style="width:719px" value="<?php echo  $inputFill->additionalAddress?>"></label>
								</p>
							</td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>SMS수신</th>
							<td>
								<div class="box-input">
									<label class="input-sp">
										<input id="smsAgreed" type="radio" name="radio" checked="checked">
										<span class="input-txt">수신함</span>
									</label>
									<label class="input-sp">
										<input id="smsUnagreed" type="radio" name="radio">
										<span class="input-txt">미수신</span>
									</label>
								</div>
								<p>SMS수신 시, 해커스의 혜택 및 이벤트 정보를 받아보실 수 있습니다.</p>
							</td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>메일수신</th>
							<td>
								<div class="box-input">
									<label class="input-sp">
										<input  id="mailAgreed" type="radio" name="radio2" checked="checked">
										<span class="input-txt">수신함</span>
									</label>
									<label class="input-sp">
										<input id="mailUnagreed" type="radio" name="radio2">
										<span class="input-txt">미수신</span>
									</label>
								</div>
								<p>메일수신 시, 해커스의 혜택 및 이벤트 정보를 받아보실 수 있습니다.</p>
							</td>
						</tr>
					</tbody>
				</table>
                <div class="box-btn">
					<a href="javascript:editSubmit()" class="btn-l">정보수정</a>
				</div>
			</div>

        </div>
    </div>  
</div>

<script>
var idDuplicateChecked = false;
var isIdChanged = false;
$(document).ready(function(){
    idListener();
    emailDomainSelector();
    emailDomainSpliter()

	var smsAgreeInit = <?php echo $inputFill->smsAgreed?>;
	var mailAgreeInit = <?php echo $inputFill->mailAgreed?>;
	if(smsAgreeInit==0){
		$("#smsUnagreed").prop("checked",true);
	};
	if(mailAgreeInit==0){
		$("#mailUnagreed").prop("checked",true);
	};
})

class Member{
    setMember(){
        this.uid = <?php echo $_SESSION['uid']?>;
        this.name = $("#name").val();
        this.id = $("#id").val();
        this.isIdChanged = isIdChanged;
        this.idDuplicateChecked = idDuplicateChecked;
        this.pw = $("#pw").val();
        this.pwConfirm = $("#pwConfirm").val();
        this.email = emailMerger();
        this.mobileNumber = $("#mobileNumber").text().replace(/-/g, "").trim();
        console.log(this.mobileNumber);
        this.telNumber = telNumberMerger();
        this.postalCode = $("#postalCode").val();
        this.address = $("#address").val();
        this.additionalAddress = $("#additionalAddress").val();
        this.smsAgreed = $("#smsAgreed").is(":checked") ? 1 : 0;
        this.mailAgreed = $("#mailAgreed").is(":checked") ? 1: 0;
    }

    isValid(){
        if(this.id=="" || this.id==null){
            console.log(this.id );
            return "아이디를 입력해 주세요.";
        }
        if(isIdChanged && !this.idDuplicateChecked){
            return "아이디 중복확인을 해주세요.";
        }
        if(this.pw==""){
            return "비밀번호를 입력해 주세요.";
        }
        if(!pwValidChecker(this.pw)){
            return "사용할 수 없는 비밀번호 형식입니다.";
        }
        if(this.pw!=this.pwConfirm){
            return "비밀번호가 일치하지 않습니다.";
        }
        if(this.email=="" || this.email==null){
            return "이메일을 입력해 주세요.";
        }
        if(this.address=="" || this.address==null){
            return "주소를 입력해 주세요.";
        }
        if(this.additionalAddress=="" || this.additionalAddress==null){
            return "상세주소를 입력해 주세요.";
        }
        if(this.smsAgreed==null){
            return "SMS수신 여부를 선택해 주세요.";
        }
        if(this.mailAgreed==null){
            return "메일수신 여부를 선택해 주세요.";
        } else {
            return "valid";
        }
    }
}

function pwValidChecker(pw){
    var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,15}$/;
    return regex.test(pw);
}

function idValidChecker(id){
    var regex = /^[a-z][a-z0-9]{3,14}$/;
    return regex.test(id);
}

function editSubmit(){
    if(isIdChanged && !idDuplicateChecked){
        alert("아이디 중복확인을 해주세요.");
        return;
    }
    var member = new Member();
    member.setMember();
    var validCheck = member.isValid();
    if(validCheck!="valid"){
        alert(validCheck);
        return;
    };

    $.ajax({
        url: 'restcontroller/RegisterController.php'
        ,type: 'UPDATE'
        ,data: {
            'action' : 'memberInfo'
            ,'member' : member
        }
        ,dataType:"json"
        ,success: function(response){
            if(response.result == "updated"){
                alert("내정보수정이 완료되었습니다.");
                window.location.href="/";
            } else if(response.result == "noChanges"){
                alert("변경 사항이 없습니다.");
            } else {
                alert("오류가 발생했습니다. 다시 시도해주세요. (dberror)");
            }
        }
        ,error: function(){
            alert("오류가 발생했습니다."); 
        }
    })

}

function idDuplicationChecker(){

	var id = $("#id").val();
    if(!idValidChecker(id)){
        alert("아이디 형식을 확인해 주세요.");
        return;
    }

    $.ajax({
        url: 'restcontroller/RegisterController.php'
        ,type: 'POST'
        ,data: {
            'action': "idcheck"
            ,'id' : id
        }
        ,dataType: 'json'
        ,success: function(response){
            if(response.result=="available"){
                alert("사용 가능한 아이디 입니다.");
                idDuplicateChecked = true;
            } else {
                alert("이미 사용중인 아이디입니다.");
                idDuplicateChecked = false;
            }
        }
        ,error: function(){
			alert("오류가 발생했습니다. 다시 시도해주세요.");
            idDuplicateChecked = false;
        }
    });
}

function idListener(){
    $("#id").on("change",function(){
        idDuplicateChecked = false;
        isIdChanged = true;
    })
}

function emailDomainSpliter(){
    $("#email").on("change",function(){
        var email = $(this).val();
        if(email.includes("@")){
            var partsArr = email.split("@");
            $(this).val(partsArr[0]);
            $("#emailDomain").val(partsArr[1]);
            $("#emailDomainSelect").val("manual");
        }
    })
}

function emailDomainSelector(){
    $("#emailDomainSelect").on("change",function(){
        var selected = $(this).val();
        if(selected!="manual"){
            $("#emailDomain").val(selected);
        }
    })
}

function emailMerger(){
    if($("#email").val()!="" && $("#emailDomain").val()!=""){
        return $("#email").val()+"@"+$("#emailDomain").val();
    }
}

function telNumberMerger(){
    if($("#telNumberBegin").val()!="" && $("#telNumberCenter").val()!="" && $("#telNumBerLast").val()!=""){
        return ""+$("#telNumberBegin").val()+$("#telNumberCenter").val()+$("#telNumBerLast").val();
    }
} 


</script>