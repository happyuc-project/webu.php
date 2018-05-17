<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Contracts\Types\Bytes;

class BytesTypeTest extends TestCase
{
    /**
     * testTypes
     * 
     * @var array
     */
    protected $testTypes = [
        [
            'value' => 'bytes',
            'result' => true
        ], [
            'value' => 'bytes[]',
            'result' => true
        ], [
            'value' => 'bytes[4]',
            'result' => true
        ], [
            'value' => 'bytes[][]',
            'result' => true
        ], [
            'value' => 'bytes[3][]',
            'result' => true
        ], [
            'value' => 'bytes[][6][]',
            'result' => true
        ], [
            'value' => 'bytes32',
            'result' => true
        ], [
            'value' => 'bytes8[4]',
            'result' => true
        ],
    ];

    /**
     * solidityType
     * 
     * @var \Webu\Contracts\SolidityType
     */
    protected $solidityType;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->solidityType = new Bytes;
    }

    /**
     * testIsType
     * 
     * @return void
     */
    public function testIsType()
    {
        $solidityType = $this->solidityType;

        foreach ($this->testTypes as $type) {
            $this->assertEquals($solidityType->isType($type['value']), $type['result']);
        }
    }
}