<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Formatter;

class AddressFormatterTest extends TestCase
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

        $address = Formatter::Address('0Xca35b7d915458ef540ade6068dfe2f44e8fa733c');
        $this->assertEquals($address, '0xca35b7d915458ef540ade6068dfe2f44e8fa733c');

        $address = Formatter::Address('0XCA35B7D915458EF540ADE6068DFE2F44E8FA733C');
        $this->assertEquals($address, '0xca35b7d915458ef540ade6068dfe2f44e8fa733c');

        $address = Formatter::Address('0xCA35B7D915458EF540ADE6068DFE2F44E8FA733C');
        $this->assertEquals($address, '0xca35b7d915458ef540ade6068dfe2f44e8fa733c');

        $address = Formatter::Address('CA35B7D915458EF540ADE6068DFE2F44E8FA733C');
        $this->assertEquals($address, '0xca35b7d915458ef540ade6068dfe2f44e8fa733c');

        $address = Formatter::Address('1234');
        $this->assertEquals($address, '0x00000000000000000000000000000000000004d2');

        $address = Formatter::Address('abcd');
        $this->assertEquals($address, '0x000000000000000000000000000000000000abcd');
    }
}