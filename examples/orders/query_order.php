<?php

use uqpay\payment\model\OrderQuery;

include dirname( __FILE__ ) . '/../config.php';

$queryOrder = new OrderQuery();
$queryOrder->date = time();

/**
 * required rule: $order_id not empty || $uqpay_order_id not empty
 */
$queryOrder->order_id = 'your origin order id';
$queryOrder->uqpay_order_id = 'your origin order uqpay order id';

try {
	$re_result = $uqpay_gateway_merchant->query( $queryOrder );
	var_dump($re_result);
} catch ( ReflectionException $e ) {
	var_dump($e->getMessage());
} catch ( \uqpay\payment\config\security\SecurityUqpayException $e ) {
	var_dump($e->getMessage());
} catch ( \uqpay\payment\UqpayException $e ) {
	var_dump($e->getMessage());
}