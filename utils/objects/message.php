<?php
    class Message
    {
        private $Id;
        private $UserId;
        private $ReceiverId;
        private $Content;

        public function __construct() { 
            $this->UserId = 0;
            $this->ReceiverId = 0;
        }

        public function getId(){
            return $this->Id;
        }

        public function setId($id){
            $this->Id = $id;
        }

        public function getUserId(){
            return $this->UserId;
        }

        public function setUserId($id){
            $this->UserId = $id;
        }

        public function getReceiverId(){
            return $this->ReceiverId;
        }

        public function setReceiverId($id){
            $this->ReceiverId = $id;
        }

        public function getContent(){
            return $this->Content;
        }

        public function setContent($ctt){
            $this->Content = $ctt;
        }
    }

?>