<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;


class Personal
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
     *
     * @return void
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
    }


    /**
     * Returns listAccounts
     *
     * @throws \Exception
     * @return array
     */
    public function listAccounts($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('personal_listAccounts',$params,$callback);
    }


    /**
     * Returns newAccount
     *
     * @throws \Exception
     * @return mixed
     */
    public function newAccount(string $pwd,$callback = null)
    {
        $params = [$pwd];
        return $this->provider->sendReal('personal_newAccount',$params,$callback);
    }


    /**
     * Returns unlockAccount
     *
     * @throws \Exception
     * @return bool
     */
    public function unlockAccount(string $address,string $pwd,$callback = null)
    {
        $params = [$address,$pwd];
        return $this->provider->sendReal('personal_unlockAccount',$params,$callback);
    }


    /**
     * Returns sendTransaction
     *
     * @throws \Exception
     * @return mixed
     */
    public function sendTransaction(array $params,string $pwd,$callback = null)
    {
        $params = [$params,$pwd];
        return $this->provider->sendReal('personal_sendTransaction',$params,$callback);
    }
}