<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu;


class Huc
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
        'huc_protocolVersion',
        'huc_syncing',
        'huc_coinbase',
        'huc_mining',
        'huc_hashrate',
        'huc_gasPrice',
        'huc_accounts',
        'huc_blockNumber',
        'huc_getBalance',
        'huc_getStorageAt',
        'huc_getTransactionCount',
        'huc_getBlockTransactionCountByHash',
        'huc_getBlockTransactionCountByNumber',
        'huc_getUncleCountByBlockHash',
        'huc_getUncleCountByBlockNumber',
        'huc_getUncleByBlockHashAndIndex',
        'huc_getUncleByBlockNumberAndIndex',
        'huc_getCode',
        'huc_sign',
        'huc_sendTransaction',
        'huc_sendRawTransaction',
        'huc_call',
        'huc_estimateGas',
        'huc_getBlockByHash',
        'huc_getBlockByNumber',
        'huc_getTransactionByHash',
        'huc_getTransactionByBlockHashAndIndex',
        'huc_getTransactionByBlockNumberAndIndex',
        'huc_getTransactionReceipt',
        'huc_getCompilers',
        'huc_compileSolidity',
        'huc_compileLLL',
        'huc_compileSerpent',
        'huc_getWork',
        'huc_newFilter',
        'huc_newBlockFilter',
        'huc_newPendingTransactionFilter',
        'huc_uninstallFilter',
        'huc_getFilterChanges',
        'huc_getFilterLogs',
        'huc_getLogs',
        'huc_submitWork',
        'huc_submitHashrate'
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
     * @return array The current happyuc protocol version
     */
    public function protocolVersion()
    {
        $params = [];
        return $this->provider->sendReal('huc_protocolVersion',$params);
    }

    /**
     * Returns an object with data about the sync status or false.
     *
     * @return array Object|Boolean, An object with sync status data or FALSE, when not syncing:
     *           startingBlock: QUANTITY - The block at which the import started (will only be reset, after the sync reached his head)
     *           currentBlock: QUANTITY - The current block, same as huc_blockNumber
     *           highestBlock: QUANTITY - The estimated highest block
     */
    public function syncing()
    {
        $params = [];
        return $this->provider->sendReal('huc_syncing',$params);
    }

    /**
     * @return array DATA, 20 bytes - the current coinbase address.
     */
    public function coinbase()
    {
        $params = [];
        return $this->provider->sendReal('huc_coinbase',$params);
    }

    /**
     * @return array returns true of the client is mining, otherwise false.
     */
    public function mining()
    {
        $params = [];
        return $this->provider->sendReal('huc_mining',$params);
    }

    /**
     * Returns the number of hashes per second that the node is mining with.
     *
     * @return string QUANTITY - number of hashes per second.
     */
    public function hashrate()
    {
        $params = [];
        return $this->provider->sendReal('huc_hashrate',$params);
    }


    /**
     * Returns the current price per gas in wei.
     *
     * @return array QUANTITY - integer of the current gas price in wei.
     */
    public function gasPrice()
    {
        $params = [];
        return $this->provider->sendReal('huc_gasPrice',$params);
    }


    /**
     * Returns a list of addresses owned by client.
     *
     * @return array of DATA, 20 Bytes - addresses owned by the client.
     */
    public function accounts()
    {
        $params = [];
        return $this->provider->sendReal('huc_accounts',$params);
    }


    /**
     * Returns the number of most recent block.
     *
     * @return int QUANTITY - integer of the current block number the client is on.
     */
    public function blockNumber()
    {
        $params      = [];
        $blockNumber = $this->provider->sendReal('huc_blockNumber',$params);
        return Formatter::Number($blockNumber);
    }


    /**
     * Returns the balance of the account of given address.
     *
     * @param string $address      DATA, 20 Bytes - address to check for balance.
     * @param string $block_number QUANTITY|TAG - integer block number, or the string "latest", "earliest" or "pending", see the default block parameter
     * @return array   QUANTITY - integer of the current balance in wei.
     */
    public function getBalance(string $address,string $block_number)
    {
        $params = [$address,$block_number];
        return $this->provider->sendReal('huc_getBalance',$params);
    }


    /**
     * Returns the value from a storage position at a given address.
     *
     * @param string $address       DATA, 20 Bytes - address of the storage.
     * @param string $position      QUANTITY - integer of the position in the storage.
     * @param string $block_number  QUANTITY|TAG - integer block number, or the string "latest", "earliest" or "pending", see the default block parameter
     * @return array DATA - the value at this storage position.
     */
    public function getStorageAt(string $address,string $position,string $block_number)
    {
        $params = [$address,$position,$block_number];
        return $this->provider->sendReal('huc_getStorageAt',$params);
    }

    /**
     * Returns the number of transactions sent from an address.
     *
     * @param string $address       DATA, 20 Bytes - address.
     * @param string $block_number  QUANTITY|TAG - integer block number, or the string "latest", "earliest" or "pending", see the default block parameter
     * @return array QUANTITY - integer of the number of transactions send from this address.
     */
    public function getTransactionCount(string $address,string $block_number)
    {
        $params = [$address,$block_number];
        return $this->provider->sendReal('huc_getTransactionCount',$params);
    }

    /**
     * Returns the number of transactions in a block from a block matching the given block hash.
     *
     * @param string $hash  DATA, 32 Bytes - hash of a block
     * @return array QUANTITY - integer of the number of transactions in this block.
     */
    public function getBlockTransactionCountByHash(string $hash)
    {
        $params = [$hash];
        return $this->provider->sendReal('huc_getBlockTransactionCountByHash',$params);
    }

    /**
     * Returns the number of transactions in a block matching the given block number.
     *
     * @param string $block_number  QUANTITY|TAG - integer of a block number, or the string "earliest", "latest" or "pending", as in the default block parameter.
     * @return array    QUANTITY - integer of the number of transactions in this block.
     */
    public function getBlockTransactionCountByNumber(string $block_number)
    {
        $params = [$block_number];
        return $this->provider->sendReal('huc_getBlockTransactionCountByNumber',$params);
    }


    /**
     * Returns the number of uncles in a block from a block matching the given block hash.
     *
     * @param string $hash  DATA, 32 Bytes - hash of a block
     * @return array        QUANTITY - integer of the number of uncles in this block.
     */
    public function getUncleCountByBlockHash(string $hash)
    {
        $params = [$hash];
        return $this->provider->sendReal('huc_getUncleCountByBlockHash',$params);
    }

    /**
     * Returns the number of uncles in a block from a block matching the given block number.
     *
     * @param string $block_number  QUANTITY|TAG - integer of a block number, or the string "latest", "earliest" or "pending", see the default block parameter
     * @return array                QUANTITY - integer of the number of uncles in this block.
     */
    public function getUncleCountByBlockNumber(string $block_number)
    {
        $params = [$block_number];
        return $this->provider->sendReal('huc_getUncleCountByBlockNumber',$params);
    }

    /**
     * Returns code at a given address.
     *
     * @param string $address       DATA, 20 Bytes - address
     * @param string $block_number  QUANTITY|TAG - integer block number, or the string "latest", "earliest" or "pending", see the default block parameter
     * @return array  DATA - the code from the given address.
     */
    public function getCode(string $address,string $block_number)
    {
        $params = [$address,$block_number];
        return $this->provider->sendReal('huc_getCode',$params);
    }

    /**
     * The sign method calculates an Ethereum specific signature with: sign(keccak256("\x19Ethereum Signed Message:\n" + len(message) + message))).
     * By adding a prefix to the message makes the calculated signature recognisable as an Ethereum specific signature. This prevents misuse where a malicious DApp can sign arbitrary data (e.g. transaction) and use the signature to impersonate the victim.
     *  ** Note ** the address to sign with must be unlocked.
     *
     * @param string $address  DATA, 20 Bytes - address
     * @param string $message  DATA, N Bytes - message to sign
     * @return array DATA: Signature
     */
    public function sign(string $address,string $message)
    {
        $params = [$address,$message];
        return $this->provider->sendReal('huc_sign',$params);
    }

    /**
     * Creates new message call transaction or a contract creation, if the data field contains code.
     *
     * @param string $from  DATA, 20 Bytes - The address the transaction is send from.
     * @param string $to    DATA, 20 Bytes - (optional when creating new contract) The address the transaction is directed to.
     * @param string $gas   QUANTITY - (optional, default: 90000) Integer of the gas provided for the transaction execution. It will return unused gas.
     * @param string $gasPrice  QUANTITY - (optional, default: To-Be-Determined) Integer of the gasPrice used for each paid gas
     * @param string $value     QUANTITY - (optional) Integer of the value sent with this transaction
     * @param string $data      DATA - The compiled code of a contract OR the hash of the invoked method signature and encoded parameters. For details see HappyUC Contract ABI
     * @param string $nonce     QUANTITY - (optional) Integer of a nonce. This allows to overwrite your own pending transactions that use the same nonce.
     * @return array DATA, 32 Bytes - the transaction hash, or the zero hash if the transaction is not yet available.
     * Use huc_getTransactionReceipt to get the contract address, after the transaction was mined, when you created a contract.
     */
    public function sendTransaction(string $from,string $to,int $gas=90000,string $gasPrice,string $value,string $data,string $nonce='')
    {

        $params = ['from'=>$from,'to'=>$to,'gas'=>$gas,'gasPrice'=>$gasPrice,'value'=>$value,'data'=>$data];
        if($nonce)
        {
            $params['nonce'] = $nonce;
        }
        return $this->provider->sendReal('huc_sendTransaction',[$params]);
    }

    /**
     * Creates new message call transaction or a contract creation for signed transactions.
     *
     * @param $transaction_data  DATA, The signed transaction data.
     * @return array   DATA, 32 Bytes - the transaction hash, or the zero hash if the transaction is not yet available.
     *             Use huc_getTransactionReceipt to get the contract address, after the transaction was mined, when you created a contract.
     */
    public function sendRawTransaction($transaction_data)
    {
        $params = [$transaction_data];
        return $this->provider->sendReal('huc_sendRawTransaction',$params);
    }

    /**
     * Executes a new message call immediately without creating a transaction on the block chain.
     *
     * @param string $from        DATA, 20 Bytes - (optional) The address the transaction is sent from.
     * @param string $to          DATA, 20 Bytes - The address the transaction is directed to.
     * @param string $gas         QUANTITY - (optional) Integer of the gas provided for the transaction execution.
     *                               huc_call consumes zero gas, but this parameter may be needed by some executions.
     * @param string $gasPrice    QUANTITY - (optional) Integer of the gasPrice used for each paid gas
     * @param string $value       QUANTITY - (optional) Integer of the value sent with this transaction
     * @param string $data        DATA - (optional) Hash of the method signature and encoded parameters. For details see HappyUC Contract ABI
     * @param string $block_number  QUANTITY|TAG - integer block number, or the string "latest", "earliest" or "pending", see the default block parameter
     * @return array  DATA - the return value of executed contract.
     */
    public function call(string $from,string $to,string $gas,string $gasPrice,string $value,string $data,string $block_number)
    {
        $params1 = ['from'=>$from,'to'=>$to,'gas'=>$gas,'gasPrice'=>$gasPrice,'value'=>$value,'data'=>$data];
        $params  = [$params1,$block_number];
        return $this->provider->sendReal('huc_call',$params);
    }

    /**
     * Generates and returns an estimate of how much gas is necessary to allow the transaction to complete.
     * The transaction will not be added to the blockchain.
     * Note that the estimate may be significantly more than the amount of gas actually used by the transaction,
     * for a variety of reasons including EVM mechanics and node performance.
     *
     * See huc_call parameters, expect that all properties are optional.
     * If no gas limit is specified geth uses the block gas limit from the pending block as an upper bound.
     * As a result the returned estimate might not be enough to executed the call/transaction when the amount of gas is higher than the pending block gas limit.
     *
     * @return array  QUANTITY - the amount of gas used.
     */
    public function estimateGas(string $from,string $to,string $gas,string $gasPrice,string $value,string $data,string $block_number)
    {
        $params1 = ['from'=>$from,'to'=>$to,'gas'=>$gas,'gasPrice'=>$gasPrice,'value'=>$value,'data'=>$data];
        $params  = [$params1,$block_number];
        return $this->provider->sendReal('huc_estimateGas',$params);
    }

    /**
     * Returns information about a block by hash.
     *
     * @param string $hash   DATA, 32 Bytes - Hash of a block.
     * @param bool $is_full  Boolean - If true it returns the full transaction objects, if false only the hashes of the transactions.
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
    public function getBlockByHash(string $hash,bool $is_full)
    {
        $params = [$hash,$is_full];
        return $this->provider->sendReal('huc_getBlockByHash',$params);
    }

    /**
     * Returns information about a block by block number.
     *
     * @param string $block_number   QUANTITY|TAG - integer of a block number, or the string "earliest", "latest" or "pending", as in the default block parameter.
     * @param bool   $is_full        Boolean - If true it returns the full transaction objects, if false only the hashes of the transactions.
     * @return array  See huc_getBlockByHash
     */
    public function getBlockByNumber(string $block_number,bool $is_full=false)
    {
        $params        = [$block_number,$is_full];
        return $this->provider->sendReal('huc_getBlockByNumber',$params);
    }

    /**
     * Returns the information about a transaction requested by transaction hash.
     *
     * @param $transaction_hash  DATA, 32 Bytes - hash of a transaction
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
    public function getTransactionByHash(string $transaction_hash)
    {
        $params = [$transaction_hash];
        return $this->provider->sendReal('huc_getTransactionByHash',$params);
    }

    /**
     * Returns information about a transaction by block hash and transaction index position.
     *
     * @param string $block_hash  QUANTITY|TAG - a block number, or the string "earliest", "latest" or "pending", as in the default block parameter.
     * @param string $position    QUANTITY - the transaction index position.
     * @return array  See huc_getTransactionByHash
     */
    public function getTransactionByBlockHashAndIndex(string $block_hash,string $position)
    {
        $params = [$block_hash,$position];
        return $this->provider->sendReal('huc_getTransactionByBlockHashAndIndex',$params);
    }


    /**
     * Returns information about a transaction by block number and transaction index position.
     *
     * @param string $block_number  QUANTITY|TAG - a block number, or the string "earliest", "latest" or "pending", as in the default block parameter.
     * @param string $position      QUANTITY - the transaction index position.
     * @return array  See huc_getTransactionByHash
     */
    public function getTransactionByBlockNumberAndIndex(string $block_number,string $position)
    {
        $params = [$block_number,$position];
        return $this->provider->sendReal('huc_getTransactionByBlockNumberAndIndex',$params);
    }

    /**
     * Returns the receipt of a transaction by transaction hash.
     * ** Note ** That the receipt is not available for pending transactions.
     *
     * @param string $transaction_hash  DATA, 32 Bytes - hash of a transaction
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
    public function getTransactionReceipt(string $transaction_hash)
    {
        $params = [$transaction_hash];
        return $this->provider->sendReal('huc_getTransactionReceipt',$params);
    }

    /**
     * Returns information about a uncle of a block by hash and uncle index position.
     *
     * @param string $block_hash   DATA, 32 Bytes - hash a block.
     * @param string $position     QUANTITY - the uncle's index position.
     * @return array  See huc_getBlockByHash
     */
    public function getUncleByBlockHashAndIndex(string $block_hash,string $position)
    {
        $params = [];
        return $this->provider->sendReal('huc_getUncleByBlockHashAndIndex',$params);
    }

    /**
     * Returns information about a uncle of a block by number and uncle index position.
     *
     * @param string $block_number   QUANTITY|TAG - a block number, or the string "earliest", "latest" or "pending", as in the default block parameter.
     * @param string $position       QUANTITY - the uncle's index position.
     * @return array  See huc_getBlockByHash
     * ** Note **: An uncle doesn't contain individual transactions.
     */
    public function getUncleByBlockNumberAndIndex(string $block_number,string $position)
    {
        $params = [$block_number,$position];
        return $this->provider->sendReal('huc_getUncleByBlockNumberAndIndex',$params);
    }

    /**
     * Returns a list of available compilers in the client.
     *
     * @return array Array - Array of available compilers.
     */
    public function getCompilers()
    {
        $params = [];
        return $this->provider->sendReal('huc_getCompilers',$params);
    }

    /**
     * Returns compiled solidity code.
     *
     * @param string $code  String - The source code.
     * @return array DATA - The compiled source code.
     */
    public function compileSolidity(string $code)
    {
        $params = [$code];
        return $this->provider->sendReal('huc_compileSolidity',$params);
    }

    /**
     * Returns compiled LLL code.
     *
     * @param string $code String - The source code.
     * @return array       DATA - The compiled source code.
     */
    public function compileLLL(string $code)
    {
        $params = [];
        return $this->provider->sendReal('huc_compileLLL',$params);
    }


    /**
     * Returns compiled serpent code.
     *
     * @param string $code String - The source code.
     * @return array       DATA - The compiled source code.
     */
    public function compileSerpent(string $code)
    {
        $params = [];
        return $this->provider->sendReal('huc_compileSerpent',$params);
    }

    /**
     * Creates a filter object, based on filter options, to notify when the state changes (logs).
     * To check if the state has changed, call huc_getFilterChanges.
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
     * @return array  QUANTITY - A filter id.
     */
    public function newFilter(string $fromBlock,string $toBlock,string $address,array $topics)
    {
        $params = [["fromBlock"=>$fromBlock,"toBlock"=>$toBlock,"address"=>$address,"topics"=>$topics]];
        return $this->provider->sendReal('huc_newFilter',$params);
    }

    /**
     * Creates a filter in the node, to notify when a new block arrives.
     * To check if the state has changed, call huc_getFilterChanges.
     *
     * @return array  QUANTITY - A filter id.
     */
    public function newBlockFilter()
    {
        $params = [];
        return $this->provider->sendReal('huc_newBlockFilter',$params);
    }

    /**
     * Creates a filter in the node, to notify when new pending transactions arrive.
     * To check if the state has changed, call huc_getFilterChanges.
     *
     * @return array QUANTITY - A filter id.
     */
    public function newPendingTransactionFilter()
    {
        $params = [];
        return $this->provider->sendReal('huc_newPendingTransactionFilter',$params);
    }

    /**
     * Uninstalls a filter with given id.
     * Should always be called when watch is no longer needed.
     * Additonally Filters timeout when they aren't requested with huc_getFilterChanges for a period of time.
     *
     * @param string $filter_id   QUANTITY - The filter id.
     * @return array  Boolean - true if the filter was successfully uninstalled, otherwise false.
     */
    public function uninstallFilter(string $filter_id)
    {
        $params = [$filter_id];
        return $this->provider->sendReal('huc_uninstallFilter',$params);
    }

    /**
     * Polling method for a filter, which returns an array of logs which occurred since last poll.
     *
     * @param string $filter_id  QUANTITY - the filter id.
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
    public function getFilterChanges(string $filter_id)
    {
        $params = [$filter_id];
        return $this->provider->sendReal('huc_getFilterChanges',$params);
    }

    /**
     * Returns an array of all logs matching filter with given id.
     *
     * @param string $filter_id  QUANTITY - the filter id.
     * @return array See huc_getFilterChanges
     */
    public function getFilterLogs(string $filter_id)
    {
        $params = [];
        return $this->provider->sendReal('huc_getFilterLogs',$params);
    }

    /**
     * Returns an array of all logs matching a given filter object.
     *
     * @param array $topics Object - the filter object, see huc_newFilter parameters.
     * @return array  See huc_getFilterChanges
     */
    public function getLogs(array $topics)
    {
        $params = [['topics'=>$topics]];
        return $this->provider->sendReal('huc_getLogs',$params);
    }

    /**
     * Returns the hash of the current block, the seedHash, and the boundary condition to be met ("target").
     *
     * @return array Array - Array with the following properties:
     *
     *   DATA, 32 Bytes - current block header pow-hash
     *   DATA, 32 Bytes - the seed hash used for the DAG.
     *   DATA, 32 Bytes - the boundary condition ("target"), 2^256 / difficulty.
     */
    public function getWork()
    {
        $params = [];
        return $this->provider->sendReal('huc_getWork',$params);
    }

    /**
     * Used for submitting a proof-of-work solution.
     *
     * @param string $nonce       DATA, 8 Bytes - The nonce found (64 bits)
     * @param string $pow_hash    DATA, 32 Bytes - The header's pow-hash (256 bits)
     * @param string $mix_digest  DATA, 32 Bytes - The mix digest (256 bits)
     * @return array  Boolean - returns true if the provided solution is valid, otherwise false.
     */
    public function submitWork(string $nonce,string $pow_hash,string $mix_digest)
    {
        $params = [$nonce,$pow_hash,$mix_digest];
        return $this->provider->sendReal('huc_submitWork',$params);
    }

    /**
     * Used for submitting mining hashrate.
     *
     * @param string $hashrate  Hashrate, a hexadecimal string representation (32 bytes) of the hash rate
     * @param string $id        ID, String - A random hexadecimal(32 bytes) ID identifying the client
     * @return array Boolean - returns true if submitting went through succesfully and false otherwise.
     */
    public function submitHashrate(string $hashrate,string $id)
    {
        $params = [$hashrate,$id];
        return $this->provider->sendReal('huc_submitHashrate',$params);
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
//        print_r(['$name'=>$name,'$arguments'=>$arguments]);
//
//        $class = explode('\\', get_class());
//
//        if (preg_match('/^[a-zA-Z0-9]+$/', $name) === 1) {
//            $method = strtolower($class[1]) . '_' . $name;
//
//            if (!in_array($method, $this->allowedMethods)) {
//                throw new \RuntimeException('Unallowed rpc method: ' . $method);
//            }
//            if ($this->provider->getIsBatch() ) {
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