<?php
namespace Admin\Controller;
use Admin\Common\AdminController;
use Think\Controller;

//class FileController extends AdminController {
class FileController extends Controller {
    public function showlist(){
    	$user=session('user');
    	$uid=$user['mg_id']; 
        //文件列表
        $md=M('File');
        $info=$md
            ->where('`condition`>0 and file_uid='.$uid)  
            ->select();
        $this->assign('info',$info);
        $this->assign('info_num',count($info));
    	/*
array(18) {
  [0] => array(13) {
    ["file_id"] => string(1) "9"
    ["file_name"] => string(7) "vr1.jpg"
    ["file_note"] => NULL
    ["file_path"] => string(34) "Uploads/20160919/57dfc32e5807b.jpg"
    ["size"] => string(6) "140665"
    ["type"] => string(10) "image/jpeg"
    ["ext"] => string(3) "jpg"
    ["file_time"] => string(10) "1474282286"
    ["file_mod_time"] => string(10) "1474282286"
    ["cate_id"] => NULL
    ["tag_ids"] => NULL
    ["file_uid"] => string(1) "5"
    ["condition"] => string(1) "1"
  }
    	 * */
        $this->display();
    }
    
    /*
    public function show(){
        getName();
    }
    */
    
    public function add(){
    	$this->display();
    }
    
    
    
    
    public function upd($id){
        if($id==0){
           echo '错误：请指定id!<br>';
           myBtn_back();
           exit();
        }
        $file_id=$id;
        $user=session('user');
        $uid=$user['mg_id'];
        $md=M('File');
        
        //1.如果是post提交，则保存数据
        if(!empty($_POST)){
            //dump($_POST);
            //dump($_FILES);
            //1.0 文件名不能重名
            $file_name=I('file_name');
            
            //[文件名允许同名] 1.2如果同名条目已经存在，则添加失败
/*           $rs_num = $md->where("file_uid = $uid AND file_name= '".$file_name."'")->count();
           debug($rs_num);
           if($rs_num>1){
               //$this->error('添加失败！该样品名已经存在.(可能在回收站)', U(''));
               echo '添加失败！该文件名已经存在.(可能在回收站)';
               myBtn_back();
               exit();
           }*/
           
           
           //1.3 获取其他数据，处理上传文件：
           $old_data=M('File')->find($file_id); //debug($old);//14
           $data=array(
                'file_id'=>$old_data['file_id'],
                'file_name'=>I('file_name'),
                'file_note'=>I('file_note'),
                'cate_id'=>I('cate_id'),
           
           
                'file_mod_time'=>time(),
                'file_renew'=>false,
           );
           
           //1.3.5判断是否有文件，且文件大小超过0
           if (!empty($_FILES) && isset($_FILES["file_ids"]) && $_FILES["file_ids"]["size"][0]>0){
               //1.3.5 处理上传文件，覆盖旧文件：只更新文件、不更新表单
               $rs=A('File')->uploadFileTo($old_data['file_path'],$old_data['ext']);
               if(!$rs){
                 echo '上传失败';//TODO
               }else{
	               //1.3.6.执行数据库更新 size type ext 
	               $data['size']=$rs[0]['size'];
	               $data['type']=$rs[0]['type'];
	               $data['ext']=$rs[0]['ext'];
               
	               $data['file_renew']=true;
               }
           }
           
            
           //1.4 从tag_name字符串到tag_ids
           $str=I('tag_ids');//"protein100,cd47,Good";
           $tag_ids=A('Tag','Logic')->get_tag_ids($str);
           $data['tag_ids']=$tag_ids;
           
           //1.5 执行上传
           $md->create($data);
           $result=$md->save();
           //1.6判断提交是否成功
           if($result){
               $this->success('成功！',U('showlist'));
           }else{
               $this->error('失败！'.$md->getError(), U('showlist'));
           }
            
           die();
        }
    	
    	//2.展示文件数据
    	//2.如果没有post数据，则显示表单      
        $info=D('File')->getDetail($file_id,$uid);
        $this->assign('info',$info);
        
        $this->assign('cate_id',$info['cate_id']);//cate_id
        //debug($info);
        
        //2.1获取分类数据
        $this->assign('cate_list',getlist('cate'));
        //2.2获取标签数据
        $this->assign('tag_list',getlist('tag'));
        
        $this->display();
    }
    
    
    
    public function del($id){
/*    	
array(2) {
  [0] => int(1)
  [1] => string(1) "9"
}
*/
       $arr=D('File')->ajaxDel($id);
       $rs=$arr[0];
       if($rs>0){
            $this->success('成功放到回收站'.$rs.'个文件(id='.$id.')',U('showlist'));
       }else{
            $this->error('失败'.$arr[1], U('showlist'));
       }
    }
    
    public function search(){
        getName();
    }
    
    //上传文件，覆盖掉旧文件
    function uploadFileTo($path,$old_suffix){
        //1设置上传参数，实例化上传类
        $upload=$this->getUploader();
        //2指定旧文件路径
        $sub_arr=explode('/',$path);
        $upload->subName=$sub_arr[1];
        //3指定旧文件名
        $dlm='.'.$old_suffix;
        $old_name=rtrim($sub_arr[2],$dlm);
        $upload->saveName=$old_name;//给上传的文件定义旧的名称
        //4.允许覆盖旧文件
        $upload->replace=true;
        
        //5.执行上传
        return $upload->upload();
    }
    
    
    //获取上传实例
    private function getUploader(){
        $config=array(
            'rootPath'=> './Public/',
            'savePath'=> 'Uploads/',
            'subName' => array('date', 'Ymd'),
        );
        $upload = new \Think\Upload($config);// 实例化上传类    
        $upload->maxSize   =     3145728 ;// 设置附件上传大小    
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        //$upload->savePath  =      './Public/Uploads/'; // 设置附件上传目录    
        return $upload;
    }
    
    //上传文件
    function upload(){
        //0.如果没有提交，则显示表单
        if(empty($_FILES)){
           //$this->display();
           die('没有可上传文件！');
        }
        
        //1.如果有提交，则处理表单
        //1.1设置上传参数，实例化上传类
        $upload=$this->getUploader();

        //1.2.上传文件
        $info   =   $upload->upload();
        
        //1.3上传失败，则提示上传错误信息
        if(!$info) {
            $this->error($upload->getError(),U());
            die();
        //1.4上传成功，则保存文件名到数据库
        }else{
            //echo '<a href="./upload">返回</a><hr />';
            //2.保存文件信息到file数据表
            $md=M('File');
            $user=session('user');
            $file_ids=array();//文件id列表
            
            foreach($info as $file){
                //echo '<img src="/Public/'. $file_path . '" /><br />';
                $data=array();
                $data['file_path']=$file['savepath'] . $file['savename'];
                $data['file_name']=$file['name'];//文件名？
                
                $data['size']=$file['size'];
                $data['type']=$file['type'];
                $data['ext']=$file['ext'];
                //公共信息
                $data['condition']=1;
                $data['file_time']=time();
                $data['file_mod_time']=time();
                $data['file_uid']=$user['mg_id'];
                
                //插入数据库
                $rs=$md->add($data);
    //          $rs=$md->addAll($data_all, array(), true);//是否覆盖
                if(false===$rs){
                   echo '插入数据表file表失败';
                }else{
                   $file_ids[]=$rs;
                   //echo '成功';
                }
            }

            //3.上传成功
            return $file_ids;        
            //$this->success('上传成功！',U());
        }
    }
}