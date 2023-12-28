<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/member/repository/MemberRepository.php';

function idDuplicateCheck($id){
    $memberDb = new MemberDB();
    $result;
    $idRowCount = $memberDb->findById($id);
    if($idRowCount==0){
        $result = "available";
    } else {
        $result = "unavailable";
    }
    return $result;
};

?>