<?php


namespace app\model;


use think\Model;

class problem extends Model
{
    protected $name = 'problem';
    protected $pk = 'problem_id';
    public function getRateAttr($value, $data){
        //return 0; //debug
        return $data['accepted']."/".$data['submit'];

    }
    public function scopeShowProblem($query){//题目列表信息
        $query->visible([
           'problem_id',
           'title',
           'rate',
        ]);
    }
    public function scopeTitle($query,$pid){//题目
        $query->where('problem_id',$pid)->visible(['title']);
    }
    public function scopeBarInfo($query, $pid){ //题目内容barInfo
        $query->where('problem_id',$pid)->visible([
           'submit',
            'accepted',
            'time_limit',
            'memory_limit',
        ]);
    }
    public function scopeLeft($query,$pid){ //题目内容左半部分
        $query->where('problem_id',$pid)->visible([
            'content',
            'description',
            'input',
            'output',
            'sample_input',
            'sample_output',
            'hint',
        ]);
    }
    public function scopeRight($query,$pid){ //题目内容右半部分
        $query->where("problem_id",$pid)->visible([
            'source',
            'rate',
            'time_limit',
            'memory_limit',
        ]);
    }
}