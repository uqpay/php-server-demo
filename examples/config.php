<?php
require_once dirname( __FILE__ ) . '/../vendor/autoload.php';

use uqpay\payment\config\ConfigOfAPI;
use uqpay\payment\Constants;
use uqpay\payment\Gateway;
use uqpay\payment\model\HttpClientInterface;

$merchant_id = 1005004;
$prv_key = file_get_contents(dirname(__FILE__).'/../merchant_prv.pem');
$pub_key = file_get_contents(dirname(__FILE__).'/../UQPAY_pub.pem');

// under test mode all request will call the test sandbox of UQPAY, and for default the test mode is on
$test_mode = true;

$uqpay_config_merchant = ConfigOfAPI::builder(
	$prv_key,
	Constants::SIGN_TYPE_RSA,
	$pub_key,
	$merchant_id,
	$test_mode
);

$uqpay_gateway_merchant = new Gateway($uqpay_config_merchant);

/**
 * Implementing HttpClientInterface
 * here we just use curl
 **/
class HttpClient implements HttpClientInterface {
	public function post( array $headers, $body, $url ) {
		var_dump($body);
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
$uqpay_gateway_merchant->setHttpClient(new HttpClient());

// test as a partner
$partner_id = 1005209;
$partner_prv_key = file_get_contents(dirname(__FILE__).'/../partner_prv.pem');
$partner_pub_key = file_get_contents(dirname(__FILE__).'/../partner_UQPAY_pub.pem');

$uqpay_config_partner = ConfigOfAPI::builder(
	$partner_prv_key,
	Constants::SIGN_TYPE_RSA,
	$partner_pub_key,
	$partner_id,
	$test_mode,
	false
);

$uqpay_gateway_partner = new Gateway($uqpay_config_partner);
$uqpay_gateway_partner->setHttpClient(new HttpClient());
