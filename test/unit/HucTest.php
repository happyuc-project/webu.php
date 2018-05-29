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
     * huc
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
        $this->assertTrue($this->webu->getProvider() instanceof \Webu\HttpProvider);
        $this->assertTrue($this->webu->getProvider()->getRequestManager() instanceof \Webu\HttpRequestManager);
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

        try{
            $this->webu->huc->protocolVersion();
        }catch (\Exception $err) {
            echo $err->getMessage();
        }
    }
}