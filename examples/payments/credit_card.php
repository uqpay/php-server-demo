<?php

use uqpay\payment\model\BankCard;
use uqpay\payment\model\PaymentOrder;
use uqpay\payment\PayMethodHelper;

include dirname( __FILE__ ) . '/../config.php';

/**
 * credit card payment
 **/

$payment_order = new PaymentOrder();
$payment_order->method_id = PayMethodHelper::UNION_PAY_EXPRESS_PAY;
$payment_order->order_id = time();
$payment_order->trans_name = 'product name';
$payment_order->amount = 1;
$payment_order->currency = 'HKD';
$payment_order->date = time();
$payment_order->client_ip = '127.0.0.1';
$payment_order->callback_url = 'https://localhost:8080/async';

$bank_card = new BankCard();
$bank_card->first_name = 'test';
$bank_card->last_name = 'test';
$bank_card->card_num='6250947000000014';
$bank_card->cvv='123';
$bank_card->expire_year=33;
$bank_card->expire_month=12;
try {
	$result = $uqpay_gateway_merchant->pay( $payment_order, $bank_card );
	var_dump($result);
} catch ( ReflectionException $e ) {
	// the library need ReflectionClass
} catch ( \uqpay\payment\config\security\SecurityUqpayException $e ) {
	// this means you lost some parameters for authentication， eg: merchant ID, RSA key ...
	var_dump($e->getMessage());
} catch ( \uqpay\payment\UqpayException $e ) {
	// this means the payment is failed, you can get more detail by check $e->message
	var_dump($e->getMessage());
}
