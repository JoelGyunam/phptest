<div id="container" class="container-full">
    <div id="content" class="content">
        <div class="inner">
            <?php require_once $_SERVER["DOCUMENT_ROOT"].'/member/view/register/lnb/registerHeader.php';?>

            <?php 
                $sort = "termsOfUse";
                include 'termsSection.php';
            ?>
            <?php
                $sort = "termsOfPrivacy";
                include 'termsSection.php';
            ?>
            <div class="all-agree-box">
				<label class="input-sp">
				<input type="checkbox" id="allAgreed">
				<span class="input-txt">상위 이용약관 및 개인정보 취급방침에 모두 동의합니다.</span>
			    </label>
                    <div class="box-btn">
			        	<a id="nextBtn" href="index.php?mode=step_02" class="btn-l-gray">다음단계 (휴대폰인증)</a>
			        </div>
			</div>
        </div>
    </div>  
</div>

<script>
    $(document).ready(function() {
        var isChecked = false;

        // 각 체크박스 체크가 모두 체크 될 시 전체동의 버튼 활성화
        $(".eachCheckBox").change(function(){
            var btnCnt =  $('.eachCheckBox').length;
            var checkedCnt =  $('.eachCheckBox:checked').length;

            if(btnCnt===checkedCnt){
                isChecked = true;
                $("#allAgreed").prop("checked",true);
                $("#nextBtn").removeClass("btn-l-gray").addClass("btn-l");
            } else {
                isChecked = false;
                $("#allAgreed").prop("checked",false);
                $("#nextBtn").removeClass("btn-l").addClass("btn-l-gray");
            }
        })

        $('#allAgreed').change(function() {
            isChecked = $(this).is(":checked");
            if(isChecked){
                $(".eachCheckBox").prop("checked",true);
                $("#nextBtn").removeClass("btn-l-gray").addClass("btn-l");
            } else {
                $(".eachCheckBox").prop("checked",false);
                $("#nextBtn").removeClass("btn-l").addClass("btn-l-gray");
            }
        })

        // 전체 체크 되지 않을 시 버튼 클릭이벤트 막음.
        $("#nextBtn").on("click",function(event){
            if(!isChecked){
                event.preventDefault();
            }
        })
    });


</script>