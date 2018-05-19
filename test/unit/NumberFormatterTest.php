<?php

namespace Test\Unit;

use Test\TestCase;

class NumberFormatterTest extends TestCase
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

        $number= \Webu\Formatter::Number('123');
        $this->assertEquals($number, 123);
    }
}