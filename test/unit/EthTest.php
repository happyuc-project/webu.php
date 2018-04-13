<?php

namespace Test\Unit;

use RuntimeException;
use Test\TestCase;
use Webu\Providers\HttpProvider;
use Webu\RequestManagers\RequestManager;
use Webu\RequestManagers\HttpRequestManager;
use Webu\Huc;

class HucTest extends TestCase
{
    /**
     * eth
     * 
     * @var \Webu\Huc
     */
    protected $eth;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->eth = $this->webu->eth;
    }

    /**
     * testInstance
     * 
     * @return void
     */
    public function testInstance()
    {
        $eth = new Huc($this->testHost);

        $this->assertTrue($eth->provider instanceof HttpProvider);
        $this->assertTrue($eth->provider->requestManager instanceof RequestManager);
    }

    /**
     * testSetProvider
     * 
     * @return void
     */
    public function testSetProvider()
    {
        $eth = $this->eth;
        $requestManager = new HttpRequestManager('http://localhost:8545');
        $eth->provider = new HttpProvider($requestManager);

        $this->assertEquals($eth->provider->requestManager->host, 'http://localhost:8545');

        $eth->provider = null;

        $this->assertEquals($eth->provider->requestManager->host, 'http://localhost:8545');
    }

    /**
     * testCallThrowRuntimeException
     * 
     * @return void
     */
    public function testCallThrowRuntimeException()
    {
        $this->expectException(RuntimeException::class);

        $eth = new Huc(null);
        $eth->protocolVersion();
    }
}