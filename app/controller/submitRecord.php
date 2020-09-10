<?php


namespace app\controller;


use app\BaseController;
use think\Request;
use app\model\solution as sol;
use app\model\source_code as sou;
use app\model\source_code_user as sou_user;
use app\model\runtimeinfo as rti;
class submitRecord extends BaseController
{
    public function submit(Request $request){// 提交代码
        //return 123;
        $sol = new sol();
        $sou = new sou();
        $sou_user = new sou_user();
        $data = $request->data;
        // in_data 和 judgetime 都是提交时间
        $data['user_id'] = $data['uid'];
        $data['in_date'] = $data['judgetime'] = date('Y-m-d H:i:s');
        $data['valid'] = 1;
        $data['num'] = -1;
        $data['code_length'] = strlen($data['source']);
        //$data['solution_id'];
        $sol->save($data);
        //halt($sol); //debug
        $data = $sol->toArray();
        //halt($data); //debug
        $sou->save($data);
        $sou_user->save($data);
        return showSuccess($data,'提交成功');
    }
    public function allRecord(){
        //return json(sol::all()->where('solution_id','>',-1)->select()); //debug
        $data = sol::all()->where('solution_id','>',-1)->select();
        return showSuccess($data,'所有提交记录');
    }
    public function oneSource(Request $request){
        //return 123; //debug
        $data = $request->data;
        //halt($data); //debug
        $data['sourceCode'] = sou::where('solution_id',$data['solution_id'])->value('source');
        $data['runTimeInfo'] = rti::where('solution_id',$data['solution_id'])->value('error');
        return showSuccess($data,'用户源码和信息');
    }
}