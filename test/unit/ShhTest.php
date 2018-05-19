<?php

namespace Test\Unit;

use RuntimeException;
use Test\TestCase;
use Webu\HttpProvider;
use Webu\HttpRequestManager;
use Webu\Shh;

class ShhTest extends TestCase
{
    /**
     * shh
     * 
     * @var \Webu\Shh
     */
    protected $shh;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->shh = $this->webu->shh;
    }

    /**
     * testInstance
     * 
     * @return void
     */
    public function testInstance()
    {
        $this->assertTrue($this->webu->getProvider() instanceof HttpProvider);
        $this->assertTrue($this->webu->getProvider()->getRequestManager() instanceof HttpRequestManager);
    }

    /**
     * testSetProvider
     * 
     * @return void
     */
    public function testSetProvider()
    {

        $this->assertEquals($this->webu->getProvider()->getRequestManager()->getHost(), $this->testHost);
    }

    /**
     * testCallThrowRuntimeException
     * 
     * @return void
     */
    public function testCallThrowRuntimeException()
    {
        $this->expectException(RuntimeException::class);

        // $this->webu->shh->post([]);
    }
}