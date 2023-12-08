<?php

namespace Fakell\Bing;


class MessageEvent {

    private $data;
    public function __construct($data){
        $this->data = $data;
    }

    /**
     * Get the value of data
     */ 
    public function getData(){
        return $this->data;
    }
}