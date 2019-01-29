<?php

namespace app\models;

class Validate
{
    public $attributes;
    public function validate(){
        print($this);
        if($this->rules()){
            print_r($this->rules()[0][0]);
        }
     echo 1;
    }
}
