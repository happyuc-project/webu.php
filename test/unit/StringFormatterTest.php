<?php

namespace Test\Unit;

use Test\TestCase;

class StringFormatterTest extends TestCase
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
     * testFormat
     * 
     * @return void
     */
    public function testFormat()
    {

        $str = \Webu\Formatter::String(123456);
        $this->assertEquals($str, '123456');
    }
}