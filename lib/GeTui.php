<?php
/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/15
 * Time: 下午3:07
 */
//集成个推第三方推送操作类
/*
 * 调用示例
$comment=new GeTui();
$comment->setCID('6199abf37fbd41c2e82bdd9338feb0a4');
$test=array('Code'=>0,
    'Message'=>"透传数据测试",
    'Data'=>array(
        'data1'=>"asdasdad",
        'data2'=>123123123123,
        'data3'=>"测试"
    )
);

$comment->setTransmissionContent(json_encode($test));
$comment->pushMessageToSingle();
*/
header("Content-Type: text/html; charset=utf-8");

require_once(dirname(dirname(__FILE__)) . '/GeTui_SDK/IGt.Push.php');
require_once(dirname(dirname(__FILE__)) . '/GeTui_SDK/igetui/IGt.AppMessage.php');
require_once(dirname(dirname(__FILE__)) . '/GeTui_SDK/igetui/IGt.APNPayload.php');
require_once(dirname(dirname(__FILE__)) . '/GeTui_SDK/igetui/template/IGt.BaseTemplate.php');
require_once(dirname(dirname(__FILE__)) . '/GeTui_SDK/IGt.Batch.php');

class  GeTui
{
    private $CID = '';   //clienid
    private $DEVICETOKEN = '';
    private $Alias = '';
    private $BEGINTIME = '';
    private $ENDTIME = '';
    private $APPID = '';
    private $APPKEY = '';
    private $MASTERSECRET = '';
    private $HOST = '';
    private $transmissionContent = '';

    public function __construct()
    {

        $this->APPKEY = 'mA1FrFqO5C9NjCIlbu1A49';
        $this->APPID = 'PgyRGa57S28MjhbXEWW4V8';
        $this->MASTERSECRET = 'XbHojuMUgk5r7gtrYaIyn4';
        $this->HOST = 'http://sdk.open.api.igexin.com/apiex.htm';
    }

    public function setCID($CID)
    {
        $this->CID = $CID;
    }

    public function setDEVICETOKEN($DEVICETOKEN)
    {
        $this->DEVICETOKEN = $DEVICETOKEN;
    }

    public function setAlias($Alias)
    {
        $this->Alias = $Alias;
    }

    public function setBEGINTIME($BEGINTIME)
    {
        $this->BEGINTIME = $BEGINTIME;
    }


    public function setENDTIME($ENDTIME)
    {
        $this->ENDTIME = $ENDTIME;
    }


    public function setTransmissionContent($message)
    {
        $this->transmissionContent = $message;
    }

    function pushMessageToSingle()
    {
        $igt = new IGeTui($this->HOST, $this->APPKEY, $this->MASTERSECRET);


        $template = GeTui::IGtTransmissionTemplateDemo();

        //个推信息体
        $message = new IGtSingleMessage();

        $message->set_isOffline(true);//是否离线
        $message->set_offlineExpireTime(3600 * 12 * 1000);//离线时间
        $message->set_data($template);//设置推送消息类型
//	$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
        //接收方
        $target = new IGtTarget();
        $target->set_appId($this->APPID);
        $target->set_clientId($this->CID);
//    $target->set_alias(Alias);


        try {
            $rep = $igt->pushMessageToSingle($message, $target);
            // var_dump($rep);
            echo("<br><br>");

        } catch (RequestException $e) {
            $requstId = e . getRequestId();
            $rep = $igt->pushMessageToSingle($message, $target, $requstId);
            // var_dump($rep);
            echo("<br><br>");
        }

    }

    function IGtTransmissionTemplateDemo()
    {
        $template = new IGtTransmissionTemplate();
        $template->set_appId($this->APPID);//应用appid
        $template->set_appkey($this->APPKEY);//应用appkey
        $template->set_transmissionType(1);//透传消息类型


        $template->set_transmissionContent($this->transmissionContent);//透传内容
        //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息

        //APN高级推送
        $apn = new IGtAPNPayload();
        $alertmsg = new DictionaryAlertMsg();
        $alertmsg->body = "body";
        $alertmsg->actionLocKey = "ActionLockey";
        $alertmsg->locKey = "LocKey";
        $alertmsg->locArgs = array("locargs");
        $alertmsg->launchImage = "launchimage";
//        IOS8.2 支持
        $alertmsg->title = "Title";
        $alertmsg->titleLocKey = "TitleLocKey";
        $alertmsg->titleLocArgs = array("TitleLocArg");

        $apn->alertMsg = $alertmsg;
        $apn->badge = 7;
        $apn->sound = "";
        $apn->add_customMsg("payload", "payload");
        $apn->contentAvailable = 1;
        $apn->category = "ACTIONABLE";
        $template->set_apnInfo($apn);

        return $template;
    }


}
