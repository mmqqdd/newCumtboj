<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\BaseController;
use app\Token;
use app\model\users as Hu;

class Users extends BaseController{
    /**
     * 调用全局中间件验证token,没有token这一步自动跳过
     * 验证注册信息, 交给register中间件
     * 创建账号
     * 返回用户信息
     */
    public function register(Request $request){//注册用户
        $userdata=$request->data;
        $userdata['user_id']=$userdata['username'];
        $userdata['accesstime']= date('Y-m-d H:i:s');

        $user=Hu::create($userdata)->hidden(['password','requiredPassword','uid','token','id']);
        $token=new token('',(string)$user['username']);
        $data=[
            'userdata' => $user,
            'token' => $token->build(3600),
        ];
        return(showSuccess($data,'注册成功'))   ;
    }

    /**
     * 验证token, 交给全局中间件
     * 验证登录信息, 交给user中间件
     * 创建token, 生成一个随机函数
     * 将token存入cache, 存入id即可, 设置token有效时间
     * 返回用户信息
     */
    public function login(Request $request){//用户登录

        $user=Hu::where("user_id",$request->data['username'])->find(); //通过用户名查找用户
        //$user=Hu::select()->toArray();
        //$user->user_id=1;
        //halt($user);
        $user->accesstime = date('Y-m-d H:i:s');
        $user->save(); //改变状态

        $token=new Token('',(string)$user['user_id']);
        $data=[ 
            'token' => $token->build('3600'),
            'userdata' => $user->hidden(["password"]),
        ];
        return showSuccess($data,'登录成功');
    }
    /** 
     * 验证token
     * 验证信息
     * 删除token
     * 返回信息
     */
    public function logout(Request $request){//
        //halt($request->data['token']); //debug
        $request->data['token']->delete();
        return showSuccess("",'注销成功');
    }
}
