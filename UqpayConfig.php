<?php

use uqpay\payment\sdk\models\config\AppgateConfig;
use uqpay\payment\sdk\models\config\cashierConfig;
use uqpay\payment\sdk\models\config\merchantConfig;
use uqpay\payment\sdk\models\config\paygateConfig;
use uqpay\payment\sdk\models\config\SecureConfig;
use uqpay\payment\sdk\UqpayApi;

$paygateConfig = new paygateConfig();
$paygateConfig->apiRoot="http://localhost:8080/";
$paygateConfig->testMode = true;
$paygateConfig->testRSA=new SecureConfig(['publicKeyPath'=>'UQPAY_pub.pem','privateKeyPath'=>'MerchantID_prv.pem']);
$merchantConfig = new merchantConfig();
$merchantConfig->id='1005004';
$cashierConfig = new cashierConfig();
$appgateConfig = new AppgateConfig();
$uqpay = new UqpayApi($paygateConfig,$merchantConfig,$cashierConfig,$appgateConfig);

return $uqpay;
