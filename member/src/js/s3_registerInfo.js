var idDuplicateChecked = false;
$(document).ready(function(){
    phoneNumberFiller("<?php echo $_SESSION['phoneNumber']?>");
    emailDomainSplit();
    emailDomainSelector();

    /*
    *	id중복 체크 : id필드 null 체크 -> id중복체크function 호출 -> 중복 : idDuplicateChecked = false, 미중복 = true;
    */
    $("#idCheckBtn").on("click",function(){
        var id = $("#id").val();
        if(id==""){
            alert("중복확인을 위해 아이디를 입력해 주세요.");
            return;
        }
        idDuplicationChecker(id, function(isDuplicated) {
            if(!isDuplicated){
                alert("사용 가능한 ID입니다.");
                idDuplicateChecked = true;
            } else {
                alert("이미 사용중인 ID입니다.");
                idDuplicateChecked = false;
            }
        });
    });

    $("#id").on("change",function(){
        idDuplicateChecked = false;
    });

    /*
    *	회원가입 버튼 클릭 -> 유효성 검사 -> valid: 서버 가입요청 call / 실패: 알럿
    */
    $("#regSubmitBtn").on("click",function(){
        var member = new Member();
        member.setMember();
        console.log(member);
        var validCheck = member.isValid();
        if(validCheck!="valid"){
            alert(validCheck);
        } else {
            $.ajax({
                url: 'restcontroller/RegisterController.php'
                ,type: 'POST'
                ,data: {
                    'action': "newMember"
                    ,'member' : member
                }
                ,success: function(result){

                    var parsedResult = JSON.parse(result);
                    if(parsedResult.result=="valid_fail" || parsedResult.result=="duplicatedId"){
                        alert(parsedResult.message);
                    } else if(parsedResult.result=="session_end"){
                        window.history.back();
                        alert(parsedResult.message);
                        window.location.href="index.php?mode=step_02";
                    } else {
                        window.location.href="index.php?mode=complete";
                    }

                    console.log(result);

                }
                ,error: function(result){
                    console.log("오류가 발생했습니다.");
                }
            })
        }
    })
});

class Member{
    setMember(){
        this.name = $("#name").val();
        this.id = $("#id").val();
        this.idDuplicateChecked = idDuplicateChecked;
        this.pw = $("#pw").val();
        this.pwConfirm = $("#pwConfirm").val();
        this.email = emailMerger();
        this.mobileNumber = "<?php echo $_SESSION['phoneNumber']?>";
        this.telNumber = telNumberMerger();
        this.postalCode = $("#postalCode").val();
        this.address = $("#address").val();
        this.additionalAddress = $("#additionalAddress").val();
        this.smsAgreed = $("#smsAgreed").is(":checked");
        this.mailAgreed = $("#mailAgreed").is(":checked");
    }

    isValid(){
        if(this.name=="" || this.name==null){
            return "이름을 입력해 주세요.";
        }
        if(this.id=="" || this.id==null){
            return "아이디를 입력해 주세요.";
        }
        if(!this.idDuplicateChecked){
            return "아이디 중복확인을 해주세요.";
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

function idDuplicationChecker(id, callback){

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
        ,success: function(result){
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

function emailMerger(){
    if($("#email").val()!="" && $("#emailDomain").val()!=""){
        return $("#email").val()+"@"+$("#emailDomain").val();
    }
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

function telNumberMerger(){
    if($("#telNumberBegin").val()!="" && $("#telNumberCenter").val()!="" && $("#telNumBerLast").val()!=""){
        return ""+$("#telNumberBegin").val()+$("#telNumberCenter").val()+$("#telNumBerLast").val();
    }
}

function hoverEffect(element) {
    element.style.cursor = 'pointer';
}

function normalCursor(element) {
    element.style.cursor = 'default';
}