<?php 
        require_once $_SERVER["DOCUMENT_ROOT"].'/member/service/sessionService.php';
        $sessionService = new SessionService();
        $sessionService->resetSession();
?>

<div id="container" class="container-full">
	<div id="content" class="content">
		<div class="inner">

            <?php include $_SERVER["DOCUMENT_ROOT"]. "/member/view/find/lnb/lnb.php"?>
            <?php include $_SERVER["DOCUMENT_ROOT"]. "/member/view/find/lnb/methodToggle.php"?>
            <div class="section-content mt30">
				<table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
					<caption class="hidden">아이디/비밀번호 찾기 개인정보입력</caption>
					<colgroup>
						<col style="width:15%">
						<col style="*">
					</colgroup>

					<tbody>
						<tr>
							<th scope="col">성명</th>
							<td><input id="name" type="text" class="input-text" style="width:302px"></td>
						</tr>
						<tr>
							<th scope="col">아이디</th>
                            <td><input id="id" type="text" class="input-text" style="width:302px"></td>

						</tr>
						<tr id="emailField" style="display:none">
							<th scope="col">이메일주소</th>
							<td>
								<input id="email" type="text" class="input-text" style="width:138px"> @ <input id="emailDomain" type="text" class="input-text" style="width:138px">
								<select id="emailDomainSelect" class="input-sel" style="width:160px">
									<option value="manual">선택입력</option>
									<option value="google.com">google.com</option>
									<option value="naver.com">naver.com</option>
								</select>
								<a href="javascript:getVerificationNumber('email')" class="btn-s-tin ml10">인증번호 받기</a>
							</td>
						</tr>
                        <tr id="phoneField">
                            <th scope="col">휴대폰 번호</th>
                            <td>
                            <input id="mobileNumberBegin" type="text" maxlength="3" class="input-text numberInput" style="width:100px">
                            -                              
                            <input id="mobileNumberCenter" type="text" maxlength="4" class="input-text numberInput" style="width:100px">
                            -                           
                            <input id="mobileNumberLast" type="text" maxlength="4" class="input-text numberInput" style="width:100px">                                
                                                        
                            <a href="javascript:getVerificationNumber('phone')" class="btn-s-tin ml10">인증번호 받기</a>
                            </td>
                        </tr>
						<tr>
							<th scope="col">인증번호</th>
							<td><input id="inputCode" type="text" class="input-text" style="width:478px"><a href="javascript:verifyMyCode()" class="btn-s-tin ml10">인증번호 확인</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
    var sent = false;
    var pwFinderInfo;
    $(document).ready(function(){
        methodToggle();
        emailDomainSplit();
        emailDomainSelector();
    })

    function methodToggle(){
        $(".methodSelect").on("change",function(){
            var selected = $(this).val();
            if(selected=="email"){
                $("#emailField").show();
                $("#phoneField").hide();
            } else {
                $("#emailField").hide();
                $("#phoneField").show();
            }
        })
    }

    function verifyMyCode(){
        var myCode = $("#inputCode").val();
        var type = $(".methodSelect:checked").val();
        if(!sent){
            alert("인증번호 받기를 눌러주세요.");
            return;
        }
        if(myCode==""){
            alert("인증번호를 입력해 주세요.");
            return;
        }
        $.ajax({
            url:"restcontroller/RegisterController.php"
            ,type:"POST"
            ,data:{
                "action":"verifyCode"
                ,"inputCode":myCode
                ,"type":type
                ,"numberOrMail":pwFinderInfo.number
            }
            ,dataType:"json"
            ,success:function(response){
                if(response.result=="success"){
                    alert("인증되었습니다.");
                    window.location.href="/member/index.php?mode=find_pw_complete";
                } else {
                    alert("잘못된 인증번호 입니다.");
                }
            }
            ,error:function(){
                alert("오류가 발생했습니다. 다시 시도해주세요.");
            }
        })
    }

    function getVerificationNumber(method){
        pwFinderInfo = new PwFinderInfo;
        pwFinderInfo.setPwFinder(method);
        if(pwFinderInfo.name==""){
            alert("성명을 입력해 주세요.");
            return;
        }
        if(pwFinderInfo.id==""){
            alert("아이디를 입력해 주세요.");
            return;
        }
        if(pwFinderInfo.number=="" && pwFinderInfo.method=="phone"){
            alert("휴대폰 번호를 입력해 주세요.");
            return;
        }
        if($("#email").val()=="" && pwFinderInfo.method=="email"){
            alert("이메일주소를 입력해 주세요.");
            return;
        }
        $.ajax({
            url:"restcontroller/RegisterController.php"
            ,type:"POST"
            ,data:{
                "action":"generateVerifCode"
                ,"idOrPw":"pw"
                ,"memberValue":pwFinderInfo
            }
            ,dataType:"json"
            ,success:function(response){
                if(response.result=="success"){
                    sent = true;
                    alert("인증번호가 발송되었습니다.");
                } else if(response.result=="notMatched"){
                    sent = false;
                    alert("회원정보가 없습니다.");
                }
            }
        })
    }

    function telNumberMerger(){
        if($("#telNumberBegin").val()!="" && $("#telNumberCenter").val()!="" && $("#telNumBerLast").val()!=""){
            return ""+$("#mobileNumberBegin").val()+$("#mobileNumberCenter").val()+$("#mobileNumberLast").val();
        }
    }

    function emailDomainSplit(){
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

    class PwFinderInfo {
        setPwFinder(method){
            this.name = $("#name").val();
            this.id = $("#id").val();
            this.method = method;
            if(this.method == "phone"){
                this.number = telNumberMerger();
            } else if(this.method=="email"){
                this.number = emailMerger();
            }
        }
    }

</script>