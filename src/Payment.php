<?php

namespace ShanchengPay;

use ShanchengPay\Traits\withToArray;

/**
 * Native 支付请求类
 */
class Payment
{
    use withToArray;

    /**
     * 交易单号
     *
     * @var string
     */
    public $out_trade_no;

    /**
     * 费用，单位分
     *
     * @var int
     */
    public $total_fee;

    /**
     * 商品名称
     *
     * @var string
     */
    public $body;

    /**
     * 回调通知地址
     *
     * @var string
     */
    public $notify_url;

    /**
     * 交易类型，NATIVE
     *
     * @var string
     */
    public $trade_type = 'NATIVE';

    const ATTRIBUTES_TO_ARRAY = [
        'out_trade_no',
        'total_fee',
        'body',
        'notify_url',
        'trade_type',
    ];
}
