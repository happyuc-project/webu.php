<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Validators\TransactionValidator;

class TransactionValidatorTest extends TestCase
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

        $this->assertEquals(false, \Webu\Validator::Transaction('hello webu.php'));
        $this->assertEquals(false, \Webu\Validator::Transaction([]));
        $this->assertEquals(false, \Webu\Validator::Transaction([
            'from' => '',
        ]));
        $this->assertEquals(false, \Webu\Validator::Transaction([
            'from' => '0xb60e8dd61c5d32be8058bb8eb970870f07233155',
            'data' => ''
        ]));
        $this->assertEquals(true, \Webu\Validator::Transaction([
            'from' => '0xb60e8dd61c5d32be8058bb8eb970870f07233155',
            'data' => '0xd46e8dd67c5d32be8d46e8dd67c5d32be8058bb8eb970870f072445675058bb8eb970870f072445675'
        ]));
        $this->assertEquals(true, \Webu\Validator::Transaction([
            'from' => '0xb60e8dd61c5d32be8058bb8eb970870f07233155',
            'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'gas' => '0x76c0',
            'gasPrice' => '0x9184e72a000',
            'value' => '0x9184e72a',
            'data' => '0xd46e8dd67c5d32be8d46e8dd67c5d32be8058bb8eb970870f072445675058bb8eb970870f072445675'
        ]));
    }
}