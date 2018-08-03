<?php

namespace Test\Unit;

use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;

class IrcBatchTest extends TestCase
{
    /**
     * eth
     * 
     * @var \Webu\Irc
     */
    protected $irc;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->irc = $this->webu->irc;
    }

    /**
     * testBatch
     * 
     * @return void
     */
    public function testBatch()
    {
        $irc    = $this->irc;
        $data_0 = $irc->protocolVersion();
        $data_1 = $irc->syncing();

        $this->assertTrue($data_0 instanceof BigNumber);
        $this->assertTrue($data_1 !== null);
    }
}