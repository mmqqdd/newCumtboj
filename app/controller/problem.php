<?php


namespace app\controller;

use app\model\problem as pr;
use app\BaseController;
use app\Request;

class problem
{
    function showProblem(Request $request){
        $data = pr::showProblem()->select();
        //$data = pr::select(); //debug
        //halt($data['rate']); //debug
        return showSuccess($data, '题目列表');
    }
    function showProblemContent(Request $request){
        $pid = $request->data['pid'];
        $problem = pr::where('problem_id',$pid)->find();
        $data = [
            'title' => pr::title($pid)->find(),
            'barInfo' => pr::barInfo($pid)->find(),
            'left' => pr::left($pid)->find(),
            'right' => pr::right($pid)->find(),
        ];
        //return ($problem->description);
        return showSuccess($data,'题目信息');
    }

}