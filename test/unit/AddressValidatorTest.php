<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Formatter;

class AddressValidatorTest extends TestCase
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
     * testValidate
     * 
     * @return void
     */
    public function testValidate()
    {

        $this->assertEquals(false, \Webu\Validator::Address('0Xca35b7d915458ef540ade6068dfe2f44e8fa733c'));
        $this->assertEquals(false, \Webu\Validator::Address('0XCA35B7D915458EF540ADE6068DFE2F44E8FA733C'));
        $this->assertEquals(false, \Webu\Validator::Address('0xcA35b7D915458eF540ade6068Dfe2f44e8fA733ccA35b7D915458eF540ade6068Dfe2f44e8fA733c'));
        $this->assertEquals(false, \Webu\Validator::Address('CA35B7D915458EF540ADE6068DFE2F44E8FA733C'));
        $this->assertEquals(false, \Webu\Validator::Address('1234'));
        $this->assertEquals(false, \Webu\Validator::Address('abcd'));
        $this->assertEquals(false, \Webu\Validator::Address(0xCA35B7D915458EF540ADE6068DFE2F44E8FA733C));
        $this->assertEquals(true, \Webu\Validator::Address('0xCA35B7D915458EF540ADE6068DFE2F44E8FA733C'));
        $this->assertEquals(true, \Webu\Validator::Address('0xca35b7d915458ef540ade6068dfe2f44e8fa733c'));
        $this->assertEquals(true, \Webu\Validator::Address('0xcA35b7D915458eF540ade6068Dfe2f44e8fA733c'));
    }
}