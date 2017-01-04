<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class CateController extends AdminController {
    public function showlist($cate_id=0){
    	$user=session('user');
    	$md=M('Cate');
        $info=$md->where('`condition`>0 and cate_uid='.$user['mg_id'])->select(); 
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
           //获取数据
           $user=session('user');
           $cate_name=I('cate_name');
           
           //保存数据
           $md=D('Cate');
           
           //如果同名条目已经存在，则添加失败
           $uid=$user['mg_id'];
           $rs_exist = $md->where("cate_uid = $uid AND cate_name= '".$cate_name."'")->select();
           if(!empty($rs_exist)){
               $this->error('添加失败！该分类已经存在.(可能在回收站)', U());
               exit();
           }
           //拼接数据
           $data=array(
                'cate_name'=>$cate_name,
                'cate_uid'=>$user['mg_id'],
                'condition'=>1,
                'cate_time'=>time(),
                'cate_mod_time'=>time(),
           );
           $md->create($data);
           
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
    
    public function upd($id){
        //1.如果是post提交，则保存数据
        $user=session('user');
        $uid=$user['mg_id'];
        
        if(!empty($_POST)){
           $md=M('Cate');
           
           //1.2如果同名条目已经存在，则添加失败
           $rs_num = $md->where("cate_uid = $uid AND cate_name= '".I('cate_name')."'")->count();
           if($rs_num>0){
               //$this->error('添加失败！该样品名已经存在.(可能在回收站)', U(''));
               echo '添加失败！该样品名已经存在.(可能在回收站)<br />';
               myBtn_back();
               exit();
           }
           
           //2.提交数据
           $data=array(
                'cate_id'=>$id,
                'cate_name'=>I('cate_name'),
                'cate_uid'=>$user['mg_id'],
                'cate_mod_time'=>time(),
           );
           //dump($data);die();
           
           if($md->save($data)){
               $this->success('成功',U('showlist'));
           }else{
               $this->error('失败！'.$md->getError(), U('showlist'));
           }
           die();
        }
        
        //2.不是post则显示表单
        $info=M('Cate')->find($id);
        $this->assign('info',$info);
        
        $this->display();
    }
    
    public function del($id){
       //放到回收站
       $md=M('Cate');
       //$rs=$mg->delete($mg_id);//彻底删除
       $rs=$md->save(array(
            'cate_id'=>$id,
            'cate_mod_time'=>time(),
            'condition'=>0,//0 进入回收站
       ));
       if($rs>0){
            $this->success('成功放到回收站',U('showlist'));
       }else{
            $this->error('失败'.$md->getError(), U('showlist'));
       }
    }
    
    /*
    public function search(){
        getName();
    }
    */
}