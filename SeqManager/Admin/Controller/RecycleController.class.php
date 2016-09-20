<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class RecycleController extends AdminController {
    public function showlist($tb_name=''){
        //getName();
        //数据表名字和表前缀
        $tables=$this->getTables();
    	//当前表的字段前缀
    	$prefix=$tables[$tb_name];
    	$this->assign('prefix',$prefix);
    	
   		$user=session('user');
    	if(!empty($tb_name)){
    		//当前表
    		$this->assign('tb_name',$tb_name);
    		//删除的数据
    		$data[$tb_name]=M($tb_name)
    		      ->where('`condition`=0 and '.$prefix.'_uid='.$user['mg_id'])
    		      ->order($prefix.'_mod_time DESC')
    		      ->select();
    		$this->assign('data',$data[$tb_name]);
    		//dump($data['box']);

            //1.如果具体表格，则使用模板2
    		$this->display(ACTION_NAME . '2');
    	}else{
    		//2.否则使用统计表格，默认模板
	        //对表格进行循环统计
	        $data=array();
	        foreach($tables as $tb=>$value){
	        	$prefix2=$tables[$tb];
	            $data[$tb]=M($tb)
	               //->where('`condition`=0')
	               ->where('`condition`=0 and '.$prefix2.'_uid='.$user['mg_id'])
	               ->count();
	        }
	        /*
	         array(10) {
	  ["role"] => string(1) "0"
	  ["manager"] => string(1) "1"
	}
	         * */
	        $this->assign('data',$data);
	        $this->display();
    	}
        
    }
    
    
    //还原条目
    public function restore($tb_name,$id){
    	if(empty($tb_name) or empty($id)){
    	   die('Invalid Parameter');
    	}
    	//获取数据
        $tables=$this->getTables();
        $prefix=$tables[$tb_name];
        
        //修改condition=1
        $m=M($tb_name);
        $data=array(
            $prefix.'_id'=>$id,
            $prefix.'_mod_time'=>time(),
            'condition'=>1,
        );
        if($m->save($data)){
            $this->success('成功',U('showlist'));
        }else{
            $this->success('失败' . $m->getError(),U('showlist'));
        }
    }
    
    //彻底删除
    public function delete($tb_name,$id){
        if(empty($tb_name) or empty($id)){
           die('Invalid Parameter');
        }
        //获取数据
        $tables=$this->getTables();
        $prefix=$tables[$tb_name];
        
        //如果不是condition=0，则直接返回
        $m=M($tb_name);
        $con=$m->where($prefix.'_id='.$id)->getField('condition');
        if($con!=0){
            $this->error('放入回收站的条目才能删除！',U('showlist'));
            die();
        }
        
        //已经放到回收站，则可以删除了
        if($m->delete($id)){
            $this->success('成功',U('showlist'));
        }else{
            $this->success('失败' . $m->getError(),U('showlist'));
        }
        
    }
    
    /*
     * 数据表名字和表前缀
     * */
    private function getTables(){
    	$data=array(
            'seq'=>'seq','oligo'=>'oligo','file'=>'file',
            'cate'=>'cate','tag'=>'tag',
            'box'=>'box',
        );
        //如果是管理员，则回收站有更多东西。
        $user=session('user');
        if($user['mg_id']==1){
            $data2=array(
                'fridge'=>'fr',
                'auth'=>'auth','role'=>'role','manager'=>'mg',
            );
            $data=array_merge($data,$data2);
        }
        return $data;
    }
    
}