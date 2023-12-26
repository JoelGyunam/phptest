<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<!--[if (IE 7)]><html class="no-js ie7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko"><![endif]-->
<!--[if (IE 8)]><html class="no-js ie8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko"><![endif]-->

    <?php
    require '../gnb/headData.php';
    session_start();
    ?>
    <body>
        <?php include getenv('BASE_PATH').'/gnb/skipnav.php' ?>
        <div id="wrap">
            <?php
            include getenv('BASE_PATH').'/gnb/header.php';
            include getenv('BASE_PATH').'/member/register/termsAgree/termsContainer.php';
            include getenv('BASE_PATH').'/gnb/footer.php'
            ?>
        </div>
    </body>
</html>