<?php

require('./exampleBase.php');

$huc = $webu->huc;

echo 'Huc Get Account and Balance' . PHP_EOL;

$huc->accounts(function ($err, $accounts) use ($huc)
{
    if ($err !== null)
    {
        echo 'Error: ' . $err->getMessage();
        return;
    }
    foreach ($accounts as $account)
    {
        echo 'Account: ' . $account . PHP_EOL;

        $huc->getBalance($account, function ($err, $balance)
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