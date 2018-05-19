<?php

namespace Test\Unit;

use Test\TestCase;

class PostFormatterTest extends TestCase
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
     * testFormat
     * 
     * @return void
     */
    public function testFormat()
    {

        $post= \Webu\Formatter::Post([
            'from' => "0x776869737065722d636861742d636c69656e74",
            'to' => "0x4d5a695276454c39425154466b61693532",
            'topics' => ["0x776869737065722d636861742d636c69656e74", "0x4d5a695276454c39425154466b61693532"],
            'payload' => "0x7b2274797065223a226d6",
            'priority' => 12,
            'ttl' => 50,
        ]);
        $this->assertEquals($post, [
            'from' => "0x776869737065722d636861742d636c69656e74",
            'to' => "0x4d5a695276454c39425154466b61693532",
            'topics' => ["0x776869737065722d636861742d636c69656e74", "0x4d5a695276454c39425154466b61693532"],
            'payload' => "0x7b2274797065223a226d6",
            'priority' => '0xc',
            'ttl' => '0x32',
        ]);

        $post= \Webu\Formatter::Post([
            'from' => "0x776869737065722d636861742d636c69656e74",
            'to' => "0x4d5a695276454c39425154466b61693532",
            'topics' => ["0x776869737065722d636861742d636c69656e74", "0x4d5a695276454c39425154466b61693532"],
            'payload' => "0x7b2274797065223a226d6",
            'priority' => '0xab',
            'ttl' => '0xcc',
        ]);
        $this->assertEquals($post, [
            'from' => "0x776869737065722d636861742d636c69656e74",
            'to' => "0x4d5a695276454c39425154466b61693532",
            'topics' => ["0x776869737065722d636861742d636c69656e74", "0x4d5a695276454c39425154466b61693532"],
            'payload' => "0x7b2274797065223a226d6",
            'priority' => '0xab',
            'ttl' => '0xcc',
        ]);
    }
}