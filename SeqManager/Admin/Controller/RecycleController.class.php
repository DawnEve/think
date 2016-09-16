<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class RecycleController extends AdminController {
    public function showlist($tb_name=''){
        //getName();
        //数据表名字和表前缀
        $tables=$this->getTables();
    	if(!empty($tb_name)){
    		//当前表
    		$this->assign('tb_name',$tb_name);
    		//当前表的字段前缀
    		$prefix=$tables[$tb_name];
    		$this->assign('prefix',$prefix);
    		//删除的数据
    		$data[$tb_name]=M($tb_name)->where('`condition`=0')->order($prefix.'_mod_time DESC')->select();
    		$this->assign('data',$data['box']);
//    		dump($data['box']);
            //1.如果具体表格，则使用模板2
    		$this->display(ACTION_NAME . '2');
    	}else{
    		//2.否则使用统计表格，默认模板
	        //对表格进行循环统计
	        $data=array();
	        foreach($tables as $tb=>$value){
	            $data[$tb]=M($tb)->where('`condition`=0')->count();
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
    
    
    //TODO
    public function restore($tb_name,$id){
        //getName();
        echo $tb_name.'-'.$id;
    }
    
    //TODO
    public function delete($tb_name,$id){
        echo $tb_name.'-'.$id;
    }
    
    /*
     * 数据表名字和表前缀
     * */
    private function getTables(){
        return array(
            'seq'=>'seq','oligo'=>'oligo','file'=>'file',
            'cate'=>'cate','tag'=>'tag',
            'fridge'=>'fr','box'=>'box',
            //'auth'=>'auth','role'=>'role','manager'=>'manager',
        );
    }
    
}