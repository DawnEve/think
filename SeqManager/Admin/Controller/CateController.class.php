<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class CateController extends AdminController {
    public function showlist(){
    	$user=session('user');
    	$md=M('Cate');
    	$info=$md->where('`condition`=1 and cate_uid='.$user['mg_id'])->select(); 
        $this->assign('info',$info);
        $this->assign('info_num',count($info));
        $this->display();
    }
    
    /*
    public function show(){
        getName();
    }
    */
    
    public function add(){
        //1.如果有post数据
        if(!empty($_POST)){
           //保存数据
           $md=D('Cate');
           $user=session('user');// dump($user);die();//debug
           $data=array(
                'cate_name'=>I('cate_name'),
                'cate_uid'=>$user['mg_id'],
                'condition'=>1,
                'cate_time'=>time(),
                'cate_mod_time'=>time(),
           );
           $wjl=$md->create($data);
           
           $rs=$md->add();
           //判断结果
           if($rs){
               $this->success('成功！',U('showlist'));
           }else{
               $this->error('失败！'.$md->getError(), U('showlist'));
           }
           die();
        }
        
        //2.如果没有post数据，则显示表单
        $this->display();
    }
    
    public function upd(){
        getName();
    }
    
    public function del(){
        getName();
    }
    
    /*
    public function search(){
        getName();
    }
    */
}