<?php

/**
 * This file is part of webu.php package.
 * 
 * (c) Kuan-Cheng,Lai <alk03073135@gmail.com>
 * 
 * @author Peter Lai <alk03073135@gmail.com>
 * @license MIT
 */

namespace Webu\Contracts\Types;

interface IType
{
    /**
     * isType
     * 
     * @param string $name
     * @return bool
     */
    public function isType($name);

    /**
     * isDynamicType
     * 
     * @return bool
     */
    public function isDynamicType();

    /**
     * inputFormat
     * 
     * @param mixed $value
     * @param string $name
     * @return string
     */
    public function inputFormat($value, $name);
}