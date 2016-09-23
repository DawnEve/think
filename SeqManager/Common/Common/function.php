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

/**
 * 更好用的获取列表的函数
 */
//获取数据列表array(1=>'1号冰箱',2=>'2号冰箱');
function getList($tb_name, $tb_prefix=null,$uid=0){
	if($uid==0){ $user=session('user'); $uid=$user['mg_id'];}
	if(strlen($tb_prefix)>0){}else{ $tb_prefix=$tb_name; }
    $info_arr=M($tb_name)
        ->field($tb_prefix.'_id,'.$tb_prefix.'_name')
        ->where('`condition`>0 AND '.$tb_prefix.'_uid='.$uid)
        ->select();   
    return getOneArr($info_arr, $tb_prefix.'_id', $tb_prefix.'_name');
}


/**
 * 把文件大小换算成人类能识别的格式
 * 
 */
function human($str){
	//dump($b);
    if($str<1000){
        return $str . ' B';
    }elseif($str<1e6){
        return round($str/1e3,1) . ' KB';
    }elseif($str<1e9){
        return round($str/1e6,1) . ' MB';
    }elseif($str<1e12){
        return round($str/1e9,1) . ' GB';
    }
    
    return $str . ' B';
    
}


/**
 * debug专用
 * 
 */
function debug($para,$die=true){
    dump($para);
    if($die) die();
}


