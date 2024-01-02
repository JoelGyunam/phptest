<div class="login-section">
	<div class="bg"></div>
	<div class="login-inner">
		<h1><a href="/"><img src="http://img.hackershrd.com/common/logo.png" alt="해커스 HRD LOGO" width="142" height="31"/></a></h1>
		<div class="box-login">
			
			<div class="login-input">
				<div class="input-text-box">
					<input id="userId" type="text" class="input-text mb5" placeholder="아이디" style="width:190px"/>
					<input id="password" type="text" class="input-text" placeholder="비밀번호" style="width:190px"/>
				</div>
				<button id="loginBtn" type="submit" class="btn-login">로그인</button>
			</div>
			
			<div class="login-chk">
				<label class="input-sp">
					<input type="checkbox"/>
					<span class="input-txt">아이디 저장</span>
				</label>
				<label class="input-privacy on">보안접속 ON <input type="checkbox" title="IP 보안이 켜져 있습니다. IP보안을 사용하지 않으시려면 선택을 해제해주세요." /></label>
				<!-- <label class="input-privacy">보안접속 OFF <input type="checkbox" title="보안이 꺼져 있습니다. 보안을 사용하려면 선택해주세요." /></label> -->
			</div>
			
			<div class="box-btn">
				<a href="/member/index.php?mode=step_01" class="btn-m-gray">회원가입</a>
				<a href="#" class="btn-m-gray">ID/PW 찾기</a>
			</div>
		</div>
		<div class="login-guide">
			<strong><i class="icon-guide"></i>로그인에 문제가 있으신가요?</strong>
			<ol>
				<li>① 인터넷 창 상단 [도구] - [인터넷 옵션] - [보안] - [사용자 지정 수준] - [보통] 으로 설정해주세요.</li>
				<li>② 인터넷 창을 껐다 다시 켜주세요. 그래도 로그인에 문제가 있으시다면 <a href="#"><strong class="tc-brand">[고객센터]</strong></a>를 통해 문의해주세요.</li>
			</ol>
		</div>
		
		<div class="link-box">
			<a href="#">환급과정안내</a>
			<a href="#">기업교육문의</a>
			<a href="#">상담/고객센터</a>
		</div>

		<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/member/view/login/loginBanner.php"?>
	</div>
	<span class="login-close"><button type="button" class="icon-layer-close"><span class="hidden">닫기</span></button></span>
</div>


<script>
	$(document).ready(function(){
		$("#loginBtn").on("click",function(){
			var loginInfo = new LoginInfo;
			loginInfo.setMember();
			var id = loginInfo.id;
			var pw = loginInfo.password;

			if(id == ""){
				alert("아이디를 입력해 주세요.");
				return;
			}

			if(pw == ""){
				alert("비밀번호를 입력해 주세요.");
				return;
			}

			$.ajax({
				url:'restcontroller/RegisterController.php'
				,type:'POST'
				,data:{
					'action':'login'
					,'member':loginInfo
				}
				,dataType:'json'
				,success: function(response){
					var result = response.result;
					if(result == "fail"){
						alert("아이디 또는 비밀번호를 확인해 주세요.");
					} else {
						window.location.href="/";
					}
				}
				,error: function(){
					alert("오류가 발생했습니다. 다시 시도해 주세요.");
				}
			})

		});


		$(".login-close").on("click",function(){
			window.history.back();
		})
	});

	class LoginInfo {
		setMember(){
			this.id = $("#userId").val();
			this.password = $("#password").val();
		}
	}
	
</script>