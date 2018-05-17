<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
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