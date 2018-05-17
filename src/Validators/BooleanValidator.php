<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu\Validators;

use Webu\Validators\IValidator;

class BooleanValidator
{
    /**
     * validate
     *
     * @param mixed $value
     * @return bool
     */
    public static function validate($value)
    {
        return is_bool($value);
    }
}