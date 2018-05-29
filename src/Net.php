<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;


class Net
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
     * Returns the current network id.
     *
     * @throws \Exception
     * @return int
     */
    public function version($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('net_version',$params,$callback);
    }

    /**
     * Returns number of peers currently connected to the client.
     *
     * @throws \Exception
     * @return int
     */
    public function peerCount($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('net_peerCount',$params,$callback);
    }

    /**
     * Returns true if client is actively listening for network connections.
     *
     * @throws \Exception
     * @return bool
     */
    public function listening($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('net_listening',$params,$callback);
    }
}