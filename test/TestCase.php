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
    protected $testHost = 'http://193.112.32.158:8545';

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
        $webu       = new Webu($this->testHost);
        $this->webu = $webu;

        $webu->huc->coinbase();
    }

    /**
     * tearDown
     * 
     * @return void
     */
    public function tearDown() {}
}