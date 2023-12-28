<?php
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'default';

switch ($mode) {
    case 'step_01':
    // 회원가입 1단계 관련 코드
    include $_SERVER["DOCUMENT_ROOT"].'/member/view/register/s1/step_01.php';
    break;
    
    case 'step_02':
        // 회원가입 2단계 관련 코드
        include $_SERVER["DOCUMENT_ROOT"].'/member/view/register/s2/step_02.php';
        break;
    
    case 'step_03':
        // 회원가입 3단계 관련 코드
        include $_SERVER["DOCUMENT_ROOT"].'/member/view/register/s3/step_03.php';
        break;
    
    case 'regist':
        include $_SERVER["DOCUMENT_ROOT"].'/member/view/register/s4/step_04.php';
        break;

    case 'complete':
        // 회원가입 완료 관련 코드
        include $_SERVER["DOCUMENT_ROOT"].'/member/steps/complete.php';
        break;

    default:
        // 기본 페이지 또는 오류 페이지
        include $_SERVER["DOCUMENT_ROOT"].'/member/register/register.php';
        break;
    }


?>