<?php

/**
 * This file is part of webu.php package.
 * 
 * (c) Kuan-Cheng,Lai <alk03073135@gmail.com>
 * 
 * @author Peter Lai <alk03073135@gmail.com>
 * @license MIT
 */

namespace Webu\Methods;

interface IRPC
{
    /**
     * __toString
     * 
     * @return array
     */
    public function __toString();

    /**
     * toPayload
     * 
     * @return array
     */
    public function toPayload();
}