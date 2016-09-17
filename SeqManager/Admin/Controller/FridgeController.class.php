<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class FridgeController extends AdminController {
    public function showlist(){
        $user=session('user');
        $md=M('Fridge');
        $info=$md->where('`condition`=1 and fr_uid='.$user['mg_id'])->select(); 
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
           $fr_name=I('fr_name');
           
           //保存数据
           $md=D('Fridge');
           
           //如果同名条目已经存在，则添加失败
           $uid=$user['mg_id'];
           $rs_exist = $md->where("fr_uid = $uid AND fr_name= '".$fr_name."'")->select();
           if(!empty($rs_exist)){
               $this->error('添加失败！该冰箱名已经存在.(可能在回收站)', U());
               exit();
           }
           //拼接数据
           $data=array(
                'fr_name'=>$fr_name,
                'fr_place'=>I('fr_place'),
                'fr_note'=>I('fr_note'),
           
                'fr_uid'=>$user['mg_id'],
                'condition'=>1,
                'fr_time'=>time(),
                'fr_mod_time'=>time(),
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
        if(!empty($_POST)){
           $md=M('Fridge');
           $data=array(
                'fr_id'=>$id,
                'fr_name'=>I('fr_name'),
                'fr_place'=>I('fr_place'),
                'fr_note'=>I('fr_note'),
           
                'fr_mod_time'=>time(),
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
        $info=M('Fridge')->find($id);
        $this->assign('info',$info);
        
        $this->display();
    }
    
    public function del($id){
       //放到回收站
       $md=M('Fridge');
       //$rs=$mg->delete($mg_id);//彻底删除
       $rs=$md->save(array(
            'fr_id'=>$id,
            'fr_mod_time'=>time(),
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