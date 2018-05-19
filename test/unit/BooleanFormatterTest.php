<?php

namespace Test\Unit;

use Test\TestCase;

class BooleanFormatterTest extends TestCase
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

        $boolean = \Webu\Formatter::Boolean(true);
        $this->assertEquals($boolean, true);

        $boolean = \Webu\Formatter::Boolean(1);
        $this->assertEquals($boolean, true);

        $boolean = \Webu\Formatter::Boolean(false);
        $this->assertEquals($boolean, false);

        $boolean = \Webu\Formatter::Boolean(0);
        $this->assertEquals($boolean, false);
    }
}