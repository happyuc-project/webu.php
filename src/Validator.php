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
     * @return array
     */
    public static function Address($value , $tag = '')
    {
        if (!is_string($value))
        {
            return [false, $tag.'Address not a string'];
        } elseif (!(preg_match('/^0x[a-fA-F0-9]{40}$/', $value) >= 1)){
            return [false, $tag.'Not a valid address string, it should be 0x plus 40 hexadecimal characters'];
        }
        return [true];
    }

    /**
     * BlockHash
     *
     * @param string $value
     * @return array
     */
    public static function BlockHash($value , $tag = '')
    {
        if (!is_string($value))
        {
            return [false, $tag.'BlockHash not a string'];
        } elseif (!(preg_match('/^0x[a-fA-F0-9]{40}$/', $value) >= 1)){
            return [false, $tag.'Not a valid BlockHash string, it should be 0x plus 64 hexadecimal characters'];
        }
        return [true];
    }

    /**
     * Boolean
     *
     * @param mixed $value
     * @return array
     */
    public static function Boolean($value , $tag = '')
    {
        if(is_bool($value))
        {
            return [true];
        }
        return [false, $tag.'Not a Boolean'];
    }

    /**
     * Call
     *
     * @param array $value
     * @return array
     */
    public static function Call($value , $tag = '')
    {
        if (!is_array($value)) {
            return [false,$tag.'Not a Array'];
        }
        // from
        if(isset($value['from'])) {
            $rs = self::Address($value['from'],'from:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // to
        if (!isset($value['to'])) {
            return [false,'to -> Can\'t be empty'];
        }
        $rs = self::Address($value['to'],'to:');
        if($rs[0] === false) {
            return [false,$tag.$rs[1]];
        }
        // gas
        if (isset($value['gas'])) {
            $rs = self::Quantity($value['gas'],'gas:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // gasPrice
        if (isset($value['gasPrice'])) {
            $rs = self::Quantity($value['gasPrice'],'gasPrice:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // value
        if (isset($value['value'])) {
            $rs = self::Quantity($value['value'],'value:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // data
        if (isset($value['data'])) {
            $rs = self::Hex($value['data'],'data:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // nonce
        if (isset($value['nonce'])) {
            $rs = self::Quantity($value['nonce'],'nonce:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }

        return [true];
    }


    /**
     * Filter
     *
     * @param array $value
     * @return array
     */
    public static function Filter($value , $tag = '')
    {
        if (!is_array($value)) {
            return [false,$tag.'Not a Array'];
        }
        // fromBlock
        if (isset($value['fromBlock'])) {
            $rs = self::Quantity($value['fromBlock'],'fromBlock:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // toBlock
        if (isset($value['toBlock'])) {
            $rs = self::Quantity($value['toBlock'],'toBlock:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // address
        if (isset($value['address'])) {
            if (is_array($value['address'])) {
                foreach ($value['address'] as $idx=>$address) {
                    $rs = self::Address($address,"address[{$idx}]:");
                    if($rs[0] === false) {
                        return [false,$tag.$rs[1]];
                    }
                }
            } else {
                $rs = self::Address($value['address'],'address:');
                if($rs[0] === false) {
                    return [false,$tag.$rs[1]];
                }
            }
        }
        // topics
        if (isset($value['topics']) && is_array($value['topics'])) {
            foreach ($value['topics'] as $idx=>$topic) {
                if (is_array($topic)) {
                    foreach ($topic as $idx2=>$v) {
                        if (isset($v)) {
                            $rs = self::Hex($v,"topic[{$idx}][{$idx2}]:");
                            if($rs[0] === false) {
                                return [false,$tag.$rs[1]];
                            }
                        }
                    }
                } else {
                    if (isset($topic) ) {
                        $rs = self::Hex($topic,"topic[{$idx}]:");
                        if($rs[0] === false) {
                            return [false,$tag.$rs[1]];
                        }
                    }
                }
            }
        }

        return [true];
    }


    /**
     * Hex
     *
     * @param string $value
     * @return array
     */
    public static function Hex($value , $tag = '')
    {
        if (!is_string($value)) {
            return [false,$tag.'Not a String'];
        }

        if( preg_match('/^0x[a-fA-F0-9]*$/', $value) >= 1 )
        {
            return [true];
        }
        return [false, $tag.'Not a Hex'];
    }


    /**
     * Identity
     * To do: check identity length.
     * Spec: 60 bytes, see https://github.com/happyuc-project/wiki/wiki/JSON-RPC#shh_newidentity
     * But returned value is 64 bytes.
     *
     * @param string $value
     * @return array
     */
    public static function Identity($value , $tag = '')
    {
        if (!is_string($value)) {
            return [false,$tag.'Not a String'];
        }
        if( preg_match('/^0x[a-fA-F0-9]*$/', $value) >= 1 )
        {
            return [true];
        }
        return [false, $tag.'Not a Identity Hex'];
    }


    /**
     * Nonce
     *
     * @param string $value
     * @return array
     */
    public static function Nonce($value , $tag = '')
    {
        if (!is_string($value)) {
            return [false,$tag.'Not a String'];
        }
        if( preg_match('/^0x[a-fA-F0-9]{16}$/', $value) >= 1 )
        {
            return [true];
        }
        return [false, $tag.'Not a Nonce Hex'];
    }



    /**
     * Post
     *
     * @param array $value
     * @return array
     */
    public static function Post($value , $tag = '')
    {
        if (!is_array($value)) {
            return [false,$tag.'Not a Array'];
        }
        // from
        if(isset($value['from'])) {
            $rs = self::Identity($value['from'],'from:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // to
        if(isset($value['to'])) {
            $rs = self::Identity($value['to'],'to:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // topics
        if (!isset($value['topics']) || !is_array($value['topics'])) {
            return [false,'topics -> It can\'t be empty and it\'s an array'];
        }
        foreach ($value['topics'] as $topic) {
            $rs = self::Identity($topic,'topics:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // payload
        if (!isset($value['payload'])) {
            return [false,'payload -> Can\'t be empty'];
        }
        $rs = self::Hex($value['payload'],'payload:');
        if($rs[0] === false) {
            return [false,$tag.$rs[1]];
        }
        // priority
        if (!isset($value['priority'])) {
            return [false,'priority -> Can\'t be empty'];
        }
        $rs = self::Quantity($value['priority'],'priority:');
        if($rs[0] === false) {
            return [false,$tag.$rs[1]];
        }
        // ttl
        if (!isset($value['ttl'])) {
            return [false,'ttl -> Can\'t be empty'];
        }
        $rs = self::Quantity($value['ttl'],'ttl:');
        if($rs[0] === false) {
            return [false,$tag.$rs[1]];
        }

        return [true];
    }


    /**
     * Quantity
     *
     * @param string $value
     * @return array
     */
    public static function Quantity($value , $tag = '')
    {
        if( is_int($value) || is_float($value) || preg_match('/^0x[a-fA-F0-9]*$/', $value) >= 1 )
        {
            return [true];
        }
        return [false, $tag.'Not a Int , Float , Hex'];
    }


    /**
     * ShhFilter
     *
     * @param array $value
     * @return array
     */
    public static function ShhFilter($value , $tag = '')
    {
        if (!is_array($value)) {
            return [false,$tag.'Not a Array'];
        }
        // to
        if(isset($value['to'])) {
            $rs = self::Address($value['to'],'to:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // topics
        if (!isset($value['topics']) || !is_array($value['topics'])) {
            return [false,'topics -> It can\'t be empty and it\'s an array'];
        }
        foreach ($value['topics'] as $idx => $topic) {
            if (is_array($topic)) {
                foreach ($topic as $idx2 => $subTopic) {
                    $rs = self::Hex($subTopic,"topics[{$idx}][{$idx2}]:");
                    if($rs[0] === false) {
                        return [false, $tag . $rs[1]];
                    }
                }
            }else
            {
                $rs = self::Hex($topic,"topics[{$idx}]:");
                if($rs[0] === false) {
                    return [false,$tag.$rs[1]];
                }
            }
        }

        return [true];
    }


    /**
     * String
     *
     * @param string $value
     * @return array
     */
    public static function String($value, $tag = '')
    {
        if(is_string($value))
        {
            return [true];
        }
        return [false,$tag.'Not a String'];
    }

    /**
     * Tag
     *
     * @param string $value
     * @return array
     */
    public static function Tag($value, $tag = '')
    {
        if( is_int($value) || preg_match('/^0x[a-fA-F0-9]*$/', $value) >= 1 )
        {
            return [true];
        }else
        {
            $value = Utils::toString($value);
            $tags  = [ 'latest', 'earliest', 'pending' ];

            if(in_array($value, $tags))
            {
                return [true];
            }

            return [false,$tag.'It\'s not int, latest, earliest, pending.'];
        }

    }

    /**
     * Transaction
     * To do: check is data optional?
     * Data is not optional on spec, see https://github.com/happyuc-project/wiki/wiki/JSON-RPC#eth_sendtransaction
     *
     * @param array $value
     * @return array
     */
    public static function Transaction($value, $tag = '')
    {
        if (!is_array($value)) {
            return [false,$tag.'Not a Array'];
        }

        // from
        if (!isset($value['from'])) {
            return [false,'from -> Can\'t be empty'];
        }
        $rs = self::Address($value['from'],'from:');
        if($rs[0] === false) {
            return [false,$tag.$rs[1]];
        }
        // to
        if(isset($value['to'])) {
            $rs = self::Address($value['to'],'to:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // gas
        if (isset($value['gas'])) {
            $rs = self::Quantity($value['gas'],'gas:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // gasPrice
        if (isset($value['gasPrice'])) {
            $rs = self::Quantity($value['gasPrice'],'gasPrice:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // value
        if (isset($value['value'])) {
            $rs = self::Quantity($value['value'],'value:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // data
        if (isset($value['data'])) {
            $rs = self::Hex($value['data'],'data:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }
        // nonce
        if (isset($value['nonce'])) {
            $rs = self::Quantity($value['nonce'],'nonce:');
            if($rs[0] === false) {
                return [false,$tag.$rs[1]];
            }
        }

        return [true];
    }

    /**
     * @param $inputs
     * @param string $tag
     * @return array
     */
    public static function batch($inputs,$tag = '')
    {
        if(is_array($inputs))
        {
            foreach ($inputs as $v)
            {
                list($methods,$value) = $v;
                $rs                   = self::$methods($value,$tag."{$methods}:");
                if ($rs[0] === false)
                {
                    return $rs;
                }
            }
            return [true];
        }
        return [false,$tag.'Not a Array'];
    }
}