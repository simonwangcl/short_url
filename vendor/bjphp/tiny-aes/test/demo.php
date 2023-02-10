<?php

// 前置操作 -----------------------------------------------------------------------------

// 引入composer的自动加载
use Bjphp\TinyAes\BjTinyAes;

require "../vendor/autoload.php";

// 引用日志组件

// End -----------------------------------------------------------------------------


// 操作Demo↓ -----------------------------------------------------------------------------

function en($str)
{
    $enStr = BjTinyAes::encrypt($str);
    echo $enStr . "\n";

    return $enStr;
}

function de($enStr)
{
    $data = BjTinyAes::decrypt($enStr);
    echo json_encode($data, 320);
    exit;# k调试语句
}

$enStr = en('{"charset":"UTF-8","out_trade_no":"20220101081012-5043","method":"alipay.trade.wap.pay.return","total_amount":"10.00","sign":"IpGu6a5yLUYbr6MoIoHjc0B0NmGhdMTUH9l8diN46r24L8+41d0Kki0UaGBBi3knJczXyv+Y7\/sCEtRypeLVCQL8qDRgdJeOz+DpvJZPXag0lu37ZFfVa+MtZITT1AD3E6vU5j4omspkBzYIN5vkcTrLaL0RSza9qLaT3E1oQwT1cv7CeipIqQ1X9BX5s61J4VXKGcFJBLOMcfsvBF\/L6MXM0dUUAdm2kgeecAHG4vKUoHqSG9JG0lMj1WMQEh6IeCB3WdXAeh0C0Sfmb+KntlUHSrmIdm1jgAk8OXsx0TSJbX98OY2qKt9n644VcSHB0EQQ1Mc0lmKdj1An8IQj9g==","trade_no":"2022010122001437001400264531","auth_app_id":"2021002136617698","version":"1.0","app_id":"2021002136617698","sign_type":"RSA2","seller_id":"2088142150874624","timestamp":"2022-01-01 08:10:52"}');
de($enStr);


