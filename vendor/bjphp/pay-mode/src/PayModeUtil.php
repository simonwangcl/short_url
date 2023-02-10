<?php

namespace Bjphp\PayMode;

class PayModeUtil
{


    /**
     *
     * @param $payMode
     * @param $target
     * @return bool
     * @author      kev.zhang
     * @date        2022/2/17
     */
    public static function judgeLv1($payMode, $target)
    {
        if (($payMode & 0xf0000) == $target) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param $payMode
     * @param $target
     * @return bool
     * @author      kev.zhang
     * @date        2022/2/17
     */
    public static function judgeLv3($payMode, $target)
    {
        if (($payMode & 0xf00) == $target) {
            return true;
        }

        return false;
    }
}
