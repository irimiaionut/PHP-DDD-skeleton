<?php

namespace App\Domain\Token;

class TokenGenerator{

    public function __construct()
    {
    }

    public function generate($data = null)
    {
        if($data == null){
            $data = $this->generateRandomString();
        }

        return md5(uniqid($data, true));
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}