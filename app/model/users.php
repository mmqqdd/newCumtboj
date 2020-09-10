<?php
namespace app\model;
use think\Model;

class users extends Model{
    protected $name = 'users'; //数据表的名字， 不写默认和文件名一样
    protected $pk = 'user_id'; //主键 ， 不写默认id;
    //设置只读字段
    protected $readonly = ['user_id','password'];
    public function setPasswordAttr($value){
        return md5($value);
    }

}