<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;

use Webu\Contracts\Ircabi;
use Webu\Contracts\Types\Address;
use Webu\Contracts\Types\Boolean;
use Webu\Contracts\Types\Bytes;
use Webu\Contracts\Types\Integer;
use Webu\Contracts\Types\Str;
use Webu\Contracts\Types\Uinteger;

class Contract
{
    /**
     * provider
     *
     * @var \Webu\HttpProvider
     */
    public $provider;


    /**
     * constructor
     * 
     * @var array
     */
    protected $constructor = [];

    /**
     * functions
     * 
     * @var array
     */
    protected $functions   = [];

    /**
     * events
     * 
     * @var array
     */
    protected $events      = [];

    /**
     * toAddress
     * 
     * @var string
     */
    protected $toAddress;

    /**
     * bytecode
     * 
     * @var string
     */
    protected $bytecode;

    /**
     * abi
     *
     * @var array
     */
    protected $abi;

    /**
     * irc
     * 
     * @var \Webu\Irc
     */
    protected $irc;

    /**
     * ircabi
     * 
     * @var \Webu\Contracts\Ircabi
     */
    protected $ircabi;

    /**
     * construct
     *
     * @param \Webu\HttpProvider $provider
     * @param string $abi
     * @return void
     */
    public function __construct(\Webu\HttpProvider $provider, string $abi)
    {
        $this->setAbi($abi);

        $this->provider = $provider;
        $this->irc      = $this->provider->webu->irc;
        $this->ircabi   = new Ircabi(['address' => new Address, 'bool' => new Boolean, 'bytes' => new Bytes, 'int' => new Integer, 'string' => new Str,'uint' => new Uinteger,]);
    }

    /**
     * getFunctions
     * 
     * @return array
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * getEvents
     * 
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * getConstructor
     * 
     * @return array
     */
    public function getConstructor()
    {
        return $this->constructor;
    }


    /**
     * getIrcabi
     * 
     * @return \Webu\Contracts\Ircabi
     */
    public function getIrcabi()
    {
        return $this->ircabi;
    }

    /**
     * @return array
     */
    public function getAbi()
    {
        return $this->abi;
    }

    /**
     * getIrc
     * 
     * @return \Webu\Irc
     */
    public function getIrc()
    {
        return $this->irc;
    }

    /**
     * setBytecode
     * 
     * @param string $bytecode
     * @return $this
     */
    public function setBytecode($bytecode)
    {
        return $this->bytecode($bytecode);
    }

    /**
     * setToAddress
     * 
     * @param string $bytecode
     * @return $this
     */
    public function setToAddress($address)
    {
        return $this->at($address);
    }

    /**
     * abi
     *
     * @param string $abi
     * @return $this
     */
    public function setAbi(string $abi_str)
    {
        if (Validator::String($abi_str) === false) {
            throw new \InvalidArgumentException('Please make sure abi is valid.');
        }
        $abi            = Utils::jsonToArray($abi_str, 5);

        foreach ($abi as $item) {
            if (isset($item['type'])) {
                if ($item['type'] === 'function') {
                    $this->functions[$item['name']] = $item;
                } elseif ($item['type'] === 'constructor') {
                    $this->constructor = $item;
                } elseif ($item['type'] === 'event') {
                    $this->events[$item['name']] = $item;
                }
            }
        }
        $this->abi    = $abi;

        return $this;
    }


    /**
     * getData
     * Get the function method call data.
     * With this function, you can send signed contract function transaction.
     * 1. Get the funtion data with params.
     * 2. Sign the data with user private key.
     * 3. Call sendRawTransaction.
     *
     * @param mixed
     */
    public function data()
    {
        $functionData  = '';
        if ($this->functions || $this->constructor){
            // $arguments    = func_get_args();
            if (!$this->toAddress && !empty($this->bytecode)) {
                $constructor = $this->constructor;

                if (count($arguments) < count($constructor['inputs'])) {
                    throw new \InvalidArgumentException('Please make sure you have put all constructor params and callback.');
                }
                if (!isset($this->bytecode)) {
                    throw new \InvalidArgumentException('Please call bytecode($bytecode) before getData().');
                }
                $params       = array_splice($arguments, 0, count($constructor['inputs']));
                $data         = $this->ircabi->encodeParameters($constructor, $params);
                $functionData = $this->bytecode . Utils::stripZero($data);
            } else {
                $method = array_splice($arguments, 0, 1)[0];

                if (!is_string($method) && !isset($this->functions[$method])) {
                    throw new \InvalidArgumentException('Please make sure the method is existed.');
                }
                $function = $this->functions[$method];

                if (count($arguments) < count($function['inputs'])) {
                    throw new \InvalidArgumentException('Please make sure you have put all function params and callback.');
                }
                $params            = array_splice($arguments, 0, count($function['inputs']));
                $data              = $this->ircabi->encodeParameters($function, $params);
                $functionName      = Utils::jsonMethodToString($function);
                $functionSignature = $this->ircabi->encodeFunctionSignature($functionName);
                $functionData      = Utils::stripZero($functionSignature) . Utils::stripZero($data);
            }
        }
        return $functionData;
    }

    /**
     * at
     * 
     * @param string $address
     *
     * @throws \Exception
     * @return Contract
     */
    public function at($address)
    {
        $rs      = Validator::Address($address,__METHOD__.':');
        if ($rs[0] === false) {
            throw new \Exception("Please make sure address is valid.\n".$rs[0]);
        }
        $this->toAddress = Formatter::Address($address);

        return $this;
    }

    /**
     * bytecode
     * 
     * @param string $bytecode
     *
     * @throws \Exception
     * @return Contract
     */
    public function bytecode($bytecode)
    {
        // echo "\$bytecode:1\n";
        $rs      = Validator::Hex($bytecode,__METHOD__.':');
        if ($rs[0] === false) {
            //  echo "\$bytecode:2\n";
            throw new \Exception("Please make sure bytecode is valid.\n".$rs[0]);
        }
        // echo "\$bytecode:3\n";
        $this->bytecode = Utils::stripZero($bytecode);
        // echo "\$bytecode:4\n";
        return $this;
    }



    /**
     * new
     * Deploy a contruct with params.
     *
     * $initialSupply,$tokenName,$decimalUnits,$tokenSymbol,$callback=null
     * 
     * @param mixed
     *
     * @throws \Exception
     * @return Contract
     */
    public function new()
    {
        if (isset($this->constructor)) {
            $arguments   = func_get_args();
            $callback    = array_pop($arguments);

            // print_r(['$arguments'=>$arguments,]);
            if ( count($arguments) < count($this->constructor['inputs']) ) {
                throw new \Exception('Please make sure you have put all constructor params and callback.');
            }
            if (is_callable($callback) !== true) {
                throw new \Exception('The last param must be callback function.');
            }
            if (!isset($this->bytecode)) {
                throw new \Exception('Please call bytecode($bytecode) before new().');
            }

            // print_r(['$callback'=>$callback,]);
            // print_r(['$arguments'=>$arguments,'$this->constructor[\'inputs\']'=>$this->constructor['inputs']  ]);
            $inputs         = array_splice($arguments, 0, count($this->constructor['inputs']));
            // print_r(['$arguments'=>$arguments]);
            $data           = $this->ircabi->encodeParameters($this->constructor, $inputs);
            // print_r(['Utils::stripZero($data)'=>Utils::stripZero($data)]);
            $data           = '0x' . $this->bytecode . Utils::stripZero($data);
            $params         = $arguments[0];
            $params['data'] = $data;
            // print_r(['$params'=>$params]);
            $this->irc->sendTransaction($params, $callback);
        }

        return $this;
    }

    /**
     * send
     * Send function method.
     * 
     * @param mixed
     *
     * @throws \Exception
     * @return Contract
     */
    public function send()
    {
        if ($this->functions)
        {
            $arguments = func_get_args();
            $method    = array_splice($arguments, 0, 1)[0];
            $callback  = array_pop($arguments);

            if (!is_string($method) && !isset($this->functions[$method])) {
                throw new \Exception('Please make sure the method is existed.');
            }
            $function  = $this->functions[$method];

            // print_r(['$function'=>$function,'$arguments'=>$arguments]);
            if (count($arguments) < count($function['inputs'])) {
                throw new \Exception('Please make sure you have put all function params and callback.');
            }
            if (is_callable($callback) !== true) {
                throw new \Exception('The last param must be callback function.');
            }
            $arguments2         = array_splice($arguments, 0, count($function['inputs']));

            // print_r($arguments);
            $data              = $this->ircabi->encodeParameters($function, $arguments2);
            $functionName      = Utils::jsonMethodToString($function);
            $functionSignature = $this->ircabi->encodeFunctionSignature($functionName);
            $params            = [];

            if (count($arguments) > 0) {
                $params     = $arguments[0];
            }
            // print_r(['to2'=>$this->toAddress,'$params'=>$params]);
            $params['to']   = $this->toAddress;
            // print_r($params);
            // print_r(['to'=>$this->toAddress,'$data'=>$data]);
            $params['data'] = $functionSignature . Utils::stripZero($data);
            // print_r($params);
            $this->irc->sendTransaction($params, $callback);
        }
        return $this;
    }

    /**
     * call
     * Call function method.
     * 
     * @param mixed
     *
     * @throws \Exception
     * @return Contract
     */
    public function call()
    {
        if ($this->functions)
        {
            $arguments = func_get_args();
            $method    = array_splice($arguments, 0, 1)[0];
            $callback  = array_pop($arguments);

            if (!is_string($method) && !isset($this->functions[$method])) {
                throw new \InvalidArgumentException('Please make sure the method is existed.');
            }
            $function = $this->functions[$method];

            if (count($arguments) < count($function['inputs'])) {
                throw new \InvalidArgumentException('Please make sure you have put all function params and callback.');
            }
            if (is_callable($callback) !== true) {
                throw new \InvalidArgumentException('The last param must be callback function.');
            }
            $params2           = array_splice($arguments, 0, count($function['inputs']));
            $data              = $this->ircabi->encodeParameters($function, $params2);
            $functionName      = Utils::jsonMethodToString($function);
            $functionSignature = $this->ircabi->encodeFunctionSignature($functionName);
            $params            = [];

            if (count($arguments) > 0) {
                $params     = $arguments[0];
            }
            $params['to']   = $this->toAddress;
            $params['data'] = $functionSignature . Utils::stripZero($data);

            $this->irc->call($params, "latest", function ($err, $data) use ($callback, $function){
                if ($err !== null) {
                    return call_user_func($callback, $err, null);
                }
                $decodedTransaction = $this->ircabi->decodeParameters($function, $data);
                return call_user_func($callback, null, $decodedTransaction);
            });
        }
        return $this;
    }

    /**
     * estimateGas
     * Estimate function gas.
     * 
     * @param mixed
     *
     * @throws \Exception
     * @return mixed
     */
    public function estimateGas()
    {
        if ($this->functions || $this->constructor) {
            $arguments = func_get_args();
            $callback  = array_pop($arguments);

            if (!$this->toAddress && $this->bytecode) {
                $constructor = $this->constructor;

                if (count($arguments) < count($constructor['inputs'])) {
                    throw new \InvalidArgumentException('Please make sure you have put all constructor params and callback.');
                }
                if (is_callable($callback) !== true) {
                    throw new \InvalidArgumentException('The last param must be callback function.');
                }
                if (!isset($this->bytecode)) {
                    throw new \InvalidArgumentException('Please call bytecode($bytecode) before estimateGas().');
                }
                $params2 = array_splice($arguments, 0, count($constructor['inputs']));
                $data    = $this->ircabi->encodeParameters($constructor, $params2);
                $params  = [];

                if (count($arguments) > 0) {
                    $params = $arguments[0];
                }
                $params['to']   = '';
                $params['data'] = '0x' . $this->bytecode . Utils::stripZero($data);
            } else {
                $method = array_splice($arguments, 0, 1)[0];

                if (!is_string($method) && !isset($this->functions[$method])) {
                    throw new \InvalidArgumentException('Please make sure the method is existed.');
                }
                $function = $this->functions[$method];

                if (count($arguments) < count($function['inputs'])) {
                    throw new \InvalidArgumentException('Please make sure you have put all function params and callback.');
                }
                if (is_callable($callback) !== true) {
                    throw new \InvalidArgumentException('The last param must be callback function.');
                }
                $params2           = array_splice($arguments, 0, count($function['inputs']));
                $data              = $this->ircabi->encodeParameters($function, $params2);
                $functionName      = Utils::jsonMethodToString($function);
                $functionSignature = $this->ircabi->encodeFunctionSignature($functionName);
                $params            = [];

                if (count($arguments) > 0) {
                    $params = $arguments[0];
                }
                $params['to']   = $this->toAddress;
                $params['data'] = $functionSignature . Utils::stripZero($data);
            }
            return $this->irc->estimateGas( $params, "latest", $callback);
        }
        return $this;
    }

}