<?php

namespace Test\Unit;

use Test\TestCase;

class IntegerFormatterTest extends TestCase
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

        $hex = \Webu\Formatter::Integer('1');
        $this->assertEquals($hex, implode('', array_fill(0, 63, '0')) . '1');

        $hex = \Webu\Formatter::Integer('-1');
        $this->assertEquals($hex, implode('', array_fill(0, 64, 'f')));

        $hex = \Webu\Formatter::Integer('ae');
        $this->assertEquals($hex, implode('', array_fill(0, 62, '0')) . 'ae');

        $hex = \Webu\Formatter::Integer('1', 20);
        $this->assertEquals($hex, implode('', array_fill(0, 19, '0')) . '1');
    }
}