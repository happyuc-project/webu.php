<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Formatters\BooleanFormatter;

class BooleanFormatterTest extends TestCase
{
    /**
     * formatter
     * 
     * @var \Webu\Formatters\BooleanFormatter
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
        $this->formatter = new BooleanFormatter;
    }

    /**
     * testFormat
     * 
     * @return void
     */
    public function testFormat()
    {
        $formatter = $this->formatter;

        $boolean = $formatter->format(true);
        $this->assertEquals($boolean, true);

        $boolean = $formatter->format(1);
        $this->assertEquals($boolean, true);

        $boolean = $formatter->format(false);
        $this->assertEquals($boolean, false);

        $boolean = $formatter->format(0);
        $this->assertEquals($boolean, false);
    }
}