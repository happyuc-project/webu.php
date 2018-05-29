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
     * @param null $callback
     * @throws \Exception
     * @return array  returns true if the value was stored, otherwise false.
     */
    public function putString(string $database,string $key,string $store,$callback = null)
    {
        $params = [$database,$key,$store];
        return $this->provider->sendReal('db_putString',$params,$callback);
    }

    /**
     * Returns string from the local database.
     * ** Note ** this function is deprecated and will be removed in the future.
     *
     * @param string $database  Database name.
     * @param string $key       Key name.
     * @throws \Exception
     * @return array  The previously stored string.
     */
    public function getString(string $database,string $key,$callback = null)
    {
        $params = [$database,$key];
        return $this->provider->sendReal('db_getString',$params,$callback);
    }

    /**
     * Stores binary data in the local database.
     * ** Note ** this function is deprecated and will be removed in the future.
     *
     * @param string $database  Database name.
     * @param string $key       Key name.
     * @param string $data      The data to store.
     * @throws \Exception
     * @return array returns true if the value was stored, otherwise false.
     */
    public function putHex(string $database,string $key,string $data,$callback = null)
    {
        $params = [$database, $key, $data];
        return $this->provider->sendReal('db_putHex',$params,$callback);
    }

    /**
     * Returns binary data from the local database.
     * ** Note ** this function is deprecated and will be removed in the future.
     *
     * @param string $database
     * @param string $key
     * @throws \Exception
     * @return array The previously stored data.
     */
    public function getHex(string $database,string $key,$callback = null)
    {
        $params = [$database,$key];
        return $this->provider->sendReal('db_getHex',$params,$callback);
    }
}