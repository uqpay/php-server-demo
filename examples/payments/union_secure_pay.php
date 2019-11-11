<?php
use uqpay\payment\model\PaymentOrder;
use uqpay\payment\PayMethodHelper;

include dirname( __FILE__ ) . '/../config.php';

/**
 * redirect payment
 * for this kind of payment, the library will NOT request UQPAY Server from server side,
 * just help user package the data, which will be post to UQPAY Server by client side.
 * here we use union secure pay as an example
 **/

$payment_order = new PaymentOrder();
$payment_order->method_id = PayMethodHelper::UNION_SECURE_PAY;
$payment_order->order_id = time();
$payment_order->trans_name = 'product name';
$payment_order->amount = 1;
$payment_order->currency = 'HKD';
$payment_order->date = time();
$payment_order->client_ip = '127.0.0.1';

// after payment finished (success or failed), UQPAY will send an message to this url
$payment_order->callback_url = 'https://localhost:8080/async';

// after consumer paid on unionPay cashier, will be redirect to this url
$payment_order->return_url = 'https://localhost:8080/sync';

try {
	$result = $uqpay_gateway_merchant->pay( $payment_order );
	/**
	 * client side use the value of $result->redirect to generate a form request
	 * like this(just an example you can do better for production env):
	 * <form action="{{$result->redirect->url}}" method="post">
	 * @foreach ($body as $name => $value)
	 *  <input type="hidden" name="{{$name}}" value="{{$value}}" />
	 * @endforeach
	 * </form>
	 */
	var_dump($result->redirect);
} catch ( ReflectionException $e ) {
	// the library need ReflectionClass
} catch ( \uqpay\payment\config\security\SecurityUqpayException $e ) {
	// this means you lost some parameters for authentication， eg: merchant ID, RSA key ...
	var_dump($e->getMessage());
} catch ( \uqpay\payment\UqpayException $e ) {
	// this means the payment is failed, you can get more detail by check $e->message
	var_dump($e->getMessage());
}
