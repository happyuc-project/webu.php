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
     * methods
     * 
     * @var array
     */
//    private $methods = [];

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
     * @return array returns true if the message was send, otherwise false.
     */
    public function post(string $from,string $to,array $topics,string $payload,string $priority,string $ttl)
    {
        $params = [$from, $to, $topics, $payload, $priority, $ttl];
        return $this->provider->sendReal('shh_post',$params);
    }


    /**
     * Returns the current whisper protocol version.
     */
    public function version()
    {
        $params = [];
        return $this->provider->sendReal('shh_version',$params);
    }


    /**
     * Creates new whisper identity in the client.
     * @return array 60 Bytes - the address of the new identiy.
     */
    public function newIdentity()
    {
        $params = [];
        return $this->provider->sendReal('shh_newIdentity',$params);
    }


    /**
     * Checks if the client hold the private keys for a given identity.
     *
     * @param string $identity  DATA, 60 Bytes - The identity address to check.
     * @return array returns true if the client holds the privatekey for that identity, otherwise false.
     */
    public function hasIdentity(string $identity)
    {
        $params = [$identity];
        return $this->provider->sendReal('shh_hasIdentity',$params);
    }

    /**
     * @return array DATA, 60 Bytes - the address of the new group. (?)
     */
    public function newGroup()
    {
        $params = [];
        return $this->provider->sendReal('shh_newGroup',$params);
    }


    /**
     * @param string $identity  DATA, 60 Bytes - The identity address to add to a group (?).
     * @return array returns true if the identity was successfully added to the group, otherwise false
     */
    public function addToGroup(string $identity)
    {
        $params = [$identity];
        return $this->provider->sendReal('shh_addToGroup',$params);
    }


    /**
     * Creates filter to notify, when client receives whisper message matching the filter options.
     *
     * @param string $to
     * @param array $topics Array of DATA - Array of DATA topics which the incoming message's topics should match. You can use the following combinations:
     *                      [A, B]       = A && B
     *                      [A, [B, C]]  = A && (B || C)
     *                      [null, A, B] = ANYTHING && A && B null works as a wildcard
     * @return array  The newly created filter.
     */
    public function newFilter(string $to,array $topics)
    {
        $params = [$topics,$to];
        return $this->provider->sendReal('shh_newFilter',$params);
    }


    /**
     * Uninstalls a filter with given id. Should always be called when watch is no longer needed. Additonally Filters timeout when they aren't requested with shh_getFilterChanges for a period of time.
     *
     * @param string $filter_id  The filter id.
     * @return array  true if the filter was successfully uninstalled, otherwise false.
     */
    public function uninstallFilter(string $filter_id)
    {
        $params = [$filter_id];
        return $this->provider->sendReal('shh_uninstallFilter',$params);
    }

    /**
     * Polling method for whisper filters. Returns new messages since the last call of this method.
     * ** Note ** calling the shh_getMessages method, will reset the buffer for this method, so that you won't receive duplicate messages.
     *
     * @param string $filter_id  The filter id.
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
    public function getFilterChanges(string $filter_id)
    {
        $params = [$filter_id];
        return $this->provider->sendReal('shh_getFilterChanges',$params);
    }


    /**
     * Get all messages matching a filter. Unlike shh_getFilterChanges this returns all messages.
     *
     * @param string $filter_id  The filter id.
     * @return array  See shh_getFilterChanges
     */
    public function getMessages(string $filter_id)
    {
        $params = [$filter_id];
        return $this->provider->sendReal('shh_getMessages',$params);
    }

    /**
     * call
     * 
     * @param string $name
     * @param array $arguments
     * @return void
     */
//    public function __call($name, $arguments)
//    {
//        if (empty($this->provider)) {
//            throw new \RuntimeException('Please set provider first.');
//        }
//
//        $class = explode('\\', get_class());
//
//        if (preg_match('/^[a-zA-Z0-9]+$/', $name) === 1) {
//            $method = strtolower($class[1]) . '_' . $name;
//
//            if (!in_array($method, $this->allowedMethods)) {
//                throw new \RuntimeException('Unallowed rpc method: ' . $method);
//            }
//            if ($this->provider->isBatch) {
//                $callback = null;
//            } else {
//                $callback = array_pop($arguments);
//
//                if (is_callable($callback) !== true) {
//                    throw new \InvalidArgumentException('The last param must be callback function.');
//                }
//            }
//            if (!array_key_exists($method, $this->methods)) {
//                // new the method
//                $methodClass = sprintf("\Webu\Methods\%s\%s", ucfirst($class[1]), ucfirst($name));
//                $methodObject = new $methodClass($method, $arguments);
//                $this->methods[$method] = $methodObject;
//            } else {
//                $methodObject = $this->methods[$method];
//            }
//            if ($methodObject->validate($arguments)) {
//                $inputs = $methodObject->transform($arguments, $methodObject->inputFormatters);
//                $methodObject->arguments = $inputs;
//                $this->provider->send($methodObject, $callback);
//            }
//        }
//    }

}