<?php

namespace App\Models\NbJoinEvent;

use Illuminate\Database\Eloquent\Model;

class ShortUrlModel extends Model
{
    protected $connection = 'mysql_mjg';
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

    /**
     * 设置配置信息
     * @param $code
     * @param $url
     * @return bool
     */
    public static function addInfo($code, $url)
    {
        $model             = new self();
        $model->code       = $code;
        $model->url        = $url;
        $model->created_at = date('Y-m-d H:i:s');

        return $model->save();
    }
}
