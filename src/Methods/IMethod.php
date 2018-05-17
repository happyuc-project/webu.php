<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu\Methods;

interface IMethod
{
    /**
     * transform
     * 
     * @param array &$data
     * @param array $rules
     * @return array
     */
    public function transform($data, $rules);
}