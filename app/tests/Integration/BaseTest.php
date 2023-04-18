<?php

namespace nasservb\AgencyAssistant\Tests\Integration;

use PHPUnit\Framework\TestCase;

use nasservb\AgencyAssistant\Database\DB;
use nasservb\AgencyAssistant\Models\User;

abstract class BaseTest extends TestCase
{

    protected function connectDatabase()
    {
        DB::connect();
        return $this; 
    }

    protected function refreshDatabase()
    {
        DB::init();
        return $this; 
    }

    protected function preparePostRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST'; 
        return $this; 
    }

    protected function prepareGetRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET'; 
        return $this; 
    }

    protected function login()
    {
        $token = (new User(''))->getToken('nasser.niazymobsser@gmail.com', '1');
        $_SERVER["HTTP_AUTHORIZATION"]='Bearer '.$token;
        return $this; 
    }

}
