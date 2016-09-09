<?php
namespace Home\Controller;
use Think\Controller;

class BlogController extends Controller {
    //登录检测
    public function login(){
    	//1.验证用户名和密码是否正确
		$m=new \Home\Model\UserModel();
		//$m = D('User');
		$rs = $m->checkLogin('Timoc','123456');
		if($rs===false){
            echo '用户名或密码错误！';
		}else{
            echo '登录成功';
            //2.登录信息持久化
            session('user',$rs);
            $id=$rs['id'];
            
		    //dump(session('user'));
		    //3.跳转到首页
		    //方法1 使用函数，url需要时U方法生成的，或绝对地址
		    redirect(U('Blog/index',array('uid'=>$id)),3,'正在跳转到后台！(function)'); 
		    //方法2 使用方法，url只需要使用控制器和操作
		    //$this->redirect('Blog/index',array('uid'=>$id),3,'正在跳转到后台！(method)'); 
		}
	}
	
    public function index(){
		$u=session('user');
		if($u!=null){
		   echo '登录名： ' . $u['user'];
		   echo ' | <a href="'.U('logout').'">'."退出" . '</a>';
		}else{
	        echo '请登录!';
    		$this->display();
		}

		//D('User'); //实例化UserModel
		//D('User','Logic'); //实例化UserLogic
	}
	
	//logotu
	function logout(){
	   session(null);
	   redirect(U('index'));
	}
	
	function session(){
	   dump(session('user'));
	}
	
	public function test(){
	   //echo 'user->test method.';
	   echo U("Blog/index") . '<hr>';
	   
       // redirect(U("Blog/index"),3,'3s后跳转到首页' );
	   $this->redirect("index",array('id'=>2),3,'3s后跳转到首页' );
	   
	   //$this->display();
	}
	
	//url生成
	function login2(){
		//C('URL_MODEL', 0);
		echo C('URL_MODEL') . ' - ';
	    echo U('User/login');
	    //0 - /index.php?m=&c=user&a=login
	    //1 - /index.php/user/login.html
	    //2 - /user/login.html
	    //3 - /index.php?s=/user/login.html
	}
	
	//页面模板
	function page(){
	   $this->display();
	}
	
	function man(){
	   //echo '123';
	   R('Admin/User/number');
	}
	
	//实例化Event控制器
	function getData(){
	   $u=A('User','Event');
	   $u->hi();
	}
	
	function data(){
	   //$t=new \Home\Model\BlogModel();//Home\Model\BlogModel  $t->output()
	   //$t=M();//Think\Model
	   //$t=M('Blog');//Think\Model
	   //$t=D();//Think\Model
	   $t=D('Blog');//Home\Model\BlogModel  $t->output()
	   dump($t);
	}
	
	//自我验证
	function auth(){
		echo '123';
	    B('Home\Behavior\AuthCheck');
	}
	
	//验证码图片生成
	function verifyIMG(){
	   $config=array(
	       //'imageW'=>120, 
	       //'imageH'=>30, 
	       //'fontSize'=>14, 
	       'length'=>4,
	       'fontttf'=>'4.ttf',
	       //'useImgBg '=>false,
	       //'useZh '=>true, //为什么数组中定义没用？
	   );
	   $vr=new \Think\Verify($config);

	   //开启验证码背景图片功能 随机使用 ThinkPHP/Library/Think/Verify/bgs 目录下面的图片
	   $vr->useImgBg = false;
	   
	   // 验证码字体使用 ThinkPHP/Library/Think/Verify/ttfs/5.ttf
	   //$vr->useZh = true; 
	   
	   ob_clean();
	   $vr->entry(1);
	}
	
	
	//验证码图片生成
    function verify($code, $id =1){
         $verify = new \Think\Verify(); 
         $rs = $verify->check($code, $id);
         dump( $rs);
         //return $rs;
    }
    
    //调用自定义类，并实例化
    function page2(){
        $page=new \Component\Page();
        $info = $page->fpage();
        echo ($info);
    }
   
    
    
    //这里读取，分页1
    function showlist(){
    	$wb=D('Weibo');
        //1.获取总条目
        $total=$wb->count();
        //2.实例化分页对象
        $per=5;
        $page=new \Component\Page($total,$per);//自定义分页类
        //3.拼装sql语句
        $sql="select * from think_weibo ". $page->limit;
        $info=$wb->query($sql);
        //4.获得页码代码
        $pagelist=$page->fpage(); //自定义分页类
        //5.模板显示
        $this->assign('info',$info);
        $this->assign('pagelist',$pagelist);
        $this->display();
    }
    
//这里读取，分页1
    function showlist2(){
        $wb=D('Weibo');
        //1.获取总条目
        $total=$wb->count();
        //2.实例化分页对象
        $per=5;
        
        //$page=new \Component\Page($total,$per);//自定义分页类
        $page=new \Think\Page($total, $per);//tp内置分页类
        
        //3.拼装sql语句
        $sql="select * from think_weibo ". $page->limit;
        $info=$wb->query($sql);
        //4.获得页码代码
        //$pagelist=$page->fpage(); //自定义分页类
        $pagelist=$page->show();//tp内置分页类
        //5.模板显示
        $this->assign('info',$info);
        $this->assign('pagelist',$pagelist);
        $this->display();
    }

    //从logic层直接获取数据，不经过数据库
    function test2(){
        $user=A('User','Logic');
        echo $user->getdata();
    }
}