<?php
/**
 * 短连接缓存
 * @最后修改人: wcl
 * @修改日期: 2022/3/24
 * @修改内容: 新建
 */

namespace App\Redis\ShortUrl;

use Illuminate\Support\Facades\Cache;

class ShortUrlCache
{
    private static function getKey($code)
    {
        return 'midGroundShortUrl:' . $code;
    }

    public static function set($code, $url, $expire = 86400)
    {
        return Cache::put(self::getKey($code), $url, $expire);
    }

    public static function get($code)
    {
        return Cache::get(self::getKey($code));
    }
}
