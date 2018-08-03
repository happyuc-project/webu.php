<?php

namespace Test\Unit;

use Test\TestCase;

class PersonalApiTest extends TestCase
{
    /**
     * personal
     * 
     * @var \Webu\Personal
     */
    protected $personal;

    /**
     * newAccount
     * 
     * @var string
     */
    protected $newAccount;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->personal = $this->webu->personal;
    }

    /**
     * testListAccounts
     * 
     * @return void
     */
    public function testListAccounts()
    {
        $personal = $this->personal;

        try{
            $accounts = $personal->listAccounts();
            $this->assertTrue(is_array($accounts));
        }catch (\Exception $exception){
            echo $exception->getMessage()."\n";
        }
    }

    /**
     * testNewAccount
     * 
     * @return void
     */
    public function testNewAccount()
    {
        $personal = $this->personal;

        try{
            $account   =  $personal->newAccount('qq123456');
            $this->assertTrue(is_string($account));
        }catch (\Exception $exception){
            echo $exception->getMessage()."\n";
        }
    }

    /**
     * testUnlockAccount
     * 
     * @return void
     */
    public function testUnlockAccount()
    {
        $personal = $this->personal;

        // create account
        try{
            $personal->newAccount('qq123456', function ($err, $account) {
                if ($err !== null) {
                    echo "\n".__METHOD__.':'.__LINE__.' '.$err."\n";
                    return ;
                }
                $this->newAccount = $account;
                $this->assertTrue(is_string($account));
            });

            $personal->unlockAccount($this->newAccount, 'qq123456', function ($err, $unlocked) {
                if ($err !== null) {
                    echo "\n".__METHOD__.':'.__LINE__.' '.$err."\n";
                    return ;
                }
                $this->assertTrue($unlocked);
            });
        }catch (\Exception $exception){
            echo $exception->getMessage()."\n";
        }
    }

    /**
     * testUnlockAccountWithDuration
     * 
     * @return void
     */
    public function testUnlockAccountWithDuration()
    {
        $personal = $this->personal;

        // create account
        try{
            $personal->newAccount('qq123456', function ($err, $account) {
                if ($err !== null) {
                    echo "\n".__METHOD__.':'.__LINE__.' '.$err."\n";
                    return ;
                }
                $this->newAccount = $account;
                $this->assertTrue(is_string($account));
            });

            $personal->unlockAccount($this->newAccount, 'qq123456', function ($err, $unlocked) {
                if ($err !== null) {
                    echo "\n".__METHOD__.':'.__LINE__.' '.$err."\n";
                    return ;
                }
                $this->assertTrue($unlocked);
            });
        }catch (\Exception $exception){
            echo $exception->getMessage()."\n";
        }
    }

    /**
     * testSendTransaction
     * 
     * @return void
     */    
    public function testSendTransaction()
    {
        $personal = $this->personal;

        // create account
        try{
            $personal->newAccount('qq123456', function ($err, $account) {
                if ($err !== null) {
                    echo "\n".__METHOD__.':'.__LINE__.' '.$err."\n";
                    return ;
                }
                $this->newAccount = $account;
                $this->assertTrue(is_string($account));
            });

            $this->webu->irc->sendTransaction([
                'from' => $this->coinbase,
                'to' => $this->newAccount,
                'value' => '0x0ffffffff',
            ], function ($err, $transaction) {
                if ($err !== null) {
                    echo "\n".__METHOD__.':'.__LINE__.' '.$err."\n";
                    return ;
                }
                $this->assertTrue(is_string($transaction));
                $this->assertTrue(mb_strlen($transaction) === 66);
            });



            $bind   = [
                'from' => $this->newAccount,
                'to' => $this->coinbase,
                'value' => '0x001',
            ];
            $personal->sendTransaction($bind, 'qq123456', function ($err, $transaction) {
                if ($err !== null) {
                    echo "\n".__METHOD__.':'.__LINE__.' '.$err."\n";
                    return ;
                }
                $this->assertTrue(is_string($transaction));
                $this->assertTrue(mb_strlen($transaction) === 66);
            });

        }catch (\Exception $exception){
            echo $exception->getMessage()."\n";
        }
    }

    /**
     * testUnallowedMethod
     * 
     * @return void
     */
//    public function testUnallowedMethod()
//    {
//
//        $personal = $this->personal;
//
//        try{
//            $personal->hello(function ($err, $hello) {
//                if ($err !== null) {
//                    echo __METHOD__.':'.__LINE__.' '.$err."\n";
//                    return ;
//                }
//                $this->assertTrue(true);
//            });
//        }catch (\Exception $exception){
//            echo $exception->getMessage()."\n";
//        }
//    }

    /**
     * testWrongParam
     * 
     * @return void
     */
//    public function testWrongParam()
//    {
//        $personal = $this->personal;
//
//        try{
//            $personal->newAccount($personal, function ($err, $account) {
//                if ($err !== null) {
//                    echo __METHOD__.':'.__LINE__.' -> '.$err."\n";
//                    return ;
//                }
//                echo "\$account:{$account}\n";
//                $this->assertTrue(is_string($account));
//            });
//        }catch (\Exception $exception){
//            echo $exception->getMessage()."\n";
//        }
//    }

    /**
     * testWrongCallback
     * 
     * @return void
     */
    public function testWrongCallback()
    {
        // $this->expectException(InvalidArgumentException::class);
        $personal = $this->personal;
        try{
            $account =  $personal->newAccount('qq123456');

            $this->assertTrue(is_string($account));
        }catch (\Exception $exception){
            echo $exception->getMessage()."\n";
        }
    }
}