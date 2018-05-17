<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu\Formatters;

use InvalidArgumentException;
use Webu\Utils;
use Webu\Formatters\IFormatter;

class IntegerFormatter implements IFormatter
{
    /**
     * format
     * 
     * @param mixed $value
     * @return string
     */
    public static function format($value)
    {
        $value = (string) $value;
        $arguments = func_get_args();
        $digit = 64;

        if (isset($arguments[1]) && is_numeric($arguments[1])) {
            $digit = intval($arguments[1]);
        }
        $bn = Utils::toBn($value);
        $bnHex = $bn->toHex(true);
        $padded = mb_substr($bnHex, 0, 1);

        if ($padded !== 'f') {
            $padded = '0';
        }        
        return implode('', array_fill(0, $digit-mb_strlen($bnHex), $padded)) . $bnHex;
    }
}