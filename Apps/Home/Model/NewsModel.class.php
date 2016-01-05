<?php
namespace Home\Model;
use Think\Model;
class NewsModel extends Model{
	protected $_scope=array(
		'sql1'=>array(
			'where'=>array('id>1'),
		),
		'sql2'=>array(
			'order'=>array('add_time'=>'DESC'),
			'limit'=>2,
		),
		
	);

	function __construct(){
		parent::__construct();//这一句一定要加上！
		echo '<h1>from news model.</h1>';
	}
}