<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu\Validators;

use Webu\Validators\IValidator;

class QuantityValidator
{
    /**
     * validate
     *
     * @param string $value
     * @return bool
     */
    public static function validate($value)
    {
        // maybe change is_int and is_float and preg_match future
        return (is_int($value) || is_float($value) || preg_match('/^0x[a-fA-F0-9]*$/', $value) >= 1);
    }
}