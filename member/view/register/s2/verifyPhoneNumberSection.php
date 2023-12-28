<div id="container" class="container-full">
    <div id="content" class="content">
        <div class="inner">
            <?php include_once $_SERVER["DOCUMENT_ROOT"].'/member/view/register/lnb/registerHeader.php';?>
            <div class="tit-box-h4">
				<h3 class="tit-h4">본인인증</h3>
			</div>
            <div class="section-content after">
				<div class="identify-box" style="width:100%;height:190px;">
					<div class="identify-inner">
						<strong>휴대폰 인증</strong>
						<p>주민번호 없이 메시지 수신가능한 휴대폰으로 1개 아이디만 회원가입이 가능합니다. </p>

						<br>
						<input id="mobileNumberBegin" type="text" maxlength="3" class="input-text numberInput" style="width:50px"> - 
						<input id="mobileNumberCenter" type="text" maxlength="4" class="input-text numberInput" style="width:50px"> - 
						<input id="mobileNumberLast" type="text" maxlength="4" class="input-text numberInput" style="width:50px">
						<a id="sendCode" href="#" class="btn-s-line">인증번호 받기</a>

						<br><br>
						<input id="phoneCode" type="text" class="input-text" style="width:200px">
						<a id="verifyBtn" href="#" class="btn-s-line">인증번호 확인</a>
					</div>
					<i class="graphic-phon"><span>휴대폰 인증</span></i>
				</div>
			</div>

        </div>
    </div>  
</div>

<script>
    $(document).ready(function(){

        var isCodeSent = false;

        $("#sendCode").click(function(){
            var mobileNumber = $("#mobileNumberBegin").val()+$("#mobileNumberCenter").val()+$("#mobileNumberLast").val();
            if(validateMobileNumber(mobileNumber)){
                $.ajax({
                    url: 'restcontroller/RegisterController.php'
                    ,type: 'POST'
                    ,data: {
                        'action': "generateCode"
                        ,'mobileNumber' : mobileNumber
                    }
                    ,success: function(result){
                        alert("인증번호가 발송되었습니다.");
                        isCodeSent = true;
                    }
                    ,error: function(result){
                        alert("인증번호 발송에 실패했습니다.");
                    }
                });
            };
        })

        $("#verifyBtn").click(function(){
            var inputCode = $("#phoneCode").val();
            var verifyResult = false;

            if(!isCodeSent){
                alert("인증번호 받기를 눌러주세요");
                return;
            } 

            $.ajax({
                url: 'restcontroller/RegisterController.php'
                ,type: 'POST'
                ,data: {
                    'action': "verifyCode"
                    ,'inputCode' : inputCode
                }
                ,success: function(result){
                    if(result=="true"){
                        alert("인증에 성공했어요.");
                        window.location.href='index.php?mode=step_03';
                    } else{
                        alert("인증코드를 다시 확인해주세요.");
                    }
                }
                ,error: function(){
                    alert("인증에 실패했습니다.")
                }
            })
        })

        $(".numberInput").keyup(function(){
            if(isNaN($(this).val())){
                var tmpNumber = $(this).val();
                $(this).val(tmpNumber.slice(0,-1));
            }
        })


    });

    function validateMobileNumber(number){
        var regex = /^[0-9]{11}/;
        return regex.test(number);
    }
</script>