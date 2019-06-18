<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class ToolController extends Controller
{
    public static function echoMsg($errcode,$msg,$data=''){
        echo json_encode(['errcode'=>$errcode,'msg'=>$msg,'data'=>$data],JSON_UNESCAPED_UNICODE);
    }

    public static function ok($msg,$code,$data=''){
        echo json_encode(['errcode'=>$code,'msg'=>$msg,'data'=>$data],JSON_UNESCAPED_UNICODE);
    }
    public static function no($msg,$code,$data=''){
        echo json_encode(['errcode'=>$code,'msg'=>$msg,'data'=>$data],JSON_UNESCAPED_UNICODE);
    }
}
