<?php

/**
 * This file is part of webu.php package.
 * 
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */
namespace Webu;

use Webu\Methods\HucMethod;

class Webu
{
    /**
     * provider
     *
     * @var \Webu\HttpProvider
     */
    protected $provider;

    /**
     * huc
     * 
     * @var \Webu\Huc
     */
    public $huc;

    /**
     * net
     * 
     * @var \Webu\Net
     */
    public $net;

    /**
     * personal
     * 
     * @var \Webu\Personal
     */
    public $personal;

    /**
     * shh
     * 
     * @var \Webu\Shh
     */
    public $shh;

//    /**
//     * methods
//     *
//     * @var array
//     */
//    private $methods = [];
//
//    /**
//     * allowedMethods
//     *
//     * @var array
//     */
//    private $allowedMethods = [
//        'webu_clientVersion',
//        'webu_sha3'
//    ];

    /**
     * construct
     *
     * @param string
     * @return void
     */
    public function __construct($host,$timeout=1)
    {
        $requestManager = new \Webu\HttpRequestManager($host,$timeout);
        $this->provider = new \Webu\HttpProvider($requestManager,$this);

        $this->huc = new Huc($this->provider);
        $this->net = new Net($this->provider);
        $this->shh = new Shh($this->provider);
        $this->personal = new Personal($this->provider);
    }

//    private $allowedMethods = [
//        'webu_clientVersion',
//        'webu_sha3'
//    ];
    /**
     * @param $callback
     */
    public function clientVersion($callback)
    {
        $method = new HucMethod('webu_clientVersion',[]);
        $this->provider->send($method,$callback);
    }

    /**
     * @param $callback
     */
    public function sha3($callback)
    {
        $method = new HucMethod('webu_sha3',[]);
        $this->provider->send($method,$callback);
    }
    /**
     * call
     * 
     * @param string $name
     * @param array $arguments
     * @return void
     */
//    public function __call($name, $arguments)
//    {
//        if (empty($this->provider)) {
//            throw new \RuntimeException('Please set provider first.');
//        }
//
//        $class = explode('\\', get_class());
//
//        if (preg_match('/^[a-zA-Z0-9]+$/', $name) === 1) {
//            $method = strtolower($class[1]) . '_' . $name;
//
//            if (!in_array($method, $this->allowedMethods)) {
//                throw new \RuntimeException('Unallowed rpc method: ' . $method);
//            }
//            if ($this->provider->getIsBatch() ) {
//                $callback = null;
//            } else {
//                $callback = array_pop($arguments);
//
//                if (is_callable($callback) !== true) {
//                    throw new \InvalidArgumentException('The last param must be callback function.');
//                }
//            }
//            if (!array_key_exists($method, $this->methods)) {
//                // new the method
//                $methodClass = sprintf("\Webu\Methods\%s\%s", ucfirst($class[1]), ucfirst($name));
//                $methodObject = new $methodClass($method, $arguments);
//                $this->methods[$method] = $methodObject;
//            } else {
//                $methodObject = $this->methods[$method];
//            }
//            if ($methodObject->validate($arguments)) {
//                $inputs = $methodObject->transform($arguments, $methodObject->inputFormatters);
//                $methodObject->arguments = $inputs;
//                $this->provider->send($methodObject, $callback);
//            }
//        }
//    }

    /**
     * getProvider
     * 
     * @return \Webu\HttpProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }
}