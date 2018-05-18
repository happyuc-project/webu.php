<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;

use GuzzleHttp\Client;

class HttpRequestManager
{
    /**
     * host
     *
     * @var string
     */
    protected $host;

    /**
     * timeout
     *
     * @var float
     */
    protected $timeout;

    /**
     * client
     * 
     * @var \GuzzleHttp
     */
    protected $client;

    /**
     * construct
     * 
     * @param string $host
     * @param int $timeout
     * @return void
     */
    public function __construct($host, $timeout = 1)
    {
        $this->host    = $host;
        $this->timeout = (float) $timeout;
        $this->client  = new Client();
    }

    /**
     * getHost
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * getTimeout
     *
     * @return float
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * payloadReal
     *
     * @param string $payload
     * @return array
     */
    public function payloadReal($payload):array
    {
        try {
            $res  = $this->client->post($this->host, [
                'headers'         => ['content-type' => 'application/json'],
                'body'            => $payload,
                'timeout'         => $this->timeout,
                'connect_timeout' => $this->timeout
            ]);
            $json = json_decode($res->getBody(),true);
            return $json;
        } catch (\Exception $err) {
            return $err;
        }
    }

    /**
     * payloadAsyn
     * 
     * @param string $payload
     * @param callable $callback
     * @return void
     */
    public function payloadAsyn($payload, $callback)
    {
        if (!is_string($payload)) {
            throw new \InvalidArgumentException('Payload must be string.');
        }

        try {
            $res = $this->client->post($this->host, [
                'headers' => [
                    'content-type' => 'application/json'
                ],
                'body'             => $payload,
                'timeout'          => $this->timeout,
                'connect_timeout'  => $this->timeout
            ]);
            $json = json_decode($res->getBody());

            if (JSON_ERROR_NONE !== json_last_error()) {
                call_user_func($callback, new \InvalidArgumentException('json_decode error: ' . json_last_error_msg()), null);
            }
            if (is_array($json)) {
                // batch results
                $results = [];
                $errors  = [];

                foreach ($json as $result) {
                    if (isset($result->result)) {
                        $results[] = $result->result;
                    } else {
                        if (isset($json->error)) {
                            $error = $json->error;
                            $errors[] = new \Exception(mb_ereg_replace('Error: ', '', $error->message), $error->code);
                        } else {
                            $results[] = null;
                        }
                    }
                }
                if (count($errors) > 0) {
                    call_user_func($callback, $errors, $results);
                } else {
                    call_user_func($callback, null, $results);
                }
            } elseif (isset($json->result)) {
                call_user_func($callback, null, $json->result);
            } else {
                if (isset($json->error)) {
                    $error = $json->error;
                    call_user_func($callback, new \Exception(mb_ereg_replace('Error: ', '', $error->message), $error->code), null);
                } else {
                    call_user_func($callback, new \Exception('Something wrong happened.'), null);
                }
            }
        } catch (\Exception $err) {
            call_user_func($callback, $err, null);
        }
    }
}
