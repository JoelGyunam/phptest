<?php 
    class UpdateMemberInfoService{

        function updatePassword($pwUpdateDto){
            require_once $_SERVER['DOCUMENT_ROOT'].'/member/repository/MemberRepository.php';

            if($pwUpdateDto->message!="valid"){
                return $pwUpdateDto->message;
            };

            $memberRepository = new MemberRepository();
            $result = $memberRepository->updatePassword($pwUpdateDto);
            if($result == 1){
                return "success";
            } else return "dbFail";
        }

        function updateUserInfo($new){
            // 기존 정보와 업데이트 요청 정보 간에 수정사항 있는지 확인

            // 비교 대상 : uid, id, pw, email, telNumber, postalCode, address, additionalAddress, smsAgreed, mailAgreed  
            require_once $_SERVER['DOCUMENT_ROOT'].'/member/repository/MemberRepository.php';
            $memberRepository = new MemberRepository();
            $exist = $memberRepository->findByUid($new['uid']);
            $updated = false; //변경사항 업으면 바로 noChanges로 리턴.
            $idChanged = false; //id수정사항 없으면 modifyValidChecker 에서 아이디 중복검사 생략.
            if($new['id'] != $exist['id']){
                $updated = true;
                $idChanged = true;
            }

            if($new['uid'] != $exist['uid']
                ||hash("sha256",$new['pw']) != $exist['password']
                ||$new['email'] != $exist['email']
                ||$new['telNumber'] != $exist['telNumber']
                ||$new['postalCode'] != $exist['postalCode']
                ||$new['address'] != $exist['address']
                ||$new['additionalAddress'] != $exist['additionalAddress']
                ||$new['smsAgreed'] != $exist['smsAgreed']
                ||$new['mailAgreed'] != $exist['mailAgreed']
            ){
                $updated = true;
            }

            if($updated == false){
                return "noChanges";
            }

            // 객체화 및 유효성 검증
            require_once $_SERVER['DOCUMENT_ROOT'].'/member/domain/Member.php';
            $member = new Member();
            $member->setForModifyMember($new);
            $validation = $member->modifyValidChecker($idChanged); //{result: "succeed", message: "pass"}
            $validResult = json_decode($validation); 
            if($validResult->result != "succeed"){
                return $validResult->message;
            };

            // 업데이트 처리
            require_once $_SERVER['DOCUMENT_ROOT'].'/member/repository/MemberRepository.php';
            $memberRepository = new MemberRepository();
            $updateResult = $memberRepository->updateMemberInfo($member);
            if($updateResult == 1){
                return "updated";
            } else {
                return "dbFail";
            }
            // return : updated noChanges dbFail
        }
    }
?>