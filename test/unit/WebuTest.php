<?php

namespace Test\Unit;

use RuntimeException;
use Test\TestCase;
use Webu\Webu;
use Webu\Huc;
use Webu\Net;
use Webu\Personal;
use Webu\Shh;
use Webu\Utils;
use Webu\Providers\HttpProvider;
use Webu\RequestManagers\RequestManager;
use Webu\RequestManagers\HttpRequestManager;

class WebuTest extends TestCase
{
    /**
     * testHex
     * 'hello world'
     * you can check by call pack('H*', $hex)
     * 
     * @var string
     */
    protected $testHex = '0x68656c6c6f20776f726c64';

    /**
     * testHash
     * 
     * @var string
     */
    protected $testHash = '0x47173285a8d7341e5e972fc677286384f802f8ef42a5ec5f03bbfa254cb01fad';

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * testInstance
     * 
     * @return void
     */
    public function testInstance()
    {
        $requestManager = new HttpRequestManager('http://localhost:8545');
        $webu = new Webu(new HttpProvider($requestManager));

        $this->assertTrue($webu->provider instanceof HttpProvider);
        $this->assertTrue($webu->provider->requestManager instanceof RequestManager);
        $this->assertTrue($webu->huc instanceof Huc);
        $this->assertTrue($webu->net instanceof Net);
        $this->assertTrue($webu->personal instanceof Personal);
        $this->assertTrue($webu->shh instanceof Shh);
        $this->assertTrue($webu->utils instanceof Utils);
    }

    /**
     * testSetProvider
     * 
     * @return void
     */
    public function testSetProvider()
    {
        $webu = $this->webu;
        $requestManager = new HttpRequestManager('http://localhost:8545');
        $webu->provider = new HttpProvider($requestManager);

        $this->assertEquals($webu->provider->requestManager->host, 'http://localhost:8545');

        $webu->provider = null;
        $this->assertEquals($webu->provider->requestManager->host, 'http://localhost:8545');
    }

    /**
     * testCallThrowRuntimeException
     * 
     * @return void
     */
    public function testCallThrowRuntimeException()
    {
        $this->expectException(RuntimeException::class);

        $webu = new Webu(null);
        $webu->sha3('hello world');
    }
}