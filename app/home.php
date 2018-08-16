<?php

namespace app;

use sdk\config\cashierConfig;
use sdk\config\merchantConfig;
use sdk\config\paygateConfig;
use core\core;
use sdk\util\payUtil;
use \sdk\sdk;


session_start();


class home extends core
{
    private $sdk;

    function __construct()
    {
        $this->sdk = new sdk();
        $this->sdk->merchantConfig->id='1005004';
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
        $config = new cashierConfig();
        if (strcmp($getArray["payment"], "cashier") === 0) {
//            $payUtil->generateCashierLink($getArray, $config);
            header("location: " . $payUtil->generateCashierLink($getArray, $config));
            return;
        } else {
            $_SESSION["demo"] = serialize($getArray);
            $this->display("templates/demo/paygate");
        }
    }

    function pay()
    {
        $phpInput = file_get_contents('php://input');
        parse_str($phpInput, $getArray);
        $demoVo = unserialize($_SESSION["demo"]);
        global $payMethod;
        $scenes = $payMethod[$getArray["methodId"]];
        $this->assign('scenes', $scenes);
        $payData = $demoVo;
        $payData["methodId"] = $getArray["methodId"];
        switch ($scenes) {
            case "QRCode":
                global $UqpayScanType;
                $payData["scantype"] = $UqpayScanType["Consumer"];
                $result = $this->sdk->QRCodePayment($payData);
                $this->assign('result', $result);
                break;
            case "OnlinePay":
                $payData["returnUrl"] = $demoVo["returnUrl"];
                $onlineRedirect = $this->sdk->OnlinePayment($payData);
                return header("location: " . $onlineRedirect);
                break;
            case "CreditCard":
                $cardResult = $this->sdk->CreditCardPayment($getArray, $payData);
                $this->assign('result', $cardResult);
                break;
            case "ThreeDCreditCard":
                $redirectUrl = $this->sdk->ThreeDSecurePayment($getArray, $payData);
                return header("location: " . $redirectUrl);
            case "InApp":
                $inAppResult = $this->sdk->InAppPayment($payData);
                $this->assign('result', $inAppResult);
        }
//    model.addAttribute("hasError", "不支持的支付方式");
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

