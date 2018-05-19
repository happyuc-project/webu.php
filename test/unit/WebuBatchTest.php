<?php

namespace Test\Unit;

use RuntimeException;
use Test\TestCase;

class WebuBatchTest extends TestCase
{
    /**
     * testHex
     * 'hello world'
     * you can check by call pack('H*', $hex)
     * 
     * @var string
     */
    protected $testHex = '0x68656c6c6f20776f726c64';

    /**
     * testHash
     * 
     * @var string
     */
    protected $testHash = '0x47173285a8d7341e5e972fc677286384f802f8ef42a5ec5f03bbfa254cb01fad';

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
     * testBatch
     * 
     * @return void
     */
    private function testBatch()
    {
        $webu = $this->webu;

//        $webu->batch(true);
        $webu->clientVersion();
//        $webu->sha3($this->testHex);

//        $webu->provider->execute(function ($err, $data) {
//            if ($err !== null) {
//                return $this->fail('Got error!');
//            }
//            $this->assertTrue(is_string($data[0]));
//            $this->assertEquals($data[1], $this->testHash);
//        });
    }

    /**
     * testWrongParam
     * 
     * @return void
     */
    private function testWrongParam()
    {
        $this->expectException(RuntimeException::class);

        $webu = $this->webu;

        $webu->clientVersion();
//        $webu->sha3($webu);

//        $webu->provider->execute(function ($err, $data) {
//            if ($err !== null) {
//                return $this->fail('Got error!');
//            }
//            $this->assertTrue(is_string($data[0]));
//            $this->assertEquals($data[1], $this->testHash);
//        });
    }
}