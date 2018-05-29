<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu\Contracts;

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

    /**
     * inputFormat
     *
     * @param mixed $value
     * @param string $name
     * @return string
     */
    public function outputFormat($value, $name);
}