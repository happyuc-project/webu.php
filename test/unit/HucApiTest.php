<?php

namespace Test\Unit;

use RuntimeException;
use InvalidArgumentException;
use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;

class HucApiTest extends TestCase
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
     * testProtocolVersion
     * 
     * @return void
     */    
    private function testProtocolVersion()
    {
        $huc = $this->huc;

        $version = $huc->protocolVersion();

        $this->assertTrue($version instanceof BigNumber);
    }

    /**
     * testSyncing
     * 
     * @return void
     */
    private function testSyncing()
    {
        $huc     = $this->huc;
        $syncing =  $huc->syncing();

        $this->assertTrue($syncing !== null);
    }

    /**
     * testCoinbase
     * 
     * @return void
     */
    public function testCoinbase()
    {
        $huc      = $this->huc;
        $coinbase = $huc->coinbase();
        $this->assertEquals($coinbase, $this->coinbase);
    }

    /**
     * testMining
     * 
     * @return void
     */    
    public function testMining()
    {
        $huc    = $this->huc;
        $mining =  $huc->mining();
        $this->assertTrue($mining);
    }

    /**
     * testHashrate
     * 
     * @return void
     */    
    public function testHashrate()
    {
        $huc = $this->huc;

        $hashrate = $huc->hashrate();

        $this->assertEquals($hashrate->toString(), '0');
    }

    /**
     * testGasPrice
     * 
     * @return void
     */    
    public function testGasPrice()
    {
        $huc      = $this->huc;
        $gasPrice = $huc->gasPrice();
        $this->assertTrue(is_numeric($gasPrice->toString()));
    }

    /**
     * testAccounts
     * 
     * @return void
     */    
    public function testAccounts()
    {
        $huc = $this->huc;

        $accounts =  $huc->accounts();

        $this->assertTrue(is_array($accounts));
    }

    /**
     * testBlockNumber
     * 
     * @return void
     */    
    public function testBlockNumber()
    {
        $huc = $this->huc;

        $blockNumber =  $huc->blockNumber();

        $this->assertTrue(is_numeric($blockNumber->toString()));
    }

    /**
     * testGetBalance
     * 
     * @return void
     */    
    public function testGetBalance()
    {
        $huc     = $this->huc;
        $balance = $huc->getBalance('0x407d73d8a49eeb85d32cf465507dd71d507100c1');
        $this->assertTrue(is_numeric($balance->toString()));
    }

    /**
     * testGetStorageAt
     * 
     * @return void
     */    
    public function testGetStorageAt()
    {
        $huc = $this->huc;

        $storage = $huc->getStorageAt('0x561a2aa10f9a8589c93665554c871106342f70af', '0x0');

        $this->assertTrue(is_string($storage));
    }

    /**
     * testGetTransactionCount
     * 
     * @return void
     */    
    public function testGetTransactionCount()
    {
        $huc = $this->huc;

        $transactionCount = $huc->getTransactionCount('0x561a2aa10f9a8589c93665554c871106342f70af');

        $this->assertTrue(is_numeric($transactionCount->toString()));
    }

    /**
     * testGetBlockTransactionCountByHash
     * 
     * @return void
     */    
    public function testGetBlockTransactionCountByHash()
    {
        $huc = $this->huc;

        $transactionCount = $huc->getBlockTransactionCountByHash('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238');

        $this->assertTrue(is_numeric($transactionCount->toString()));
    }

    /**
     * testGetBlockTransactionCountByNumber
     * 
     * @return void
     */    
    public function testGetBlockTransactionCountByNumber()
    {
        $huc = $this->huc;

        $transactionCount = $huc->getBlockTransactionCountByNumber('0x0');


        $this->assertTrue(is_numeric($transactionCount->toString()));
    }

    /**
     * testGetUncleCountByBlockHash
     * 
     * @return void
     */    
    public function testGetUncleCountByBlockHash()
    {
        $huc = $this->huc;

        $uncleCount = $huc->getUncleCountByBlockHash('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238');

        $this->assertTrue(is_numeric($uncleCount->toString()));
    }

    /**
     * testGetUncleCountByBlockNumber
     * 
     * @return void
     */    
    public function testGetUncleCountByBlockNumber()
    {
        $huc = $this->huc;

        $uncleCount = $huc->getUncleCountByBlockNumber('0x0');

        $this->assertTrue(is_numeric($uncleCount->toString()));
    }

    /**
     * testGetCode
     * 
     * @return void
     */    
    public function testGetCode()
    {
        $huc = $this->huc;

        $code = $huc->getCode('0x407d73d8a49eeb85d32cf465507dd71d507100c1');

        $this->assertTrue(is_string($code));
    }

    /**
     * testSign
     * 
     * @return void
     */    
    public function testSign()
    {
        $huc = $this->huc;

        $sign = $huc->sign('0x407d73d8a49eeb85d32cf465507dd71d507100c1', '0xdeadbeaf');

        $this->assertTrue(is_string($sign));
    }

    /**
     * testSendTransaction
     * 
     * @return void
     */    
    public function testSendTransaction()
    {
        $huc = $this->huc;

        $transaction =  $huc->sendTransaction( "0xb60e8dd61c5d32be8058bb8eb970870f07233155",
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
        $huc = $this->huc;

        $transaction =  $huc->sendRawTransaction('0xd46e8dd67c5d32be8d46e8dd67c5d32be8058bb8eb970870f072445675058bb8eb970870f072445675');

        $this->assertTrue(is_string($transaction));
    }

    /**
     * testCall
     * 
     * @return void
     */    
    public function testCall()
    {
        $huc = $this->huc;

        $transaction=  $huc->call( "0xb60e8dd61c5d32be8058bb8eb970870f07233155",
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
        $huc = $this->huc;

        $gas =  $huc->estimateGas(  "0xb60e8dd61c5d32be8058bb8eb970870f07233155",
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
        $huc = $this->huc;

        $block = $huc->getBlockByHash('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238', false);

        $this->assertTrue($block !== null);
    }

    /**
     * testGetBlockByNumber
     * 
     * @return void
     */    
    public function testGetBlockByNumber()
    {
        $huc = $this->huc;

        $block =  $huc->getBlockByNumber('latest', false);

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
        $huc = $this->huc;

        $transaction =  $huc->getTransactionByHash('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238');

        $this->assertTrue($transaction !== null);
    }

    /**
     * testGetTransactionByBlockHashAndIndex
     * 
     * @return void
     */    
    public function testGetTransactionByBlockHashAndIndex()
    {
        $huc = $this->huc;

        $transaction =   $huc->getTransactionByBlockHashAndIndex('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238', '0x0');

        $this->assertTrue($transaction !== null);
    }

    /**
     * testGetTransactionByBlockNumberAndIndex
     * 
     * @return void
     */    
    public function testGetTransactionByBlockNumberAndIndex()
    {
        $huc = $this->huc;

        $transaction =   $huc->getTransactionByBlockNumberAndIndex('0xe8', '0x0');

        $this->assertTrue($transaction !== null);
    }

    /**
     * testGetTransactionReceipt
     * 
     * @return void
     */    
    public function testGetTransactionReceipt()
    {
        $huc = $this->huc;

        $transaction =  $huc->getTransactionReceipt('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238');

        $this->assertTrue($transaction !== null);
    }

    /**
     * testGetUncleByBlockHashAndIndex
     * 
     * @return void
     */    
    public function testGetUncleByBlockHashAndIndex()
    {
        $huc = $this->huc;

        $uncle =   $huc->getUncleByBlockHashAndIndex('0xb903239f8543d04b5dc1ba6579132b143087c68db1b2168786408fcbce568238', '0x0');

        $this->assertTrue($uncle !== null);
    }

    /**
     * testGetUncleByBlockNumberAndIndex
     * 
     * @return void
     */    
    public function testGetUncleByBlockNumberAndIndex()
    {
        $huc = $this->huc;

        $uncle =  $huc->getUncleByBlockNumberAndIndex('0xe8', '0x0');

        $this->assertTrue($uncle !== null);
    }

    /**
     * testGetCompilers
     * 
     * @return void
     */    
    public function testGetCompilers()
    {
        $huc = $this->huc;

        $compilers=  $huc->getCompilers();

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
        $huc = $this->huc;

        $compiled = $huc->compileSolidity('contract test { function multiply(uint a) returns(uint d) {   return a * 7;   } }');

        $this->assertTrue(is_string($compiled));
    }

    /**
     * testCompileLLL
     * 
     * @return void
     */    
    public function testCompileLLL()
    {
        $huc = $this->huc;

        $compiled =  $huc->compileLLL('(returnlll (suicide (caller)))');

        $this->assertTrue(is_string($compiled));
    }

    /**
     * testCompileSerpent
     * 
     * @return void
     */    
    public function testCompileSerpent()
    {
        $huc = $this->huc;

        $compiled = $huc->compileSerpent('\/* some serpent *\/');

        $this->assertTrue(is_string($compiled));
    }

    /**
     * testNewFilter
     * 
     * @return void
     */    
    public function testNewFilter()
    {
        $huc = $this->huc;

        $filter=  $huc->newFilter(
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
        $huc = $this->huc;

        $filter =  $huc->newBlockFilter('0x01');

        $this->assertTrue(is_string($filter));
    }

    /**
     * testNewPendingTransactionFilter
     * 
     * @return void
     */    
    public function testNewPendingTransactionFilter()
    {
        $huc = $this->huc;

        $filter =  $huc->newPendingTransactionFilter();

        $this->assertTrue(is_string($filter));
    }

    /**
     * testUninstallFilter
     * 
     * @return void
     */    
    public function testUninstallFilter()
    {
        $huc = $this->huc;

        $filter =  $huc->uninstallFilter('0x01');

        $this->assertTrue(is_bool($filter));
    }

    /**
     * testGetFilterChanges
     * 
     * @return void
     */    
    public function testGetFilterChanges()
    {
        $huc = $this->huc;

        $changes =  $huc->getFilterChanges('0x01');

        $this->assertTrue(is_array($changes));
    }

    /**
     * testGetFilterLogs
     * 
     * @return void
     */    
    public function testGetFilterLogs()
    {
        $huc = $this->huc;

        $logs =  $huc->getFilterLogs('0x01');

        $this->assertTrue(is_array($logs));
    }

    /**
     * testGetLogs
     * 
     * @return void
     */    
    public function testGetLogs()
    {
        $huc = $this->huc;

        $logs =  $huc->getLogs([
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
        $huc = $this->huc;

        $work = $huc->getWork();

        $this->assertTrue(is_array($work));
    }

    /**
     * testSubmitWork
     * 
     * @return void
     */    
    public function testSubmitWork()
    {
        $huc = $this->huc;

        $work =  $huc->submitWork(
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
        $huc = $this->huc;

        $work = $huc->submitHashrate(
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

        $huc = $this->huc;

        $huc->hello();

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

        $huc = $this->huc;

        $protocolVersion =  $huc->protocolVersion();

        $this->assertTrue(is_string($protocolVersion));
    }
}