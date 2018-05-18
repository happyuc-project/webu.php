<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;


class HttpProvider
{
    /**
     * web
     *
     * @var Webu
     */
    public $webu;

    /**
     * isBatch
     *
     * @var bool
     */
    public $isBatch = false;


    /**
     * requestManager
     *
     * @var \Webu\HttpRequestManager
     */
    protected $requestManager;

    /**
     * rpcVersion
     *
     * @var string
     */
    protected $rpcVersion = '2.0';

    /**
     * batch
     *
     * @var array
     */
    protected $batch = [];

    /**
     * id
     *
     * @var integer
     */
    protected $id = 0;
    /**
     * methods
     * 
     * @var array
     */
    protected $methods = [];

    /**
     * construct
     * 
     * @param \Webu\HttpRequestManager $requestManager
     * @return void
     */
    public function __construct(HttpRequestManager $requestManager, Webu $webu)
    {
        $this->requestManager = $requestManager;
        $this->webu           = $webu;
    }

    /**
     * send
     * 
     * @param \Webu\Methods\HucMethod $method
     * @param callable $callback
     * @return void
     */
    public function send($method, $callback)
    {
        $payload = $method->toPayloadString();

        if (!$this->isBatch) {
            $proxy = function ($err, $res) use ($method, $callback) {
                if ($err !== null) {
                    return call_user_func($callback, $err, null);
                }
                if (!is_array($res)) {
                    // $res = $method->transform([$res], $method->outputFormatters);
                    return call_user_func($callback, null, $res[0]);
                }
                // $res = $method->transform($res, $method->outputFormatters);

                return call_user_func($callback, null, $res);
            };
            $this->requestManager->sendPayload($payload, $proxy);
        } else {
            $this->methods[] = $method;
            $this->batch[]   = $payload;
        }
    }


    /**
     * execute
     * 
     * @param callable $callback
     * @return void
     */
    public function execute($callback)
    {
        if (!$this->isBatch) {
            throw new \RuntimeException('Please batch json rpc first.');
        }

        $methods = $this->methods;
        $proxy = function ($err, $res) use ($methods, $callback) {
            if ($err !== null) {
                return call_user_func($callback, $err, null);
            }
            foreach ($methods as $key => $method) {
                if (isset($res[$key])) {
                    if (!is_array($res[$key])) {
                        $transformed = $method->transform([$res[$key]], $method->outputFormatters);
                        $res[$key] = $transformed[0];
                    } else {
                        $transformed = $method->transform($res[$key], $method->outputFormatters);
                        $res[$key] = $transformed;
                    }
                }
            }
            return call_user_func($callback, null, $res);
        };
        $this->requestManager->sendPayload('[' . implode(',', $this->batch) . ']', $proxy);
        $this->methods[] = [];
        $this->batch     = [];
    }


    /**
     * getRequestManager
     *
     * @return \Webu\HttpRequestManager
     */
    public function getRequestManager()
    {
        return $this->requestManager;
    }
}