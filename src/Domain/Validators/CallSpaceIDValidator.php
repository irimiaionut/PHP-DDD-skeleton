<?php

namespace App\Domain\Validators;

class CallSpaceIDValidator{

    //options separator
    private $separator = "|";

    //holds expectation object
    private $expect = [
        "token" => "required|string",
    ];

    public function __construct($expect = null)
    {
        if($expect != null){
            $this->expect = $expect;
        }

    }

    public function validate(array $data){
        if(sizeOf($data) == 0){
            throw new Exception("[Validator] [ERROR] Config object is empty");
        }

        foreach( $this->expect as $key => $value){
            $options = explode($this->separator, $value);
            foreach($options as $option) {
                $this->validateOption($data, $key, $option);
            }
        }
        return true;
    }

    private function validateOption($data, $value, $option){

        switch($option) {
            case 'required':
                if(!array_key_exists($value, $data)){
                    throw new Exception('[Validator] ' . $value . ' is required');
                }
                break;
            case 'string':
                if (!is_string($data[$value])) {
                    throw new Exception('[Validator] ' . $value . ' should be string');
            }
        break;
            default:
        }
        return true;
    }
}