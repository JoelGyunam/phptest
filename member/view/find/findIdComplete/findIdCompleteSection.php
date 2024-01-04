<?php 
    if(!isset($_SESSION["id"])){
        echo "<script> window.location.href='/'; </script>";
    }
?>
<div id="container" class="container-full">
	<div id="content" class="content">
		<div class="inner">

            <?php include $_SERVER["DOCUMENT_ROOT"]. "/member/view/find/lnb/lnb.php"?>

            <div class="tit-box-h4">
				<h3 class="tit-h4">아이디 조회결과</h3>
			</div>

            <div class="guide-box">
				<p class="fs16 mb5"><?php if(isset($_SESSION["name"])){echo $_SESSION["name"];}?> 회원님의 아이디는 아래와 같습니다.</p>
				<strong class="big-title tc-brand"><?php if(isset($_SESSION["id"])){echo $_SESSION["id"];}?></strong>
			</div>

            <div class="box-btn mt30">
				<a href="/member/login.html" class="btn-l">로그인하러 가기</a>
				<a href="/member/index.php?mode=find_pw" class="btn-l-line ml5">비밀번호 찾기</a>
			</div>

		</div>
	</div>
</div>