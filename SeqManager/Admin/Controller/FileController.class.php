<?php
namespace Admin\Controller;
use Admin\Common\AdminController;
use Think\Controller;

//class FileController extends AdminController {
class FileController extends Controller {
    public function showlist(){
        getName();
    }
    
    /*
    public function show(){
        getName();
    }
    */
    
    public function add(){
        getName();
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