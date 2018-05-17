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
    protected $huc;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->huc = $this->webu->huc;
    }

    /**
     * testInstance
     * 
     * @return void
     */
    public function testInstance()
    {
        $huc = new Huc($this->testHost);

        $this->assertTrue($huc->provider instanceof HttpProvider);
        $this->assertTrue($huc->provider->requestManager instanceof RequestManager);
    }

    /**
     * testSetProvider
     * 
     * @return void
     */
    public function testSetProvider()
    {
        $eth = $this->huc;
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