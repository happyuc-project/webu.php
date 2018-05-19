<?php

namespace Test\Unit;

use Test\TestCase;

class HexFormatterTest extends TestCase
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

        $hex = \Webu\Formatter::Hex('ae');
        $this->assertEquals($hex, '0x6165');

        $hex = \Webu\Formatter::Hex('0xabce');
        $this->assertEquals($hex, '0xabce');

        $hex = \Webu\Formatter::Hex('123');
        $this->assertEquals($hex, '0x7b');

        $hex = \Webu\Formatter::Hex(12);
        $this->assertEquals($hex, '0xc');
    }
}