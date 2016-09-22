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
    
    public function upd(){
        getName();
    }
    
    public function del($id){
        $wjl=D('File')->ajaxDel($id);
        dump($wjl);
    }
    
    public function search(){
        getName();
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
        $config=array(
            'rootPath'=> './Public/',
            'savePath'=> 'Uploads/',
            'subName' => array('date', 'Ymd'),
        );
        $upload = new \Think\Upload($config);// 实例化上传类    
        $upload->maxSize   =     3145728 ;// 设置附件上传大小    
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        //$upload->savePath  =      './Public/Uploads/'; // 设置附件上传目录    

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