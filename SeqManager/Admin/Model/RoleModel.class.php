<?php
namespace Admin\Model;
use Think\Model;

class RoleModel extends Model {
	//
	function saveAuth($auth_id_arr,$role_id){ 
		//接收到一维数组，代表当前权限信息
		$auth_ids=implode(',', $auth_id_arr);//数组2字符串
		//2.根据id查询具体 控制器-操作方法 名字
		$auth_info=D('Auth')->select($auth_ids);
		//拼装控制器-方法
		$auth_ac='';
		foreach($auth_info as $k){
		   if(''!=$k['auth_c']){
		       $auth_ac .= $k['auth_c'] .'-'. $k['auth_a'].',';
		   }
		}
		$auth_ac=rtrim($auth_ac,',');//删除最后一个逗号
	   //执行更新操作
	   $data=array(
	       'role_id'=>$role_id,
	       'role_auth_ids'=>$auth_ids,
	       'role_auth_ac'=>$auth_ac,
	       'auth_mod_time'=>time()
	   );
	   $rs=$this->save($data); //debug($rs);
	   if($rs>0){
	       return true;
	   }else{
	       return $this->getError();
	   }
	}
	
	//1.获取role二维数组
	//2.变二维数组为array(1=>'角色1', 2=>'角色2', )
	function getRoleArr(){
	   $role_info=$this->where('`condition`=1')->select();
        /*
array(2) {
  [0] => array(4) {
    ["role_id"] => string(1) "1"
    ["role_name"] => string(6) "老板"
    ["role_auth_ids"] => string(26) "1,4,5,6,7,3,11,12,13,14,15"
    ["role_auth_ac"] => string(101) "Goods-showlist,Goods-add,Goods-cate,User-comment,Auth-showlist,Auth-add,Role-showlist,Role-distribute"
  }
         * */
        //变二维数组为array(1=>'角色1', 2=>'角色2', )
        $role_arr=getOneArr($role_info, 'role_id','role_name');
        $role_arr[0]='超级管理员';
        return $role_arr;
	}

}