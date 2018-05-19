<?php

namespace Test\Unit;

use Test\TestCase;

class FilterValidatorTest extends TestCase
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

        $this->assertEquals(false, \Webu\Validator::Filter('hello webu.php'));
        $this->assertEquals(false, \Webu\Validator::Filter([
            'fromBlock' => 'hello',
        ]));
        $this->assertEquals(false, \Webu\Validator::Filter([
            'toBlock' => 'hello',
        ]));
        $this->assertEquals(false, \Webu\Validator::Filter([
            'address' => '0xzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz',
        ]));
        $this->assertEquals(false, \Webu\Validator::Filter([
            'topics' => [
                '0xzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz',
            ]
        ]));
        $this->assertEquals(true, \Webu\Validator::Filter([]));
        $this->assertEquals(true, \Webu\Validator::Filter([
            'fromBlock' => 'earliest',
            'toBlock' => 'latest',
            'address' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'topics' => [
                '0xd46e8dd67c5d32be8058bb8eb970870f07244567', '0xd46e8dd67c5d32be8058bb8eb970870f07244567'
            ]
        ]));
        $this->assertEquals(true, \Webu\Validator::Filter([
            'fromBlock' => 'earliest',
            'toBlock' => 'latest',
            'address' => [
                '0xd46e8dd67c5d32be8058bb8eb970870f07244567', '0xd46e8dd67c5d32be8058bb8eb970870f07244567'
            ],
            'topics' => [
                '0xd46e8dd67c5d32be8058bb8eb970870f07244567', '0xd46e8dd67c5d32be8058bb8eb970870f07244567'
            ]
        ]));
    }
}