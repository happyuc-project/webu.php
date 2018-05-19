<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\HttpRequestManager;

class RequestManagerTest extends TestCase
{
    /**
     * testSetHost
     * 
     * @return void
     */
    public function testSetHost()
    {
        $requestManager = new HttpRequestManager($this->testHost, 0.1);
        $this->assertEquals($requestManager->getHost(), $this->testHost);
        $this->assertEquals($requestManager->getTimeout(), 0.1);


        $this->assertEquals($requestManager->getHost(), $this->testHost);
        $this->assertEquals($requestManager->getTimeout(), 0.1);
    }
}