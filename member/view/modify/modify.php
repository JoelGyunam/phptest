<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<!--[if (IE 7)]><html class="no-js ie7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko"><![endif]-->
<!--[if (IE 8)]><html class="no-js ie8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko"><![endif]-->

    <?php
    require $_SERVER["DOCUMENT_ROOT"].'/gnb/headData.php';
    ?>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"].'/gnb/skipnav.php' ?>
        <div id="wrap">
            <?php
            include $_SERVER["DOCUMENT_ROOT"].'/gnb/header.php';
            include $_SERVER["DOCUMENT_ROOT"].'/member/view/modify/modifySection.php';
            include $_SERVER["DOCUMENT_ROOT"].'/gnb/footer.php'
            ?>
        </div>
    </body>
</html>