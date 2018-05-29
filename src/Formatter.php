<?php
/**
 * Created by PhpStorm.
 * User: dreamxyp
 * Date: 2018/5/18
 * Time: 18:53
 */

namespace Webu;


class Formatter
{
    /**
     * Address
     * to do: iban
     *
     * @param mixed $value
     * @return string
     */
    public static function Address($value)
    {
        $value = (string) $value;

        if (Utils::isAddress($value)) {
            $value = mb_strtolower($value);

            if (Utils::isZeroPrefixed($value)) {
                return $value;
            }
            return '0x' . $value;
        }
        $value = self::Integer($value, 40);

        return '0x' . $value;
    }

    /**
     * BigNumber
     *
     * @param mixed $value
     * @return string
     */
    public static function BigNumber($value):string
    {
        $value = Utils::toString($value);
        $bn    = Utils::toBn($value);

        return $bn;
    }

    /**
     * Boolean
     *
     * @param mixed $value
     * @return bool
     */
    public static function Boolean($value)
    {
        return (bool) $value;
    }

    /**
     * Hex
     *
     * @param mixed $value
     * @return string
     */
    public static function Hex($value)
    {
        $value = Utils::toString($value);
        $value = mb_strtolower($value);

        if (Utils::isZeroPrefixed($value)) {
            return $value;
        } else {
            $value = Utils::toHex($value, true);
        }
        return $value;
    }

    /**
     * Integer
     *
     * @param mixed $value
     * @return string
     */
    public static function Integer($value)
    {
        if(is_numeric($value))
        {
            $value = (int) $value;
        }else
        {
            $value = (string) $value;
        }
        $arguments = func_get_args();
        $digit     = 64;

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

    /**
     * Number
     *
     * @param mixed $value
     * @return int
     */
    public static function Number($value)
    {
        $value = Utils::toString($value);
        $bn    = Utils::toBn($value);
        $int   = (float) $bn->toString();

        return $int;
    }

    /**
     * OptionalQuantity
     *
     * @param mixed $value
     * @return string
     */
    public static function OptionalQuantity($value)
    {
        if (Validator::Tag($value)) {
            return $value;
        }
        return self::Quantity($value);
    }

    /**
     * Post
     *
     * @param mixed $value
     * @return string
     */
    public static function Post($value)
    {
        if (isset($value['priority'])) {
            $value['priority'] = self::Quantity($value['priority']);
        }
        if (isset($value['ttl'])) {
            $value['ttl'] = self::Quantity($value['ttl']);
        }
        return $value;
    }

    /**
     * Quantity
     *
     * @param mixed $value
     * @return string
     */
    public static function Quantity($value)
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

    /**
     * String
     *
     * @param mixed $value
     * @return string
     */
    public static function String($value)
    {
        return Utils::toString($value);
    }

    /**
     * Transaction
     *
     * @param mixed $value
     * @return string
     */
    public static function Transaction($value)
    {
        if (isset($value['gas'])) {
            $value['gas'] = self::Quantity($value['gas']);
        }
        if (isset($value['gasPrice'])) {
            $value['gasPrice'] = self::Quantity($value['gasPrice']);
        }
        if (isset($value['value'])) {
            $value['value'] = self::Quantity($value['value']);
        }
        if (isset($value['data'])) {
            $value['data'] = self::Hex($value['data']);
        }
        if (isset($value['nonce'])) {
            $value['nonce'] = self::Quantity($value['nonce']);
        }
        return $value;
    }
}