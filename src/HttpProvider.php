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


    /**
     * @param string $method
     * @param array $params
     * @param null $callback
     * @return mixed
     * @throws \Exception
     */
    public function sendReal(string $method,array $params,$callback = null)
    {
        $payload = json_encode([
            'jsonrpc' => $this->rpcVersion,
            'method'  => $method,
            'params'  => $params,
            'id'      => ++$this->id
        ]);
//        print_r([
//            'jsonrpc' => $this->rpcVersion,
//            'method'  => $method,
//            'params'  => $params,
//            'id'      => ++$this->id
//        ]);
        $data =  $this->requestManager->payloadReal($payload);


        if($data && $data['jsonrpc'] && $data['id'] && $data['result'])
        {
            if($callback)
            {
                return call_user_func($callback, null, $data['result']);
            }
            return $data['result'];
        }

        $error = "{$data['error']['message']}[code:{$data['error']['code']}]";
        // print_r(['$data'=>$data]);
        return $this->sendError($error,$callback);
    }


    /**
     * @param string $error
     * @param $callback
     * @return mixed
     * @throws \Exception
     */
    public function sendError(string $error,$callback)
    {
        if($callback)
        {
            return call_user_func($callback, $error, null);
        }
        throw new \Exception($error);
    }

    /**
     * send
     * 
     * @param \Webu\Methods\IrcMethod $method
     * @return void
     */
//    public function sendAsyn($method)
//    {
//        $payload          = $method->toPayloadString();
//
//        $this->methods[]  = $method;
//        $this->payloads[] = $payload;
//    }

    /**
     * execute
     * 
     * @param callable $callback
     * @return void
     */
//    public function execute($callback)
//    {
//        $methods = $this->methods;
//        $proxy   = function ($err, $res) use ($methods, $callback) {
//            if ($err !== null) {
//                return call_user_func($callback, $err, null);
//            }
//            foreach ($methods as $key => $method) {
//                if (isset($res[$key])) {
//                    if (!is_array($res[$key])) {
//                        $transformed = $method->transform([$res[$key]], $method->outputFormatters);
//                        $res[$key] = $transformed[0];
//                    } else {
//                        $transformed = $method->transform($res[$key], $method->outputFormatters);
//                        $res[$key] = $transformed;
//                    }
//                }
//            }
//            return call_user_func($callback, null, $res);
//        };
//        $this->requestManager->payloadAsyn('[' . implode(',', $this->payloads) . ']', $proxy);
//        $this->methods   = [];
//        $this->payloads  = [];
//    }


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