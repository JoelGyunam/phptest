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
				<h3 class="tit-h4">비밀번호 재설정</h3>
			</div>

            <div class="section-content mt30">
				<table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
					<caption class="hidden">비밀번호 재설정</caption>
					<colgroup>
						<col style="width:17%">
						<col style="*">
					</colgroup>

					<tbody>
						<tr>
							<th scope="col">신규 비밀번호 입력</th>
							<td><input id="pw" type="text" class="input-text" placeholder="영문자로 시작하는 4~15자의 영문소문자,숫자" style="width:302px"></td>
						</tr>
						<tr>
							<th scope="col">신규 비밀번호 재확인</th>
							<td><input id="pwConfirm" type="text" class="input-text" style="width:302px"></td>
						</tr>
					</tbody>
				</table>
				<div class="box-btn">
					<a href="javascript:pwSubmit()" class="btn-l">확인</a>
				</div>
			</div>

		</div>
	</div>
</div>

<script>

function pwValidChecker(pw){
    var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,15}$/;
    return regex.test(pw);
}

function pwSubmit(){
    var pwObj = new newPassword();
    pwObj.setPassword();

    if(!pwObj.validChecker()){
        return;
    }

    $.ajax({
        url:"restcontroller/RegisterController.php"
        ,type:"UPDATE"
        ,data:{
            "action":"pw"
            ,"pwObj":pwObj
        }
        ,dataType:"json"
        ,success:function(response){
            if(response.result=="success"){
                alert("변경이 완료되었습니다. 다시 로그인해 주세요.");
                window.location.href="/member/login.html";
            } else {
                alert("잘못된 시도입니다.")
            }
        }
        ,error:function(response){
            alert("오류가 발생했습니다. 다시 시도해 주세요.");
        }
    })
}

class newPassword{
    setPassword(){
        this.uid = <?php echo $_SESSION['findUid'];?>;
        this.id = "<?php echo $_SESSION['id'];?>";
        this.pw = $("#pw").val();
        this.pwConfirm = $("#pwConfirm").val();
        this.isValid = false;

        if(this.uid==""||this.id==""){
            alert("세션이 종료되었습니다.");
            window.history.back();
        }

        if(this.pw==""){
            alert("비밀번호를 입력해 주세요");
            return;
        };

        if(this.pw != this.pwConfirm){
            alert("비밀번호가 일치하지 않습니다.");
            return;
        };

        if(!pwValidChecker(this.pw)){
            alert("사용할 수 없는 비밀번호 형식입니다.");
            return;
        };

        this.isValid = true;
    };

    validChecker(){
        return this.isValid;
    };
}


</script>