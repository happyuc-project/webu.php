<?php

namespace Test\Unit;

use RuntimeException;
use InvalidArgumentException;
use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;

class IrcApiTest extends TestCase
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
     * testProtocolVersion
     * 
     * @return void
     */    
    private function testProtocolVersion()
    {
        $irc = $this->irc;

        $version = $irc->protocolVersion();

        $this->assertTrue($version instanceof BigNumber);
    }

    /**
     * testSyncing
     * 
     * @return void
     */
    private function testSyncing()
    {
        $irc     = $this->irc;
        $syncing = $irc->syncing();

        $this->assertTrue($syncing !== null);
    }

    /**
     * testCoinbase
     * 
     * @return void
     */
    public function testCoinbase()
    {
        $irc      = $this->irc;
        $coinbase = $irc->coinbase();
        $this->assertEquals($coinbase, $this->coinbase);
    }

    /**
     * testMining
     * 
     * @return void
     */    
    public function testMining()
    {
        $irc    = $this->irc;
        $mining = $irc->mining();
        $this->assertTrue($mining);
    }

    /**
     * testHashrate
     * 
     * @return void
     */    
    public function testHashrate()
    {
        $irc      = $this->irc;
        $hashrate = $irc->hashrate();

        $this->assertEquals($hashrate->toString(), '0');
    }

    /**
     * testGasPrice
     * 
     * @return void
     */    
    public function testGasPrice()
    {
        $irc      = $this->irc;
        $gasPrice = $irc->gasPrice();
        $this->assertTrue(is_numeric($gasPrice->toString()));
    }

    /**
     * testAccounts
     * 
     * @return void
     */    
    public function testAccounts()
    {
        $irc      = $this->irc;
        $accounts = $irc->accounts();
        $this->assertTrue(is_array($accounts));
    }

    /**
     * testBlockNumber
     * 
     * @return void
     */    
    public function testBlockNumber()
    {
        $irc         = $this->irc;
        $blockNumber = $irc->blockNumber();

        $this->assertTrue(is_numeric($blockNumber->toString()));
    }

    /**
     * testGetBalance
     * 
     * @return void
     */    
    public function testGetBalance()
    {
        $irc     = $this->irc;
        $balance = $irc->getBalance('0x407d73d8a49eeb85d32cf465507dd71d507100c1');
        $this->assertTrue(is_numeric($balance->toString()));
    }

    /**
     * testGetStorageAt
     * 
     * @return void
     */    
    public function testGetStorageAt()
    {
        $irc     = $this->irc;
        $storage = $irc->getStorageAt('0x561a2aa10f9a8589c93665554c871106342f70af', '0x0');

        $this->assertTrue(is_string($storage));
    }

    /**
     * testGetTransactionCount
     * 
     * @return void
     */    
    public function testGetTransactionCount()
    {
        $irc              = $this->irc;
        $transactionCount = $irc->getTransactionCount('0x561a2aa10f9a8589c93665554c871106342f70af');

        $this->assertTrue(is_numeric($transactionCount->toString()));
    }

    /**
     * testGetBlockTransactionCountByHash
     * 
     * @return void
     */    
    public function testGetBlockTransactionCountByHash()
    {
        $irc = $this->irc;

        $transactionCount = $irc->getBlockTransactionCountByHash('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238');

        $this->assertTrue(is_numeric($transactionCount->toString()));
    }

    /**
     * testGetBlockTransactionCountByNumber
     * 
     * @return void
     */    
    public function testGetBlockTransactionCountByNumber()
    {
        $irc = $this->irc;

        $transactionCount = $irc->getBlockTransactionCountByNumber('0x0');


        $this->assertTrue(is_numeric($transactionCount->toString()));
    }

    /**
     * testGetUncleCountByBlockHash
     * 
     * @return void
     */    
    public function testGetUncleCountByBlockHash()
    {
        $irc = $this->irc;

        $uncleCount = $irc->getUncleCountByBlockHash('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238');

        $this->assertTrue(is_numeric($uncleCount->toString()));
    }

    /**
     * testGetUncleCountByBlockNumber
     * 
     * @return void
     */    
    public function testGetUncleCountByBlockNumber()
    {
        $irc        = $this->irc;
        $uncleCount = $irc->getUncleCountByBlockNumber('0x0');

        $this->assertTrue(is_numeric($uncleCount->toString()));
    }

    /**
     * testGetCode
     * 
     * @return void
     */    
    public function testGetCode()
    {
        $irc  = $this->irc;
        $code = $irc->getCode('0x407d73d8a49eeb85d32cf465507dd71d507100c1');

        $this->assertTrue(is_string($code));
    }

    /**
     * testSign
     * 
     * @return void
     */    
    public function testSign()
    {
        $irc  = $this->irc;
        $sign = $irc->sign('0x407d73d8a49eeb85d32cf465507dd71d507100c1', '0xdeadbeaf');

        $this->assertTrue(is_string($sign));
    }

    /**
     * testSendTransaction
     * 
     * @return void
     */    
    public function testSendTransaction()
    {
        $irc         = $this->irc;
        $transaction = $irc->sendTransaction( "0xb60e8dd61c5d32be8058bb8eb970870f07233155",
            "0xd46e8dd67c5d32be8058bb8eb970870f07244567",
            "0x76c0",
             "0x9184e72a000",
            "0x9184e72a",
            "0xd46e8dd67c5d32be8d46e8dd67c5d32be8058bb8eb970870f072445675058bb8eb970870f072445675"
        );

        $this->assertTrue(is_string($transaction));
    }

    /**
     * testSendRawTransaction
     * 
     * @return void
     */    
    public function testSendRawTransaction()
    {
        $irc         = $this->irc;
        $transaction = $irc->sendRawTransaction('0xd46e8dd67c5d32be8d46e8dd67c5d32be8058bb8eb970870f072445675058bb8eb970870f072445675');

        $this->assertTrue(is_string($transaction));
    }

    /**
     * testCall
     * 
     * @return void
     */    
    public function testCall()
    {
        $irc         = $this->irc;
        $transaction = $irc->call( "0xb60e8dd61c5d32be8058bb8eb970870f07233155",
             "0xd46e8dd67c5d32be8058bb8eb970870f07244567",
             "0x76c0",
             "0x9184e72a000",
              "0x9184e72a",
              "0xd46e8dd67c5d32be8d46e8dd67c5d32be8058bb8eb970870f072445675058bb8eb970870f072445675"
        );

        $this->assertTrue(is_string($transaction));
    }

    /**
     * testEstimateGas
     * 
     * @return void
     */    
    public function testEstimateGas()
    {
        $irc = $this->irc;
        $gas =  $irc->estimateGas(  "0xb60e8dd61c5d32be8058bb8eb970870f07233155",
             "0xd46e8dd67c5d32be8058bb8eb970870f07244567",
              "0x76c0",
             "0x9184e72a000",
             "0x9184e72a",
              "0xd46e8dd67c5d32be8d46e8dd67c5d32be8058bb8eb970870f072445675058bb8eb970870f072445675"
        );

        $this->assertTrue(is_numeric($gas->toString()));
    }

    /**
     * testGetBlockByHash
     * 
     * @return void
     */    
    public function testGetBlockByHash()
    {
        $irc   = $this->irc;
        $block = $irc->getBlockByHash('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238', false);

        $this->assertTrue($block !== null);
    }

    /**
     * testGetBlockByNumber
     * 
     * @return void
     */    
    public function testGetBlockByNumber()
    {
        $irc   = $this->irc;
        $block = $irc->getBlockByNumber('latest', false);

        // weired behavior, see https://github.com/happyuc-project/webu.php/issues/16
        $this->assertTrue($block !== null);
    }

    /**
     * testGetTransactionByHash
     * 
     * @return void
     */    
    public function testGetTransactionByHash()
    {
        $irc         = $this->irc;
        $transaction = $irc->getTransactionByHash('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238');

        $this->assertTrue($transaction !== null);
    }

    /**
     * testGetTransactionByBlockHashAndIndex
     * 
     * @return void
     */    
    public function testGetTransactionByBlockHashAndIndex()
    {
        $irc         = $this->irc;
        $transaction = $irc->getTransactionByBlockHashAndIndex('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238', '0x0');

        $this->assertTrue($transaction !== null);
    }

    /**
     * testGetTransactionByBlockNumberAndIndex
     * 
     * @return void
     */    
    public function testGetTransactionByBlockNumberAndIndex()
    {
        $irc         = $this->irc;
        $transaction = $irc->getTransactionByBlockNumberAndIndex('0xe8', '0x0');

        $this->assertTrue($transaction !== null);
    }

    /**
     * testGetTransactionReceipt
     * 
     * @return void
     */    
    public function testGetTransactionReceipt()
    {
        $irc         = $this->irc;
        $transaction = $irc->getTransactionReceipt('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238');

        $this->assertTrue($transaction !== null);
    }

    /**
     * testGetUncleByBlockHashAndIndex
     * 
     * @return void
     */    
    public function testGetUncleByBlockHashAndIndex()
    {
        $irc   = $this->irc;
        $uncle = $irc->getUncleByBlockHashAndIndex('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238', '0x0');

        $this->assertTrue($uncle !== null);
    }

    /**
     * testGetUncleByBlockNumberAndIndex
     * 
     * @return void
     */    
    public function testGetUncleByBlockNumberAndIndex()
    {
        $irc   = $this->irc;
        $uncle = $irc->getUncleByBlockNumberAndIndex('0xe8', '0x0');

        $this->assertTrue($uncle !== null);
    }

    /**
     * testGetCompilers
     * 
     * @return void
     */    
    public function testGetCompilers()
    {
        $irc      = $this->irc;
        $compilers= $irc->getCompilers();

        $this->assertTrue(is_array($compilers));
        $this->assertEquals($compilers[0], 'solidity');
    }

    /**
     * testCompileSolidity
     * 
     * @return void
     */    
    public function testCompileSolidity()
    {
        $irc      = $this->irc;
        $compiled = $irc->compileSolidity('contract test { function multiply(uint a) returns(uint d) {   return a * 7;   } }');

        $this->assertTrue(is_string($compiled));
    }

    /**
     * testCompileLLL
     * 
     * @return void
     */    
    public function testCompileLLL()
    {
        $irc      = $this->irc;
        $compiled = $irc->compileLLL('(returnlll (suicide (caller)))');

        $this->assertTrue(is_string($compiled));
    }

    /**
     * testCompileSerpent
     * 
     * @return void
     */    
    public function testCompileSerpent()
    {
        $irc      = $this->irc;
        $compiled = $irc->compileSerpent('\/* some serpent *\/');

        $this->assertTrue(is_string($compiled));
    }

    /**
     * testNewFilter
     * 
     * @return void
     */    
    public function testNewFilter()
    {
        $irc   = $this->irc;
        $filter=  $irc->newFilter(
             '0x1',
             '0x2',
             '0x8888f1f195afa192cfee860698584c030f4c9db1',
             ['0x000000000000000000000000a94f5374fce5edbc8e2a8697c15331677e6ebf0b', null, ['0x000000000000000000000000a94f5374fce5edbc8e2a8697c15331677e6ebf0b', '0x0000000000000000000000000aff3454fce5edbc8cca8697c15331677e6ebccc']]
        );

        $this->assertTrue(is_string($filter));
    }

    /**
     * testNewBlockFilter
     * 
     * @return void
     */    
    public function testNewBlockFilter()
    {
        $irc    = $this->irc;
        $filter = $irc->newBlockFilter('0x01');

        $this->assertTrue(is_string($filter));
    }

    /**
     * testNewPendingTransactionFilter
     * 
     * @return void
     */    
    public function testNewPendingTransactionFilter()
    {
        $irc    = $this->irc;
        $filter = $irc->newPendingTransactionFilter();

        $this->assertTrue(is_string($filter));
    }

    /**
     * testUninstallFilter
     * 
     * @return void
     */    
    public function testUninstallFilter()
    {
        $irc    = $this->irc;
        $filter = $irc->uninstallFilter('0x01');

        $this->assertTrue(is_bool($filter));
    }

    /**
     * testGetFilterChanges
     * 
     * @return void
     */    
    public function testGetFilterChanges()
    {
        $irc     = $this->irc;
        $changes = $irc->getFilterChanges('0x01');

        $this->assertTrue(is_array($changes));
    }

    /**
     * testGetFilterLogs
     * 
     * @return void
     */    
    public function testGetFilterLogs()
    {
        $irc  = $this->irc;
        $logs = $irc->getFilterLogs('0x01');

        $this->assertTrue(is_array($logs));
    }

    /**
     * testGetLogs
     * 
     * @return void
     */    
    public function testGetLogs()
    {
        $irc  = $this->irc;
        $logs = $irc->getLogs([
            'fromBlock' => '0x1',
            'toBlock' => '0x2',
            'address' => '0x8888f1f195afa192cfee860698584c030f4c9db1',
            'topics' => ['0x000000000000000000000000a94f5374fce5edbc8e2a8697c15331677e6ebf0b', null, ['0x000000000000000000000000a94f5374fce5edbc8e2a8697c15331677e6ebf0b', '0x0000000000000000000000000aff3454fce5edbc8cca8697c15331677e6ebccc']]
        ]);

        $this->assertTrue(is_array($logs));
    }

    /**
     * testGetWork
     * 
     * @return void
     */    
    public function testGetWork()
    {
        $irc  = $this->irc;
        $work = $irc->getWork();

        $this->assertTrue(is_array($work));
    }

    /**
     * testSubmitWork
     * 
     * @return void
     */    
    public function testSubmitWork()
    {
        $irc  = $this->irc;
        $work = $irc->submitWork(
            '0x0000000000000001',
            '0x1234567890abcdef1234567890abcdef1234567890abcdef1234567890abcdef',
            '0xD1FE5700000000000000000000000000D1FE5700000000000000000000000000'
        );

        $this->assertTrue(is_bool($work));
    }

    /**
     * testSubmitHashrate
     * 
     * @return void
     */    
    public function testSubmitHashrate()
    {
        $irc = $this->irc;

        $work = $irc->submitHashrate(
            '0x1234567890abcdef1234567890abcdef1234567890abcdef1234567890abcdef',
            '0xD1FE5700000000000000000000000000D1FE5700000000000000000000000000'
        );

        $this->assertTrue(is_bool($work));
    }

    /**
     * testUnallowedMethod
     * 
     * @return void
     */
    public function testUnallowedMethod()
    {
        $this->expectException(RuntimeException::class);

        $irc = $this->irc;

        $irc->hello();

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

        $irc             = $this->irc;
        $protocolVersion = $irc->protocolVersion();

        $this->assertTrue(is_string($protocolVersion));
    }
}