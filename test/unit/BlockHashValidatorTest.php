<?php

namespace Test\Unit;



use Test\TestCase;

class BlockHashValidatorTest extends TestCase
{

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * testValidate
     * 
     * @return void
     */
    public function testValidate()
    {

        $this->assertEquals(false, \Webu\Validator::BlockHash('0Xca35b7d915458ef540ade6068dfe2f44e8fa733c'));
        $this->assertEquals(false, \Webu\Validator::BlockHash('0XCA35B7D915458EF540ADE6068DFE2F44E8FA733C'));
        $this->assertEquals(false, \Webu\Validator::BlockHash('0xcA35b7D915458eF540ade6068Dfe2f44e8fA733ccA35b7D915458eF540ade6068Dfe2f44e8fA733c'));
        $this->assertEquals(false, \Webu\Validator::BlockHash('CA35B7D915458EF540ADE6068DFE2F44E8FA733C'));
        $this->assertEquals(false, \Webu\Validator::BlockHash('1234'));
        $this->assertEquals(false, \Webu\Validator::BlockHash('abcd'));
        $this->assertEquals(false, \Webu\Validator::BlockHash(0xCA35B7D915458EF540ADE6068DFE2F44E8FA733C));
        $this->assertEquals(true, \Webu\Validator::BlockHash('0xEB0B54D62EC3F561C2EEBDAEBD92432126F0817579C102B062D1A6C1F2ED83E8'));
        $this->assertEquals(true, \Webu\Validator::BlockHash('0xeb0b54d62ec3f561c2eebdaebd92432126f0817579c102b062d1a6c1f2ed83e8'));
        $this->assertEquals(true, \Webu\Validator::BlockHash('0xeb0b54D62ec3f561C2eebdaebd92432126F0817579c102b062d1a6c1f2ed83e8'));
    }
}