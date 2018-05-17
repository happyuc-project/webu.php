<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\RequestManagers\RequestManager;

class RequestManagerTest extends TestCase
{
    /**
     * testSetHost
     * 
     * @return void
     */
    public function testSetHost()
    {
        $requestManager = new RequestManager('http://193.112.32.158:8545', 0.1);
        $this->assertEquals($requestManager->host, 'http://193.112.32.158:8545');
        $this->assertEquals($requestManager->timeout, 0.1);

        $requestManager->host = $this->testRinkebyHost;
        $requestManager->timeout = 1;
        $this->assertEquals($requestManager->host, 'http://193.112.32.158:8545');
        $this->assertEquals($requestManager->timeout, 0.1);
    }
}