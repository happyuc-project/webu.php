<?php

namespace Test\Unit;

use Test\TestCase;

class ShhFilterValidatorTest extends TestCase
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

        $this->assertEquals(false, \Webu\Validator::ShhFilter('hello webu.php'));
        $this->assertEquals(false, \Webu\Validator::ShhFilter([]));
        $this->assertEquals(false, \Webu\Validator::ShhFilter([
            'to' => 'hello',
        ]));
        $this->assertEquals(false, \Webu\Validator::ShhFilter([
            'to' => '0xeb0b54D62ec3f561C2eebdaebd92432126F0817579c102b062d1a6c1f2ed83e8121233',
        ]));
        $this->assertEquals(false, \Webu\Validator::ShhFilter([
            'to' => '0xeb0b54D62ec3f561C2eebdaebd92432126F0817579c102b062d1a6c1f2ed83e8121233',
            'topics' => [
                '0xeb0b54D62ec3f561C2eebdaebd9243212', [
                    '0xeb0b54D62ec3f561C2eebdaebd9243212', '0xzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz'
                ]
            ]
        ]));
        $this->assertEquals(true, \Webu\Validator::ShhFilter([
            'to' => '0xeb0b54D62ec3f561C2eebdaebd92432126F0817579c102b062d1a6c1f2ed83e8121233',
            'topics' => [
                '0xeb0b54D62ec3f561C2eebdaebd9243212', [
                    '0xeb0b54D62ec3f561C2eebdaebd9243212', '0xeb0b54D62ec3f561C2eebdaebd9243212'
                ]
            ]
        ]));
        $this->assertEquals(true, \Webu\Validator::ShhFilter([
            'topics' => [
                '0xeb0b54D62ec3f561C2eebdaebd9243212', [
                    '0xeb0b54D62ec3f561C2eebdaebd9243212', '0xeb0b54D62ec3f561C2eebdaebd9243212'
                ]
            ]
        ]));
    }
}