<?php

namespace ShanchengPay;

/**
 * 响应
 * @property int $id
 * @property string $sub_mch_id
 * @property int $applyment_business_code 商户号
 * @property string $out_trade_no 商户订单号
 * @property int $total_fee 交易金额
 * @property string $body 交易名称
 * @property string $notify_url 回调地址
 * @property string $trade_type 类型 JSAPI-JSAPI支付 NATIVE-Native支付 APP-APP支付
 * @property int $status 状态 0已下单 1已支付 2回调成功 -1已取消
 * @property PaymentReturnRequestData $request_data 微信支付请求响应
 */
class PaymentReturn
{
}
