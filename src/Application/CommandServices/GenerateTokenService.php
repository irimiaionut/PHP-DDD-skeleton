<?php

namespace App\Application\CommandServices;

use App\Domain\Token\TokenGenerator;

class GenerateTokenService{

    private $tokenGenerator;

    public function __construct(TokenGenerator $tokenGenerator)
    {
        $this->tokenGenerator = $tokenGenerator;

    }

    public function generateNewToken($clientName = null)
    {
        $token = $this->tokenGenerator->generate($clientName);
        return $token;
    }
}