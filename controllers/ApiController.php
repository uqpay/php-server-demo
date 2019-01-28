<?php

namespace app\controllers;
use tj\sdk\test\models\common\BankCardDTO;
use tj\sdk\test\models\common\ServerHostDTO;
use tj\sdk\test\models\emvco\EmvcoCreateDTO;
use tj\sdk\test\models\emvco\EmvcoGetPayloadDTO;
use tj\sdk\test\models\enroll\EnrollOrder;
use tj\sdk\test\models\enroll\VerifyOrder;
use tj\sdk\test\models\exchangeRate\ExchangeRateQueryDTO;
use tj\sdk\test\models\merchant\MerchantRegisterDTO;
use tj\sdk\test\models\operation\OrderCancel;
use tj\sdk\test\models\operation\OrderQuery;
use tj\sdk\test\models\operation\OrderRefund;
use tj\sdk\test\models\pay\PayOrder;
use tj\sdk\test\models\common\MerchantHostDTO;
use tj\sdk\test\utils\payMethod;
use yii\web\Controller;
use Yii;



class ApiController extends Controller
{
    public $uqpay;
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        $this->uqpay=require '../UqpayConfig.php';
    }



//===========================================
// Pay API
//===========================================

    /**
     * @return false|string
     */

//PayOrder $order
    public function actionPay()
    {
        $postArray = Yii::$app->request->post();
        $postArray["amount"]=(double)$postArray["amount"];
        $payMethod=new payMethod();
        $payData = new PayOrder();
        $payData->attributes=$postArray;
        $payData->date=round(microtime(true)*1000);;
        $scenes='';
        if(array_key_exists('methodId',$postArray)){
            $scenes = $payMethod->payMethod()[$postArray["methodId"]];
        }
        $needCardInfo = false;
        switch ($scenes) {
            case "InApp":
                break;
            case "QRCode":
                break;
            case "OnlinePay":
                /** for online pay, if you use the SDK, you will get a special result
                 * because for the online pay, the pay request must send from the client side,
                 * so the SDK just generate a post data {@link RedirectPostData}, you can return this data to client.
                 */
                $payData->returnUrl = $postArray["returnUrl"];
                break;
            case "ThreeDCreditCard":
                break;
            case "CreditCard":
                $needCardInfo = true;
                break;
            case "MerchantHost":
                $merchantHost = new MerchantHostDTO();
                $merchantHost->attributes=$postArray;
                $payData->merchantHost=$merchantHost;
                break;
            case "ServerHost":
                $serverHost = new ServerHostDTO();
                $serverHost->attributes=$postArray;
                $payData->serverHost=$serverHost;
                break;
            default:
        }
        if($needCardInfo){
            $cardInfo = new BankCardDTO();
            $cardInfo->attributes = $postArray;
            $payData->bankCard = $cardInfo;
            $result =$this->uqpay->Pay($payData);
        }else {
            $result =$this->uqpay->Pay($payData);
        }
        return json_encode($result);
    }


    function actionRegister(){
        $postArray = Yii::$app->request->post();
        $registerDto=new MerchantRegisterDTO();
        $registerDto->attributes = $postArray;
        $result = $this->uqpay->register($registerDto);
        return $result;
    }

    function actionQueryExchangeRate(){
        $postArray = Yii::$app->request->post();
        $queryDto=new ExchangeRateQueryDTO();
        $queryDto->attributes = $postArray;
        $result = $this->uqpay->queryExchangeRate($queryDto);
        echo json_encode($result);
    }
    function actionQrCodeCreate(){
        $postArray = Yii::$app->request->post();
        $createDto = new EmvcoCreateDTO();
        $createDto->attributes = $postArray;
        $result= $this->uqpay->createQRCode($createDto);
        echo json_encode($result);
    }
    function actionQrCodePayload(){
        $postArray = Yii::$app->request->post();
        $payloadDTO = new EmvcoGetPayloadDTO();
        $payloadDTO->attributes = $postArray;
        $result= $this->uqpay->getQRCodePayload($payloadDTO);
        echo json_encode($result);
    }

    function actionRefundOrder(){
        $postArray = Yii::$app->request->post();
        $orderRefundDto = new OrderRefund();
        $orderRefundDto->attributes = $postArray;
        $result= $this->uqpay->Refund($orderRefundDto);
        echo json_encode($result);
    }

    function actionQueryOrder(){
        $postArray = Yii::$app->request->post();
        $orderQueryDto = new OrderQuery();
        $orderQueryDto->attributes = $postArray;
        $result= $this->uqpay->Query($orderQueryDto);
        echo json_encode($result);
    }

    function actionCancelOrder(){
        $postArray = Yii::$app->request->post();
        $paramsMap = new OrderCancel();
        $paramsMap->attributes = $postArray;
        $paramsMap->transType="cancel";
        $result= $this->uqpay->Cancel($paramsMap);
        echo json_encode($result);
    }

    function actionEnroll(){
        $postArray = Yii::$app->request->post();
        $enrollOrder = new EnrollOrder();
        $enrollOrder->attributes = $postArray;
        $enrollOrder->date=round(microtime(true)*1000);
        $enrollOrder->cvv = $postArray['cvv'];
        $enrollOrder->expireMonth = $postArray['expireMonth'];
        $enrollOrder->expireYear = $postArray['expireYear'];
        $result= $this->uqpay->EnrollCard($enrollOrder);
        echo json_encode($result);
    }

    function actionVerify(){
        $postArray = Yii::$app->request->post();
        $verifyDto = new VerifyOrder();
        $verifyDto->attributes = $postArray;
        $verifyDto->date=round(microtime(true)*1000);
        $verifyDto->transType = "verifycode";
        $result= $this->uqpay->verify($verifyDto);
        return json_encode($result);
    }

    public function actionIndex()
    {
       echo 'welcome';
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\controller\ApiController',
            ],
        ];
    }
}
