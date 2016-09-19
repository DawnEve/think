<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class OligoController extends AdminController {
    public function showlist(){
        getName();
    }
    
    public function show(){
        getName();
    }
    
    public function add(){
        //1.如果有post数据
        if(!empty($_POST)){
           //获取数据
           $user=session('user');
           $oligo_name=I('oligo_name');
           
           //保存数据
           $md=M('Oligo');
           
           //如果同名条目已经存在，则添加失败
           $uid=$user['mg_id'];
           $rs_exist = $md->where("oligo_uid = $uid AND oligo_name= '".$oligo_name."'")->select();
           if(!empty($rs_exist)){
               $this->error('添加失败！该样品名已经存在.(可能在回收站)', U());
               exit();
           }
           
           //文件上传
            //上传文件、保存文件名和地址到数据库、返回文件id
           $file_ids='';
           //判断是否有文件，且文件大小超过0
           //dump($_FILES['file_ids']['size'][0]);die();
           if (!empty($_FILES) && isset($_FILES["file_ids"]) && $_FILES["file_ids"]["size"][0]>0){
	           $file_ids_arr=A('File')->upload();
	            /*
					array(3) {
					  [0] => string(2) "40"
					  [1] => string(2) "41"
					  [2] => string(2) "42"
					}
	             * */
	            $file_ids=implode(',',$file_ids_arr);//"1,2,3"; 
           }
           
           //从tag_name字符串到tag_ids
           $str=I('tag_ids');//"protein100,cd47,Good";
           $tag_ids=A('Tag','Logic')->get_tag_ids($str);
           
           //拼接数据
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
                      
           $w=$md->create($data);
           
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
    
    public function upd(){
        getName();
    }
    
    public function del(){
        getName();
    }
    
    public function search(){
        getName();
    }
}