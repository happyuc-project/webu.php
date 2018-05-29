<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;


class Shh
{
    /**
     * provider
     *
     * @var \Webu\HttpProvider
     */
    protected $provider;


    /**
     * allowedMethods
     * 
     * @var array
     */
//    private $allowedMethods = [
//        'shh_version',
//        'shh_newIdentity',
//        'shh_hasIdentity',
//        'shh_post',
//        'shh_newFilter',
//        'shh_uninstallFilter',
//        'shh_getFilterChanges',
//        'shh_getMessages'
//        // doesn't exist: 'shh_newGroup', 'shh_addToGroup'
//    ];

    /**
     * construct
     *
     * @param \Webu\HttpProvider $provider
     * @return void
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
    }



    /**
     * Sends a whisper message.
     *
     * @param string $from    DATA, 60 Bytes - (optional) The identity of the sender.
     * @param string $to      DATA, 60 Bytes - (optional) The identity of the receiver. When present whisper will encrypt the message so that only the receiver can decrypt it.
     * @param array $topics   Array of DATA - Array of DATA topics, for the receiver to identify messages.
     * @param string $payload  DATA - The payload of the message.
     * @param string $priority QUANTITY - The integer of the priority in a rang from ... (?).
     * @param string $ttl      QUANTITY - integer of the time to live in seconds.
     *
     * @throws \Exception
     * @return array returns true if the message was send, otherwise false.
     */
    // public function post(string $from,string $to,array $topics,string $payload,string $priority,string $ttl,$callback = null)
    public function post(array $params,$callback = null)
    {
        $inputs = [['Post',$params]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$params];
        return $this->provider->sendReal('shh_post',$params,$callback);
    }


    /**
     * Returns the current whisper protocol version.
     *
     * @throws \Exception
     * @return mixed
     */
    public function version($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('shh_version',$params,$callback);
    }


    /**
     * Creates new whisper identity in the client.
     *
     * @throws \Exception
     * @return array 60 Bytes - the address of the new identiy.
     */
    public function newIdentity($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('shh_newIdentity',$params,$callback);
    }


    /**
     * Checks if the client hold the private keys for a given identity.
     *
     * @param string $identity  DATA, 60 Bytes - The identity address to check.
     *
     * @throws \Exception
     * @return array returns true if the client holds the privatekey for that identity, otherwise false.
     */
    public function hasIdentity(string $identity,$callback = null)
    {
        $inputs = [['Hex',$identity]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$identity];
        return $this->provider->sendReal('shh_hasIdentity',$params,$callback);
    }

    /**
     * @throws \Exception
     * @return array DATA, 60 Bytes - the address of the new group. (?)
     */
    public function newGroup($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('shh_newGroup',$params,$callback);
    }


    /**
     * @param string $identity  DATA, 60 Bytes - The identity address to add to a group (?).
     *
     * @throws \Exception
     * @return array returns true if the identity was successfully added to the group, otherwise false
     */
    public function addToGroup(string $identity,$callback = null)
    {
        $inputs = [['Hex',$identity]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$identity];
        return $this->provider->sendReal('shh_addToGroup',$params,$callback);
    }


    /**
     * Creates filter to notify, when client receives whisper message matching the filter options.
     *
     * @param string $to
     * @param array $topics Array of DATA - Array of DATA topics which the incoming message's topics should match. You can use the following combinations:
     *                      [A, B]       = A && B
     *                      [A, [B, C]]  = A && (B || C)
     *                      [null, A, B] = ANYTHING && A && B null works as a wildcard
     *
     * @throws \Exception
     * @return array  The newly created filter.
     */
    public function newFilter(string $to,array $topics,$callback = null)
    {
        $params = ['topics'=>$topics,'to'=>$to];

        $inputs = [['ShhFilter',$params]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        return $this->provider->sendReal('shh_newFilter',$params,$callback);
    }


    /**
     * Uninstalls a filter with given id. Should always be called when watch is no longer needed. Additonally Filters timeout when they aren't requested with shh_getFilterChanges for a period of time.
     *
     * @param string $filter_id  The filter id.
     *
     * @throws \Exception
     * @return array  true if the filter was successfully uninstalled, otherwise false.
     */
    public function uninstallFilter(string $filter_id,$callback = null)
    {
        $inputs = [['Quantity',$filter_id]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$filter_id];
        return $this->provider->sendReal('shh_uninstallFilter',$params,$callback);
    }

    /**
     * Polling method for whisper filters. Returns new messages since the last call of this method.
     * ** Note ** calling the shh_getMessages method, will reset the buffer for this method, so that you won't receive duplicate messages.
     *
     * @param string $filter_id  The filter id.
     *
     * @throws \Exception
     * @return array  Array - Array of messages received since last poll:
     *                   hash: DATA, 32 Bytes (?) - The hash of the message.
     *                   from: DATA, 60 Bytes - The sender of the message, if a sender was specified.
     *                   to  : DATA, 60 Bytes - The receiver of the message, if a receiver was specified.
     *                   expiry: QUANTITY - Integer of the time in seconds when this message should expire (?).
     *                   ttl: QUANTITY - Integer of the time the message should float in the system in seconds (?).
     *                   sent: QUANTITY - Integer of the unix timestamp when the message was sent.
     *                   topics: Array of DATA - Array of DATA topics the message contained.
     *                   payload: DATA - The payload of the message.
     *                   workProved: QUANTITY - Integer of the work this message required before it was send (?).
     */
    public function getFilterChanges(string $filter_id,$callback = null)
    {
        $inputs = [['Quantity',$filter_id]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$filter_id];
        return $this->provider->sendReal('shh_getFilterChanges',$params,$callback);
    }


    /**
     * Get all messages matching a filter. Unlike shh_getFilterChanges this returns all messages.
     *
     * @param string $filter_id  The filter id.
     *
     * @throws \Exception
     * @return array  See shh_getFilterChanges
     */
    public function getMessages(string $filter_id,$callback = null)
    {
        $inputs = [['Quantity',$filter_id]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$filter_id];
        return $this->provider->sendReal('shh_getMessages',$params,$callback);
    }

}