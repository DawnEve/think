<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class BoxController extends AdminController {
    public function showlist(){
        $user=session('user');
        $this->assign('uid',$user['mg_id']);
        
        $md=M('Box');
        $info=$md->where('`condition`=1 and box_uid='.$user['mg_id'])->select(); 
        $this->assign('info',$info);
        $this->assign('info_num',count($info));
        
        //从Logic层获取冰箱数据列表array(1=>'1号冰箱',2=>'2号冰箱');
        $fr_data=A('Fridge','Logic')->getList();
        $this->assign('fr_data',$fr_data);
        
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
           $box_name=I('box_name');
           
           //保存数据
           $md=D('Box');
           
           //如果同名条目已经存在，则添加失败
           $uid=$user['mg_id'];
           $rs_exist = $md->where("box_uid = $uid AND box_name= '".$box_name."'")->select();
           if(!empty($rs_exist)){
               $this->error('添加失败！该盒子名已经存在.(可能在回收站)', U());
               exit();
           }
           //拼接数据
           $data=array(
                'box_name'=>$box_name,
                'box_place'=>I('box_place'),
                'box_note'=>I('box_note'),
                'box_fr_id'=>I('box_fr_id'),
           
                'box_uid'=>$user['mg_id'],
                'condition'=>1,
                'box_time'=>time(),
                'box_mod_time'=>time(),
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
        $fr_data=A('Fridge','Logic')->getList();
        $this->assign('fr_data',$fr_data);
        $this->display();
    }
    
    //TODO
    public function upd($id){
        //1.如果是post提交，则保存数据
        $user=session('user');
        if(!empty($_POST)){
           $md=M('Box');
           $data=array(
                'box_id'=>$id,
                'box_name'=>I('box_name'),
                'box_place'=>I('box_place'),
                'box_note'=>I('box_note'),
                'box_fr_id'=>I('box_fr_id'),
           
                'box_mod_time'=>time(),
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
        $info=M('Box')->find($id);
        $this->assign('info',$info);
        $this->assign('sel',$info['box_fr_id']);
        //获取冰箱信息
        $fr_data=A('Fridge','Logic')->getList();
        $this->assign('fr_data',$fr_data);
        
        $this->display();
    }
    
    //TODO
    public function del($id){
        //放到回收站
       $md=M('Box');
       //$rs=$mg->delete($mg_id);//彻底删除
       $rs=$md->save(array(
            'box_id'=>$id,
            'box_mod_time'=>time(),
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