<?php

namespace Test\Unit;

use Test\TestCase;

class OptionalQuantityFormatterTest extends TestCase
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

        $this->assertEquals('0x927c0', \Webu\Formatter::OptionalQuantity(0x0927c0));
        $this->assertEquals('0x927c0', \Webu\Formatter::OptionalQuantity('0x0927c0'));
        $this->assertEquals('0x927c0', \Webu\Formatter::OptionalQuantity('0x927c0'));
        $this->assertEquals('0x927c0', \Webu\Formatter::OptionalQuantity('600000'));
        $this->assertEquals('0x927c0', \Webu\Formatter::OptionalQuantity(600000));
        
        $this->assertEquals('0xea60', \Webu\Formatter::OptionalQuantity('0x0ea60'));
        $this->assertEquals('0xea60', \Webu\Formatter::OptionalQuantity('0xea60'));
        $this->assertEquals('0xea60', \Webu\Formatter::OptionalQuantity(0x0ea60));
        $this->assertEquals('0xea60', \Webu\Formatter::OptionalQuantity('60000'));
        $this->assertEquals('0xea60', \Webu\Formatter::OptionalQuantity(60000));

        $this->assertEquals('0x0', \Webu\Formatter::OptionalQuantity(0x00));
        $this->assertEquals('0x0', \Webu\Formatter::OptionalQuantity('0x00'));
        $this->assertEquals('0x0', \Webu\Formatter::OptionalQuantity('0x0'));
        $this->assertEquals('0x0', \Webu\Formatter::OptionalQuantity('0'));
        $this->assertEquals('0x0', \Webu\Formatter::OptionalQuantity(0));

        $this->assertEquals('latest',   \Webu\Formatter::OptionalQuantity('latest'));
        $this->assertEquals('earliest', \Webu\Formatter::OptionalQuantity('earliest'));
        $this->assertEquals('pending',  \Webu\Formatter::OptionalQuantity('pending'));
        $this->assertEquals('0x0',      \Webu\Formatter::OptionalQuantity('hello'));
    }
}