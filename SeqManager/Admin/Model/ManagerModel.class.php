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
	
	//修改管理员信息
	function upd($mg_id){
	   $_POST['mg_id']=$mg_id;
	   $_POST['mg_mod_time']=time();//修改时间
	   $this->create();
	   if($this->save()){
	       return true;
	   }else{
	       return $this->getError();
	   }
	}

	//插入数据
	function addManager(){
        //检查是否重名
        $mg_name=I('mg_name');
        $rs=$this->getBymg_name($mg_name);
        if($rs!=null){
            echo '该用户名已经存在，请换一个用户名再试试吧-.-<br>';
            myBtn_back();
        }
        		
		//如果没有重名，则插入
        $_POST['mg_time']=time();
        $_POST['mg_mod_time']=time();
        $this->create();
        return $this->add();
	}
	

}