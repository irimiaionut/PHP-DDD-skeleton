<?php

namespace App\Infrastructure\Config;

use Symfony\Component\Dotenv\Dotenv;

class Config
{
    private static $instance = null;
    private $dotenv = null;


    public function __construct(Dotenv $dotenv){
        $dotenv->load(__DIR__.'/../../.env');
        $this->dotenv = $dotenv;
    }

    public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new Config();
      }

      return self::$instance;
    }

    public function get($key, $defaultValue = null){
        if(isset($_ENV[$key])){
            return $_ENV[$key];
        }
        return $defaultValue;
    }
}