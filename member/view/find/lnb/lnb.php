<div class="tit-box-h3">
    <h3 class="tit-h3">아이디/비밀번호 찾기</h3>
    <div class="sub-depth">
        <span><i class="icon-home"><span>홈</span></i></span>
        <strong>아이디/비밀번호 찾기</strong>
    </div>
</div>

<ul class="tab-list">
    <li id="findIdBar"><a href="/member/index.php?mode=find_id">아이디 찾기</a></li>
    <li id="findPwBar"><a href="/member/index.php?mode=find_pw">비밀번호 찾기</a></li>
</ul>

<script>
    $(document).ready(function(){
        //파라미터 값 기준으로, 해당 스텝의 progressbar 에 on 클래스 추가.
        var modeValue = paramDetect();
        if(modeValue.includes("id")){
            $("#findIdBar").addClass("on");
            return;
        }
        if(modeValue.includes("pw")){
            $("#findPwBar").addClass("on");
            return;
        }
    });

    function paramDetect(){
        var param = $(location).attr('search');
        if(param.includes('mode=')) {
            var modeValue = param.split('mode=')[1];
            return modeValue;
        }
    }


</script>