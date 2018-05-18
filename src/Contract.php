<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;

use Webu\Contracts\Hucabi;
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
    protected $provider;

    /**
     * abi
     * 
     * @var array
     */
    protected $abi;

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
     * huc
     * 
     * @var \Webu\Huc
     */
    protected $huc;

    /**
     * hucabi
     * 
     * @var \Webu\Contracts\Hucabi
     */
    protected $hucabi;

    /**
     * construct
     *
     * @param \Webu\HttpProvider $provider
     * @param array $abi
     * @return void
     */
    public function __construct(\Webu\HttpProvider $provider, array $abi)
    {
        $this->provider = $provider;
        $abi            = Utils::jsonToArray($abi, 5);

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
        $this->abi = $abi;
        $this->huc = $this->provider->webu->huc;
        $this->hucabi = new Hucabi([
            'address' => new Address,
            'bool' => new Boolean,
            'bytes' => new Bytes,
            'int' => new Integer,
            'string' => new Str,
            'uint' => new Uinteger,
        ]);
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
     * getAbi
     * 
     * @return array
     */
    public function getAbi()
    {
        return $this->abi;
    }

    /**
     * setAbi
     * 
     * @param string $abi
     * @return $this
     */
    public function setAbi($abi)
    {
        return $this->abi($abi);
    }

    /**
     * getHucabi
     * 
     * @return \Webu\Contracts\Hucabi
     */
    public function getHucabi()
    {
        return $this->hucabi;
    }

    /**
     * getHuc
     * 
     * @return \Webu\Huc
     */
    public function getHuc()
    {
        return $this->huc;
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
     * at
     * 
     * @param string $address
     * @return $this
     */
    public function at($address)
    {
        if (Validator::Address($address) === false) {
            throw new \InvalidArgumentException('Please make sure address is valid.');
        }
        $this->toAddress = Formatter::Address($address);

        return $this;
    }

    /**
     * bytecode
     * 
     * @param string $bytecode
     * @return $this
     */
    public function bytecode($bytecode)
    {
        if (Validator::Hex($bytecode) === false) {
            throw new \InvalidArgumentException('Please make sure bytecode is valid.');
        }
        $this->bytecode = Utils::stripZero($bytecode);

        return $this;
    }

    /**
     * abi
     * 
     * @param string $abi
     * @return $this
     */
    public function abi($abi)
    {
        if (Validator::String($abi) === false) {
            throw new \InvalidArgumentException('Please make sure abi is valid.');
        }
        $abi = Utils::jsonToArray($abi, 5);

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
        $this->abi = $abi;

        return $this;
    }

    /**
     * new
     * Deploy a contruct with params.
     * 
     * @param mixed
     * @return void
     */
    public function new()
    {
        if (isset($this->constructor)) {
            $constructor = $this->constructor;
            $arguments = func_get_args();
            $callback = array_pop($arguments);

            if (count($arguments) < count($constructor['inputs'])) {
                throw new \InvalidArgumentException('Please make sure you have put all constructor params and callback.');
            }
            if (is_callable($callback) !== true) {
                throw new \InvalidArgumentException('The last param must be callback function.');
            }
            if (!isset($this->bytecode)) {
                throw new \InvalidArgumentException('Please call bytecode($bytecode) before new().');
            }
            $params = array_splice($arguments, 0, count($constructor['inputs']));
            $data = $this->hucabi->encodeParameters($constructor, $params);
            $transaction = [];

            if (count($arguments) > 0) {
                $transaction = $arguments[0];
            }
            $transaction['data'] = '0x' . $this->bytecode . Utils::stripZero($data);

            $this->huc->sendTransaction($transaction, function ($err, $transaction) use ($callback){
                if ($err !== null) {
                    return call_user_func($callback, $err, null);
                }
                return call_user_func($callback, null, $transaction);
            });
        }
    }

    /**
     * send
     * Send function method.
     * 
     * @param mixed
     * @return void
     */
    public function send()
    {
        if (isset($this->functions)) {
            $arguments = func_get_args();
            $method = array_splice($arguments, 0, 1)[0];
            $callback = array_pop($arguments);

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
            $params = array_splice($arguments, 0, count($function['inputs']));
            $data = $this->hucabi->encodeParameters($function, $params);
            $functionName = Utils::jsonMethodToString($function);
            $functionSignature = $this->hucabi->encodeFunctionSignature($functionName);
            $transaction = [];

            if (count($arguments) > 0) {
                $transaction = $arguments[0];
            }
            $transaction['to'] = $this->toAddress;
            $transaction['data'] = $functionSignature . Utils::stripZero($data);

            $this->huc->sendTransaction($transaction, function ($err, $transaction) use ($callback){
                if ($err !== null) {
                    return call_user_func($callback, $err, null);
                }
                return call_user_func($callback, null, $transaction);
            });
        }
    }

    /**
     * call
     * Call function method.
     * 
     * @param mixed
     * @return void
     */
    public function call()
    {
        if (isset($this->functions)) {
            $arguments = func_get_args();
            $method = array_splice($arguments, 0, 1)[0];
            $callback = array_pop($arguments);

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
            $params = array_splice($arguments, 0, count($function['inputs']));
            $data = $this->hucabi->encodeParameters($function, $params);
            $functionName = Utils::jsonMethodToString($function);
            $functionSignature = $this->hucabi->encodeFunctionSignature($functionName);
            $transaction = [];

            if (count($arguments) > 0) {
                $transaction = $arguments[0];
            }
            $transaction['to'] = $this->toAddress;
            $transaction['data'] = $functionSignature . Utils::stripZero($data);

            $this->huc->call($transaction, function ($err, $transaction) use ($callback, $function){
                if ($err !== null) {
                    return call_user_func($callback, $err, null);
                }
                $decodedTransaction = $this->hucabi->decodeParameters($function, $transaction);

                return call_user_func($callback, null, $decodedTransaction);
            });
        }
    }

    /**
     * estimateGas
     * Estimate function gas.
     * 
     * @param mixed
     * @return void
     */
    public function estimateGas()
    {
        if (isset($this->functions) || isset($this->constructor)) {
            $arguments = func_get_args();
            $callback = array_pop($arguments);

            if (empty($this->toAddress) && !empty($this->bytecode)) {
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
                $params = array_splice($arguments, 0, count($constructor['inputs']));
                $data = $this->hucabi->encodeParameters($constructor, $params);
                $transaction = [];

                if (count($arguments) > 0) {
                    $transaction = $arguments[0];
                }
                $transaction['to'] = '';
                $transaction['data'] = '0x' . $this->bytecode . Utils::stripZero($data);
            } else {
                $mhucod = array_splice($arguments, 0, 1)[0];

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
                $params = array_splice($arguments, 0, count($function['inputs']));
                $data = $this->hucabi->encodeParameters($function, $params);
                $functionName = Utils::jsonMethodToString($function);
                $functionSignature = $this->hucabi->encodeFunctionSignature($functionName);
                $transaction = [];

                if (count($arguments) > 0) {
                    $transaction = $arguments[0];
                }
                $transaction['to'] = $this->toAddress;
                $transaction['data'] = $functionSignature . Utils::stripZero($data);
            }

            $this->huc->estimateGas($transaction, function ($err, $gas) use ($callback){
                if ($err !== null) {
                    return call_user_func($callback, $err, null);
                }
                return call_user_func($callback, null, $gas);
            });
        }
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
     * @return void
     */
    public function getData()
    {
        if (isset($this->functions) || isset($this->constructor)) {
            $arguments = func_get_args();
            $functionData = '';

            if (empty($this->toAddress) && !empty($this->bytecode)) {
                $constructor = $this->constructor;

                if (count($arguments) < count($constructor['inputs'])) {
                    throw new \InvalidArgumentException('Please make sure you have put all constructor params and callback.');
                }
                if (!isset($this->bytecode)) {
                    throw new \InvalidArgumentException('Please call bytecode($bytecode) before getData().');
                }
                $params = array_splice($arguments, 0, count($constructor['inputs']));
                $data = $this->hucabi->encodeParameters($constructor, $params);
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
                $params = array_splice($arguments, 0, count($function['inputs']));
                $data = $this->hucabi->encodeParameters($function, $params);
                $functionName = Utils::jsonMethodToString($function);
                $functionSignature = $this->hucabi->encodeFunctionSignature($functionName);
                $functionData = Utils::stripZero($functionSignature) . Utils::stripZero($data);
            }
            return $functionData;
        }
    }
}