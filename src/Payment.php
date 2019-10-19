<?php

namespace ShanchengPay;

use Exception;

/**
 * 请求类
 */
class Payment
{
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
    public $trade_type;

    /**
     * 转换为数组
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'out_trade_no' => $this->out_trade_no,
            'total_fee' => $this->total_fee,
            'body' => $this->body,
            'notify_url' => $this->notify_url,
            'trade_type' => $this->trade_type,
        ];
        foreach ($data as $key => $value) {
            if (!$value) {
                throw new Exception($value . "不能为空", 1);
            }
        }
        return $data;
    }
}
