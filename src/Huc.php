<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;


class Huc
{
    /**
     * provider
     *
     * @var \Webu\HttpProvider
     */
    protected $provider;

    /**
     * methods
     * 
     * @var array
     */
//  private $methods = [];

    /**
     * allowedMethods
     * 
     * @var array
     */
    private $allowedMethods = [
        'huc_protocolVersion',
        'huc_syncing',
        'huc_coinbase',
        'huc_mining',
        'huc_hashrate',
        'huc_gasPrice',
        'huc_accounts',
        'huc_blockNumber',
        'huc_getBalance',
        'huc_getBlock',
        'huc_getStorageAt',
        'huc_getTransactionCount',
        'huc_getBlockTransactionCountByHash',
        'huc_getBlockTransactionCountByNumber',
        'huc_getUncleCountByBlockHash',
        'huc_getUncleCountByBlockNumber',
        'huc_getUncleByBlockHashAndIndex',
        'huc_getUncleByBlockNumberAndIndex',
        'huc_getCode',
        'huc_sign',
        'huc_sendTransaction',
        'huc_sendRawTransaction',
        'huc_call',
        'huc_estimateGas',
        'huc_getBlockByHash',
        'huc_getBlockByNumber',
        'huc_getTransactionByHash',
        'huc_getTransactionByBlockHashAndIndex',
        'huc_getTransactionByBlockNumberAndIndex',
        'huc_getTransactionReceipt',
        'huc_getCompilers',
        'huc_compileSolidity',
        'huc_compileLLL',
        'huc_compileSerpent',
        'huc_getWork',
        'huc_newFilter',
        'huc_newBlockFilter',
        'huc_newPendingTransactionFilter',
        'huc_uninstallFilter',
        'huc_getFilterChanges',
        'huc_getFilterLogs',
        'huc_getLogs',
        'huc_submitWork',
        'huc_submitHashrate'
    ];

    /**
     * construct
     *
     * @param string|\Webu\HttpProvider $provider
     * @return void
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
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
//        print_r(['$name'=>$name,'$arguments'=>$arguments]);
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
}