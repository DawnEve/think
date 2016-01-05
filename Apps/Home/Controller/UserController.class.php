<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller {
    public function index(){
		echo 'UserController->index: ';
		
		//echo C('URL_MODEL',1);
		//echo U('Index/Login');
		
		$data=M('User');
		$result=$data->find(18);
		//dump($result);
		$this->assign('data',$result);
		$this->display();
		
		//D('User'); //实例化UserModel
		//D('User','Logic'); //实例化UserLogic
		
	}
	
    public function add(){
		echo 'UserController->add';
		$this->show();
	}
	
	public function insert(){
		$form=D('user');
		if($form->create()){
			$result=$form->add();
			if($result){
				$this->success('添加成功');
			}else{
				$this->error('添加失败！');
			}
		}else{
			$this->error($form->getError());
		}
		
	}
	
	
	public function Login($var){
		echo 'from user->login:' . $var;
	}
	
	
	public function blog(){
		echo 'hello user->blog: ';
		echo 'http://tp.dawneve.cc/home/user/blog';
	}
	
	function i(){
		//变量操作
		//http://tp.dawneve.cc/home/user/i/id/3/name/300sa%7D%7B
		echo '<pre>';
		print_r( I('get.') ); //获取整个$_GET
		echo '<hr>';
		
		echo I('get.id'); //相当于$_GET['id']
		//http://tp.dawneve.cc/home/user/i/id/3
		//echo I('get.name','some names');//默认值
		echo I('get.name','some names','htmlspecialchars');//过滤
		
		
		echo '<hr>',I('get.name/d');//强制转换为整形数字
		echo '<hr>',I('get.name/f');//强制转换为浮点数字
		
	}
	
	
	function select(){
		echo 'User->select():';
		$user=M('User');
		dump( $user->select() );//查询所有值
	}
	
	function select2(){
		echo 'User->select(2):';
		$user=M('User');
		dump( $user->where('id=1')->select() );//查询id=1的条目
	}
	
	function select3(){
		echo 'User->select(3):';
		$user=M('User');
		dump( $user->where('id>4 or email like "%qq.com"')->select() );//复杂where语句
	}
	
	function select4(){
		echo 'User->select(4):';
		$user=M('User');
		
		$condition['id']=1;
		$condition['user']='tom';
		$condition['_logic']='or';//使用数组方式定义where条件
		dump( $user->where($condition)->select() );//复杂where语句
	}
	
	function select5(){
		echo 'User->select(5):';
		$user=M('User');
		
		$condition=new \stdClass();//必须使用顶层命名空间
		$condition->id=1;
		$condition->user='tom';
		$condition->_logic='or';//使用对象方式定义where条件
		dump( $user->where($condition)->select() );//复杂where语句
	}
	
	
	//表达式查询
	function select6(){
		echo 'User->select(6):';
		$user=M('User');
		
		$map['id']=array('eq',1);
		
		dump( $user->where($map)->select() );//复杂where语句
	}
	
	//表达式查询
	function select7(){
		echo 'User->select(7):';
		$user=M('User');
		//$map2['id']=array('not between',array(2,4));
		//$map2['id']=array('between','1,3');
		$map2['id']=array('not in','1,3,4');
		
		dump( $user->where($map2)->select() );//复杂where语句
	}
	
	
	//自定义查询
	function select8(){
		echo 'User->select(8):';
		$user=M('User');
		$map3['id']=array('exp','>=3');
		dump( $user->where($map3)->select() );//复杂where语句
	}
	
	//-------------------------------------------------------
	//组合查询 _string
	function where(){
		echo 'User->where():';
		$user=M('User');
		$map3['_string']='id>5';//字符串查询条件
		dump( $user->where($map3)->select() );//复杂where语句
	}
	
	//组合查询 |
	function where2(){
		echo 'User->where2():';
		$user=M('User');
		$map3['id|email']=array('eq','3');//&是and，|是or
		dump( $user->where($map3)->select() );//复杂where语句
	}
	
	//统计查询
	function where3(){
		echo 'User->where3():';
		$user=M('User');

		dump( $user->count('id') );//8
		dump( $user->count('email') );//8
	}
	
	//统计查询
	function where4(){
		echo 'User->where4():';
		$user=M('User');

		dump( $user->max('id') );//8
	}
	
	//动态查询
	function dynamic(){
		echo 'User->dynamic():';
		$user=M('User');

		dump( $user->getByAddTime('1451294372') );
	}
	
	
	//动态查询
	function dynamic2(){
		echo __method__;
		$user=M('User');
		dump( $user->getFieldByUser('Tom','id') );
	}
	
	//sql查询：读
	function sql(){
		echo __method__;
		$user=M('User');
		dump( $user->query('select * from think_user;') );
	}
	
	//sql查询：写
	function sql2(){
		echo __method__;
		$user=M('User');
		dump( $user->execute('update think_user set modi_time="1451294972" where id=1;') );
	}
	
	
	//====================================连贯操作
	
	function lg(){
		echo __method__;
		$user=M('User');
		dump( $user->where('id>5')->select() );//连贯操作
	}

	function lg2(){
		echo __method__;
		$user=M('User');
		dump( $user->where('id>4')->order('user DESC')->select() );//连贯操作
	}
	
	function lg3(){
		echo __method__;
		$user=M('User');
		dump( $user->where('id>4')->order('user DESC')->limit(2)->select() );//连贯操作
	}
	
	function lg4(){
		echo __method__;
		$user=M('User');
		dump( $user->select(array(
			//'where'=>'id>5',//
			'where'=>array('id'=>array('neq',5)),
			'order'=>'user desc',
		)) );//连贯操作
	}


	function lg5(){
		echo __method__;
		$user=M('User');
		dump( $user->where('id in(3,4,5)')->find() );//连贯操作
	}

	
	function lg6(){
		echo __method__;
		$user=M('User');
		$map['user']='Jim';
		$map['_logic']='Or';
		dump( $user->where($map)->where('id in(1,3)')->select() );//连贯操作
	}

	function lg7(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		dump( $user->field('id,user,email')->select() );//连贯操作field
	}

	function lg8(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		dump( $user->field(array('id','LEFT(email,5)'))->select() );//取出email字段左边5位
	}
	
	function lg9(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		dump( $user->field(array('id','LEFT(email,5)'=>'left5Email2'))->select() );//取出email字段左边5位，并重新命名字段
	}
	function lg10(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		dump( $user->limit(1,1)->select() );//limit用法
	}
	
	function page(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		dump( $user->page(3,2)->select() );//分页的page：5、6
	}
	
	
	function table(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		dump( $user->table('__INFO__')->select() );//用于切换表
		//dump( $user->table('__user__')->select() );//用于切换表
		//dump( $user->table('test.t_user')->select() );//用于切换表
	}
	
		
	function table2(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		//MyDump( $user->field('a.id,b.id')->table('__USER__ as a,__INFO__ as b')->select() );//多表查询
		MyDump( $user->field('a.id,b.id')->table(array('think_user'=>'a', 'think_info'=>'b'))->select() );//多表查询
	}
	
	function table3(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		MyDump( $user->alias('a')->select() );//别名
	}
	
	function table4(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('Info');
		MyDump( $user->field('id,SUM(weight) as sum')->group('uid')->select() );//别名
	}
	
	function table5(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('Info');
		MyDump( $user->comment('查找身高体重')->select() );//添加注释
	}
	
	function table6(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		//MyDump( $user->join('think_info ON think_user.id = think_info.uid ')->select() );//连接查询
		//MyDump( $user->alias('a')->field('a.id,a.user,b.height,b.weight')->join('think_info b ON a.id= b.uid')->select() );//内连接
		//MyDump( $user->alias('a')->field('a.id,a.user,b.height,b.weight')->join('think_info b ON a.id= b.uid','RIGHT')->select() );//右链接
		MyDump( $user->alias('a')->field('a.id,a.user,b.height,b.weight')->join('think_info b ON a.id= b.uid','LEFT')->select() );//左链接
	}
	
	function table7(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		MyDump( $user->field('id')->union('select id form __INFO__')->select() );//UNION todo
	}
	
	function cache(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=M('User');
		//MyDump( $user->select() );//cache
		MyDump( $user->cache(true)->select() );//cache
	}
}

//http://tp.dawneve.cc/index.php/home/User/index

/*
http://tp.dawneve.cc/index.php?c=user
http://tp.dawneve.cc/home/user/login/var/value
*/