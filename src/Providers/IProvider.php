<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu\Providers;

interface IProvider
{
    /**
     * send
     * 
     * @param \Webu\Methods\Method $method
     * @param callable $callback
     * @return void
     */
    public function send($method, $callback);  

    /**
     * batch
     * 
     * @param bool $status
     * @return void
     */
    public function batch($status);

    /**
     * execute
     * 
     * @param callable $callback
     * @return void
     */
    public function execute($callback);
}