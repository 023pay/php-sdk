<?php

namespace ShanchengPay\Traits;

use Exception;

trait withToArray
{

    /**
     * 转换为数组
     *
     * @return array
     */
    public function toArray()
    {
        $data = [];
        foreach (static::ATTRIBUTES_TO_ARRAY as $attribute) {
            $data[$attribute] = $this->{$attribute};
        }
        foreach ($data as $key => $value) {
            if (!$value) {
                throw new Exception($value . "不能为空", 1);
            }
        }
        return $data;
    }
}