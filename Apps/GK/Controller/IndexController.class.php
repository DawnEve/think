<?php
namespace GK\Controller;
use Think\Controller;
class IndexController extends Controller {
	/*
	 * 负责显示
	 */
    public function index(){
    	// 获取父级数据
    	$data=M('knowledge')->where('pid=0')->order('klID')->select();
        //递归构建树形结构
		$this->createTree($data);
		//输出树形结构
		echo '<pre>';
		print_r($this->tree);
	}

	
	/* 私有方法：递归分层显示。
	 * 
	 * 缺点:
	 * 1.递归查询次数过多！
	 * 2.需要js配合过滤数据。
	 */
	private function createTree($data=null, $level=1){
		//一次性取出每个传入元素的子元素
		for($i=0; $i<count($data); $i++){
			//对刚传入的数字赋值level
			$data[$i]['level']=$level;
			//把该元素加入到数组中
			$this->tree[count($this->tree)] = $data[$i];
			
			// 查找pid = 该条目id的元素
			$res=M('knowledge')->where('pid='.$data[$i]['klid'])->select();
			//进入下一层递归
			$this->createTree($res, ($level+1));
		}
	}
	
	public function show(){
		echo 'from show method';
	}
	
	
	
	
	// 查看数据表
	function select($id){
		$tb='knowledge';
		if($id==2) $tb='test_kl_real';
		if($id==3) $tb='user_answerrecord';
		
		echo 'tableName: zj_', $tb,'<hr>';
		
		$data=M($tb)->select();
		dump($data);
	}
}