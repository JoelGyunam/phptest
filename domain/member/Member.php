<?php 

class Member {

    private $name;
    private $id;
    private $password;
    private $email;
    private $mobileCode;
    private $mobileNumber;
    private $telNumber;
    private $postalCode;
    private $address;
    private $additionalAddress;
    private $smsAgreed;
    private $mailAgreed;
    private $regDttm;
    private $modDttm;

    public function setMobileNumber($mobileNumber){
        $this->mobileNumber = $mobileNumber;
    }

    public function setMobileCode($mobileCode){
        $this->mobileCode = $mobileCode;
    }

}
?>