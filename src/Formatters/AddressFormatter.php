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
use Webu\Formatters\IntegerFormatter;

class AddressFormatter implements IFormatter
{
    /**
     * format
     * to do: iban
     * 
     * @param mixed $value
     * @return string
     */
    public static function format($value)
    {
        $value = (string) $value;

        if (Utils::isAddress($value)) {
            $value = mb_strtolower($value);

            if (Utils::isZeroPrefixed($value)) {
                return $value;
            }
            return '0x' . $value;
        }
        $value = IntegerFormatter::format($value, 40);

        return '0x' . $value;
    }
}