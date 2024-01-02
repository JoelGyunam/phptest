<script>
function go_link(action) {
    if (action === 'register') {
        window.location.href = "/member/index.php?mode=step_01";
    };
	if(action === 'logout') {
		if(confirm("로그아웃 하시겠습니까?")==false){
			return;
		};
		$.ajax({
			url:"/member/restcontroller/RegisterController.php"
			,type:"DELETE"
			,data:{
				"sess":"delete"
			}
			,success:function(){
				window.location.href="/";
			}
			, error:function(){
				alert("오류가 발생했습니다. 다시 시도해 주세요.");
			}
		});
	};
	if(action === 'login'){
		window.location.href="/member/login.html";
	}
}
</script>

<div id="header" class="header">
	<div class="nav-section">
		<div class="inner p-r">
			<h1><a href="/"><img src="http://img.hackershrd.com/common/logo.png" alt="해커스 HRD LOGO" width="165" height="37"/></a></h1>
			<div class="nav-box">
				<h2 class="hidden">주메뉴 시작</h2>
				
				<ul class="nav-main-lst">
					<li class="mnu">
						<a href="#">일반직무</a>
						<ul class="nav-sub-lst">
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
						</ul>
					</li>
					<li class="mnu2">
						<a href="#">산업직무</a>
						<ul class="nav-sub-lst">
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
						</ul>
					</li>
					<li class="mnu3">
						<a href="#">공통역량</a>
						<ul class="nav-sub-lst">
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
						</ul>
					</li>
					<li class="mnu4">
						<a href="#">어학 및 자격증</a>
						<ul class="nav-sub-lst">
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
						</ul>
					</li>
					<li class="mnu5">
						<a href="#">직무교육 안내</a>
						<ul class="nav-sub-lst">
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
						</ul>
					</li>
					<li class="mnu6">
						<a href="#">내 강의실</a>
						<ul class="nav-sub-lst">
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
							<li><a href="#">서브메뉴</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>

		<div class="nav-sub-box">
			<div class="inner"><!-- <a href="#"><img src="/" alt="배너이미지" width="171" height="196"></a> --></div>
		</div>

	</div>
	<div class="top-section">
		<div class="inner">
			<div class="link-box">
				<?php 
				// 'id' 세션 변수가 설정되었는지 확인
				if(isset($_SESSION['id']) && $_SESSION['id'] != "") {
					// 사용자가 로그인한 경우
					?>
					<a href="javascript:go_link('logout');">로그아웃</a>
					<a href="#">내정보</a>
					<a href="#">상담/고객센터</a>
					<?php 
				} else {
					// 사용자가 로그인하지 않은 경우
					?>
					<a href="javascript:go_link('login');">로그인</a>
					<a href="javascript:go_link('register');">회원가입</a>
					<a href="#">상담/고객센터</a>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
</div>
