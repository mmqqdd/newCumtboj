<?php


namespace app\model;


use think\Model;

class solution extends Model
{
    protected $name = 'solution';
    protected $pk = 'solution_id';
    public function getResultAttr($value,$data){
        $arr=["等待","等待重判","编译中","运行并评判","正确","格式错误","答案错误","时间超限",
               "内存超限","输出超限","运行错误","编译错误","编译成功","运行完成"];
        return $arr[$value];
    }
    public function getLanguageAttr($value,$data){
        $arr = ['C','C++','','Java','','','Python','PHP'];
        $arr[9]='C#';
        $arr[16]='Javascript';
        $arr[17]='Go';
        $arr[18]='SQL';

        return $arr[$value];
    }

    public function scopeAll($query){
        $query->visible([
            'solution_id',
            'problem_id',
            'user_id',
            'time',
            'memory',
            'in_data',
            'result',
            'language',
            'code_length',
            'pass_rate',
            'judger',
        ]);
    }
}
