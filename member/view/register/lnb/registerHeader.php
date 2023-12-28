<div class="tit-box-h3">
    <h3 class="tit-h3">회원가입</h3>
    <div class="sub-depth">
        <span><i class="icon-home"><span>홈</span></i></span>
        <strong>회원가입</strong>
    </div>
</div>

<div class="join-step-bar">
    <ul>
        <li id="step_01_Progress" class="on progressBar"><i class="icon-join-agree"></i> 약관동의</li>
        <li id="step_02_Progress" class="progressBar"><i class="icon-join-chk"></i> 본인확인</li>
        <li id="step_03_Progress" class="progressBar"><i class="icon-join-inp"></i> 정보입력</li>
    </ul>
</div>

<script>
    $(document).ready(function(){
        //파라미터 값 기준으로, 해당 스텝의 progressbar 에 on 클래스 추가.
        var modeValue = paramDetect();
        $(".progressBar").removeClass();
        $("#"+modeValue+"_Progress").addClass("on");
    });

    function paramDetect(){
        var param = $(location).attr('search');
        if(param.includes('mode=')) {
            var modeValue = param.split('mode=')[1];
            return modeValue;
        }
    }

</script>