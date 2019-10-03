<?php
require_once dirname( __FILE__ ) . '/vendor/autoload.php';

use uqpay\payment\config\ConfigOfAPI;
use uqpay\payment\Constants;
use uqpay\payment\Gateway;
use uqpay\payment\model\BankCard;
use uqpay\payment\model\HttpClientInterface;
use uqpay\payment\model\MerchantRegister;
use uqpay\payment\model\PaymentOrder;
use uqpay\payment\PayMethodHelper;

$merchant_id = 1005004;
$prv_key = file_get_contents(dirname(__FILE__).'/merchant_prv.pem');
$pub_key = file_get_contents(dirname(__FILE__).'/UQPAY_pub.pem');

// under test mode all request will call the test sandbox of UQPAY, and for default the test mode is on
$test_mode = true;

$uqpay_config = ConfigOfAPI::builder(
	$prv_key,
	Constants::SIGN_TYPE_RSA,
	$pub_key,
	$merchant_id,
	$test_mode
);

$uqpay_gateway = new Gateway($uqpay_config);

/**
 * Implementing HttpClientInterface
 * here we just use curl
 **/
class HttpClient implements HttpClientInterface {
	public function post( array $headers, $body, $url ) {
		$curl_headers = array();
		$curl_headers[] = 'Content-type: '.$headers['content-type'];
		$curl_headers[] = 'UQPAY-Version: '.$headers['UQPAY-Version'];
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $curl_headers);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		$res = curl_exec($curl);
		curl_close($curl);
		return $res;
	}
}
$uqpay_gateway->setHttpClient(new HttpClient());

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
$result = $uqpay_gateway->pay($payment_order, $bank_card);
var_dump($result);


// test as a partner
$partner_id = 1005238;
$partner_prv_key = file_get_contents(dirname(__FILE__).'/partner_prv.pem');
$partner_pub_key = file_get_contents(dirname(__FILE__).'/partner_UQPAY_pub.pem');

$uqpay_config = ConfigOfAPI::builder(
	$partner_prv_key,
	Constants::SIGN_TYPE_RSA,
	$partner_pub_key,
	$partner_id,
	$test_mode,
	false
);

$uqpay_gateway = new Gateway($uqpay_config);
$uqpay_gateway->setHttpClient(new HttpClient());

$merchantRegister = new MerchantRegister();
$merchantRegister->name = 'test merchant from php';
$merchantRegister->abbr = 'php';
$merchantRegister->register_email = 'php@qq.com';
$merchantRegister->company_name = 'php company';
$merchantRegister->company_register_num = '123456789';
$merchantRegister->company_register_address = 'hangzhou';
$merchantRegister->company_register_country = 'CN';
$merchantRegister->mcc='0742';

$merchantRegister->date = time();

$re_result = $uqpay_gateway->register($merchantRegister);
var_dump($re_result);
