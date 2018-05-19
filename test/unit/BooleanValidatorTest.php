<?php

namespace Test\Unit;

use Test\TestCase;

class BooleanValidatorTest extends TestCase
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

        $this->assertEquals(false, \Webu\Validator::Boolean('0XCA35B7D915458EF540ADE6068DFE2F44E8FA733C'));
        $this->assertEquals(false, \Webu\Validator::Boolean(0xCA35B7D915458EF540ADE6068DFE2F44E8FA733C));
        $this->assertEquals(true,  \Webu\Validator::Boolean(true));
    }
}