<?php

namespace App\Application\ControllerServices;


class TestService
{
    public function test(){
        return array(
            'status'  => 'success',
            'message' => 'The api is working'
        );
    }
}