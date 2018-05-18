<?php
/**
 * Created by PhpStorm.
 * User: dreamxyp
 * Date: 2018/5/18
 * Time: 18:14
 */

namespace Webu;


class Validator
{
    /**
     * Address
     *
     * @param string $value
     * @return bool
     */
    public static function Address($value)
    {
        if (!is_string($value)) {
            return false;
        }
        return (preg_match('/^0x[a-fA-F0-9]{40}$/', $value) >= 1);
    }

    /**
     * BlockHash
     *
     * @param string $value
     * @return bool
     */
    public static function BlockHash($value)
    {
        if (!is_string($value)) {
            return false;
        }
        return (preg_match('/^0x[a-fA-F0-9]{64}$/', $value) >= 1);
    }

    /**
     * Boolean
     *
     * @param mixed $value
     * @return bool
     */
    public static function Boolean($value)
    {
        return is_bool($value);
    }

    /**
     * Call
     *
     * @param array $value
     * @return bool
     */
    public static function Call($value)
    {
        if (!is_array($value)) {
            return false;
        }
        if (isset($value['from']) && self::Address($value['from']) === false) {
            return false;
        }
        if (!isset($value['to'])) {
            return false;
        }
        if (self::Address($value['to']) === false) {
            return false;
        }
        if (isset($value['gas']) && self::Quantity($value['gas']) === false) {
            return false;
        }
        if (isset($value['gasPrice']) && self::Quantity($value['gasPrice']) === false) {
            return false;
        }
        if (isset($value['value']) && self::Quantity($value['value']) === false) {
            return false;
        }
        if (isset($value['data']) && self::Hex($value['data']) === false) {
            return false;
        }
        if (isset($value['nonce']) && self::Quantity($value['nonce']) === false) {
            return false;
        }
        return true;
    }


    /**
     * Filter
     *
     * @param array $value
     * @return bool
     */
    public static function Filter($value)
    {
        if (!is_array($value)) {
            return false;
        }
        if (
            isset($value['fromBlock']) &&
            self::Quantity($value['fromBlock']) === false &&
            self::Tag($value['fromBlock']) === false
        ) {
            return false;
        }
        if (
            isset($value['toBlock']) &&
            self::Quantity($value['toBlock']) === false &&
            self::Tag($value['toBlock']) === false
        ) {
            return false;
        }
        if (isset($value['address'])) {
            if (is_array($value['address'])) {
                foreach ($value['address'] as $address) {
                    if (self::Address($address) === false) {
                        return false;
                    }
                }
            } elseif (self::Address($value['address']) === false) {
                return false;
            }
        }
        if (isset($value['topics']) && is_array($value['topics'])) {
            foreach ($value['topics'] as $topic) {
                if (is_array($topic)) {
                    foreach ($topic as $v) {
                        if (isset($v) && self::Hex($v) === false) {
                            return false;
                        }
                    }
                } else {
                    if (isset($topic) && self::Hex($topic) === false) {
                        return false;
                    }
                }
            }
        }
        return true;
    }


    /**
     * Hex
     *
     * @param string $value
     * @return bool
     */
    public static function Hex($value)
    {
        if (!is_string($value)) {
            return false;
        }
        return (preg_match('/^0x[a-fA-F0-9]*$/', $value) >= 1);
    }


    /**
     * Identity
     * To do: check identity length.
     * Spec: 60 bytes, see https://github.com/happyuc-project/wiki/wiki/JSON-RPC#shh_newidentity
     * But returned value is 64 bytes.
     *
     * @param string $value
     * @return bool
     */
    public static function Identity($value)
    {
        if (!is_string($value)) {
            return false;
        }
        return (preg_match('/^0x[a-fA-F0-9]*$/', $value) >= 1);
    }


    /**
     * Nonce
     *
     * @param string $value
     * @return bool
     */
    public static function Nonce($value)
    {
        if (!is_string($value)) {
            return false;
        }
        return (preg_match('/^0x[a-fA-F0-9]{16}$/', $value) >= 1);
    }



    /**
     * Post
     *
     * @param array $value
     * @return bool
     */
    public static function Post($value)
    {
        if (!is_array($value)) {
            return false;
        }
        if (isset($value['from']) && self::Identity($value['from']) === false) {
            return false;
        }
        if (isset($value['to']) && self::Identity($value['to']) === false) {
            return false;
        }
        if (!isset($value['topics']) || !is_array($value['topics'])) {
            return false;
        }
        foreach ($value['topics'] as $topic) {
            if (self::Identity($topic) === false) {
                return false;
            }
        }
        if (!isset($value['payload'])) {
            return false;
        }
        if (self::Hex($value['payload']) === false) {
            return false;
        }
        if (!isset($value['priority'])) {
            return false;
        }
        if (self::Quantity($value['priority']) === false) {
            return false;
        }
        if (!isset($value['ttl'])) {
            return false;
        }
        if (isset($value['ttl']) && self::Quantity($value['ttl']) === false) {
            return false;
        }
        return true;
    }


    /**
     * Quantity
     *
     * @param string $value
     * @return bool
     */
    public static function Quantity($value)
    {
        // maybe change is_int and is_float and preg_match future
        return (is_int($value) || is_float($value) || preg_match('/^0x[a-fA-F0-9]*$/', $value) >= 1);
    }


    /**
     * ShhFilter
     *
     * @param array $value
     * @return bool
     */
    public static function ShhFilter($value)
    {
        if (!is_array($value)) {
            return false;
        }
        if (isset($value['to']) && self::Identity($value['to']) === false) {
            return false;
        }
        if (!isset($value['topics']) || !is_array($value['topics'])) {
            return false;
        }
        foreach ($value['topics'] as $topic) {
            if (is_array($topic)) {
                foreach ($topic as $subTopic) {
                    if (self::Hex($subTopic) === false) {
                        return false;
                    }
                }
                continue;
            }
            if (self::Hex($topic) === false) {
                if (!is_null($topic)) {
                    return false;
                }
            }
        }
        return true;
    }


    /**
     * String
     *
     * @param string $value
     * @return bool
     */
    public static function String($value)
    {
        return is_string($value);
    }

    /**
     * Tag
     *
     * @param string $value
     * @return bool
     */
    public static function Tag($value)
    {
        $value = Utils::toString($value);
        $tags = [
            'latest', 'earliest', 'pending'
        ];

        return in_array($value, $tags);
    }

    /**
     * Transaction
     * To do: check is data optional?
     * Data is not optional on spec, see https://github.com/happyuc-project/wiki/wiki/JSON-RPC#eth_sendtransaction
     *
     * @param array $value
     * @return bool
     */
    public static function Transaction($value)
    {
        if (!is_array($value)) {
            return false;
        }
        if (!isset($value['from'])) {
            return false;
        }
        if (self::Address($value['from']) === false) {
            return false;
        }
        if (isset($value['to']) && self::Address($value['to']) === false && $value['to'] !== '') {
            return false;
        }
        if (isset($value['gas']) && self::Quantity($value['gas']) === false) {
            return false;
        }
        if (isset($value['gasPrice']) && self::Quantity($value['gasPrice']) === false) {
            return false;
        }
        if (isset($value['value']) && self::Quantity($value['value']) === false) {
            return false;
        }
        // if (!isset($value['data'])) {
        //     return false;
        // }
        // if (HexValidator::validate($value['data']) === false) {
        //     return false;
        // }
        if (isset($value['data']) && self::Hex($value['data']) === false) {
            return false;
        }
        if (isset($value['nonce']) && self::Quantity($value['nonce']) === false) {
            return false;
        }
        return true;
    }


}