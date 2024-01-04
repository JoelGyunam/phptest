<?php 
    class LoginUserInfoDto {
        public $name;
        public $id;
        public $password;
        public $passwordConfirm;
        public $email;
        public $mobileNumber;
        public $telNumber;
        public $postalCode;
        public $address;
        public $additionalAddress;
        public $smsAgreed;
        public $mailAgreed;
        public $regDttm;
        public $modDttm;

        public function setValues($name,$id,$password,$passwordConfirm,$email,$mobileNumber,$telNumber,$postalCode,$address,$additionalAddress,$smsAgreed,$mailAgreed,$regDttm,$modDttm){
            $this->name=$name;
            $this->id=$id;
            $this->password=$password;
            $this->passwordConfirm=$passwordConfirm;
            $this->email=$email;
            $this->mobileNumber=$mobileNumber;
            $this->telNumber=$telNumber;
            $this->postalCode=$postalCode;
            $this->address=$address;
            $this->additionalAddress=$additionalAddress;
            $this->smsAgreed=$smsAgreed;
            $this->mailAgreed=$mailAgreed;
            $this->regDttm=$regDttm;
            $this->modDttm=$modDttm;
        }

        public function toArray(){
            return get_object_vars($this);
        }
    }
?>