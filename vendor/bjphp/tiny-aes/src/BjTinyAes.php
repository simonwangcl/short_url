<?php

namespace Bjphp\TinyAes;

class BjTinyAes
{

    //设置AES秘钥
    private static $aes_key = 'boLY7HBQDIoTxb7glbhhjgaR9QXhR9EN';

    /**
     * 加密
     * @param string $str 要加密的数据
     * @return string   加密后的数据
     */
    static public function encrypt($str, $key = '')
    {
        if (!$key) $key = self::$aes_key;

        $data = openssl_encrypt($str, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        return base64_encode($data);
    }

    /**
     * 解密
     * @param string $str 要解密的数据
     * @return string        解密后的数据
     */
    static public function decrypt($str, $key = '')
    {
        if (!$key) $key = self::$aes_key;

        return openssl_decrypt(base64_decode($str), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
    }
}
