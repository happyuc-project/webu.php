# webu.php

[![Build Status](https://travis-ci.org/sc0Vu/webu.php.svg?branch=master)](https://travis-ci.org/sc0Vu/webu.php)
[![codecov](https://codecov.io/gh/sc0Vu/webu.php/branch/master/graph/badge.svg)](https://codecov.io/gh/sc0Vu/webu.php)
[![Join the chat at https://gitter.im/webu-php/webu.php](https://img.shields.io/badge/gitter-join%20chat-brightgreen.svg)](https://gitter.im/webu-php/webu.php)
[![Licensed under the MIT License](https://img.shields.io/badge/License-MIT-blue.svg)](https://github.com/happyuc-project/webu.php/blob/master/LICENSE)


A php interface for interacting with the HappyUC blockchain and ecosystem.

# Install

Set minimum stability to dev
```
"minimum-stability": "dev"
```

Then
```
composer require sc0vu/webu.php dev-master
```

Or you can add this line in composer.json

```
"sc0vu/webu.php": "dev-master"
```


# Usage

### New instance
```php
use Webu\Webu;

$webu = new Webu('http://localhost:8545');
```

### Using provider
```php
use Webu\Webu;
use Webu\Providers\HttpProvider;
use Webu\RequestManagers\HttpRequestManager;

$webu = new Webu(new HttpProvider(new HttpRequestManager('http://193.112.32.158:8545')));

// timeout
$webu = new Webu(new HttpProvider(new HttpRequestManager('http://193.112.32.158:8545', 0.1)));
```

### You can use callback to each rpc call:
```php
$webu->clientVersion(function ($err, $version) {
    if ($err !== null) {
        // do somhucing
        return;
    }
    if (isset($client)) {
        echo 'Client version: ' . $version;
    }
});
```

### Huc
```php
use Webu\Webu;

$webu = new Webu('http://localhost:8545');
$huc = $webu->huc;
```

Or

```php
use Webu\Huc;

$huc = new Huc('http://localhost:8545');
```

### Net
```php
use Webu\Webu;

$webu = new Webu('http://localhost:8545');
$net = $webu->net;
```

Or

```php
use Webu\Net;

$net = new Net('http://localhost:8545');
```

### Batch

webu
```php
$webu->batch(true);
$webu->clientVersion();
$webu->hash('0x1234');
$webu->execute(function ($err, $data) {
    if ($err !== null) {
        // do somhucing
        // it may throw exception or array of exception depends on error type
        // connection error: throw exception
        // json rpc error: array of exception
        return;
    }
    // do somhucing
});
```

huc

```php
$huc->batch(true);
$huc->protocolVersion();
$huc->syncing();

$huc->provider->execute(function ($err, $data) {
    if ($err !== null) {
        // do somhucing
        return;
    }
    // do somhucing
});
```

net
```php
$net->batch(true);
$net->version();
$net->listening();

$net->provider->execute(function ($err, $data) {
    if ($err !== null) {
        // do somhucing
        return;
    }
    // do somhucing
});
```

personal
```php
$personal->batch(true);
$personal->listAccounts();
$personal->newAccount('123456');

$personal->provider->execute(function ($err, $data) {
    if ($err !== null) {
        // do somhucing
        return;
    }
    // do somhucing
});
```

### Contract

```php
use Webu\Contract;

$contract = new Contract('http://localhost:8545', $abi);

// deploy contract
$contract->bytecode($bytecode)->new($params, $callback);

// call contract function
$contract->at($contractAddress)->call($functionName, $params, $callback);

// change function state
$contract->at($contractAddress)->send($functionName, $params, $callback);

// estimate deploy contract gas
$contract->bytecode($bytecode)->estimateGas($params, $callback);

// estimate function gas
$contract->at($contractAddress)->estimateGas($functionName, $params, $callback);

// get constructor data
$constructorData = $contract->bytecode($bytecode)->getData($params);

// get function data
$functionData = $contract->at($contractAddress)->getData($functionName, $params);
```

# Assign value to outside scope(from callback scope to outside scope)
Due to callback is not like javascript callback, 
if we need to assign value to outside scope, 
we need to assign reference to callback.
```php
$newAccount = '';

$webu->personal->newAccount('123456', function ($err, $account) use (&$newAccount) {
    if ($err !== null) {
        echo 'Error: ' . $err->getMessage();
        return;
    }
    $newAccount = $account;
    echo 'New account: ' . $account . PHP_EOL;
});
```

# Examples

To run examples, you need to run HappyUC blockchain local (testrpc).

If you are using docker as development machain, you can try [hucdock](https://github.com/sc0vu/hucdock) to run local HappyUC blockchain, just simply run `docker-compose up -d testrpc` and expose the `8545` port.

# Develop

### Local php cli installed

1. Clone the repo and install packages.
```
git clone https://github.com/happyuc-project/webu.php.git && cd webu.php && composer install
```

2. Run test script.
```
vendor/bin/phpunit
```

### Docker container

1. Clone the repo and run docker container.
```
git clone https://github.com/happyuc-project/webu.php.git
```

2. Copy webu.php to webu.php/docker/app directory and start container.
```
cp files docker/app && docker-compose up -d php
```

3. Enter php container and install packages.
```
docker-compose exec php ash
```

4. Run test script
```
vendor/bin/phpunit
```

# API

Todo.

# License
MIT
