<?php

require_once '../vendor/braintree/braintree_php/lib/Braintree.php';
$gateway = new Braintree\Gateway([
    'environment' => 'sandbox',
    'merchantId' => 'p6jg58y9zmmpjyh5',
    'publicKey' => 'x5n8ksc73vhbqkn6',
    'privateKey' => '0b8634ba27d6f1ce8d01eee54147a999'
]);
echo($clientToken = $gateway->clientToken()->generate());
