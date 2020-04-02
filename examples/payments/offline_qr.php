<?php

use uqpay\payment\Constants;
use uqpay\payment\model\PaymentOrder;
use uqpay\payment\PayMethodHelper;

include dirname( __FILE__ ) . '/../config.php';

/**
 * Online QR
 * this example user union pay online qr
 */
$payment_order = new PaymentOrder();
$payment_order->method_id = PayMethodHelper::WECHAT_OFFLINE_QR;
$payment_order->order_id = time();
$payment_order->trans_name = 'product name';
$payment_order->amount = 1;
$payment_order->currency = 'SGD';
$payment_order->date = time();
$payment_order->merchant_city = 'shanghai';
$payment_order->terminal_id = '123123';
$payment_order->client_ip = '127.0.0.1';
$payment_order->callback_url = 'https://localhost:8080/async';

/**
 * this is required for online QR
 */
$payment_order->scan_type = Constants::QR_CODE_SCAN_BY_CONSUMER;

try {
	$result = $uqpay_gateway_merchant->pay( $payment_order );
	/**
	 * in the result you will get the QR payload (check $result->qr_payload)
	 * you can use the payload generate a QR Code Image
	 * also you can use the QR Code Url (check $result->qr_url) generate by UQPAY
	 */
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