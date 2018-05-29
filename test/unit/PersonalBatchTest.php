<?php

namespace Test\Unit;

use RuntimeException;
use Test\TestCase;

class PersonalBatchTest extends TestCase
{
    /**
     * personal
     * 
     * @var \Webu\Personal
     */
    protected $personal;

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
     * testBatch
     * 
     * @return void
     */
    public function testBatch()
    {
        $personal = $this->personal;

        try{
            $personal->listAccounts(function ($err,$data){
                if ($err !== null) {
                    echo  __LINE__." ".$err;
                    return;
                }
                $this->assertTrue(is_array($data));
                // print_r(['data'=>$data]);
            });
            $personal->newAccount('qq123456',function ($err,$data){
                if ($err !== null) {
                    echo  __LINE__." ".$err;
                    return;
                }
                $this->assertTrue(is_string($data));
                // print_r(['data'=>$data]);
            });
        }catch (\Exception $exception) {
            echo $exception->getMessage()."\n";
        }
    }

    /**
     * testWrongParam
     * 
     * @return void
     */
    public function testWrongParam()
    {
//        $this->expectException(RuntimeException::class);

        $personal = $this->personal;

        try{
            $personal->listAccounts(function ($err,$data){
                if ($err !== null) {
                    echo  __LINE__." ".$err."\n";
                    return;
                }
                $this->assertTrue(is_string($data));
            });
            $personal->newAccount('qq123456',function ($err,$data){
                if ($err !== null) {
                    echo  __LINE__." ".$err."\n";
                    return;
                }
                // print_r(['data'=>$data]);
                $this->assertEquals($data, '0x7196b95a0c9b030f7572945adc0ead9d81965c00');
            });
        }catch (\Exception $exception){
            echo $exception->getMessage()."\n";
        }

//      $personal->listAccounts();
//      $personal->newAccount($personal);
//
//      $personal->provider->execute(function ($err, $data) {
//          if ($err !== null) {
//              return $this->fail($err->getMessage());
//          }
//          $this->assertTrue(is_string($data[0]));
//          $this->assertEquals($data[1], $this->testHash);
//      });
    }
}