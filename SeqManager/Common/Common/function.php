<?php 
//import('Think.Auth');
//$name, $uid, $type=1, $mode='url', $relation='or'

function authcheck($name, $uid, $relation='or',$t,$f='<p>没有权限</p>'){
	$auth=new \Think\Auth();
	//echo '<hr>'.$rule .' - '. $uid .'<hr>';
	return $auth->check($name, $uid, $type=1, $mode='url', $relation)?$t:$f;
}

//输出当前控制器和操作方法
function getName(){
    echo CONTROLLER_NAME.'/'.ACTION_NAME . ' 正在开发中.';
}

//由二维数组生成一维数组
//变二维数组为array(1=>'角色1', 2=>'角色2', )
function getOneArr($arr2,$kname,$vname){
    $arr=array();
	foreach($arr2 as $k2=>$v2){
        $arr[$v2[$kname]]=$v2[$vname];
    }
    return $arr;
}

//返回按钮
function myBtn_back(){
    echo "<input type='button' onclick='history.back(-1)' value='返回'></td>";
}