<?php
/**
 * Created by PhpStorm.
 * User: wmk
 * QQ: 2393209180
 * Date: 2018/3/2
 * Time: 13:29
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table="gdsp_admin";//用来代替数据表
    protected $primaryKey="id";//关键字
    public $timestamps=false;
    protected $guarded=[];
}