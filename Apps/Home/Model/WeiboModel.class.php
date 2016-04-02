<?php
namespace Home\Model;
use Think\Model;
class WeiboModel extends Model{
	protected $_auto = array (         
		//array('status','1'),  // 新增的时候把status字段设置为1         
		//array('password','md5',3,'function') , // 对password字段在新增和编辑的时候使md5函数处理         
		//array('name','getName',3,'callback'), // 对name字段在新增和编辑的时候回调getName方法         
		//array('update_time','time',2,'function'), // 对update_time字段在更新的时候写入当前时间戳     );
		array('add_time','time',1,'function'), // 对update_time字段在添加的时候写入当前时间戳     );
	);
	
	protected $_validate=array(
		array('content','require','内容必须'),
	);
		
}