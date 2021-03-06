<?php
namespace Lambq\Eucp;


class eucp
{
    protected $config;

    public function __construct() {
        $this->config   = config('eucp');
    }
    public function sms_curl($url, $data)
    {
        $data = http_build_query($data);
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt( $ch, CURLOPT_URL , $url);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            return false;
        }
        curl_close( $ch );
        return $response;
    }
    function signmd5($appId,$secretKey,$timestamp){
        return md5($appId.$secretKey.$timestamp);
    }
    function sendSMS()
    {
        $content = "【某某公司】您的验证码是123&st=xxx";/* 短信内容请以商务约定的为准，如果已经在通道端绑定了签名，则无需在这里添加签名 */
        $timestamp = date("YmdHis");
        $sign = $this->signmd5($this->config['ym_sms_appid'],$this->config['ym_sms_aespwd'],$timestamp);
        // 如果您的系统环境不是UTF-8，需要转码到UTF-8。如下：从gb2312转到了UTF-8
        // $content = mb_convert_encoding( $content,"UTF-8","gb2312");
        // 另外，如果包含特殊字符，需要对内容进行urlencode
        $data = [
            "appId" => $this->config['ym_sms_appid'],
            "timestamp" => $timestamp,
            "sign" => $sign,
            "mobiles" => "18001000000,18001000001",
            "content" =>  $content,
            "customSmsId" => "10001",
            "timerTime" => "20170910110200",
            "extendedCode" => "1234"
        ];
        $url = $this->config['ym_sms_addr'].$this->config['ym_sms_send_uri'];
        $resobj = $this->http_request($url, $data);
    }
    function sendTo($phone,$content)
    {
        $timestamp = date("YmdHis");
        $sign = $this->signmd5($this->config['ym_sms_appid'],$this->config['ym_sms_aespwd'],$timestamp);
        // 如果您的系统环境不是UTF-8，需要转码到UTF-8。如下：从gb2312转到了UTF-8
//        $content = mb_convert_encoding($content,"UTF-8","gb2312");
        // 另外，如果包含特殊字符，需要对内容进行urlencode
        $data = [
            "appId" => $this->config['ym_sms_appid'],
            "timestamp" => $timestamp,
            "sign" => $sign,
            "mobiles" => $phone,
            "content" =>  $content, /* 短信内容请以商务约定的为准，如果已经在通道端绑定了签名，则无需在这里添加签名 */
            "customSmsId" => "10001",
            "extendedCode" => "1234"
        ];
        $url = $this->config['ym_sms_addr'].$this->config['ym_sms_send_uri'];
        return $this->sms_curl($url, $data);
    }
    function setPersonalitySms()
    {
        $mobile1 = "18001000000";
        $content1 = "今天天气不错啊&st=xxx";
        $mobile2 = "18001000001";
        $content2 = "今天天气不错";
        $timestamp = date("YmdHis");
        $sign = $this->signmd5($this->config['ym_sms_appid'],$this->config['ym_sms_aespwd'],$timestamp);
        // 如果您的系统环境不是UTF-8，需要转码到UTF-8。如下：从gb2312转到了UTF-8
        // $content = mb_convert_encoding( $content,"UTF-8","gb2312");
        // 另外，如果包含特殊字符，需要对内容进行urlencode
        $data = [
            "appId" => $this->config['ym_sms_appid'],
            "timestamp" => $timestamp,
            "sign" => $sign,
            $mobile1 => $content1,
            $mobile2 => $content2,
            "customSmsId" => "10001",
            "timerTime" => "20170910110200",
            "extendedCode" => "1234"
        ];
        $url = $this->config['ym_sms_addr'].$this->config['ym_sms_send_per_uri'];
        $resobj = $this->http_request($url, $data);
    }
    function getReport()
    {
        $timestamp = date("YmdHis");
        $sign = $this->signmd5($this->config['ym_sms_appid'],$this->config['ym_sms_aespwd'],$timestamp);
        $data = [
            "appId" => $this->config['ym_sms_appid'],
            "timestamp" => $timestamp,
            "sign" => $sign,
            "number" => "300"
        ];
        $url = $this->config['ym_sms_addr'].$this->config['ym_sms_getreport_uri'];
        $resobj = $this->http_request($url, $data);
    }
    function getMo()
    {
        $timestamp = date("YmdHis");
        $sign = $this->signmd5($this->config['ym_sms_appid'],$this->config['ym_sms_aespwd'],$timestamp);
        $data = [
            "appId" => $this->config['ym_sms_appid'],
            "timestamp" => $timestamp,
            "sign" => $sign,
            "number" => "300"
        ];
        $url = $this->config['ym_sms_addr'].$this->config['ym_sms_getmo_uri'];
        $resobj = $this->http_request($url, $data);
    }
    function getBalance()
    {
        $timestamp = date("YmdHis");
        $sign = $this->signmd5($this->config['ym_sms_appid'],$this->config['ym_sms_aespwd'],$timestamp);
        $data = [
            "appId" => $this->config['ym_sms_appid'],
            "timestamp" => $timestamp,
            "sign" => $sign
        ];
        $url = $this->config['ym_sms_addr'].$this->config['ym_sms_getbalance_uri'];
        $resobj = $this->http_request($url,$data);
    }
//    public function run(){
//        echo "***************测试短信发送START***************\n";
//        $this->SendSMS();
//        echo "\n";
//        echo "***************测试短信发送END***************\n";
//
//        echo "***************测试个性短信发送START***************\n";
//        $this->setPersonalitySms();
//        echo "\n";
//        echo "***************测试个性短信发送END***************\n";
//
//        echo "***************测试获取余额START***************\n";
//        $this->getBalance();
//        echo "\n";
//        echo "***************测试获取余额END***************\n";
//
//        echo "***************测试获取状态报告START***************\n";
//        $this->getReport();
//        echo "\n";
//        echo "***************测试获取状态报告END***************\n";
//
//        echo "***************测试获取上行START***************\n";
//        $this->getMo();
//        echo "\n";
//        echo "***************测试获取上行END***************\n";
//
//    }
}