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
     * id
     *
     * @var integer
     */
    protected $id = 0;


    /**
     * @var array
     */
    protected $methods  = [];

    /**
     * @var array
     */
    protected $payloads = [];

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


    public function sendReal($method,$params)
    {
        $payload = json_encode([
            'jsonrpc' => $this->rpcVersion,
            'method'  => $method,
            'params'  => $params,
            'id'      => ++$this->id
        ]);
        $data =  $this->requestManager->payloadReal($payload);
        return $this->_sendReal($data);
    }


    protected function _sendReal($data)
    {
        if($data && $data['jsonrpc'] && $data['id'] && $data['result'])
        {
            return $data['result'];
        }else
        {
            throw new \Exception($data['error']);
        }
        return null;
    }
    /**
     * send
     * 
     * @param \Webu\Methods\HucMethod $method
     * @return void
     */
    public function sendAsyn($method)
    {
        $payload          = $method->toPayloadString();

        $this->methods[]  = $method;
        $this->payloads[] = $payload;
    }


    /**
     * execute
     * 
     * @param callable $callback
     * @return void
     */
    public function execute($callback)
    {
        $methods = $this->methods;
        $proxy   = function ($err, $res) use ($methods, $callback) {
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
        $this->requestManager->payloadAsyn('[' . implode(',', $this->payloads) . ']', $proxy);
        $this->methods   = [];
        $this->payloads  = [];
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