<?php

namespace app\controllers;
use app\models\Test;
use uqpay\payment\sdk\models\common\BankCardDTO;
use uqpay\payment\sdk\models\common\BaseJsonRequestDTO;
use uqpay\payment\sdk\models\common\PageRequestDTO;
use uqpay\payment\sdk\models\common\ServerHostDTO;
use uqpay\payment\sdk\models\emvco\EmvcoCreateDTO;
use uqpay\payment\sdk\models\emvco\EmvcoGetPayloadDTO;
use uqpay\payment\sdk\models\enroll\EnrollOrder;
use uqpay\payment\sdk\models\enroll\VerifyOrder;
use uqpay\payment\sdk\models\exchangeRate\ExchangeRateQueryDTO;
use uqpay\payment\sdk\models\merchant\ConfigPaymentDTO;
use uqpay\payment\sdk\models\merchant\DownloadCheckingFileDTO;
use uqpay\payment\sdk\models\merchant\MerchantRegisterDTO;
use uqpay\payment\sdk\models\operation\OrderCancel;
use uqpay\payment\sdk\models\operation\OrderQuery;
use uqpay\payment\sdk\models\operation\OrderRefund;
use uqpay\payment\sdk\models\pay\PayOrder;
use uqpay\payment\sdk\models\common\MerchantHostDTO;
use uqpay\payment\sdk\utils\payMethod;
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
    function actionMerchantDetail(){
        $postArray = Yii::$app->request->post();
        $requestDto=new BaseJsonRequestDTO();
        $requestDto->attributes = $postArray;
        $result = $this->uqpay->queryMerchantDetail($requestDto);
        return $result;
    }
    function actionMerchantList(){
        $postArray = Yii::$app->request->post();
        $requestDto=new PageRequestDTO();
        $requestDto->attributes = $postArray;
        $result = $this->uqpay->queryMerchantList($requestDto);
        return $result;
    }
    function actionConfigPay(){
        $postArray = Yii::$app->request->post();
        $requestDto=new ConfigPaymentDTO();
        $requestDto->attributes = $postArray;
        $result = $this->uqpay->configPayMethod($requestDto);
        return $result;
    }
    function actionConfiguredPay(){
        $postArray = Yii::$app->request->post();
        $requestDto=new BaseJsonRequestDTO();
        $requestDto->attributes = $postArray;
        $result = $this->uqpay->queryConfiguredPayMethod($requestDto);
        return $result;
    }
    function actionDownloadCheckingFile(){
        $postArray = Yii::$app->request->post();
        $requestDto=new DownloadCheckingFileDTO();
        $requestDto->attributes = $postArray;
        $result = $this->uqpay->downloadCheckingFiles($requestDto,dirname(__FILE__));
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

    function actionRefund(){
        $postArray = Yii::$app->request->post();
        $orderRefundDto = new OrderRefund();
        $orderRefundDto->attributes = $postArray;
        $orderRefundDto->date=round(microtime(true)*1000);
        $result= $this->uqpay->Refund($orderRefundDto);
        echo json_encode($result);
    }

    function actionQuery(){
        $postArray = Yii::$app->request->post();
        $orderQueryDto = new OrderQuery();
        $orderQueryDto->attributes = $postArray;
        $result= $this->uqpay->Query($orderQueryDto);
        echo json_encode($result);
    }

    function actionCancel(){
        $postArray = Yii::$app->request->post();
        $paramsMap = new OrderCancel();
        $paramsMap->attributes = $postArray;
        $paramsMap->date=round(microtime(true)*1000);
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
       $test = new Test();
       $test->validate();
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
