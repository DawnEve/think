<?php
namespace Admin\Model;
use Think\Model;

class ManagerModel extends Model {
	//检验name和psw是否正确？
	function checkNamePsw($name,$psw=''){
		$info = $this->getBymg_name($name);
        if($info != null){
            if(md5($psw) == $info['mg_pwd']){
                unset($info['mg_pwd']);//防止密码泄露
                return $info;
            }else{
                return false;
            }
        }else{
            return false;
        }
	   return ;
	}
	
	
	//初始化用户:添加 冰箱、盒子、分类、标签
	function init($uid){
	   $error='';
	   $time=time();
	   //1.添加盒子
	   $fr_info=M('fridge')->find();
	   $fr_id=$fr_info['fr_id'];
	   $box=array(
	       'box_name'=>'默认盒子',
	       'condition'=>1,
	       'box_fr_id'=>$fr_id,
	       'box_uid'=>$uid,
	       'box_time'=>$time,
	       'box_mod_time'=>$time,
	   );
	   if(!M('box')->add($box)){
	       $error .= '创建默认盒子失败!';
	   }
		
	   //2.添加分类
	   $cate=array(
	       'cate_name'=>'默认分类',
	       'cate_uid'=>$uid,
	       'condition'=>1,
	       'cate_time'=>$time,
	       'cate_mod_time'=>$time,
	   );
	   if(!M('cate')->add($cate)){
           $error .= '创建默认分类失败!';
       }
	   
	   
	   //3.添加标签
	   $tag=array(
           'tag_name'=>'默认标签',
           'tag_uid'=>$uid,
           'condition'=>1,
           'tag_time'=>$time,
           'tag_mod_time'=>$time,
       );
       if(!M('tag')->add($tag)){
           $error .= '创建默认标签失败!';
       }
	   
	   //返回结果
	   if(strlen($error)==0){
		   return array(1,'初始化成功！');
	   }else{
		   return array(0,$error);
	   }
	}

}