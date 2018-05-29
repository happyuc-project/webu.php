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
     * testHost
     * 
     * @var string
     */
    // protected $testHost = 'http://193.112.32.158:8545';
    protected $testHost = 'http://127.0.0.1:8545';

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

        try{
            $webu->huc->coinbase();
        }catch (\Exception $exception){
            $this->ShowException($exception);
        }
    }

    /**
     * tearDown
     * 
     * @return void
     */
    public function tearDown() {}


    public function ShowException(\Exception $e) {
        $trace   = $e->getTrace();
        $result  = 'Exception: "';
        $result .= $e->getMessage();
        $result .= '" @ ';
        if($trace[0]['class'] != '') {
            $result .= $trace[0]['class'];
            $result .= '->';
        }
        $result .= $trace[0]['function'];
        $result .= '();'."\n";
        return $result;
    }
}