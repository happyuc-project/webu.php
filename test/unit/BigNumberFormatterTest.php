<?php

namespace Test\Unit;

use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;

class BigNumberFormatterTest extends TestCase
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

        $bigNumber = \Webu\Formatter::BigNumber(1);
        $this->assertEquals($bigNumber->toString(), '1');
        $this->assertTrue($bigNumber instanceof BigNumber);
    }
}