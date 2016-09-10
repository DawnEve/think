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

}