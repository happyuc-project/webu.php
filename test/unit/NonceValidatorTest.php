<?php

namespace Test\Unit;

use Test\TestCase;

class NonceValidatorTest extends TestCase
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

        $this->assertEquals(false, \Webu\Validator::Nonce('0Xca35b7d915458ef540ade6068dfe2f44e8fa733c'));
        $this->assertEquals(false, \Webu\Validator::Nonce('0XCA35B7D915458EF540ADE6068DFE2F44E8FA733C'));
        $this->assertEquals(false, \Webu\Validator::Nonce('0xcA35b7D915458eF540ade6068Dfe2f44e8fA733ccA35b7D915458eF540ade6068Dfe2f44e8fA733c'));
        $this->assertEquals(false, \Webu\Validator::Nonce('CA35B7D915458EF540ADE6068DFE2F44E8FA733C'));
        $this->assertEquals(false, \Webu\Validator::Nonce('1234'));
        $this->assertEquals(false, \Webu\Validator::Nonce('abcd'));
        $this->assertEquals(false, \Webu\Validator::Nonce(0xCA35B7D915458EF540ADE6068DFE2F44E8FA733C));
        $this->assertEquals(true, \Webu\Validator::Nonce('0xCA35B7D915458EF5'));
        $this->assertEquals(true, \Webu\Validator::Nonce('0xeb0b54d62ec3f561'));
        $this->assertEquals(true, \Webu\Validator::Nonce('0xeb0b54D62ec3f561'));
    }
}