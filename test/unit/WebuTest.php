<?php

namespace Test\Unit;

use RuntimeException;
use Test\TestCase;
use Webu\HttpProvider;
use Webu\HttpRequestManager;
use Webu\Webu;
use Webu\Irc;
use Webu\Net;
use Webu\Personal;
use Webu\Shh;
use Webu\Utils;

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
        $webu = new Webu($this->testHost);

        $this->assertTrue($webu->getProvider() instanceof HttpProvider);
        $this->assertTrue($webu->getProvider()->getRequestManager() instanceof HttpRequestManager);
        $this->assertTrue($webu->irc instanceof Irc);
        $this->assertTrue($webu->net instanceof Net);
        $this->assertTrue($webu->personal instanceof Personal);
        $this->assertTrue($webu->shh instanceof Shh);
    }

    /**
     * testSetProvider
     * 
     * @return void
     */
    public function testSetProvider()
    {
        $webu = $this->webu;

        $this->assertEquals($webu->getProvider()->getRequestManager()->getHost(), $this->testHost);

    }

    /**
     * testCallThrowRuntimeException
     * 
     * @return void
     */
    public function testCallThrowRuntimeException()
    {
        $this->expectException(RuntimeException::class);

        $webu = new Webu($this->testHost);
        $webu->sha3('hello world');
    }
}