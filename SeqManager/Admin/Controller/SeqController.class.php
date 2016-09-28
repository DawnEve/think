<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class SeqController extends AdminController {
    //public function showlist($cate_id=0,$tag_id=0){
    public function showlist($by='',$id=0){
        $user=session('user');
        $uid=$user['mg_id'];
        $this->assign('uid',$uid);
        
        $info=D('Seq')->getData($by,$id); 
        $this->assign('info',$info[0]);
        $this->assign('info_num',count($info[0]));
        //debug($info);
        //类别提示语
        $this->assign('hint_text',$info[1]);
        
        $this->display();
    }
    
    
    //显示具体要求
    public function detail($id=''){
        $seq_id=$id;
        //1.如果没有指定id，则返回showlist页面
        if(empty($seq_id)){
           $this->error('Error:请指定条目id',U('showlist'));
           die();
        }
        
        
        //2.获取seq数据
        $user=session('user');
        $uid=$user['mg_id'];
        $info=D('Seq')->getDetail($seq_id);
        $this->assign('info',$info);
        //debug($info);
        /*
array(26) {
  ["seq_id"] => string(1) "1"
  ["seq_name"] => string(3) "001"
  ["seq_order_no"] => string(3) "002"
  ["seq_sequence"] => string(7) "aaaaaaa"
  ["seq_en_site"] => string(2) "xx"
  ["seq_note"] => string(23) "第二个，
第二行"
  ["file_ids"] => string(2) "32"
  ["seq_time"] => string(10) "1474891740"
  ["seq_mod_time"] => string(10) "1474940530"
  ["cate_id"] => string(1) "2"
  ["tag_ids"] => string(6) "4,18,5"
  ["box_id"] => string(1) "3"
  ["palce"] => NULL
  ["condition"] => string(1) "1"
  ["seq_oligo_ids"] => string(1) "2"
  ["seq_uid"] => string(1) "5"
  ["cate_name"] => string(5) "phage"
  ["tag_name_links"] => string(186) "<a class=tag href='/Admin/Seq/showlist/by/tag/id/4'>cd47</a><a class=tag href='/Admin/Seq/showlist/by/tag/id/18'>吕小翠</a><a class=tag href='/Admin/Seq/showlist/by/tag/id/5'>Good</a>"
  ["tag_names"] => string(19) "cd47,吕小翠,Good"
  ["seq_oligo_sequence"] => string(16) "aaaaaaaaaaaaaaaa"
  ["seq_oligo_name"] => string(6) "cd47Up"
  ["file_links"] => string(80) "附件1: <a href="/Public/Uploads/20160926/57e90fdc16644.txt">backup.txt</a><br>"
  ["box_name"] => string(12) "蛋白表达"
  ["box_place"] => string(58) "第2层左起第1个抽屉第3层从外向内第1个位置"
  ["fr_id"] => string(1) "2"
  ["fr_name"] => string(10) "-20冰箱2"
}
         * */
        $this->display();
    }
    
    public function add(){
        //1.如果有post数据
        if(!empty($_POST)){
           //1.1获取数据
           $user=session('user');
           $uid=$user['mg_id'];
           $seq_name=I('seq_name');
           
           //1.2如果同名条目已经存在，则添加失败
           $md=M('Seq');
           $rs_exist = $md->where("seq_uid = $uid AND seq_name= '".$seq_name."'")->select();
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
                'seq_name'=>$seq_name,
                'seq_order_no'=>I('seq_order_no'),
                'seq_sequence'=>I('seq_sequence'),
                'seq_en_site'=>I('seq_en_site'),
                'seq_note'=>I('seq_note'),
                'file_ids'=>$file_ids,
                'seq_oligo_ids'=>I('seq_oligo_ids'),
           
                //类别信息
                'cate_id'=>I('cate_id'),
                'tag_ids'=>$tag_ids,
                
                //位置信息
                'fridge_id'=>I('fridge_id'),
                'box_id'=>I('box_id'),
                'place'=>I('place'),
           
                //其他信息
                'seq_uid'=>$user['mg_id'],
                'condition'=>1,
                'seq_time'=>time(),
                'seq_mod_time'=>time(),
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
        //2.5获取引物数据
        $oligo_list=getlist('oligo');
        if(count($oligo_list)<1){
            $this->error('请先添加引物！之后才能添加测序结果.',U('Oligo/add'));
        }
        $this->assign('oligo_list',$oligo_list);
        
        $this->display();
    }
    
    public function upd($id=0,$uid=0){
        if($id==0){
           echo '错误：请指定id!<br>';
           myBtn_back();
           exit();
        }
        
        $seq_id=$id;
        
        //uid
        if($uid==0){
            $user=session('user');
            $uid=$user['mg_id'];
        }
        
        //1.如果是post提交，则保存数据
        $md=M('Seq');
        if(!empty($_POST)){
            //1.1获取数据
            $seq_name=I('seq_name');
            
            //1.2如果同名条目已经存在，则添加失败
           $rs_num = $md->where("seq_uid = $uid AND seq_name= '".$seq_name."'")->count();
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
                'seq_id'=>$seq_id,
                //核心信息
                'seq_name'=>$seq_name,
                'seq_order_no'=>I('seq_order_no'),
                'seq_sequence'=>I('seq_sequence'),
                'seq_en_site'=>I('seq_en_site'),
                'seq_note'=>I('seq_note'),
                'file_ids'=>$file_ids,
                'seq_oligo_ids'=>I('seq_oligo_ids'),
           
                //类别信息
                'cate_id'=>I('cate_id'),
                'tag_ids'=>$tag_ids,
                
                //位置信息
                //'fridge_id'=>I('fridge_id'),
                'box_id'=>I('box_id'),
                'place'=>I('place'),
           
                //其他信息
                'seq_uid'=>$uid,
                'condition'=>1,
                'seq_mod_time'=>time(),
           );

           //debug($data);
           //1.6提交数据   
           //debug($data);        
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
        $info=D('Seq')->getDetail($seq_id,$uid,true);
        $this->assign('info',$info);
        //debug($info);
        
        $this->assign('cate_id',$info['cate_id']);//cate_id
        $this->assign('fr_id',$info['fr_id']);//fr_id
        $this->assign('box_id',$info['box_id']);//box_id
        $this->assign('oligo_id',$info['seq_oligo_ids']);//oligo_id
        
        //2.1获取分类数据
        $this->assign('cate_list',getlist('cate'));
        //2.2获取标签数据
        $this->assign('tag_list',getlist('tag'));
        //2.3获取冰箱数据
        $this->assign('fridge_list',getlist('fridge','fr',1));
        //2.4获取盒子数据
        $this->assign('box_list',getlist('box'));
        //2.5获取引物数据
        $this->assign('oligo_list',getlist('oligo'));
        
        $this->display();
    }
    
    
    
    public function del($id){
       //放到回收站
       $md=M('Seq');
       //$rs=$mg->delete($mg_id);//彻底删除
       $rs=$md->save(array(
            'seq_id'=>$id,
            'seq_mod_time'=>time(),
            'condition'=>0,//0 进入回收站
       ));
       if($rs>0){
            $this->success('成功放到回收站',U('showlist'));
       }else{
            $this->error('失败'.$md->getError(), U('showlist'));
       }
    }
    
    
    
    public function search(){
        $this->redirect('Search/index',array('in'=>'seq'));
    }
}