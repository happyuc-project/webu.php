<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu\Validators;

use Webu\Validators\IValidator;

class IdentityValidator
{
    /**
     * validate
     * To do: check identity length.
     * Spec: 60 bytes, see https://github.com/happyuc-project/wiki/wiki/JSON-RPC#shh_newidentity
     * But returned value is 64 bytes.
     *
     * @param string $value
     * @return bool
     */
    public static function validate($value)
    {
        if (!is_string($value)) {
            return false;
        }
        return (preg_match('/^0x[a-fA-F0-9]*$/', $value) >= 1);
    }
}