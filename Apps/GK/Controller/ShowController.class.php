<?php
namespace GK\Controller;
use Think\Controller;

class ShowController extends Controller {
	private $result=array();
	/*
	 * win7
	 * PHP Version 5.5.1
	 * mysqlnd 5.0.11-dev
	 * thinkPHP3.2.3
	 */
    public function index(){
	    //获取全部数据
    	$data=M('knowledge')->field('klid,klname,pid')->select();
    	//获取答题情况
    	$this->getResult();
    	//生成树形结构
    	$tree = $this->getTree($data,0);
    	$tree=$tree[0];
    	//为一级和二级节点添加大体情况
    	$this->calc($tree);
    	//输出结果
    	echo '<pre>';
    	print_r($tree);
    	echo '</pre>';
    }
	
    // 遍历树状结构，统计结果
    function calc(&$data){
    	foreach($data as $k1=>$v1){
    		$two=$v1['pid']; //echo '-------'; p($v1);
	    	foreach($two as $k2=>$v2){
	    		$data[$k1]['result'] .= $v2['result'];
	    	}
    	}
    }
    
	//连接答题结果，赋值给类变量
	private function getResult(){
    	// 获取父级数据
    	$data = M('test_kl_real')->alias('a')
    	  ->field('a.KlID, b.IfRight')
    	  ->join('__USER_ANSWERRECORD__ b on a.TestID = b.TestID','RIGHT')
    	  ->select();
    	  
    	 //分离正确选项
    	 for($i=0;$i<count($data); $i++){
    	 	$row=$data[$i];
    	 	$id=$row['klid'];
    	 	//初始化，抑制错误提示
	    	if(!array_key_exists($id, $this->result)){
	    		$this->result[$id]='';
	    	}
    	 	$this->result[$id] .= $row['ifright'];
    	 }
	}


	/* http://bbs.csdn.net/topics/391832442
	 * 数组转换成树型结构
	 */
	private function getTree($data,$pid,$level=1){
	    if (!is_array($data) || empty($data) ) return false;
	    $tree = array();//保存树状结构
	    $result ='';
	    
	    foreach ($data as $k => $v) {
			$v['lever']=$level;	//层级		
			$id = $v['klid'];
	    	//初始化，抑制错误提示
	    	if(!array_key_exists('result', $v)){
	    		$v['result'] = '';
				//获取答题情况
		    	if(array_key_exists($id, $this->result)){
			    	$v['result'] = $this->result[ $id ];
		    	}
	    	}
	    	
        	//当相等时，说明此数组为上个数组的子目录	
	        if ($v['pid'] == $pid) {
	            unset($data[$k]); //删除遍历过的数组数据，避免无效遍历
	            
	        	$result .= $v['result'];
	        	//递归返回树结构
	        	$treeTmp = self::getTree($data, $v['klid'],($level+1));
				if( count($treeTmp[0])>0 ){
					$v['pid']=$treeTmp[0];
				}
				$v['result'] .= $treeTmp[1];

	            $tree[] = $v;
	        }
	    }
	    return array( $tree, $result );
	}
}