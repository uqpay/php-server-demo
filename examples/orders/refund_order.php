<?php

use uqpay\payment\model\OrderRefund;

include dirname( __FILE__ ) . '/../config.php';

/**
 * refund or cancel order
 * the cancel is almost the same as refund
 * for cancel use OrderCancel
 */


$refundOrder = new OrderRefund();
$refundOrder->order_id = time();

// get it from the payment order
$refundOrder->uqpay_order_id = 3121231233123;
// less or equal the amount of payment order
$refundOrder->amount = 1.0;
$refundOrder->callback_url = 'https://localhost:8080/async';
$refundOrder->date = time();

try {
	$re_result = $uqpay_gateway_merchant->refund( $refundOrder );
	var_dump($re_result);
} catch ( ReflectionException $e ) {
	var_dump($e->getMessage());
} catch ( \uqpay\payment\config\security\SecurityUqpayException $e ) {
	var_dump($e->getMessage());
} catch ( \uqpay\payment\UqpayException $e ) {
	var_dump($e->getMessage());
}