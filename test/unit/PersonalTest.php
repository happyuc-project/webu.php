<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Personal;

class PersonalTest extends TestCase
{
    /**
     * personal
     * 
     * @var \Webu\Personal
     */
    protected $personal;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->personal = $this->webu->personal;
    }

    /**
     * testInstance
     *
     * 0x7a8e09366299314443fd824151006ca5b889e023
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
        try{
            $account = $this->personal->newAccount('qq123456');
            // echo $account."\n";
            $this->assertTrue((preg_match('/^0x[a-f0-9]{40}$/', $account) === 1));

        }catch (\Exception $exception)
        {
            echo  "\n".$exception->getMessage()."\n";
        }
    }
}