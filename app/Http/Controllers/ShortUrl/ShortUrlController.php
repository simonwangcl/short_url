<?php

namespace App\Http\Controllers\ShortUrl;

use App\Helper\Log\LogBeanHelper;
use App\Models\NbJoinEvent\ShortUrlModel;
use App\ModelsAdb\NbJoinEvent\AdbShortUrlModel;
use App\Redis\ShortUrl\ShortUrlCache;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Env;

class ShortUrlController extends BaseController
{
    public function urlToShortUrl(Request $request)
    {
        $url = $request->input('url', '');
        if (!$url) {
            LogBeanHelper::info('urlToShortUrl', debug_backtrace(), 13001001);
            return array('error_code' => 13001001, 'msg' => 'url为空');
        }
        $url = urldecode($url);

        $i = 1;
        while ($i <= 3) {
            $url  = $url . '&t=' . rand(10000, 99999) . $i;
            $code = hash('adler32', $url);
            $i++;

            try {
                $addResult = ShortUrlModel::addInfo($code, $url);
                if ($addResult) {
                    ShortUrlCache::set($code, $url);
                    break;
                }
            } catch (\Exception $e) {
                LogBeanHelper::info($e);
                continue;
            }
        }

        if (!isset($addResult) || !$addResult) {
            LogBeanHelper::info('urlToShortUrl', debug_backtrace(), 13001002);
            return array('error_code' => 13001002, 'msg' => '生成短连接失败');
        }

        $environment = Env::get('APP_ENV');
        switch ($environment) {
            case 'dev':
                $domain = 'sd.nbmj.cn';
                break;
            case 'pre':
                $domain = 'sp.nbmj.cn';
                break;
            case 'prod':
                $domain = 's.nbmj.cn';
            default:
        }
        $shortUrl = 'https://' . $domain . '?c=' . $code . date('ymd');

        $result = array('error_code' => 0, 'msg' => '', 'short_url' => $shortUrl);
        LogBeanHelper::info('urlToShortUrl', $result, 0);

        return $result;
    }

    public function shortUrlToUrl(Request $request)
    {
        $code = $request->input('c', '');// ad900b30
        $time = 20 . substr($code, -6);
        $code = substr($code, 0, -6);

        if (!$code) {
            LogBeanHelper::info('shortUrlToUrl', $_REQUEST, 13001003);
            return array('error_code' => 13001003, 'msg' => 'code为空');
        }

        $url = ShortUrlCache::get($code);
        if (!$url) {
            if (date('ymd') > date('ymd', strtotime('30 days', strtotime($time)))) {
                // 当前时间在分析时间30天以上的，走ADB，其余走RDS
                $info = AdbShortUrlModel::getByCode($code);
            } else {
                $info = ShortUrlModel::getByCode($code);
            }
            $url = $info ? $info->url : '';
            if ($url) {
                ShortUrlCache::set($code, $url);
            }
        }

        if (!$url) {
            LogBeanHelper::info('shortUrlToUrl', debug_backtrace(), 13001004);
            return array('error_code' => 13001004, 'msg' => '获取短连接失败');
        }

        $url = urldecode($url);
        LogBeanHelper::info('shortUrlToUrl', array($url), 0);

        Header('Location:' . $url);
        exit;
    }
}
