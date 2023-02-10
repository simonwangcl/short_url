<?php

namespace App\Http\Controllers\Test;

use App\Models\NbJoinEvent\ShortUrlModel;
use App\ModelsAdb\NbJoinEvent\AdbShortUrlModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TestController extends BaseController
{
    /**
     * 测试函数
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return array(
            'RDS' => ShortUrlModel::getByCode('00003beb'),
            'ADB' => AdbShortUrlModel::getByCode('1d6b3be4'),
        );
    }
}
