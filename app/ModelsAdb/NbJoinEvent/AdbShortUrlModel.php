<?php

namespace App\ModelsAdb\NbJoinEvent;

use Illuminate\Database\Eloquent\Model;

class AdbShortUrlModel extends Model
{
    protected $connection = 'mysql_adb';
    protected $table = 'nbjoinevent.short_url';// 该表将与模型关联
    protected $primaryKey = 'code';// 与表关联的主键
    public $timestamps = false;// 是否主动维护时间戳

    /**
     * 根据code获取配置信息
     * @param $code
     * @return mixed
     */
    public static function getByCode($code)
    {
        return self::where('code', $code)->first();
    }
}
