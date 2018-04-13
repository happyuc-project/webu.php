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