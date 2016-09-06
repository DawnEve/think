<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	//protected $tablePrefix='t_';//修改表前缀
	//protected $tableName='abc';//修改表名 'think.think_abc' doesn't exist
	//protected $trueTableName='abc';//修改表真名 'think.abc' doesn't exist
	//protected $dbName='test';//修改数据库名 'test.think_user' doesn't exist 
	
//	protected $patchValidate = true;
	
	//定义自动验证
	protected $_validate=array(
//		array('user','require','用户名必须填写',1),
//		array('email','require','邮箱必须填写',1),
//		array('add_time','require','添加时间必须填写',1),
		
		//array('num','/^\d{2,5}$/','必须是2-5位的数字',0,'regex'),//使用正则表达式作为验证条件
		//array('num','123456','传递过来的值不相等',0,'equal'),//必须与传递过来的值相等
//		array('psw','repsw','密码不一致',0,'confirm'), //验证密码是否一致
//		array('user','张三,李四,王五', '不在给定的范围内！',0,'in'), //值必须在给定范围
//		array('psw','6,8', '密码必须6-8位',0,'length'), //密码必须是6-8位长度
//		array('psw','6,8', '密码必须6-8位',1,'between'), //密码必须是6-8位长度
//		array('psw',array(6,8), '密码必须6-8位',0,'notbetween'), //密码必须是6-8位长度. 不起作用【失败】??
		
//		array('email', '', '邮箱已经存在！', 1, 'unique', 3), // email唯一

//		array('user', '202.196.120.202', '您的IP被允许！', 1, 'ip_allow'), // IP访问权限
        //array('user', '202.196.120.202', '您的IP被禁止！', 1, 'ip_deny'), // IP访问权限
        
		
//      array('psw', 'checkLength', '密码至少6位！', 0, 'callback', 3), // callback验证
//        array('psw', 'checkLength2', '密码至少6位！', 0, 'function', 3), // function验证

	);

	protected function checkLength($str){
	   if( strlen($str) < 6){
	       return false;
	   }
	   return true;
	}
		
		
	
	//定义自动完成
	protected $_auto=array(
		//array('user','sha1',3,'function'),
//		array('modi_time','time',1,'function'), //更新的时候这一句不起作用？
		array('modi_time','time',3,'function'), //3就可以了
		
//		array('user','email',3,'field'),//field 用其它字段填充，表示填充的内容是一个其他字段的值 
//		array('user','addPrefix',3,'callback','wjl_'),//callback调用模型方法 
		
		array('user','',2,'ignore') 
		
	);
	
	function addPrefix($str,$prefix){
	   return '2016_' . $prefix . $str;
	}
	
	
	/*
	*/
	
	/*
	//type定义每个字段的类型，可以永远字段验证。
	protected $fields=array('id','user','email','_pk'=>'id',
		'type'=>array('id'=>'smallint', 'user'=>'varchar')	);
	
	
	public function __construct(){
		parent::__construct();
		echo '[from UserModel->__construct()]<hr>';
	}
    */
	
	
    //返回一维数组
    function checkLogin($user='Tom',$passwd=''){
        $info = $this->getByUser($user);
        if($info != null){
            if(md5($passwd) == $info['passwd']){
            	unset($info['passwd']);//防止密码泄露
                return $info;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    
}