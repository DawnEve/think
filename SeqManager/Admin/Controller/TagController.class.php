<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class TagController extends AdminController {
    public function showlist(){
        $user=session('user');
        $md=M('Tag');
        $info=$md->where('`condition`=1 and tag_uid='.$user['mg_id'])->select(); 
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
           $uid=$user['mg_id'];
           $tag_name=I('tag_name');
           
           //保存数据
           $md=M('Tag');
           
           //如果同名条目已经存在，则添加失败
           $rs_exist = $md->where("tag_uid = $uid AND tag_name= '".$tag_name."'")->select();
           if(!empty($rs_exist)){
               $this->error('添加失败！该标签已经存在.(可能在回收站)', U());
               exit();
           }
           //拼接数据
           $data=array(
                'tag_name'=>$tag_name,
                'tag_uid'=>$user['mg_id'],
                'condition'=>1,
                'tag_time'=>time(),
                'tag_mod_time'=>time(),
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
           $md=M('Tag');
           
           //1.2如果同名条目已经存在，则添加失败
           $rs_num = $md->where("tag_uid = $uid AND tag_name= '".I('tag_name')."'")->count();
           if($rs_num>0){
               //$this->error('添加失败！该样品名已经存在.(可能在回收站)', U(''));
               echo '添加失败！该样品名已经存在.(可能在回收站)<br />';
               myBtn_back();
               exit();
           }
           
           
           //2.提交数据
           $data=array(
                'tag_id'=>$id,
                'tag_name'=>I('tag_name'),
                'tag_uid'=>$user['mg_id'],
                'tag_mod_time'=>time(),
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
        $info=M('Tag')->find($id);
        $this->assign('info',$info);
        
        $this->display();
    }
    
    
    
    public function del($id){
       //放到回收站
       $md=M('Tag');
       //$rs=$mg->delete($mg_id);//彻底删除
       $rs=$md->save(array(
            'tag_id'=>$id,
            'tag_mod_time'=>time(),
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