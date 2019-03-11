<?php

use uqpay\payment\sdk\models\config\AppgateConfig;
use uqpay\payment\sdk\models\config\cashierConfig;
use uqpay\payment\sdk\models\config\merchantConfig;
use uqpay\payment\sdk\models\config\paygateConfig;
use uqpay\payment\sdk\models\config\SecureConfig;
use uqpay\payment\sdk\UqpayApi;

$paygateConfig = new paygateConfig();
$paygateConfig->apiRoot="http://paygate.uqpay.cn";
$paygateConfig->testMode = true;
$paygateConfig->testRSA=new SecureConfig(['publicKeyPath'=>'UQPAY_pub.pem','privateKeyPath'=>'resource/MerchantID_prv.pem']);
$merchantConfig = new merchantConfig();
$merchantConfig->agentId=1005167;
$merchantConfig->id=0;
$cashierConfig = new cashierConfig();
$appgateConfig = new AppgateConfig();
$appgateConfig->apiRoot = 'http://localhost:8089/';
$appgateConfig->testMode = true;
$appgateConfig->testRSA=new SecureConfig(['publicKeyPath'=>'partner_uqpay_pub.pem','privateKeyPath'=>'1005167_prv.pem']);
$uqpay = new UqpayApi($paygateConfig,$merchantConfig,$cashierConfig,$appgateConfig);

return $uqpay;
