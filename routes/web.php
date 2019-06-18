<?php
$router->get('/',function(){
	echo '<h1 align="center">API服务端_Lumen</h1>';
});
//$router->post('user/login','UserController@login');
//$router->post('user/create','UserController@create');
//$router->post('user/update','UserController@update');
//$router->post('user/weather','UserController@weather');

$router->get('guzzle/get','TestController@get');
$router->post('guzzle/post','TestController@post');
$router->post('guzzle/file','TestController@file');
$router->post('test_rsa','TestController@test_rsa');
$router->post('signature','TestController@signature');


$router->post('reg','LoginController@reg');//注册
$router->post('login1','LoginController@login');//登陆
$router->post('islogin','LoginController@islogin');//登陆


