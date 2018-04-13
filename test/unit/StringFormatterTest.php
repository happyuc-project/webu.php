<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Formatters\StringFormatter;

class StringFormatterTest extends TestCase
{
    /**
     * formatter
     * 
     * @var \Webu\Formatters\StringFormatter
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
        $this->formatter = new StringFormatter;
    }

    /**
     * testFormat
     * 
     * @return void
     */
    public function testFormat()
    {
        $formatter = $this->formatter;

        $str = $formatter->format(123456);
        $this->assertEquals($str, '123456');
    }
}