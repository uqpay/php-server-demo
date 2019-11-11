<?php

use uqpay\payment\model\MerchantRegister;

include dirname( __FILE__ ) . '/../config.php';

$merchantRegister = new MerchantRegister();
$merchantRegister->name = 'test';
$merchantRegister->abbr = 'test';
$merchantRegister->register_email = 'info@ccpay.sg';
$merchantRegister->company_name = 'test';
$merchantRegister->company_register_num = 'test';
$merchantRegister->company_register_address = 'test';
$merchantRegister->company_register_country = 'SG';
$merchantRegister->mcc='5411';

$merchantRegister->date = 1570086441150;

try {
	$re_result = $uqpay_gateway_partner->register( $merchantRegister );
	var_dump($re_result);
} catch ( ReflectionException $e ) {
	var_dump($e->getMessage());
} catch ( \uqpay\payment\config\security\SecurityUqpayException $e ) {
	var_dump($e->getMessage());
} catch ( \uqpay\payment\UqpayException $e ) {
	var_dump($e->getMessage());
}
