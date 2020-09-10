<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;
use app\model\users as Hu;
use think\facade\Request;
class users extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'username|用户名' => ['require','max' => '20',],
        'password|密码' => ['require'],
        'nick|昵称' => ['require','max' => '20'],
        'email|邮箱' => ['require','email'],
    ];

    protected $scene=[
        'register' => ['username','password','nick','email'],
        'login' => ['username'],
        'logout' => ['username'],
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        
    ];
    public function checkHas($value){//用户名存在报错
        if (Hu::where('user_id',$value)->find()==Null)
            return true;
        return '用户名已存在';
    }
    public function checkNotHas($value){ //用户名不存在报错
        if (Hu::where('user_id',$value)->find()==Null)
            return '用户名不存在';
        return true;
    }
    public function checkPassword($value,$rule,$data){ // 验证密码是否正确
        $password = Hu::where('user_id',$data['username'])->value('password');
        //halt($password); //debug
        if (md5($value)==$password)return true;
        return "密码错误";
    }

    public function isTrue($value,$rule,$data){ 
        if ($value!=$data['requiredPassword'])
            return "第二次输入的密码与第一次不同";
        return true;
    }
    public function sceneRegister(){//注册场景
        $data = $this->append([
            'username' => 'checkHas',
            'password' => 'isTrue',
        ]); 
        return $data;   
    }
    public function sceneLogin(){//登录场景
        $data = $this->only(['username','password'])->append([
            'username' => 'checkNotHas',
            'password' => 'checkPassword',
        ]);
    }
    public function sceneLogout(){//注销场景
        $data = $this->only(['user_id'])->append([
            'user_id'=>'checkNotHas',
            'user_id'=>'checkStatus',
        ]);
        return $data;
    }

}
