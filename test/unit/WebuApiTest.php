<?php

namespace Test\Unit;

use RuntimeException;
use InvalidArgumentException;
use Test\TestCase;

class WebuApiTest extends TestCase
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
     * testClientVersion
     * 
     * @return void
     */    
    public function testClientVersion()
    {
        $webu = $this->webu;

        $version = $webu->clientVersion();

        // print_r($version);

        $this->assertTrue(is_string($version));
    }

    /**
     * testSha3
     * 
     * @return void
     */    
    public function testSha3()
    {
        $webu = $this->webu;

        $hash = $webu->sha3($this->testHex);
        $this->assertEquals($hash, $this->testHash);

        $hash = $webu->sha3('hello world');
        $this->assertEquals($hash, $this->testHash);
    }

    /**
     * testUnallowedMethod
     * 
     * @return void
     */
    public function testUnallowedMethod()
    {
        $this->expectException(RuntimeException::class);

        $webu = $this->webu;

        $webu->hello();

        $this->assertTrue(true);
    }

    /**
     * testWrongParam
     * We transform data and throw invalid argument exception
     * instead of runtime exception.
     * 
     * @return void
     */
    public function testWrongParam()
    {
        $this->expectException(RuntimeException::class);

        $webu = $this->webu;

        $webu->sha3($webu);
        $this->assertTrue(true);
    }

    /**
     * testWrongCallback
     * 
     * @return void
     */
    public function testWrongCallback()
    {
        $this->expectException(InvalidArgumentException::class);

        $webu = $this->webu;

        $webu->sha3('hello world');
    }
}