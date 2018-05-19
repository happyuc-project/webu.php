<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Validators\PostValidator;

class PostValidatorTest extends TestCase
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

        $this->assertEquals(false, \Webu\Validator::Post('hello webu.php'));
        $this->assertEquals(false, \Webu\Validator::Post([]));
        $this->assertEquals(false, \Webu\Validator::Post([
            'from' => 'hello',
        ]));
        $this->assertEquals(false, \Webu\Validator::Post([
            'to' => 'hello',
        ]));
        $this->assertEquals(false, \Webu\Validator::Post([
            'from' => '0xeb0b54D62ec3f561C2eebdaebd92432126F0817579c102b062d1a6c1f2ed83e8121233',
            'to' => '0xeb0b54D62ec3f561C2eebdaebd92432126F0817579c102b062d1a6c1f2ed83e8121233',
        ]));
        $this->assertEquals(false, \Webu\Validator::Post([
            'topics' => [
                '0xzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz',
            ]
        ]));
        $this->assertEquals(false, \Webu\Validator::Post([
            'topics' => [
                '0xzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz',
            ],
            'payload' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
        ]));
        $this->assertEquals(false, \Webu\Validator::Post([
            'topics' => [
                '0xzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz',
            ],
            'payload' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'priority' => '0x1',
        ]));
        $this->assertEquals(true, \Webu\Validator::Post([
            'topics' => [
                '0xd46e8dd67c5d32be8058bb8eb970870f07244567', '0xd46e8dd67c5d32be8058bb8eb970870f07244567'
            ],
            'payload' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'priority' => '0x1',
            'ttl' => '0x1',
        ]));
        $this->assertEquals(true, \Webu\Validator::Post([
            'from' => '0xeb0b54D62ec3f561C2eebdaebd92432126F0817579c102b062d1a6c1f2ed83e8121233',
            'to' => '0xeb0b54D62ec3f561C2eebdaebd92432126F0817579c102b062d1a6c1f2ed83e8121233',
            'topics' => [
                '0xd46e8dd67c5d32be8058bb8eb970870f07244567', '0xd46e8dd67c5d32be8058bb8eb970870f07244567'
            ],
            'payload' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
            'priority' => '0x1',
            'ttl' => '0x1',
        ]));
    }
}