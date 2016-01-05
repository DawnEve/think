<?php
namespace Home\Controller;
use Think\Controller;
//use Think\Model;//引入类文件命名空间
//use Home\Model\UserModel;

class IndexController extends Controller {


	


    public function index(){
	
		echo '<pre>', C('name');
		echo '<br>',U();
		echo '<br>','Index->index';
		//$this->show('wjl');
		//echo '<pre>', C('email');
		//echo '<pre>', C('my_config2', null, 'default_config');//可以设置默认值
		
		//echo '<hr>',C('DATA_CACHE_TIME');//动态配置赋值仅对当前请求有效，不会对以后的请求造成影响。
		//echo '<hr>',C('USER_CONFIG.USER_TYPE',null,100);//动态配置赋值仅对当前请求有效，不会对以后的请求造成影响。
		//dump(C());//获取所有设置结果
		
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
	
	function model(){
		echo 'model';
		$user=M('User','think_');
		dump($user->select());
	}
	
	function model2(){
		echo 'model2';
		//用于调用不是配置文件指定的数据库时
		$user=M('User','t_', 'mysql://root:@localhost:3306/test#utf8');
		dump($user->select());
	}
	
	function model3(){
		echo 'model3';
		//关于M方法
		$user=new UserModel();
		dump($user->select());
	}
	
	function model4(){
		echo 'model4';
		//D方法
		$user=D('User');//M函数不经过模型类，而D函数必须用模型类。
		dump($user->select());
	}
	
	
	function model5(){
		echo 'model5';
		//D方法
		$user=D('Admin/User');//调用其他模块的Model。
		dump($user->select());
	}
	
	function model6(){
		echo 'model6';
		$user=M();//空M方法，可以使用原生sql查询。不用D，因为D会创建一个空Model再执行查询，速度慢
		dump($user->query('show tables;'));
		//dump($user->query('show databases;'));
	}
	
	function model7(){
		echo 'model7';
		$user=M('User');//缓存与否的影响
		dump( $user->getDbFields() );
	}
	
	function model8(){
		echo 'model8';
		$user=D('User');//手工指定缓存字段，需要在Model类中自定义。使用D方法。
		dump( $user->getDbFields() );
	}
	
	public function Read(){
		echo 'from index->read';
		dump( C('URL_CASE_INSENSITIVE') );
	
	}
	
	function router(){
		dump( C('URL_ROUTER_ON') );
	}
	
	function login($usr,$psw){
		echo 'index: Admin->login';
		echo '<hr>usr: ',$usr;
		echo '<hr>psw: ',$psw;
		
		echo '<hr>URL_PATHINFO_DEPR: ', C('URL_PATHINFO_DEPR');
		echo '<hr>URL_MODEL: ', C('URL_MODEL');
		echo '<hr>URL_MODEL: ', U();
		
	}
}

/*
http://localhost/?m=home&c=user&a=login&var=value


*/