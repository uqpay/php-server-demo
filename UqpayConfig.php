<?php

use tj\sdk\test\models\config\AppgateConfig;
use tj\sdk\test\models\config\cashierConfig;
use tj\sdk\test\models\config\merchantConfig;
use tj\sdk\test\models\config\paygateConfig;
use tj\sdk\test\models\config\SecureConfig;
use tj\sdk\test\UqpayApi;

$paygateConfig = new paygateConfig();
$paygateConfig->apiRoot="http://localhost:8080/";
$paygateConfig->testMode = true;
$paygateConfig->testRSA=new SecureConfig(['publicKeyPath'=>'UQPAY_pub.pem','privateKeyPath'=>'1005004_prv.pem']);
$merchantConfig = new merchantConfig();
$merchantConfig->id='1005004';
$cashierConfig = new cashierConfig();
$appgateConfig = new AppgateConfig();
$uqpay = new UqpayApi($paygateConfig,$merchantConfig,$cashierConfig,$appgateConfig);

return $uqpay;
