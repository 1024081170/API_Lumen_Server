<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ToolController;
use App\Model\UserModel;

class LoginController extends Controller
{
    public function reg(Request $request)
    {
        $data['account'] = $request->account;
        $data['password'] = $request->password;
        $data['password_confirm'] = $request->password_confirm;
        $data['email'] = $request->email;
        //安全验证
        $res=UserModel::where('account',$data['account'])->first();
        if ($res){
            ToolController::no('用户已存在', 1);
            die;
        }
        if ($data['password'] != $data['password_confirm']) {
            ToolController::no('密码验证有误', 1);
            die;
        } else {
            unset($data['password_confirm']);
        }

        //............


        //入库
        $res = UserModel::insert($data);
        if ($res) {
            ToolController::ok('注册成功', 0);
        } else {
            ToolController::no('注册失败', 1);
        }
    }

    public function login(Request $request)
    {
        $account = $request->account;
        $password = $request->password;
        $where=[
            'account'=>$account,
            'password'=>$password
        ];
        $res=UserModel::where($where)->first();
        if ($res){
            file_put_contents('login',$res);
            ToolController::ok('登陆成功', 0);
        }else{
             ToolController::no('账号或密码有误', 1);
        }
    }

    public function islogin(Request $request){
        if ($res=file_get_contents('login')){
            $res=json_decode($res,true);
            ToolController::ok('用户数据', 0,$res);
        }else{
            ToolController::no('错误', 1);
        }
    }
}
