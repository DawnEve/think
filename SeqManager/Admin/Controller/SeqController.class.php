<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class SeqController extends AdminController {
    //public function showlist($cate_id=0,$tag_id=0){
    public function showlist($by='',$id=0){
        $user=session('user');
        $uid=$user['mg_id'];
        $this->assign('uid',$uid);
        
        $info=D('Oligo')->getData($by,$id); 
        $this->assign('info',$info[0]);
        $this->assign('info_num',count($info[0]));
        
        //类别提示语
        $this->assign('hint_text',$info[1]);
        
        $this->display();
    }
    
    
    //显示具体要求
    public function detail($id=''){
        $oligo_id=$id;
        //1.如果没有指定id，则返回showlist页面
        if(empty($oligo_id)){
           $this->error('Error:请指定条目id',U('showlist'));
           die();
        }
        
        
        //2.获取oligo数据
        $user=session('user');
        $uid=$user['mg_id'];
        $info=D('Oligo')->getDetail($oligo_id);
        $this->assign('info',$info);
        /*
array(22) {
  ["oligo_id"] => string(1) "6"
  ["oligo_name"] => string(10) "5个文件"
  ["oligo_order_no"] => string(4) "xx02"
  ["oligo_sequence"] => string(6) "aaattt"
  ["oligo_en_site"] => string(5) "BamHI"
  ["oligo_note"] => string(10) "5个文件"
  ["file_ids"] => string(9) "1,2,3,4,5"
  ["oligo_time"] => string(10) "1474273061"
  ["oligo_mod_time"] => string(10) "1474273061"
  ["cate_id"] => string(1) "2"
  ["tag_ids"] => string(2) "15"
  ["box_id"] => string(1) "1"
  ["place"] => string(6) " (1,8)"
  ["condition"] => string(1) "1"
  ["oligo_uid"] => string(1) "5"
  ["cate_name"] => string(5) "phage"
  ["tag_name_links"] => string(59) "<a class=tag href='/admin/Oligo/showlist/tag_id/15'>cd8</a>"
  ["file_links"] => string(423) "附件1: <a href="/Public/Uploads/20160919/57df9f258845a.jpeg">20130717130913_WSUWJ.thumb.700_0.jpeg</a><br>附件2: <a href="/Public/Uploads/20160919/57df9f2588842.jpg">island.jpg</a><br>附件3: <a href="/Public/Uploads/20160919/57df9f2589207.jpg">jeff1.jpg</a><br>附件4: <a href="/Public/Uploads/20160919/57df9f2589bcb.jpg">jeff2.jpg</a><br>附件5: <a href="/Public/Uploads/20160919/57df9f258a58f.jpg">vr2.jpg</a><br>"
  ["box_name"] => string(17) "phage保存菌种"
  ["box_place"] => string(58) "第2层左起第1个抽屉第3层从外向内第1个位置"
  ["fr_id"] => string(1) "1"
  ["fr_name"] => string(8) "4冰箱1"
}
         * */
        $this->display();
    }
    
    public function add(){
        //1.如果有post数据
        if(!empty($_POST)){
           //1.1获取数据
           $user=session('user');
           $oligo_name=I('oligo_name');
           
           //1.2如果同名条目已经存在，则添加失败
           $md=M('Oligo');
           $uid=$user['mg_id'];
           $rs_exist = $md->where("oligo_uid = $uid AND oligo_name= '".$oligo_name."'")->select();
           if(!empty($rs_exist)){
               $this->error('添加失败！该样品名已经存在.(可能在回收站)', U());
               exit();
           }
           
           //1.3上传文件、保存文件名和地址到数据库、返回文件id
           $file_ids='';
           //判断是否有文件，且文件大小超过0
           //dump($_FILES['file_ids']['size'][0]);die();
           if (!empty($_FILES) && isset($_FILES["file_ids"]) && $_FILES["file_ids"]["size"][0]>0){
               $file_ids_arr=A('File')->upload();
               $file_ids=implode(',',$file_ids_arr);//"1,2,3"; 
           }
           
           //1.4从tag_name字符串到tag_ids
           $str=I('tag_ids');//"protein100,cd47,Good";
           $tag_ids=A('Tag','Logic')->get_tag_ids($str);
           
           //1.5拼接其他数据
           $data=array(
                //核心信息
                'oligo_name'=>$oligo_name,
                'oligo_order_no'=>I('oligo_order_no'),
                'oligo_sequence'=>I('oligo_sequence'),
                'oligo_en_site'=>I('oligo_en_site'),
                'oligo_note'=>I('oligo_note'),
                'file_ids'=>$file_ids,
           
                //类别信息
                'cate_id'=>I('cate_id'),
                'tag_ids'=>$tag_ids,
                
                //位置信息
                'fridge_id'=>I('fridge_id'),
                'box_id'=>I('box_id'),
                'place'=>I('place'),
           
                //其他信息
                'oligo_uid'=>$user['mg_id'],
                'condition'=>1,
                'oligo_time'=>time(),
                'oligo_mod_time'=>time(),
           );
           //1.6提交数据           
           $w=$md->create($data);
           $rs=$md->add();
           
           //1.7判断提交是否成功
           if($rs){
               $this->success('成功！',U('showlist'));
           }else{
               $this->error('失败！'.$md->getError(), U('showlist'));
           }
           die();
        }
        
        //2.如果没有post数据，则显示表单
        //2.1获取分类数据
        $this->assign('cate_list',getlist('cate'));
        //2.2获取标签数据
        $this->assign('tag_list',getlist('tag'));
        //2.3获取冰箱数据
        $this->assign('fridge_list',getlist('fridge','fr',1));
        //2.4获取盒子数据
        $this->assign('box_list',getlist('box'));
        
        $this->display();
    }
    
    public function upd($id=0,$uid=0){
        if($id==0){
           echo '错误：请指定id!<br>';
           myBtn_back();
           exit();
        }
        
        $oligo_id=$id;
        
        //uid
        if($uid==0){
            $user=session('user');
            $uid=$user['mg_id'];
        }
        
        //1.如果是post提交，则保存数据
        $md=M('Oligo');
        if(!empty($_POST)){
            //1.1获取数据
            $oligo_name=I('oligo_name');
            
            //1.2如果同名条目已经存在，则添加失败
           $rs_num = $md->where("oligo_uid = $uid AND oligo_name= '".$oligo_name."'")->count();
           //dump($rs_num);
           if($rs_num>1){
               //$this->error('添加失败！该样品名已经存在.(可能在回收站)', U(''));
               echo '添加失败！该样品名已经存在.(可能在回收站)';
               myBtn_back();
               exit();
           }
           //1.3上传文件、保存文件名和地址到数据库、返回文件id【老的文件id不变吗？】
           $file_ids='';
           //判断是否有文件，且文件大小超过0
           //dump($_FILES['file_ids']['size'][0]);die();
               // debug($_FILES);     
           if (!empty($_FILES) && isset($_FILES["file_ids"]) && $_FILES["file_ids"]["size"][0]>0){
               $file_ids_arr=A('File')->upload();
               $file_ids=implode(',',$file_ids_arr);//"1,2,3"; 
           }
                //debug($file_ids);//0
           //1.3.5 获取以前的文件名字符串
           $old_file_ids_arr=$md->field('file_ids')->find($id);
           $old_file_ids=$old_file_ids_arr['file_ids'];
           //debug($old_file_ids);//19
           //1.3.6新旧字符串拼接
            //debug(strlen($old_file_ids));
           if(strlen($old_file_ids)>0){
                if(strlen($file_ids)>0){
                    $file_ids = $old_file_ids.','.$file_ids; //拼接上old_file_ids
                }else{
                    $file_ids=$old_file_ids;
                }
           }
           //debug($file_ids);
           //1.4从tag_name字符串到tag_ids
           $str=I('tag_ids');//"protein100,cd47,Good";
           $tag_ids=A('Tag','Logic')->get_tag_ids($str);
           
           //1.5拼接其他数据
           $data=array(
                'oligo_id'=>$oligo_id,
                //核心信息
                'oligo_name'=>$oligo_name,
                'oligo_order_no'=>I('oligo_order_no'),
                'oligo_sequence'=>I('oligo_sequence'),
                'oligo_en_site'=>I('oligo_en_site'),
                'oligo_note'=>I('oligo_note'),
                'file_ids'=>$file_ids,
           
                //类别信息
                'cate_id'=>I('cate_id'),
                'tag_ids'=>$tag_ids,
                
                //位置信息
                'fridge_id'=>I('fridge_id'),
                'box_id'=>I('box_id'),
                'place'=>I('place'),
           
                //其他信息
                'oligo_uid'=>$user['mg_id'],
                'condition'=>1,
                //'oligo_time'=>time(),
                'oligo_mod_time'=>time(),
           );

           //debug($data);
           //1.6提交数据           
           $rs =$md->save($data);
           
           //1.7判断提交是否成功
           if($rs){
               $this->success('成功！',U('detail',array('id'=>$id)));
           }else{
               $this->error('失败！'.$md->getError(), U('showlist'));
           }
           die();
        }
        
        //2.如果没有post数据，则显示表单      
        $info=D('Oligo')->getDetail($oligo_id,$uid,true);
        $this->assign('info',$info);
        //debug($info);
        
        $this->assign('cate_id',$info['cate_id']);//cate_id
        $this->assign('fr_id',$info['fr_id']);//fr_id
        $this->assign('box_id',$info['box_id']);//box_id
        
        //2.1获取分类数据
        $this->assign('cate_list',getlist('cate'));
        //2.2获取标签数据
        $this->assign('tag_list',getlist('tag'));
        //2.3获取冰箱数据
        $this->assign('fridge_list',getlist('fridge','fr',1));
        //2.4获取盒子数据
        $this->assign('box_list',getlist('box'));
        
        $this->display();
    }
    
    
    
    public function del($id){
       //放到回收站
       $md=M('Oligo');
       //$rs=$mg->delete($mg_id);//彻底删除
       $rs=$md->save(array(
            'oligo_id'=>$id,
            'oligo_mod_time'=>time(),
            'condition'=>0,//0 进入回收站
       ));
       if($rs>0){
            $this->success('成功放到回收站',U('showlist'));
       }else{
            $this->error('失败'.$md->getError(), U('showlist'));
       }
    }
    
    
    
    public function search(){
        getName();
    }
}