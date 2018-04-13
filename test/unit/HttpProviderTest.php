<?php

namespace Test\Unit;

use RuntimeException;
use Test\TestCase;
use Webu\RequestManagers\HttpRequestManager;
use Webu\Providers\HttpProvider;
use Webu\Methods\Webu\ClientVersion;

class HttpProviderTest extends TestCase
{
    /**
     * testSend
     * 
     * @return void
     */
    public function testSend()
    {
        $requestManager = new HttpRequestManager('http://localhost:8545');
        $provider = new HttpProvider($requestManager);
        $method = new ClientVersion('webu_clientVersion', []);

        $provider->send($method, function ($err, $version) {
            if ($err !== null) {
                $this->fail($err->getMessage());
            }
            $this->assertTrue(is_string($version));
        });
    }

    /**
     * testBatch
     * 
     * @return void
     */
    public function testBatch()
    {
        $requestManager = new HttpRequestManager('http://localhost:8545');
        $provider = new HttpProvider($requestManager);
        $method = new ClientVersion('webu_clientVersion', []);
        $callback = function ($err, $data) {
            if ($err !== null) {
                $this->fail($err->getMessage());
            }
            $this->assertEquals($data[0], $data[1]);
        };

        try {
            $provider->execute($callback);
        } catch (RuntimeException $err) {
            $this->assertTrue($err->getMessage() !== true);
        }

        $provider->batch(true);
        $provider->send($method, null);
        $provider->send($method, null);
        $provider->execute($callback);
    }
}