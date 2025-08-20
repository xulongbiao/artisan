<?php

namespace util;

class Str
{
    /**
     * 用于初始化随机字符串生成函数
     *
     * @var callable|null
     */
    protected static $randomStringFactory;

    public static function random($length = 16)
    {
        return (static::$randomStringFactory ?? function ($length) {
            $string = '';

            while (($len = strlen($string)) < $length) {
                $size = $length - $len;

                $bytesSize = (int) ceil($size / 3) * 3;

                $bytes = random_bytes($bytesSize);

                $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
            }

            return $string;
        })($length);
    }

    /**
     * 生成UUID
     *
     * @return string
     */
    public static function getUUID()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // 设置版本为 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // 设置变体为 RFC 4122
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}