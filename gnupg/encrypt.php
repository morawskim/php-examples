<?php


$pubKey = file_get_contents(__DIR__ . '/pubkey.asc');

$gnupg = new gnupg($pubKey);
$gnupg->import($pubKey);
$gnupg->addencryptkey("0A2EF9AE9D9904816116C4063EB6BE9650D8871F");
echo $gnupg->encrypt("Hello from PHP & GNUGP");
