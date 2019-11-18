# 山城清算 PHP SDK

023pay 的 PHP SDK; 对补全提示友好，对 Laravel 支持友好。

## 安装

使用 composer 安装
```bash
composer require 023pay/sdk
```

**若您是 laravel**

若是 laravel 5.5 以下，需要手工添加 `providers` 到 `config/app.php`
```php
'providers' => [
    // ...
    ShanchengPay\Laravel\ShanchengPayServiceProvider::class,
],
'aliases' => [
    'ShanchengPay' => ShanchengPay\Laravel\ShanchengPay::class,
],
```

## 使用

### 若您是 laravel

在 .env 添加如下配置
```env
023PAY_KEY_ID=
023PAY_KEY_SECRET=
```

#### 发起支付

```php
/**
 * @var \ShanchengPay\ShanchengPay $sdk
 */
$sdk = app('023pay');
$pay = new \ShanchengPay\Payment();

$pay->out_trade_no  = 1; // 订单号
$pay->total_fee  = 1; // 费用，单位分
$pay->body  = '测试商品'; // 商品名称
$pay->notify_url  = route('xxx'); // 您的回调地址
$pay->trade_type  = 'NATIVE'; // 交易类型，NATIVE

return json_encode($sdk->pay($pay));
/*
{
    "applyment_business_code": 11,
    "sub_mch_id": "1559467841",
    "access_key_id": "4SrkyTUbN6NYexfP",
    "out_trade_no": "1",
    "total_fee": "1",
    "body": "\u6d4b\u8bd5\u5546\u54c1",
    "notify_url": "https:\/\/www.xxx.cn\/sdk-test\/callback",
    "trade_type": "NATIVE",
    "request_data": {
        "return_code": "SUCCESS",
        "return_msg": "OK",
        "appid": "wxea9d19d056fb849c",
        "mch_id": "1511345681",
        "sub_mch_id": "1559467841",
        "nonce_str": "ZBZdurLxUeOyptc3",
        "sign": "6B9995E74B417E4A44FA5422F47A27CC",
        "result_code": "SUCCESS",
        "prepay_id": "wx1917121721738150d73cf81e1028085100",
        "trade_type": "NATIVE",
        "code_url": "weixin:\/\/wxpay\/bizpayurl?pr=gMJHe5F"
    }
}
*/
```

#### 回调发货

```php
/**
    * @var \ShanchengPay\ShanchengPay $sdk
    */
$sdk = app('023pay');
$resource = $_SERVER['REQUEST_URI'];

return $sdk->callback($resource, $request->all(), function () use ($request) {
    //发货逻辑
    //$request->all() 可以取到:
    //{
    //  "accessKeyId": "4LUUPmxRtGEmC7ut",
    //  "appid": "wx0fb1c570def9d2a1",
    //  "applyment_business_code": "19",
    //  "bank_type": "CMB_CREDIT",
    //  "body": "测试商品",
    //  "cash_fee": "1",
    //  "fee_type": "CNY",
    //  "id": "93",
    //  "is_subscribe": "N",
    //  "mch_id": "1420282202",
    //  "nonce": "5db44ab93ffb3",
    //  "nonce_str": "5db44aa86c7c3",
    //  "openid": "o-3siwCyOVL0j1lBz-u8OG_KX9Aw",
    //  "out_trade_no": "orZRMO6gPlzMPXj3",
    //  "result_code": "SUCCESS",
    //  "return_code": "SUCCESS",
    //  "sub_mch_id": "1559961621",
    //  "time_end": "20191026213136",
    //  "timestamp": "2019-10-26T21:31:37Z",
    //  "total_fee": "1",
    //  "trade_type": "NATIVE",
    //  "transaction_id": "4200000435201910266139998759",
    //  "sign": "eEovtq8bOc+g+ff7yQ7Krp8euLwtrI/PufyPxwY9fgY="
    //}
    return 'SUCCESS'; //发货成功务必返回SUCCESS或OK，否则会被重复通知
});
```

### 非 Laravel (其它框架或原生 PHP)

#### 发起支付

```php
/**
 * @var \ShanchengPay\ShanchengPay $sdk
 */
$sdk = new \ShanchengPay\ShanchengPay('你的 accessKeyId', '你的 accessKeySecret');
$pay = new \ShanchengPay\Payment();

$pay->out_trade_no  = 1; // 订单号
$pay->total_fee  = 1; // 费用，单位分
$pay->body  = '测试商品'; // 商品名称
$pay->notify_url  = route('xxx'); // 您的回调地址
$pay->trade_type  = 'NATIVE'; // 交易类型，NATIVE

return json_encode($sdk->pay($pay));
/*
{
    "applyment_business_code": 11,
    "sub_mch_id": "1559467841",
    "access_key_id": "4SrkyTUbN6NYexfP",
    "out_trade_no": "1",
    "total_fee": "1",
    "body": "\u6d4b\u8bd5\u5546\u54c1",
    "notify_url": "https:\/\/www.xxx.cn\/sdk-test\/callback",
    "trade_type": "NATIVE",
    "request_data": {
        "return_code": "SUCCESS",
        "return_msg": "OK",
        "appid": "wxea9d19d056fb849c",
        "mch_id": "1511345681",
        "sub_mch_id": "1559467841",
        "nonce_str": "ZBZdurLxUeOyptc3",
        "sign": "6B9995E74B417E4A44FA5422F47A27CC",
        "result_code": "SUCCESS",
        "prepay_id": "wx1917121721738150d73cf81e1028085100",
        "trade_type": "NATIVE",
        "code_url": "weixin:\/\/wxpay\/bizpayurl?pr=gMJHe5F"
    }
}
*/
```

#### 回调发货

```php
/**
 * @var \ShanchengPay\ShanchengPay $sdk
 */
$sdk = new \ShanchengPay\ShanchengPay('你的 accessKeyId', '你的 accessKeySecret');
$resource = $_SERVER['REQUEST_URI'];

if (!count($_POST)) {
    $_POST = json_decode(file_get_contents('php://input'), true);
}

return $sdk->callback($resource, $_POST, function () {
    //发货逻辑
    //$_POST 可以取到
    //{
    //  "accessKeyId": "4LUUPmxRtGEmC7ut",
    //  "appid": "wx0fb1c570def9d2a1",
    //  "applyment_business_code": "19",
    //  "bank_type": "CMB_CREDIT",
    //  "body": "测试商品",
    //  "cash_fee": "1",
    //  "fee_type": "CNY",
    //  "id": "93",
    //  "is_subscribe": "N",
    //  "mch_id": "1420282202",
    //  "nonce": "5db44ab93ffb3",
    //  "nonce_str": "5db44aa86c7c3",
    //  "openid": "o-3siwCyOVL0j1lBz-u8OG_KX9Aw",
    //  "out_trade_no": "orZRMO6gPlzMPXj3",
    //  "result_code": "SUCCESS",
    //  "return_code": "SUCCESS",
    //  "sub_mch_id": "1559961621",
    //  "time_end": "20191026213136",
    //  "timestamp": "2019-10-26T21:31:37Z",
    //  "total_fee": "1",
    //  "trade_type": "NATIVE",
    //  "transaction_id": "4200000435201910266139998759",
    //  "sign": "eEovtq8bOc+g+ff7yQ7Krp8euLwtrI/PufyPxwY9fgY="
    //}
    return 'SUCCESS'; //发货成功务必返回SUCCESS或OK，否则会被重复通知
});
```

## 授权

MIT
