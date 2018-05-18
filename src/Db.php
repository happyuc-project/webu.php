<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;


class Db
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
//    private $methods = [];

    /**
     * allowedMethods
     * 
     * @var array
     */
//    private $allowedMethods = [
//        'db_putString', 'db_getString', 'db_putHex', 'db_getHex'
//    ];


    /**
     * construct
     *
     * @param \Webu\HttpProvider $provider
     * @return void
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    /**
     * Stores a string in the local database.
     * ** Note ** this function is deprecated and will be removed in the future.
     *
     * @param string $database Database name.
     * @param string $key      Key name.
     * @param string $store    String to store.
     * @return array  returns true if the value was stored, otherwise false.
     */
    public function putString(string $database,string $key,string $store)
    {
        $params = [$database,$key,$store];
        return $this->provider->sendReal('db_putString',$params);
    }

    /**
     * Returns string from the local database.
     * ** Note ** this function is deprecated and will be removed in the future.
     *
     * @param string $database  Database name.
     * @param string $key       Key name.
     * @return array  The previously stored string.
     */
    public function getString(string $database,string $key)
    {
        $params = [$database,$key];
        return $this->provider->sendReal('db_getString',$params);
    }

    /**
     * Stores binary data in the local database.
     * ** Note ** this function is deprecated and will be removed in the future.
     *
     * @param string $database  Database name.
     * @param string $key       Key name.
     * @param string $data      The data to store.
     * @return array returns true if the value was stored, otherwise false.
     */
    public function putHex(string $database,string $key,string $data)
    {
        $params = [$database, $key, $data];
        return $this->provider->sendReal('db_putHex',$params);
    }

    /**
     * Returns binary data from the local database.
     * ** Note ** this function is deprecated and will be removed in the future.
     *
     * @param string $database
     * @param string $key
     * @return array The previously stored data.
     */
    public function getHex(string $database,string $key)
    {
        $params = [$database,$key];
        return $this->provider->sendReal('db_getHex',$params);
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
//            if ($this->provider->isBatch) {
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
//
}