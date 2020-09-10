<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;
use app\model\problem as Hp;
use app\model\users as Hu;
class SubmitRecord extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'problem_id|题目ID' => ['require','checkPid','number'],
        'source|代码' => ['require'],
        //'language|编程语言' => ['require'],
        'suid|请求的题目' =>['require','checkUid'],
        'solution_id' =>['require','number']
    ];
    protected $scene = [
        'submit' => ['problem_id','source'],
        'oneSource' =>['solution_id']
    ];
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    public function checkPid($value,$rule,$data){
        if (Hp::where('problem_id',$value)->find()) return true;
        return "没有此题目";
    }
    public function checkUid($value,$rule,$data){
        if (Hu::where('user_id','uid')->find()) return true;
        return "该用户不存在";
    }
    public function sceneSubmit(){
        return $this->remove('suid',['require']);//
    }
    public function sceneAllRecord(){
        return $this->only(['']);
    }
    public function sceneOneSource(){
        return $this->only(['solution_id']);
    }
    public function sceneOneUserRecord(){
        return $this->only(['suid']);
    }

}
