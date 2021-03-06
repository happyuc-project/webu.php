<?php

namespace Test\Unit;

use Test\TestCase;
use Webu\Contracts\Types\Integer;

class IntegerTypeTest extends TestCase
{
    /**
     * testTypes
     * 
     * @var array
     */
    protected $testTypes = [
        [
            'value' => 'int',
            'result' => true
        ], [
            'value' => 'int[]',
            'result' => true
        ], [
            'value' => 'int[4]',
            'result' => true
        ], [
            'value' => 'int[][]',
            'result' => true
        ], [
            'value' => 'int[3][]',
            'result' => true
        ], [
            'value' => 'int[][6][]',
            'result' => true
        ], [
            'value' => 'int32',
            'result' => true
        ], [
            'value' => 'int64[4]',
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
        $this->solidityType = new Integer;
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