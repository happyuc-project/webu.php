<?php

namespace Test\Unit;

use Test\TestCase;

class CallValidatorTest extends TestCase
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

        $this->assertEquals(false, \Webu\Validator::Call('hello webu.php'));
        $this->assertEquals(false, \Webu\Validator::Call([]));
        $this->assertEquals(false, \Webu\Validator::Call([
            'from' => '',
            'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
        ]));
        $this->assertEquals(false, \Webu\Validator::Call([
            'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'gas' => '',
        ]));
        $this->assertEquals(false, \Webu\Validator::Call([
            'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'gasPrice' => '',
        ]));
        $this->assertEquals(false, \Webu\Validator::Call([
            'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'value' => '',
        ]));
        $this->assertEquals(false, \Webu\Validator::Call([
            'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'data' => '',
        ]));
        $this->assertEquals(false, \Webu\Validator::Call([
            'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'nonce' => '',
        ]));
        $this->assertEquals(true, \Webu\Validator::Call([
            'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
        ]));
        $this->assertEquals(true, \Webu\Validator::Call([
            'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'gas' => '0x76c0',
            'gasPrice' => '0x9184e72a000',
            'value' => '0x9184e72a',
            'data' => '0xd46e8dd67c5d32be8d46e8dd67c5d32be8058bb8eb970870f072445675058bb8eb970870f072445675',
            'nonce' => '0x9184e72a',
        ]));
    }
}