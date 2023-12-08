<?php
    class User
    {
        private $Id;
        private $Pseudo;
        private $Password;

        public function __construct($pseudo, $pass) { 
            $this->Pseudo = $pseudo;
            $this->Password = $pass;
        }

        public function getId(){
            return $this->Id;
        }

        public function setId($id){
            $this->Id = $id;
        }

        public function getPseudo(){
            return $this->Pseudo;
        }

        public function setPseudo($ps){
            $this->Pseudo = $ps;
        }

        public function getPassword(){
            return $this->Password;
        }

        public function setPassword($pass){
            $this->Password = $pass;
        }
    }

?>