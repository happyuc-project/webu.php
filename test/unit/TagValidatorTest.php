<?php

namespace Test\Unit;

use Test\TestCase;

class TagValidatorTest extends TestCase
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

        $this->assertEquals(false, \Webu\Validator::Tag(1234));
        $this->assertEquals(false, \Webu\Validator::Tag(0xCA35B7D915458EF540ADE6068DFE2F44E8FA733C));
        $this->assertEquals(false, \Webu\Validator::Tag('hello'));
        $this->assertEquals(true, \Webu\Validator::Tag('latest'));
        $this->assertEquals(true, \Webu\Validator::Tag('earliest'));
        $this->assertEquals(true, \Webu\Validator::Tag('pending'));
    }
}