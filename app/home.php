<?php

namespace app;

use uqpay\payment\sdk\config\RSAconfig;
use uqpay\payment\sdk\sdk;
use uqpay\payment\sdk\config\cashierConfig;
use uqpay\payment\sdk\config\merchantConfig;
use uqpay\payment\sdk\config\paygateConfig;
use uqpay\payment\sdk\utils\payMethod;
use uqpay\payment\sdk\utils\payUtil;
use core\core;

session_start();


class home extends core
{
    private $sdk;

    function __construct()
    {
        $rsaConfig = new RSAconfig(array(
            "publicKeyPath"=>"UQPAY_pub.pem", //You can set UQPAY public key path here
            "privateKeyPath"=>"1005004_prv.pem", //You can set you private key path here
        ));

        $cashierConfig = new cashierConfig(array(
            "apiRoot"=>"https://cashier.uqpay.com" ,
        ));
        $merchantConfig = new merchantConfig(array("id"=>'1005004')); //Set your merchant ID or partner ID;
        $paygateConfig = new paygateConfig(array(
            "apiRoot"=>"http://openapi.uapay.com",
            "rsaConfig"=>$rsaConfig
        ));
        $this->sdk = new sdk($paygateConfig,$merchantConfig,$cashierConfig);
    }

    function index()
    {
        function generateOrderId($figure)
        {
            if (is_int($figure)) {
                if ($figure == 0) {
                    return "";
                }
                $result = "";
                for ($i = 0; $i < $figure; $i++) {
                    $result = $result . rand(0, 9);
                }
                return $result;
            }
        }
        $merchantId = $this->sdk->merchantConfig->id;
        $date = time() * 1000;
        $orderId = generateOrderId(12);
        $this->assign('merchantId', $merchantId);
        $this->assign('orderId', $orderId);
        $this->assign('date', $date);
        $this->display('templates/demo/index');
    }

    function paygate()
    {
        $phpInput = file_get_contents('php://input');
        parse_str($phpInput, $getArray);
        $this->assign('scenes', '');
        $this->assign('methodId', '');
        $this->assign('result', null);
        $payUtil = new payUtil();
        $config = $this->sdk->paygateConfig;
        $config->apiRoot=$this->sdk->cashierConfig->apiRoot;
        if (strcmp($getArray["payment"], "cashier") === 0) {
            header("location: " . $payUtil->generateCashierLink($getArray, $config));
            return;
        } else {
            $_SESSION["demo"] = serialize($getArray);
            $this->display("templates/demo/paygate");
        }
    }

    function pay()
    {
        $this->sdk->paygateConfig->apiRoot = 'http://192.168.1.174:8084';
        $phpInput = file_get_contents('php://input');
        parse_str($phpInput, $getArray);
        $demoVo = unserialize($_SESSION["demo"]);
        $payMethodObject = new payMethod();
        $payMethod = $payMethodObject->payMethod();
        $UqpayScanType = $payMethodObject->UqpayScanType;
        $scenes = $payMethod[$getArray["methodId"]];
        $this->assign('scenes', $scenes);
        $payData = $demoVo;
        $payData["methodId"] = $getArray["methodId"];
        $payData["client"] = $getArray["client"];
        $scenes = $payMethod[$getArray["methodId"]];
        $count=count($getArray);
        $needCardInfo = false;
        switch ($scenes) {
            case "InApp":
                break;
            case "QRCode":
                $payData["scanType"]=$UqpayScanType["Consumer"];
                break;
            case "RedirectPay":
                $payData["returnUrl"]=$demoVo["returnUrl"];
                break;
            case "ThreeDCreditCard":
                $payData["returnUrl"]=$demoVo["returnUrl"];
            case "CreditCard":
            case "MerchantHost":
                $needCardInfo = true;
                break;
            default:
                $this->assign('hasError', "Not Support Pay Method");
        }

        if($needCardInfo){
            $result = $this->sdk->pay($getArray,$payData);
        }else {
            $result = $this->sdk->pay($payData);
        }
        $this->assign('result', (object) $result);
        $this->assign('methodId', $getArray["methodId"]);
        $this->assign('scenes', $scenes);
        $this->display("templates/demo/paygate");
    }

    function post()
    {
        $data = array(
            "name" => "Lei",
            "msg" => "Are you OK?"
        );
        $this->httpArrayPost(ORDER_ID, $data);
    }

    function jsonPost()
    {
        $body = file_get_contents('php://input'); //获取post请求内容
        $data = '{"name":"Lei","msg":"Are you OK?"}';
    }

    //set方法
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    //get方法
    public function __get($name)
    {
        if (!isset($this->$name)) {
            //未设置
            $this->$name = "";
        }
        return $this->$name;
    }
}

class Builder
{
    private $test;
    public $paygateConfig;
    public $merchantConfig;

    public function paygateConfig($config)
    {
        $this->test = new paygateConfig();
        if ($config == null) throw new \Exception("uqpay paygate config == null");
        if ($config["RSA"] == null) throw new \Exception("uqpay paygate config miss rsa config");
        $this->paygateConfig = (object)array_merge($config, (array)$this->test);
        return $this->paygateConfig;
    }

    public function merchantConfig($config)
    {
        $this->test = new merchantConfig();
        if ($config == null) throw new \Exception("uqpay paygate config == null");
        if ($config["id"] == null) throw new \Exception("uqpay merchant config miss merchant account id");
        $this->merchantConfig = (object)array_merge($config, (array)$this->test);
        return $this->merchantConfig;
    }
}

