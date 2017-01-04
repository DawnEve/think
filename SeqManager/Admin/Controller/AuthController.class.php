<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class AuthController extends AdminController {
	//显示角色列表
    public function showlist(){
        $auth_info=$this->getInfo();
        $this->assign('auth_info',$auth_info);
        $this->assign('auth_info_num',count($auth_info));
        $this->display();
    }
    
    //添加权限
    function add(){
    	//1.如果有post数据
    	if(!empty($_POST)){
    	   //在模型中保存权限信息
    	   $auth=D('Auth');
    	   $rs=$auth->saveAuth();
    	   //判断结果
    	   if($rs){
    	       $this->success('成功！',U('showlist'));
    	   }else{
    	       $this->error('失败！'.$auth->getError(), U('showlist'));
    	   }
    	   die();
    	}
    	
    	//2.如果没有post数据，则显示表单
        $auth_info=$this->getInfo(2);
        /*
         [1] => array(7) {
    ["auth_id"] => string(1) "4"
    ["auth_name"] => string(24) "&nbsp;&nbsp;商品列表"
    ["auth_pid"] => string(1) "1"
    ["auth_c"] => string(5) "Goods"
    ["auth_a"] => string(8) "showlist"
    ["auth_path"] => string(3) "1-4"
    ["auth_level"] => string(1) "1"
  }
         * */
        //2.1转变成array(1=>'权限管理', 2=>'添加权限')
        $auth_select=array();
        foreach($auth_info as $v){
            $auth_select[$v['auth_id']]=$v['auth_name'];
        }
        $this->assign('auth_select',$auth_select);
        $this->display();
    }
    
    //todo
    public function upd(){
        getName();
    }
    
    //todo
    public function del(){
        getName();
    }
    
    
    /**
     * 私有方法，只能内部使用
    //获取Auth_info数据
    //分别用于showlist显示，和add下拉框(level<2)
     */
    private function getInfo($auth_level=false){
    	$auth=M('Auth');
        //从属关系使用order全路径表示 
        if(false === $auth_level){
            $auth_info=$auth->order('auth_path')->select();
        }else{
            $auth_info=$auth->where("auth_level<$auth_level")->order('auth_path')->select();
        }
        
        //缩进关系，提现从属关系
        foreach($auth_info as $k=>$v){
            //$auth_info[$k]['auth_name']=str_repeat('&nbsp;&nbsp;',$v['auth_level']).$v['auth_name'];
            $auth_info[$k]['auth_name']=str_repeat('—>',$v['auth_level']).$v['auth_name'];
        }
        return $auth_info;
    }
}