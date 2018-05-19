<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Formatter;

class QuantityFormatterTest extends TestCase
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
        $this->assertEquals('0x927c0', Formatter::Quantity(0x0927c0));
        $this->assertEquals('0x927c0', Formatter::Quantity('0x0927c0'));
        $this->assertEquals('0x927c0', Formatter::Quantity('0x927c0'));
        $this->assertEquals('0x927c0', Formatter::Quantity('600000'));
        $this->assertEquals('0x927c0', Formatter::Quantity(600000));
        
        $this->assertEquals('0xea60', Formatter::Quantity('0x0ea60'));
        $this->assertEquals('0xea60', Formatter::Quantity('0xea60'));
        $this->assertEquals('0xea60', Formatter::Quantity(0x0ea60));
        $this->assertEquals('0xea60', Formatter::Quantity('60000'));
        $this->assertEquals('0xea60', Formatter::Quantity(60000));

        $this->assertEquals('0x0', Formatter::Quantity(0x00));
        $this->assertEquals('0x0', Formatter::Quantity('0x00'));
        $this->assertEquals('0x0', Formatter::Quantity('0x0'));
        $this->assertEquals('0x0', Formatter::Quantity('0'));
        $this->assertEquals('0x0', Formatter::Quantity(0));
    }
}