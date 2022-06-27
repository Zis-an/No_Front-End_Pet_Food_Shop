<?php
session_start();
require_once '../vendor/braintree/braintree_php/lib/Braintree.php';

if(isset($_POST['nonce']) && isset($_SESSION['order_details'])){
// Instantiate a Braintree Gateway either like this:
$gateway = new Braintree\Gateway([
    'environment' => 'sandbox',
    'merchantId' => 'p6jg58y9zmmpjyh5',
    'publicKey' => 'x5n8ksc73vhbqkn6',
    'privateKey' => '0b8634ba27d6f1ce8d01eee54147a999'
]);

// Then, create a transaction:
$result = $gateway->transaction()->sale([
    'amount' => $_SESSION['order_details']['tprice'],
    'paymentMethodNonce' => $_POST['nonce'],
    'options' => [ 'submitForSettlement' => True ]
]);

if ($result->success) {
    // print_r("success!: " . $result->transaction);
    $_SESSION['transaction_id'] = $result->transaction->id;
    $_SESSION['paid_amount'] = $result->transaction->amount;
    echo 1;
} else if ($result->transaction) {
    // print_r("Error processing transaction:");
    // print_r("\n  code: " . $result->transaction->processorResponseCode);
    // print_r("\n  text: " . $result->transaction->processorResponseText);
    echo 0;
} else {
    // foreach($result->errors->deepAll() AS $error) {
    //   print_r($error->code . ": " . $error->message . "\n");
    // }
    echo 0;
}
}
