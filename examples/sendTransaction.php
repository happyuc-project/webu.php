<?php

require('./exampleBase.php');

$irc = $webu->irc;

echo 'Irc Send Transaction' . PHP_EOL;

$irc->accounts(function ($err, $accounts) use ($irc) {
    if ($err !== null) {
        echo 'Error: ' . $err->getMessage();
        return;
    }
    $fromAccount = $accounts[0];
    $toAccount   = $accounts[1];

    // get balance
    $irc->getBalance($fromAccount, function ($err, $balance) use($fromAccount) {
        if ($err !== null) {
            echo 'Error: ' . $err->getMessage();
            return;
        }
        echo $fromAccount . ' Balance: ' . $balance . PHP_EOL;
    });
    $irc->getBalance($toAccount, function ($err, $balance) use($toAccount) {
        if ($err !== null) {
            echo 'Error: ' . $err->getMessage();
            return;
        }
        echo $toAccount . ' Balance: ' . $balance . PHP_EOL;
    });

    // send transaction
    $irc->sendTransaction([
        'from' => $fromAccount,
        'to' => $toAccount,
        'value' => '0x11'
    ], function ($err, $transaction) use ($irc, $fromAccount, $toAccount) {
        if ($err !== null) {
            echo 'Error: ' . $err->getMessage();
            return;
        }
        echo 'Tx hash: ' . $transaction . PHP_EOL;

        // get balance
        $irc->getBalance($fromAccount, function ($err, $balance) use($fromAccount) {
            if ($err !== null) {
                echo 'Error: ' . $err->getMessage();
                return;
            }
            echo $fromAccount . ' Balance: ' . $balance . PHP_EOL;
        });
        $irc->getBalance($toAccount, function ($err, $balance) use($toAccount) {
            if ($err !== null) {
                echo 'Error: ' . $err->getMessage();
                return;
            }
            echo $toAccount . ' Balance: ' . $balance . PHP_EOL;
        });
    });
});