<?php

require('./exampleBase.php');

$irc = $webu->irc;

echo 'Irc Get Account and Balance' . PHP_EOL;

$irc->accounts(function ($err, $accounts) use ($irc)
{
    if ($err !== null)
    {
        echo 'Error: ' . $err->getMessage();
        return;
    }
    foreach ($accounts as $account)
    {
        echo 'Account: ' . $account . PHP_EOL;

        $irc->getBalance($account, function ($err, $balance)
        {
            if ($err !== null)
            {
                echo 'Error: ' . $err->getMessage();
                return;
            }
            echo 'Balance: ' . $balance . PHP_EOL;
        });
    }
});