<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Formatters\IntegerFormatter;

class IntegerFormatterTest extends TestCase
{
    /**
     * formatter
     * 
     * @var \Webu\Formatters\IntegerFormatter
     */
    protected $formatter;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->formatter = new IntegerFormatter;
    }

    /**
     * testFormat
     * 
     * @return void
     */
    public function testFormat()
    {
        $formatter = $this->formatter;

        $hex = $formatter->format('1');
        $this->assertEquals($hex, implode('', array_fill(0, 63, '0')) . '1');

        $hex = $formatter->format('-1');
        $this->assertEquals($hex, implode('', array_fill(0, 64, 'f')));

        $hex = $formatter->format('ae');
        $this->assertEquals($hex, implode('', array_fill(0, 62, '0')) . 'ae');

        $hex = $formatter->format('1', 20);
        $this->assertEquals($hex, implode('', array_fill(0, 19, '0')) . '1');
    }
}