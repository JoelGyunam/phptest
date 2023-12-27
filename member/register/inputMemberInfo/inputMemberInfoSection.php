<div id="container" class="container-full">
    <div id="content" class="content">
        <div class="inner">
            <?php // include '..\registerLnb\registerHeader.php'?>
			<?php require_once(getenv('BASE_PATH').'/member/register/registerLnb/registerHeader.php');?>

            <div class="tit-box-h4">
				<h3 class="tit-h4">본인인증</h3>
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
							<td><input id="name" type="text" class="input-text" style="width:302px"></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>아이디</th>
							<td><input id="id" type="text" class="input-text" style="width:302px" placeholder="영문자로 시작하는 4~15자의 영문소문자, 숫자"><a id="idCheckBtn" href="#" class="btn-s-tin ml10">중복확인</a></td>
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
								<input id="email" type="text" class="input-text" style="width:138px"> @ <input id="emailDomain" type="text" class="input-text" style="width:138px">
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
							<td>
								<input id="mobileNumberBegin" type="text" class="input-text" style="width:50px" disabled> - 
								<input id="mobileNumberCenter" type="text" class="input-text" style="width:50px" disabled> - 
								<input id="mobileNumberLast" type="text" class="input-text" style="width:50px" disabled>
							</td>
						</tr>
						<tr>
							<th scope="col"><span class="icons"></span>일반전화 번호</th>
							<td><input id="telNumberBegin" type="text" class="input-text" style="width:88px"> - <input id="telNumberCenter" type="text" class="input-text" style="width:88px"> - <input id="telNumBerLast" type="text" class="input-text" style="width:88px"></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>주소</th>
							<td>
								<p>
									<label>우편번호 <input id="postalCode" type="text" class="input-text ml5" style="width:242px" disabled=""></label><a id="findAddressBtn" onclick="execDaumPostcode()" href="#" class="btn-s-tin ml10">주소찾기</a>
								</p>
								<p class="mt10">
									<label>기본주소 <input id="address" type="text" class="input-text ml5" style="width:719px"></label>
								</p>
								<p class="mt10">
									<label>상세주소 <input id="additionalAddress" type="text" class="input-text ml5" style="width:719px"></label>
								</p>
							</td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>SMS수신</th>
							<td>
								<div class="box-input">
									<label class="input-sp">
										<input id="smsAgreed" id="smsAgreed" type="radio" name="radio" checked="checked">
										<span class="input-txt">수신함</span>
									</label>
									<label class="input-sp">
										<input type="radio" name="radio">
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
										<input type="radio" name="radio2" id="">
										<span class="input-txt">미수신</span>
									</label>
								</div>
								<p>메일수신 시, 해커스의 혜택 및 이벤트 정보를 받아보실 수 있습니다.</p>
							</td>
						</tr>
					</tbody>
				</table>

				<div id="regSubmitBtn" class="box-btn">
					<a class="btn-l">회원가입</a>
				</div>
			</div>

        </div>
    </div>  
</div>


<script>
    $(document).ready(function(){
        
        phoneNumberFiller("<?php echo $_SESSION['phoneNumber']?>");
        let member = new Member();
        member.mobileNumber = "<?php echo $_SESSION['phoneNumber']?>";

        //      회원가입 3단계(회원정보입력)
        //     - 필수항목 : * 화된 모든 개인정보
        //     - 아이디  중복체크기능 추가할것
        //     - 우편번호 찾기 다음 API활용
        //     - 2단계에 입력받은 휴대폰 번호는 재입력 하지 않도록 디폴트 세팅할것(인증용으로 사용된 정보는 수정불가임을 확인)
        //     - /member/index.php?mode=step_03

        //     회원가입 처리단계
        //     - 넘어온 항목 유효성 체크할것(필수정보, 중복처리유무 등등)
        //     - 비밀번호는 sha256 암호화처리
        //     - /member/index.php?mode=regist

        //     회원가입완료
        //     - 로그인이 되어있지 않은 상태이며 로그인 버튼 클릭시 로그인 페이지로 이동
        //     - /member/index.php?mode=complete

        $("#regSubmitBtn").on("click",function(){
            var member = new Member();
            member.setName($("#name").val());
            member.setId($("#id").val());
        })

		$("#idCheckBtn").on("click",function(){
			var id = $("#id").val();
			if(id==""){
				return;
			}
			idDuplicationChecker(id, function(isDuplicated) {
				console.log(isDuplicated);
				if(!isDuplicated){
					alert("사용 가능한 ID입니다.");
				} else {
					alert("이미 사용중인 ID입니다.");
				}
			});
		})

		emailDomainSplit();
		emailDomainSelector();

		// $("#findAddressBtn").on("click",function(){
		// 	e.preventDefault();
		// 	new daum.Postcode({
		// 		oncomplete: function(data){
		// 			$("#postalCode").val(data.zonecode);
		// 			$("#address").val(data.address);
		// 			$("#additionalAddress").focus();
		// 		}
		// 	}).open();
		// })
	});

    class Member{
        constructor(){
            this.name = null;
            this.id = null;
            this.idDuplicationCheck = null;
            this.password = null;
            this.email = null;
            this.mobileNumber = null;
            this.telNumber = null;
        }

        setName(name){
            this.name = name;
        }

        setId(id){
			idDuplicationChecker("1");
        }
    }

	function idDuplicationChecker(id, callback){
		$.ajax({
			url: 'register/inputMemberInfo/inputMemberInfoService.php'
			,type: 'POST'
			,data: {
				'action': "idcheck"
				,'id' : id
			}
			,success: function(result){
				console.log(result);
				if(result=="available"){
					callback(false);
				} else {
					callback(true);
				}
			}
			,error: function(){
				callback(true);
			}
		});
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


    function phoneNumberFiller(mobileNumber){
        var numArr = phoneNumberSlicer(mobileNumber)
        $("#mobileNumberBegin").val(numArr[0]);
        $("#mobileNumberCenter").val(numArr[1]);
        $("#mobileNumberLast").val(numArr[2]);
    }

    function phoneNumberSlicer(mobileNumber){
        if(mobileNumber.length!=11){
            alert("오류가 발생했어요. 다시 시도해 주세요.");
            window.history.back();
        }
        var numArr=[];
        numArr[0] = mobileNumber.slice(0,3);
        numArr[1] = mobileNumber.slice(3,7);
        numArr[2] = mobileNumber.slice(7,11);
        return numArr;
    }

</script>
<!-- <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script> -->
<script>
    function execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if(data.userSelectedType === 'R'){
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
					// -> 참고항목은 addr 뒤에 붙였음.
                    // document.getElementById().value = extraAddr;
                } 
				// else {
                //     document.getElementById().value = '';
                // }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('postalCode').value = data.zonecode;
                document.getElementById("address").value = addr + extraAddr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("additionalAddress").focus();
            }
        }).open();
    }
</script>