<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ToolController;
use App\Model\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

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
        $res1=UserModel::where('email',$data['email'])->first();
        if ($res){
            ToolController::no('用户已存在', 1);
            die;
        }elseif($res1){
            ToolController::no('邮箱已存在', 1);
            die;
        }
        if ($data['password'] != $data['password_confirm']) {
            ToolController::no('密码验证有误', 1);
            die;
        } else {
            unset($data['password_confirm']);
        }
        //入库
        $data['password']=Hash::make($data['password']);
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
        $res=UserModel::where('account',$account)->first();
        if ($res&&password_verify($password, $res->password)){
            //制作token;
            $token=substr(md5($res->id.'_'.Str::random(10).rand(1000,9999)),10,10);
            Cache::put($token,$res , 7200);
            ToolController::ok('登陆成功', 0,$token);
        }else{
             ToolController::no('账号或密码有误', 1);
        }
    }

    public function islogin(Request $request){
        if ($res=Cache::get($request->token)){
            ToolController::ok('用户数据', 0,$res);
        }else{
            ToolController::no('错误', 1);
        }
    }
}
