<?php

namespace Test\Unit;

use Test\TestCase;

class StringValidatorTest extends TestCase
{

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
     * testValidate
     * 
     * @return void
     */
    public function testValidate()
    {

        $this->assertEquals(true, \Webu\Validator::String('0Xca35b7d915458ef540ade6068dfe2f44e8fa733c'));
        $this->assertEquals(false, \Webu\Validator::String(1234));
        $this->assertEquals(false, \Webu\Validator::String(0xCA35B7D915458EF540ADE6068DFE2F44E8FA733C));
    }
}