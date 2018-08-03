<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;


class Irc
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
//  private $methods = [];

    /**
     * allowedMethods
     * 
     * @var array
     */
    private $allowedMethods = [
        'irc_protocolVersion',
        'irc_syncing',
        'irc_coinbase',
        'irc_mining',
        'irc_hashrate',
        'irc_gasPrice',
        'irc_accounts',
        'irc_blockNumber',
        'irc_getBalance',
        'irc_getStorageAt',
        'irc_getTransactionCount',
        'irc_getBlockTransactionCountByHash',
        'irc_getBlockTransactionCountByNumber',
        'irc_getUncleCountByBlockHash',
        'irc_getUncleCountByBlockNumber',
        'irc_getUncleByBlockHashAndIndex',
        'irc_getUncleByBlockNumberAndIndex',
        'irc_getCode',
        'irc_sign',
        'irc_sendTransaction',
        'irc_sendRawTransaction',
        'irc_call',
        'irc_estimateGas',
        'irc_getBlockByHash',
        'irc_getBlockByNumber',
        'irc_getTransactionByHash',
        'irc_getTransactionByBlockHashAndIndex',
        'irc_getTransactionByBlockNumberAndIndex',
        'irc_getTransactionReceipt',
        'irc_getCompilers',
        'irc_compileSolidity',
        'irc_compileLLL',
        'irc_compileSerpent',
        'irc_getWork',
        'irc_newFilter',
        'irc_newBlockFilter',
        'irc_newPendingTransactionFilter',
        'irc_uninstallFilter',
        'irc_getFilterChanges',
        'irc_getFilterLogs',
        'irc_getLogs',
        'irc_submitWork',
        'irc_submitHashrate'
    ];

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
     * Returns the current happyuc protocol version.
     *
     * @throws \Exception
     * @return array The current happyuc protocol version
     */
    public function protocolVersion($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_protocolVersion',$params,$callback);
    }

    /**
     * Returns an object with data about the sync status or false.
     *
     * @throws \Exception
     * @return array Object|Boolean, An object with sync status data or FALSE, when not syncing:
     *           startingBlock: QUANTITY - The block at which the import started (will only be reset, after the sync reached his head)
     *           currentBlock: QUANTITY - The current block, same as irc_blockNumber
     *           highestBlock: QUANTITY - The estimated highest block
     */
    public function syncing($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_syncing',$params,$callback);
    }

    /**
     * @throws \Exception
     * @return array DATA, 20 bytes - the current coinbase address.
     */
    public function coinbase($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_coinbase',$params,$callback);
    }

    /**
     * @throws \Exception
     * @return array returns true of the client is mining, otherwise false.
     */
    public function mining($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_mining',$params,$callback);
    }

    /**
     * Returns the number of hashes per second that the node is mining with.
     *
     * @throws \Exception
     * @return string QUANTITY - number of hashes per second.
     */
    public function hashrate($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_hashrate',$params,$callback);
    }

    /**
     * Returns the current price per gas in wei.
     *
     * @throws \Exception
     * @return array QUANTITY - integer of the current gas price in wei.
     */
    public function gasPrice($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_gasPrice',$params,$callback);
    }


    /**
     * Returns a list of addresses owned by client.
     *
     * @throws \Exception
     * @return array of DATA, 20 Bytes - addresses owned by the client.
     */
    public function accounts($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_accounts',$params,$callback);
    }


    /**
     * Returns the number of most recent block.
     *
     * @throws \Exception
     * @return int QUANTITY - integer of the current block number the client is on.
     */
    public function blockNumber($callback = null)
    {
        $params      = [];
        if($callback)
        {
            $this->provider->sendReal('irc_blockNumber',$params,function ($err, $blockNumber) use ($callback) {
                if(!$err){
                    $blockNumber  = Formatter::Number($blockNumber);
                }
                return call_user_func($callback, $err, $blockNumber);
            });
        }else
        {
            $blockNumber = $this->provider->sendReal('irc_blockNumber',$params,$callback);
            return Formatter::Number($blockNumber);
        }
    }


    /**
     * Returns the balance of the account of given address.
     *
     * @param string $address      DATA, 20 Bytes - address to check for balance.
     * @param string $block_number QUANTITY|TAG - integer block number, or the string "latest", "earliest" or "pending", see the default block parameter
     * @throws \Exception
     * @return array   QUANTITY - integer of the current balance in wei.
     */
    public function getBalance(string $address,string $block_number='latest',$callback = null)
    {
        $inputs = [['Address',$address],['Tag',$block_number]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$address,$block_number];
        return $this->provider->sendReal('irc_getBalance',$params,$callback);
    }


    /**
     * Returns the value from a storage position at a given address.
     *
     * @param string $address       DATA, 20 Bytes - address of the storage.
     * @param string $position      QUANTITY - integer of the position in the storage.
     * @param string $block_number  QUANTITY|TAG - integer block number, or the string "latest", "earliest" or "pending", see the default block parameter
     * @throws \Exception
     * @return array DATA - the value at this storage position.
     */
    public function getStorageAt(string $address,string $position,string $block_number,$callback = null)
    {

        $inputs = [['Address',$address],['Quantity',$position],['Tag',$block_number]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$address,$position,$block_number];
        return $this->provider->sendReal('irc_getStorageAt',$params,$callback);
    }

    /**
     * Returns the number of transactions sent from an address.
     *
     * @param string $address       DATA, 20 Bytes - address.
     * @param string $block_number  QUANTITY|TAG - integer block number, or the string "latest", "earliest" or "pending", see the default block parameter
     *
     * @throws \Exception
     * @return array QUANTITY - integer of the number of transactions send from this address.
     */
    public function getTransactionCount(string $address,string $block_number,$callback = null)
    {
        $inputs = [['Address',$address],['Tag',$block_number]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$address,$block_number];
        return $this->provider->sendReal('irc_getTransactionCount',$params,$callback);
    }

    /**
     * Returns the number of transactions in a block from a block matching the given block hash.
     *
     * @param string $hash  DATA, 32 Bytes - hash of a block
     * @throws \Exception
     *
     * @return array QUANTITY - integer of the number of transactions in this block.
     */
    public function getBlockTransactionCountByHash(string $hash,$callback = null)
    {
        $inputs = [['Hex',$hash]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$hash];
        return $this->provider->sendReal('irc_getBlockTransactionCountByHash',$params,$callback);
    }

    /**
     * Returns the number of transactions in a block matching the given block number.
     *
     * @param string $block_number  QUANTITY|TAG - integer of a block number, or the string "earliest", "latest" or "pending", as in the default block parameter.
     *
     * @throws \Exception
     * @return array    QUANTITY - integer of the number of transactions in this block.
     */
    public function getBlockTransactionCountByNumber(string $block_number,$callback = null)
    {
        $inputs = [['Tag',$block_number]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$block_number];
        return $this->provider->sendReal('irc_getBlockTransactionCountByNumber',$params,$callback);
    }


    /**
     * Returns the number of uncles in a block from a block matching the given block hash.
     *
     * @param string $hash  DATA, 32 Bytes - hash of a block
     *
     * @throws \Exception
     * @return array        QUANTITY - integer of the number of uncles in this block.
     */
    public function getUncleCountByBlockHash(string $hash,$callback = null)
    {
        $inputs = [['Hex',$hash]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$hash];
        return $this->provider->sendReal('irc_getUncleCountByBlockHash',$params,$callback);
    }

    /**
     * Returns the number of uncles in a block from a block matching the given block number.
     *
     * @param string $block_number  QUANTITY|TAG - integer of a block number, or the string "latest", "earliest" or "pending", see the default block parameter
     *
     * @throws \Exception
     * @return array                QUANTITY - integer of the number of uncles in this block.
     */
    public function getUncleCountByBlockNumber(string $block_number,$callback = null)
    {
        $inputs = [['Tag',$block_number]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$block_number];
        return $this->provider->sendReal('irc_getUncleCountByBlockNumber',$params,$callback);
    }

    /**
     * Returns code at a given address.
     *
     * @param string $address       DATA, 20 Bytes - address
     * @param string $block_number  QUANTITY|TAG - integer block number, or the string "latest", "earliest" or "pending", see the default block parameter
     *
     * @throws \Exception
     * @return array  DATA - the code from the given address.
     */
    public function getCode(string $address,string $block_number,$callback = null)
    {
        $inputs = [['Address',$address],['Tag',$block_number]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$address,$block_number];
        return $this->provider->sendReal('irc_getCode',$params,$callback);
    }

    /**
     * The sign method calculates an Ethereum specific signature with: sign(keccak256("\x19Ethereum Signed Message:\n" + len(message) + message))).
     * By adding a prefix to the message makes the calculated signature recognisable as an Ethereum specific signature. This prevents misuse where a malicious DApp can sign arbitrary data (e.g. transaction) and use the signature to impersonate the victim.
     *  ** Note ** the address to sign with must be unlocked.
     *
     * @param string $address  DATA, 20 Bytes - address
     * @param string $message  DATA, N Bytes - message to sign
     *
     * @throws \Exception
     * @return array DATA: Signature
     */
    public function sign(string $address,string $message,$callback = null)
    {
        $inputs = [['Address',$address],['String',$message]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$address,$message];
        return $this->provider->sendReal('irc_sign',$params,$callback);
    }

    /**
     * Creates new message call transaction or a contract creation, if the data field contains code.
     *   $params = ['from'=>$from,'to'=>$to,'gas'=>$gas,'gasPrice'=>$gasPrice,'value'=>$value,'data'=>$data]
     *
     * @param string $from  DATA, 20 Bytes - The address the transaction is send from.
     * @param string $to    DATA, 20 Bytes - (optional when creating new contract) The address the transaction is directed to.
     * @param string $gas   QUANTITY - (optional, default: 90000) Integer of the gas provided for the transaction execution. It will return unused gas.
     * @param string $gasPrice  QUANTITY - (optional, default: To-Be-Determined) Integer of the gasPrice used for each paid gas
     * @param string $value     QUANTITY - (optional) Integer of the value sent with this transaction
     * @param string $data      DATA - The compiled code of a contract OR the hash of the invoked method signature and encoded parameters. For details see HappyUC Contract ABI
     * @param string $nonce     QUANTITY - (optional) Integer of a nonce. This allows to overwrite your own pending transactions that use the same nonce.
     *
     *
     *
     * @throws \Exception
     * @return array DATA, 32 Bytes - the transaction hash, or the zero hash if the transaction is not yet available.
     * Use irc_getTransactionReceipt to get the contract address, after the transaction was mined, when you created a contract.
     */
    public function sendTransaction(array $params,$callback=null)
    {
        $inputs = [['Transaction',$params]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        // print_r($params);
       // exit();
        return $this->provider->sendReal('irc_sendTransaction',[$params],$callback);
    }

    /**
     * Creates new message call transaction or a contract creation for signed transactions.
     *
     * @param $transaction_data  DATA, The signed transaction data.
     *
     * @throws \Exception
     * @return array   DATA, 32 Bytes - the transaction hash, or the zero hash if the transaction is not yet available.
     *             Use irc_getTransactionReceipt to get the contract address, after the transaction was mined, when you created a contract.
     */
    public function sendRawTransaction($transaction_data,$callback = null)
    {
        $params = [$transaction_data];
        return $this->provider->sendReal('irc_sendRawTransaction',$params,$callback);
    }

    /**
     * Executes a new message call immediately without creating a transaction on the block chain.
     *
     * @param string $from        DATA, 20 Bytes - (optional) The address the transaction is sent from.
     * @param string $to          DATA, 20 Bytes - The address the transaction is directed to.
     * @param string $gas         QUANTITY - (optional) Integer of the gas provided for the transaction execution.
     *                               irc_call consumes zero gas, but this parameter may be needed by some executions.
     * @param string $gasPrice    QUANTITY - (optional) Integer of the gasPrice used for each paid gas
     * @param string $value       QUANTITY - (optional) Integer of the value sent with this transaction
     * @param string $data        DATA - (optional) Hash of the method signature and encoded parameters. For details see HappyUC Contract ABI
     * @param string $block_number  QUANTITY|TAG - integer block number, or the string "latest", "earliest" or "pending", see the default block parameter
     *
     * @throws \Exception
     * @return array  DATA - the return value of executed contract.
     */
     //public function call(string $from,string $to,string $gas,string $gasPrice,string $value,string $data,string $block_number,$callback = null)
     public function call(array $params,string $block_number,$callback = null)
     {
         $inputs = [['Call',$params],['Tag',$block_number]];
         $rs     = Validator::batch($inputs,__METHOD__.':');
         if ($rs[0] === false)
         {
             return $this->provider->sendError($rs[0],$callback);
         }

         // print_r([$params]);
         return $this->provider->sendReal('irc_call',[$params,$block_number],$callback);
    }

    /**
     * Generates and returns an estimate of how much gas is necessary to allow the transaction to complete.
     * The transaction will not be added to the blockchain.
     * Note that the estimate may be significantly more than the amount of gas actually used by the transaction,
     * for a variety of reasons including EVM mechanics and node performance.
     *
     * See irc_call parameters, expect that all properties are optional.
     * If no gas limit is specified geth uses the block gas limit from the pending block as an upper bound.
     * As a result the returned estimate might not be enough to executed the call/transaction when the amount of gas is higher than the pending block gas limit.
     *
     * public function estimateGas(string $from,string $to,string $gas,string $gasPrice,string $value,string $data,string $block_number,$callback = null)
     *
     * @throws \Exception
     * @return mixed  QUANTITY - the amount of gas used.
     */
    public function estimateGas(array $params,string $block_number,$callback = null)
    {
        $inputs = [['Post',$params],['Tag',$block_number]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false) {
            return $this->provider->sendError($rs[0],$callback);
        }
        //  $params1 = ['from'=>$from,'to'=>$to,'gas'=>$gas,'gasPrice'=>$gasPrice,'value'=>$value,'data'=>$data];
        $params  = [$params,$block_number];
        return $this->provider->sendReal('irc_estimateGas',$params,$callback);
    }

    /**
     * Returns information about a block by hash.
     *
     * @param string $hash   DATA, 32 Bytes - Hash of a block.
     * @param bool $is_full  Boolean - If true it returns the full transaction objects, if false only the hashes of the transactions.
     *
     * @throws \Exception
     * @return array  Object - A block object, or null when no block was found:
     *                   number: QUANTITY - the block number. null when its pending block.
     *                   hash: DATA, 32 Bytes - hash of the block. null when its pending block.
     *                   parentHash: DATA, 32 Bytes - hash of the parent block.
     *                   nonce: DATA, 8 Bytes - hash of the generated proof-of-work. null when its pending block.
     *                   sha3Uncles: DATA, 32 Bytes - SHA3 of the uncles data in the block.
     *                   logsBloom: DATA, 256 Bytes - the bloom filter for the logs of the block. null when its pending block.
     *                   transactionsRoot: DATA, 32 Bytes - the root of the transaction trie of the block.
     *                   stateRoot: DATA, 32 Bytes - the root of the final state trie of the block.
     *                   receiptsRoot: DATA, 32 Bytes - the root of the receipts trie of the block.
     *                   miner: DATA, 20 Bytes - the address of the beneficiary to whom the mining rewards were given.
     *                   difficulty: QUANTITY - integer of the difficulty for this block.
     *                   totalDifficulty: QUANTITY - integer of the total difficulty of the chain until this block.
     *                   extraData: DATA - the "extra data" field of this block.
     *                   size: QUANTITY - integer the size of this block in bytes.
     *                   gasLimit: QUANTITY - the maximum gas allowed in this block.
     *                   gasUsed: QUANTITY - the total used gas by all transactions in this block.
     *                   timestamp: QUANTITY - the unix timestamp for when the block was collated.
     *                   transactions: Array - Array of transaction objects, or 32 Bytes transaction hashes depending on the last given parameter.
     *                   uncles: Array - Array of uncle hashes.
     */
    public function getBlockByHash(string $hash,bool $is_full,$callback = null)
    {
        $inputs = [['Hex',$hash],['Boolean',$is_full]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$hash,$is_full];
        return $this->provider->sendReal('irc_getBlockByHash',$params,$callback);
    }

    /**
     * Returns information about a block by block number.
     *
     * @param string $block_number   QUANTITY|TAG - integer of a block number, or the string "earliest", "latest" or "pending", as in the default block parameter.
     * @param bool   $is_full        Boolean - If true it returns the full transaction objects, if false only the hashes of the transactions.
     *
     * @throws \Exception
     * @return array  See irc_getBlockByHash
     */
    public function getBlockByNumber(string $block_number,bool $is_full=false,$callback = null)
    {
        $inputs = [['Tag',$block_number],['Boolean',$is_full]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params        = [$block_number,$is_full];
        return $this->provider->sendReal('irc_getBlockByNumber',$params,$callback);
    }

    /**
     * Returns the information about a transaction requested by transaction hash.
     *
     * @param $transaction_hash  DATA, 32 Bytes - hash of a transaction
     *
     * @throws \Exception
     * @return array  Object - A transaction object, or null when no transaction was found:
     *          hash: DATA, 32 Bytes - hash of the transaction.
     *          nonce: QUANTITY - the number of transactions made by the sender prior to this one.
     *          blockHash: DATA, 32 Bytes - hash of the block where this transaction was in. null when its pending.
     *          blockNumber: QUANTITY - block number where this transaction was in. null when its pending.
     *          transactionIndex: QUANTITY - integer of the transactions index position in the block. null when its pending.
     *          from: DATA, 20 Bytes - address of the sender.
     *          to: DATA, 20 Bytes - address of the receiver. null when its a contract creation transaction.
     *          value: QUANTITY - value transferred in Wei.
     *          gasPrice: QUANTITY - gas price provided by the sender in Wei.
     *          gas: QUANTITY - gas provided by the sender.
     *          input: DATA - the data send along with the transaction.
     */
    public function getTransactionByHash(string $transaction_hash,$callback = null)
    {
        $inputs = [['Hex',$transaction_hash]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$transaction_hash];
        return $this->provider->sendReal('irc_getTransactionByHash',$params,$callback);
    }

    /**
     * Returns information about a transaction by block hash and transaction index position.
     *
     * @param string $block_hash  QUANTITY|TAG - a block number, or the string "earliest", "latest" or "pending", as in the default block parameter.
     * @param string $position    QUANTITY - the transaction index position.
     *
     * @throws \Exception
     * @return array  See irc_getTransactionByHash
     */
    public function getTransactionByBlockHashAndIndex(string $block_hash,string $position,$callback = null)
    {
        $inputs = [['Hex',$block_hash],['Quantity',$position]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$block_hash,$position];
        return $this->provider->sendReal('irc_getTransactionByBlockHashAndIndex',$params,$callback);
    }


    /**
     * Returns information about a transaction by block number and transaction index position.
     *
     * @param string $block_number  QUANTITY|TAG - a block number, or the string "earliest", "latest" or "pending", as in the default block parameter.
     * @param string $position      QUANTITY - the transaction index position.
     *
     * @throws \Exception
     * @return array  See irc_getTransactionByHash
     */
    public function getTransactionByBlockNumberAndIndex(string $block_number,string $position,$callback = null)
    {
        $inputs = [['Tag',$block_number],['Quantity',$position]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$block_number,$position];
        return $this->provider->sendReal('irc_getTransactionByBlockNumberAndIndex',$params,$callback);
    }

    /**
     * Returns the receipt of a transaction by transaction hash.
     * ** Note ** That the receipt is not available for pending transactions.
     *
     * @param string $transaction_hash  DATA, 32 Bytes - hash of a transaction
     *
     * @throws \Exception
     * @return array Object - A transaction receipt object, or null when no receipt was found:
     *         transactionHash: DATA, 32 Bytes - hash of the transaction.
     *         transactionIndex: QUANTITY - integer of the transactions index position in the block.
     *         blockHash: DATA, 32 Bytes - hash of the block where this transaction was in.
     *         blockNumber: QUANTITY - block number where this transaction was in.
     *         cumulativeGasUsed: QUANTITY - The total amount of gas used when this transaction was executed in the block.
     *         gasUsed: QUANTITY - The amount of gas used by this specific transaction alone.
     *         contractAddress: DATA, 20 Bytes - The contract address created, if the transaction was a contract creation, otherwise null.
     *         logs: Array - Array of log objects, which this transaction generated.
     *         logsBloom: DATA, 256 Bytes - Bloom filter for light clients to quickly retrieve related logs.
     *    It also returns happyUC :
     *         root : DATA 32 bytes of post-transaction stateroot (pre Byzantium)
     *         status: QUANTITY either 1 (success) or 0 (failure)
     */
    public function getTransactionReceipt(string $transaction_hash,$callback = null)
    {
        $inputs = [['Hex',$transaction_hash]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$transaction_hash];
        return $this->provider->sendReal('irc_getTransactionReceipt',$params,$callback);
    }

    /**
     * Returns information about a uncle of a block by hash and uncle index position.
     *
     * @param string $block_hash   DATA, 32 Bytes - hash a block.
     * @param string $position     QUANTITY - the uncle's index position.
     *
     * @throws \Exception
     * @return array  See irc_getBlockByHash
     */
    public function getUncleByBlockHashAndIndex(string $block_hash,string $position,$callback = null)
    {
        $inputs = [['Hex',$block_hash],['Quantity',$position]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$block_hash,$position];
        return $this->provider->sendReal('irc_getUncleByBlockHashAndIndex',$params,$callback);
    }

    /**
     * Returns information about a uncle of a block by number and uncle index position.
     *
     * @param string $block_number   QUANTITY|TAG - a block number, or the string "earliest", "latest" or "pending", as in the default block parameter.
     * @param string $position       QUANTITY - the uncle's index position.
     *
     * @throws \Exception
     * @return array  See irc_getBlockByHash
     * ** Note **: An uncle doesn't contain individual transactions.
     */
    public function getUncleByBlockNumberAndIndex(string $block_number,string $position,$callback = null)
    {
        $inputs = [['Tag',$block_number],['Quantity',$position]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$block_number,$position];
        return $this->provider->sendReal('irc_getUncleByBlockNumberAndIndex',$params,$callback);
    }

    /**
     * Returns a list of available compilers in the client.
     *
     * @throws \Exception
     * @return array Array - Array of available compilers.
     */
    public function getCompilers($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_getCompilers',$params,$callback);
    }

    /**
     * Returns compiled solidity code.
     *
     * @param string $code  String - The source code.
     *
     * @throws \Exception
     * @return array DATA - The compiled source code.
     */
    public function compileSolidity(string $code,$callback = null)
    {
        $inputs = [['String',$code]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$code];
        return $this->provider->sendReal('irc_compileSolidity',$params,$callback);
    }

    /**
     * Returns compiled LLL code.
     *
     * @param string $code String - The source code.
     *
     * @throws \Exception
     * @return array       DATA - The compiled source code.
     */
    public function compileLLL(string $code,$callback = null)
    {
        $inputs = [['String',$code]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$code];
        return $this->provider->sendReal('irc_compileLLL',$params,$callback);
    }


    /**
     * Returns compiled serpent code.
     *
     * @param string $code String - The source code.
     *
     * @throws \Exception
     * @return array       DATA - The compiled source code.
     */
    public function compileSerpent(string $code,$callback = null)
    {
        $inputs = [['String',$code]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$code];
        return $this->provider->sendReal('irc_compileSerpent',$params,$callback);
    }

    /**
     * Creates a filter object, based on filter options, to notify when the state changes (logs).
     * To check if the state has changed, call irc_getFilterChanges.
     *
     *  A note on specifying topic filters:
     *  Topics are order-dependent. A transaction with a log with topics [A, B] will be matched by the following topic filters:
     *
     *   [] "anything"
     *   [A] "A in first position (and anything after)"
     *   [null, B] "anything in first position AND B in second position (and anything after)"
     *   [A, B] "A in first position AND B in second position (and anything after)"
     *   [[A, B], [A, B]] "(A OR B) in first position AND (A OR B) in second position (and anything after)"
     *
     * @param string $fromBlock  QUANTITY|TAG - (optional, default: "latest") Integer block number, or "latest" for the last mined block or "pending", "earliest" for not yet mined transactions.
     * @param string $toBlock    QUANTITY|TAG - (optional, default: "latest") Integer block number, or "latest" for the last mined block or "pending", "earliest" for not yet mined transactions.
     * @param string $address    DATA|Array, 20 Bytes - (optional) Contract address or a list of addresses from which logs should originate.
     * @param array $topics      Array of DATA, - (optional) Array of 32 Bytes DATA topics. Topics are order-dependent. Each topic can also be an array of DATA with "or" options.
     *
     * @throws \Exception
     * @return array  QUANTITY - A filter id.
     */
    // public function newFilter(string $fromBlock,string $toBlock,string $address,array $topics,$callback = null)
    public function newFilter(array $params,$callback = null)
    {
        $inputs = [['Filter',$params]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$params];
        return $this->provider->sendReal('irc_newFilter',$params,$callback);
    }

    /**
     * Creates a filter in the node, to notify when a new block arrives.
     * To check if the state has changed, call irc_getFilterChanges.
     *
     * @throws \Exception
     * @return array  QUANTITY - A filter id.
     */
    public function newBlockFilter($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_newBlockFilter',$params,$callback);
    }

    /**
     * Creates a filter in the node, to notify when new pending transactions arrive.
     * To check if the state has changed, call irc_getFilterChanges.
     *
     * @throws \Exception
     * @return array QUANTITY - A filter id.
     */
    public function newPendingTransactionFilter($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_newPendingTransactionFilter',$params,$callback);
    }

    /**
     * Uninstalls a filter with given id.
     * Should always be called when watch is no longer needed.
     * Additonally Filters timeout when they aren't requested with irc_getFilterChanges for a period of time.
     *
     * @param string $filter_id   QUANTITY - The filter id.
     *
     * @throws \Exception
     * @return array  Boolean - true if the filter was successfully uninstalled, otherwise false.
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
        return $this->provider->sendReal('irc_uninstallFilter',$params,$callback);
    }

    /**
     * Polling method for a filter, which returns an array of logs which occurred since last poll.
     *
     * @param string $filter_id  QUANTITY - the filter id.
     *
     * @throws \Exception
     * @return array Array - Array of log objects, or an empty array if nothing has changed since last poll.
     *  For filters created with eth_newBlockFilter the return are block hashes (DATA, 32 Bytes), e.g. ["0x3454645634534..."].
     *  For filters created with eth_newPendingTransactionFilter the return are transaction hashes (DATA, 32 Bytes), e.g. ["0x6345343454645..."].
     *  For filters created with eth_newFilter logs are objects with following params:
     *      removed: TAG - true when the log was removed, due to a chain reorganization. false if its a valid log.
     *      logIndex: QUANTITY - integer of the log index position in the block. null when its pending log.
     *      transactionIndex: QUANTITY - integer of the transactions index position log was created from. null when its pending log.
     *      transactionHash: DATA, 32 Bytes - hash of the transactions this log was created from. null when its pending log.
     *      blockHash: DATA, 32 Bytes - hash of the block where this log was in. null when its pending. null when its pending log.
     *      blockNumber: QUANTITY - the block number where this log was in. null when its pending. null when its pending log.
     *      address: DATA, 20 Bytes - address from which this log originated.
     *      data: DATA - contains one or more 32 Bytes non-indexed arguments of the log.
     *      topics: Array of DATA - Array of 0 to 4 32 Bytes DATA of indexed log arguments.
     *         (In solidity: The first topic is the hash of the signature of the event (e.g. Deposit(address,bytes32,uint256)),
     *          except you declared the event with the anonymous specifier.)
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
        return $this->provider->sendReal('irc_getFilterChanges',$params,$callback);
    }

    /**
     * Returns an array of all logs matching filter with given id.
     *
     * @param string $filter_id  QUANTITY - the filter id.
     *
     * @throws \Exception
     * @return array See irc_getFilterChanges
     */
    public function getFilterLogs(string $filter_id,$callback = null)
    {
        $inputs = [['Quantity',$filter_id]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$filter_id];
        return $this->provider->sendReal('irc_getFilterLogs',$params,$callback);
    }

    /**
     * Returns an array of all logs matching a given filter object.
     *
     * @param array $topics Object - the filter object, see irc_newFilter parameters.
     *
     * @throws \Exception
     * @return array  See irc_getFilterChanges
     */
    public function getLogs(array $topics,$callback = null)
    {
        $params = ['topics'=>$topics];

        $inputs = [['ShhFilter',$params]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        // $params = [['topics'=>$topics]];
        return $this->provider->sendReal('irc_getLogs',[$params],$callback);
    }

    /**
     * Returns the hash of the current block, the seedHash, and the boundary condition to be met ("target").
     *
     * @throws \Exception
     * @return array Array - Array with the following properties:
     *
     *   DATA, 32 Bytes - current block header pow-hash
     *   DATA, 32 Bytes - the seed hash used for the DAG.
     *   DATA, 32 Bytes - the boundary condition ("target"), 2^256 / difficulty.
     */
    public function getWork($callback = null)
    {
        $params = [];
        return $this->provider->sendReal('irc_getWork',$params,$callback);
    }

    /**
     * Used for submitting a proof-of-work solution.
     *
     * @param string $nonce       DATA, 8 Bytes - The nonce found (64 bits)
     * @param string $pow_hash    DATA, 32 Bytes - The header's pow-hash (256 bits)
     * @param string $mix_digest  DATA, 32 Bytes - The mix digest (256 bits)
     *
     * @throws \Exception
     * @return array  Boolean - returns true if the provided solution is valid, otherwise false.
     */
    public function submitWork(string $nonce,string $pow_hash,string $mix_digest,$callback = null)
    {
        $inputs = [['Nonce',$nonce],['Hex',$pow_hash],['Hex',$mix_digest]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$nonce,$pow_hash,$mix_digest];
        return $this->provider->sendReal('irc_submitWork',$params,$callback);
    }

    /**
     * Used for submitting mining hashrate.
     *
     * @param string $hashrate  Hashrate, a hexadecimal string representation (32 bytes) of the hash rate
     * @param string $id        ID, String - A random hexadecimal(32 bytes) ID identifying the client
     *
     * @throws \Exception
     * @return array Boolean - returns true if submitting went through succesfully and false otherwise.
     */
    public function submitHashrate(string $hashrate,string $id,$callback = null)
    {
        $inputs = [['Hex',$hashrate],['Hex',$id]];
        $rs     = Validator::batch($inputs,__METHOD__.':');
        if ($rs[0] === false)
        {
            return $this->provider->sendError($rs[0],$callback);
        }

        $params = [$hashrate,$id];
        return $this->provider->sendReal('irc_submitHashrate',$params,$callback);
    }

}