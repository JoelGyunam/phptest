<?php
class Document {
    private $title;
    private $content;
    private $isOptional;
    private $sort;

    public function __construct($sort) {
        $this->sort = $sort;
        if ($sort == "termsOfUse") {
            $this->title = "이용 약관";
            $this->content = $this->getContent($sort);
            $this->isOptional = false;
        } else if($sort == "termsOfPrivacy") {
            $this->title = "개인정보취급방침";
            $this->content = $this->getContent($sort);
            $this->isOptional = false;
        }
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        $this->loadContent($this->sort);
        return $this->content;
    }

    private function loadContent($sort){
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/domain/terms/' . $sort . '.txt';
        if (file_exists($filePath)) {
            $this->content = file_get_contents($filePath);
        } else {
            $this->content = "내용을 불러올 수 없습니다.";
        }
    }

    public function getIsOptional() {
        return $this->isOptional ? "선택" : "필수";
    }
}

?>