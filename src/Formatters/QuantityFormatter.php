<?php

/**
 * This file is part of webu.php package.
 * 
 * (c) Kuan-Cheng,Lai <alk03073135@gmail.com>
 * 
 * @author Peter Lai <alk03073135@gmail.com>
 * @license MIT
 */

namespace Webu\Formatters;

use InvalidArgumentException;
use Webu\Utils;
use Webu\Formatters\IFormatter;

class QuantityFormatter implements IFormatter
{
    /**
     * format
     * 
     * @param mixed $value
     * @return string
     */
    public static function format($value)
    {
        $value = Utils::toString($value);

        if (Utils::isZeroPrefixed($value)) {
            // test hex with zero ahead, hardcode 0x0
            if ($value === '0x0' || strpos($value, '0x0') !== 0) {
                return $value;
            }
            $hex = preg_replace('/^0x0+(?!$)/', '', $value);
        } else {
            $bn = Utils::toBn($value);
            $hex = $bn->toHex(true);
        }
        if (empty($hex)) {
            $hex = '0';
        } else {
            $hex = preg_replace('/^0+(?!$)/', '', $hex);
        }
        return '0x' . $hex;
    }
}