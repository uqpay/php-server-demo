<?php

use uqpay\payment\sdk\models\config\AppgateConfig;
use uqpay\payment\sdk\models\config\cashierConfig;
use uqpay\payment\sdk\models\config\merchantConfig;
use uqpay\payment\sdk\models\config\paygateConfig;
use uqpay\payment\sdk\models\config\SecureConfig;
use \uqpay\payment\sdk\models\config\SecretKey;
use uqpay\payment\sdk\UqpayApi;

$paygateConfig = new paygateConfig();
$paygateConfig->apiRoot="http://paygate.uqpay.cn";
$paygateConfig->testMode = true;
$encipher = new SecretKey();
$decipher = new SecretKey();
$encipher->path='MerchantID_prv.pem';
$decipher->path='UQPAY_pub.pem';
$paygateConfig->testSecure=new SecureConfig();
$paygateConfig->testSecure->encipher=$encipher;
$paygateConfig->testSecure->decipher=$decipher;
$merchantConfig = new merchantConfig();
$merchantConfig->agentId=1005167;
$merchantConfig->id=0;
$cashierConfig = new cashierConfig();
$appgateConfig = new AppgateConfig();
$appgateConfig->apiRoot = 'http://localhost:8089/';
$appgateConfig->testMode = true;
$appgate_encipher = new SecretKey();
$appgate_decipher = new SecretKey();
$appgate_encipher->path='1005167_prv.pem';
$appgate_decipher->path='partner_uqpay_pub.pem';
$appgateConfig->testSecure=new SecureConfig();
$appgateConfig->testSecure->encipher=$appgate_encipher;
$appgateConfig->testSecure->decipher=$appgate_decipher;
$uqpay = new UqpayApi($paygateConfig,$merchantConfig,$cashierConfig,$appgateConfig);

return $uqpay;
