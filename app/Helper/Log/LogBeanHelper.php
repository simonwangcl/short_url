<?php

namespace App\Helper\Log;

use BjphpLog\LogUtil;

class LogBeanHelper
{

    const ALARM_EMAIL = '854641898@qq.com';

    /**
     * 记录请求日志
     * @param
     * @return void
     * @author      kev.zhang
     * @date        2022/2/15
     */
    public static function request($request)
    {
        $rawPostData = file_get_contents('php://input', 'r');
        $arr         = json_decode($rawPostData, true);
        $arr         = $arr ?? [];
        $data        = array_merge($_REQUEST, $arr);

        LogUtil::info($request->path(), $data, 'default', 'REQUEST');
    }

    /**
     * info 日志
     * @param $msg
     * @param array $data
     * @param string $tag
     * @return void
     * @author      kev.zhang
     * @date        2022/2/10
     */
    public static function info($msg, array $data = [], $tag = '')
    {
        LogUtil::info($msg, $data, 'default', $tag);
    }

    /**
     * 告警 日志
     * @param $msg
     * @param $data
     * @param $tag
     * @return void
     * @author      kev.zhang
     * @date        2022/2/10
     */
    public static function alarm($msg, $data, $tag)
    {
        LogUtil::alarm($msg, $data, 'alarm', $tag, self::ALARM_EMAIL);
    }


}
