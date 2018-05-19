<?php

namespace Test\Unit;

use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;

class HucBatchTest extends TestCase
{
    /**
     * eth
     * 
     * @var \Webu\Huc
     */
    protected $huc;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->huc = $this->webu->huc;
    }

    /**
     * testBatch
     * 
     * @return void
     */
    public function testBatch()
    {
        $huc= $this->huc;

        $data_0 = $huc->protocolVersion();
        $data_1 = $huc->syncing();

        $this->assertTrue($data_0 instanceof BigNumber);
        $this->assertTrue($data_1 !== null);
    }
}