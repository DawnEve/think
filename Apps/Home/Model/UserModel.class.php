<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	//protected $tablePrefix='t_';//�޸ı�ǰ׺
	//protected $tableName='abc';//�޸ı��� 'think.think_abc' doesn't exist
	//protected $trueTableName='abc';//�޸ı����� 'think.abc' doesn't exist
	//protected $dbName='test';//�޸����ݿ��� 'test.think_user' doesn't exist 
	
	/*
	//�����Զ���֤
	protected $_validate=array(
		array('name','require','�������'),
	);
	
	//�����Զ����
	protected $_auto=array(
		array('create_time','time',1,'function'),
	);
	*/
	
	//type����ÿ���ֶε����ͣ�������Զ�ֶ���֤��
	protected $fields=array('id','user','email','_pk'=>'id',
		'type'=>array('id'=>'smallint', 'user'=>'varchar')	);
	
	
	public function __construct(){
		parent::__construct();
		echo '[from UserModel->__construct()]<hr>';
	}

}