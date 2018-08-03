<?php

/**
 * This file is part of webu.php package.
 * 
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */
namespace Webu;

use Webu\Methods\IrcMethod;

class Webu
{
    /**
     * provider
     *
     * @var \Webu\HttpProvider
     */
    protected $provider;

    /**
     * irc
     * 
     * @var \Webu\Irc
     */
    public $irc;

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

        $this->irc = new Irc($this->provider);
        $this->net = new Net($this->provider);
        $this->shh = new Shh($this->provider);
        $this->personal = new Personal($this->provider);
    }

    /**
     * getProvider
     *
     * @return \Webu\HttpProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Returns the current client version.
     * @return string
     * @throws \Exception
     */
    public function clientVersion($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('webu_clientVersion',$params,$callback);
    }

    /**
     * Returns Keccak-256 (not the standardized SHA3-256) of the given data.
     * @param string $data
     *
     * @return string  $data the data to convert into a SHA3 hash
     *
     * @throws \Exception
     */
    public function sha3(string $data,$callback = null)
    {
        $params = [$data];
        return $this->provider->sendReal('webu_sha3',$params,$callback);
    }


}