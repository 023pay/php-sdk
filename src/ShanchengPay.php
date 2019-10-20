<?php

namespace ShanchengPay;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use ShanchengPay\Sign\SignTrait;

use function GuzzleHttp\json_decode;

/**
 * 山城清算SDK类
 */
class ShanchengPay
{
    use SignTrait;

    /**
     * http请求包
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * 秘钥ID
     *
     * @var string
     */
    protected $accessKeyId;

    /**
     * 秘钥私钥
     *
     * @var string
     */
    protected $accessKeySecret;

    /**
     * 请求基址
     *
     * @var string
     */
    protected $base_uri = 'https://pay.digital-sign.com.cn'; #'https://www.023pay.cn';

    public function __construct($accessKeyId, $accessKeySecret)
    {
        $this->accessKeyId = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;

        $this->http = new Client([
            'base_uri' => $this->base_uri,
        ]);
    }

    /**
     * 发起支付
     *
     * @param Payment $payment 支付参数
     * @return PaymentReturn
     */
    public function pay(Payment $payment)
    {
        $uri = '/api/pay/wechat';
        $data = $this->http->post($uri, [
            RequestOptions::FORM_PARAMS => $this->sign($uri, $payment->toArray(), $this->accessKeyId, $this->accessKeySecret),
        ]);
        $json = json_decode($data->getBody()->__toString());
        if (!$json->success) {
            throw new Exception($json->message);
        }

        return $json->data;
    }

    /**
     * 回调
     * @param string $resource URI
     * @param array $parameters 所有的post参数
     * @param \Closure $delivery_function 发货逻辑 若发货失败请throw异常让HTTP服务器返回非200的HTTP CODE；系统会重试。
     * @return string
     */
    public function callback($resource, $parameters, $delivery_function)
    {
        $sign = isset($parameters['sign']) ? $parameters['sign'] : null;
        if (!$sign) {
            throw new Exception('sign 不能为空');
        }

        unset($parameters['sign']);
        $local_signed_parameters = $this->sign($resource, $parameters, $this->accessKeyId, $this->accessKeySecret);

        if ($sign !== $local_signed_parameters['sign']) {
            throw new Exception('sign check failed. 验签失败');
        }

        $delivery_function($parameters);
        return 'SUCCESS';
    }
}
