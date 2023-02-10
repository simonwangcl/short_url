<?php

namespace App\Http\Controllers\Test;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $connection = 'mysql_adb';
    protected $table = 'adb_statistic.user_online';// 该表将与模型关联
    protected $primaryKey = 'id';// 与表关联的主键
    public $timestamps = false;// 是否主动维护时间戳
}
