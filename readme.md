# eucp for Laravel5.5/5.6
>亿美短信平台接口

## Installation/安装
```shell
composer require lambq/eucp
```

### laravel 5.*
> 在laravel config/app.php里面的providers添加下面的代码

```php
Lambq\Eucp\EucpServiceProvider::class
```

### 发布laravel扩展包
> 生成一个配置文件sdk.php 在 config文件夹下面

```shell
php artisan vendor:publish
```

## 配置

### 修改config/eucp.php文件内容

```php
return [
    'ym_sms_addr'    => "100.100.11.68:8999", /*接口地址,请联系销售获取*/
    'ym_sms_send_uri'   => '/simpleinter/sendSMS',/*发送单条短信接口*/
    'ym_sms_send_per_uri'                => '/simpleinter/sendPersonalitySMS',/*发送个性短信接口*/
    'ym_sms_getreport_uri'               => "/simpleinter/getReport",/*获取状态报告接口*/
    'ym_sms_getmo_uri'               => "/simpleinter/getMo",/*获取上行接口*/
    'ym_sms_getbalance_uri'               => "/simpleinter/getBalance",/*获取余额接口*/
    'ym_sms_appid'               => "EUCe-EMt-SMS9-XXXXX",/*APPID,请联系销售或者在页面获取*/
    'ym_sms_aespwd'               => "1234567893214567",/*密钥，请联系销售或者在页面获取*/
    'end'               =>  "\n",
];
```
## 使用
> 可调用的文件都在 Facades 文件里面