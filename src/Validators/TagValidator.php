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

use Webu\Validators\IValidator;
use Webu\Utils;

class TagValidator implements IValidator
{
    /**
     * validate
     *
     * @param string $value
     * @return bool
     */
    public static function validate($value)
    {
        $value = Utils::toString($value);
        $tags = [
            'latest', 'earliest', 'pending'
        ];

        return in_array($value, $tags);
    }
}