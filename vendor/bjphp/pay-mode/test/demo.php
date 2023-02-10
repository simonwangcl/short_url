<?php

require "../vendor/autoload.php";

use Bjphp\PayMode\Enum\AliEnum;
use Bjphp\PayMode\PayModeUtil;




$rs = PayModeUtil::judgeLv3(0x10101, AliEnum::ALI_WX_SUBMIT);
echo json_encode($rs,320);exit;