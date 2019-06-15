<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ToolController;
use App\Model\UserModel;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');
        $res = UserModel::where('name', $name)->first();
        if ($res) {
            if ($res->password == $password) {
                ToolController::echoMsg(0, '登陆成功', '');
            } else {
                ToolController::echoMsg(201, '密码验证有误', '');
            }
        } else {
            ToolController::echoMsg(202, '账号有误', '');
        }

    }

    public function create(Request $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');
        $confirmpassword = $request->input('confirmpassword');
        $res = UserModel::where('name', $name)->first();
        if (!$res) {
            if ($confirmpassword == $password) {
                $res = UserModel::create(['name' => $name, 'password' => $password]);
                if ($res) {
                    ToolController::echoMsg(0, '添加成功', '');
                } else {
                    ToolController::echoMsg(301, '添加失败', '');
                }

            } else {
                ToolController::echoMsg(201, '密码验证有误', '');
            }
        } else {
            ToolController::echoMsg(203, '账号已存在', '');
        }
    }

    public function update(Request $request)
    {
        $name = $request->input('name');
        $oldpassword = $request->input('oldpassword');
        $newpassword = $request->input('newpassword');
        $where = [
            'name' => $name,
            'password' => $oldpassword
        ];
        $res = UserModel::where($where)->first();
        if ($res) {
            $res = UserModel::where('id', $res->id)->update(['name' => $name, 'password' => $newpassword]);
            if ($res) {
                ToolController::echoMsg(0, '修改成功', '');
            } else {
                ToolController::echoMsg(302, '修改失败', '');
            }
        } else {
            ToolController::echoMsg(201, '密码验证有误', '');
        }
    }

    public function weather(Request $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');
        $weather=$request->input('weather');
        $where = [
            'name' => $name,
            'password' => $password
        ];
        $res = UserModel::where($where)->first();
        if ($res) {
            $json = file_get_contents('http://api.k780.com/?app=weather.future&weaid=' . $weather . '&&appkey=42236&sign=a83573283f05ff2cc24d6f39e2549818&format=json');
            $arr=json_decode($json,true);
            if ($arr['success']==1) {
                ToolController::echoMsg(0, '查询成功', $arr['result']);
            } else {
                ToolController::echoMsg(401, '查询失败', '');
            }
        } else {
            ToolController::echoMsg(201, '密码验证有误', '');
        }

    }

}
