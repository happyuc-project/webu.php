<?php

namespace Test\Unit;

use RuntimeException;
use InvalidArgumentException;
use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;

class NetApiTest extends TestCase
{
    /**
     * net
     * 
     * @var \Webu\Net
     */
    protected $net;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->net = $this->webu->net;
    }

    /**
     * testVersion
     * 
     * @return void
     */    
    public function testVersion()
    {
        $net = $this->net;

        $version = $net->version();

        $this->assertTrue(is_string($version));
    }

    /**
     * testPeerCount
     * 
     * @return void
     */    
    public function testPeerCount()
    {
        $net = $this->net;

        $count = $net->peerCount();

        $this->assertTrue($count instanceof BigNumber);
    }

    /**
     * testListening
     * 
     * @return void
     */    
    public function testListening()
    {
        $net = $this->net;

        $nets = $net->listening();

        $this->assertTrue(is_bool($nets));
    }

    /**
     * testUnallowedMethod
     * 
     * @return void
     */
    public function testUnallowedMethod()
    {
        $this->expectException(RuntimeException::class);

        $net = $this->net;

        $hello =  $net->hello();

        $this->assertTrue(true);
    }

    /**
     * testWrongCallback
     * 
     * @return void
     */
    public function testWrongCallback()
    {
        $this->expectException(InvalidArgumentException::class);

        $net = $this->net;

        $net->version();
    }
}