<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{

    public function get()
    {
        return '11111111111111111';
    }

    public function post()
    {
        $key = 'Paint';
        $iv = '0123456789abcdef';
        $data = file_get_contents('php://input');
        return openssl_decrypt(base64_decode($data), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }

    public function file()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//            $file=json_encode($_POST,true);
//            dd($file);
            $data = file_get_contents('php://input');
            $path = 'uploads/' . date('Ymd') . '/';
            $filename = date('Ymdhis') . '.jpg';
            if (!is_dir($path)) {
                $flag = mkdir($path,0777, true);
            }
            $file = file_put_contents($path.$filename, $data);
            if (FALSE !== $file) {
                echo '上传成功';
            } else {
                echo '上传失败';
            }
        }
    }

    public function test_rsa(){
        $data=base64_decode(file_get_contents('php://input'));
        $public=openssl_get_publickey('file://'.storage_path('key/test_public_key.pem'));
        openssl_public_decrypt($data,$xxx,$public);
        echo '<hr>';
        echo $xxx;
    }
    public function signature(){
        $key = 'Paint';
        $iv = '0123456789abcdef';

        $data=file_get_contents('php://input');
        $arr=unserialize(base64_decode($data));

        $public=openssl_get_publickey('file://'.storage_path('key/test_public_key.pem'));
        
        dd(openssl_verify($arr['data'],$arr['signa'],$public));
    }
}
