<?php

namespace Test;

use \PHPUnit\Framework\TestCase as BaseTestCase;
use Webu\Webu;

class TestCase extends BaseTestCase
{
    /**
     * webu
     * 
     * @var \Webu\Webu
     */
    protected $webu;

    /**
     * testRinkebyHost
     * 
     * @var string
     */
    protected $testRinkebyHost = 'https://rinkeby.infura.io/vuethexplore';

    /**
     * testHost
     * 
     * @var string
     */
    protected $testHost = 'http://localhost:8545';

    /**
     * coinbase
     * 
     * @var string
     */
    protected $coinbase;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        $webu = new Webu($this->testHost);
        $this->webu = $webu;

        $webu->eth->coinbase(function ($err, $coinbase) {
            if ($err !== null) {
                return $this->fail($err->getMessage());
            }
            $this->coinbase = $coinbase;
        });
    }

    /**
     * tearDown
     * 
     * @return void
     */
    public function tearDown() {}
}