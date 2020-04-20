<?php

use uqpay\payment\Constants;
use uqpay\payment\model\PaymentResult;
use uqpay\payment\model\RefundResult;
use uqpay\payment\ModelHelper;

include dirname( __FILE__ ) . '/config.php';

$is_partner = false;

// step1 get the request body of notify

$request_body = $_POST;

// this is a compatibility processing，work in wordpress, for other web framework maybe no need, you need check by yourself
if ( isset( $_POST[ Constants::PAY_ORDER_EXTEND_INFO ] ) ) {
	$request_body[ Constants::PAY_ORDER_EXTEND_INFO ] = str_replace( '\\', '', $_POST[ Constants::PAY_ORDER_EXTEND_INFO ] );
}
if ( isset( $_POST[ Constants::PAY_ORDER_CHANNEL_INFO ] ) ) {
	$request_body[ Constants::PAY_ORDER_CHANNEL_INFO ] = str_replace( '\\', '', $_POST[ Constants::PAY_ORDER_CHANNEL_INFO ] );
}

// step2(recommend, but not coercive) verify the request body is from UQPAY
$sdk_config = $is_partner ? $uqpay_config_partner : $uqpay_config_merchant;
$verify     = false;
try {
	$verify = ModelHelper::verifyPaymentResult( $request_body, $sdk_config->getSecurity() );
} catch ( \uqpay\payment\config\security\SecurityUqpayException $e ) {
	var_dump( $e->getMessage() );
	$verify = false;
}

// step3 parse body
switch ( $request_body[ Constants::PAY_OPTIONS_TRADE_TYPE ] ) {
	case Constants::TRADE_TYPE_PAY:
		try {
			/** @var PaymentResult $payment_result */
			$payment_result = ModelHelper::parseResultData( $notification, PaymentResult::class );
			var_dump($payment_result);
		} catch ( ReflectionException $e ) {
			var_dump( $e->getMessage() );
		}
		break;
	case Constants::TRADE_TYPE_REFUND:
		/** @var RefundResult $refund_result */
		try {
			$refund_result = ModelHelper::parseResultData( $notification, RefundResult::class );
			var_dump($refund_result);
		} catch ( ReflectionException $e ) {
			var_dump( $e->getMessage() );
		}
		break;
}