<?php

/**
 * This file is part of webu.php package.
 * 
 * (c) Kuan-Cheng,Lai <alk03073135@gmail.com>
 * 
 * @author Peter Lai <alk03073135@gmail.com>
 * @license MIT
 */

namespace Webu\Validators;

interface IValidator
{
    /**
     * validate
     *
     * @param mixed $value
     * @return bool
     */
     public static function validate($value);
}