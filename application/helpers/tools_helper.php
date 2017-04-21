<?php

/**
 * 通用辅助函数
 *
 * @author haokaiyang
 * @date 2016-07-02 12:46:21
 */

if ( ! function_exists('price_format')) {
    /**
     * price_format 格式化价格
     *
     * @param int $price
     *
     * @return float 带两位小数点的价格
     * @author haokaiyang
     * @date 2016-07-02 12:49:24
     */
    function price_format($price = 0): float
    {
        return sprintf('%.2f', $price);
    }
}

if(! function_exists('random_number')) {
    /**
     * random_number 生成一个指定长度的随机数字串
     *
     * @param int $length 需要生成的长度
     * @return string
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-07-28 14:22:04
     */
    function random_number(int $length = 6): string
    {
        if(0 >= $length)
            return '';

        $number = '';
        for($i = 0; $i < $length; $i++) {
            $number .= random_int(0, 9);
        }

        return $number;
    }
}

if(! function_exists('random_characters')) {
    /**
     * random_characters 生成一个指定长度的随机字符串(包含数字和字母)
     *
     * @param int $length 需要生成的长度
     * @return string
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-08-16 19:57:12
     */
    function random_characters(int $length = 6): string
    {
        if(0 >= $length)
            return '';

        $characters = '0123456789abcdefjhijklmnopqrstuvwxyzABCDEFJHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($characters) - 1;
        $generate_characters = '';
        for($i = 0; $i < $length; $i++) {
            $generate_characters .= $characters[random_int(0, $max)];
        }

        return $generate_characters;
    }
}

if (! function_exists('get_ip')) {
    /**
     * 获取客户端ip地址
     *
     * @return string
     * @author haokaiyang
     * @date   2016-11-20 15:47:30
     */
    function get_ip()
    {
        $ip = '';
        if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            return is_ip($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : $ip;
        } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return is_ip($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $ip;
        } else {
            return is_ip($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $ip;
        }
    }
}

if (! function_exists('is_ip')) {
    /**
     * 判断字符串是否是ip地址
     *
     * @param string $str
     *
     * @return bool|int
     * @author haokaiyang
     * @date $DATETIME
     */
    function is_ip(string $str)
    {
        $ip = explode('.', $str);
        for ($i = 0;$i < count($ip);$i++) {
            if ($ip[$i] > 255) {
                return false;
            }
        }
        return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $str);
    }
}