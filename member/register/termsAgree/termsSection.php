<?php 
    require_once(getenv('BASE_PATH').'/domain/terms/TermsDocument.php');

    $document = new Document($sort);
    $termsTitle = $document->getTitle();
    $isOptional = $document->getIsOptional();
    $termsContent = $document->getContent();
?>

<div class="section-content">
    <div class="tit-box-h4">
        <h3 class="tit-h4"><?php echo $termsTitle ?><span class="tc-brand"> (<?php echo $isOptional ?>)</span></h3>
    </div>
    
    <div class="agree-box">
        <div class="agree-box-txt">
            <?php echo $termsContent ?>
        </div>
        <button type="button" class="js_agree_open"><em>펼치기 ▼</em></button>
        <div class="mt10">
            <label class="input-sp">
                <input type="checkbox" class="eachCheckBox">
                <span class="input-txt">약관에 동의합니다.</span>
            </label>
        </div>
    </div>
</div>