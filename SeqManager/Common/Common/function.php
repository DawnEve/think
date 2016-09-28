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


//显示备注的前5个字节
function my_mb_substr($note,$len=5){
	//$note=$vo['file_note'];
	if(mb_strlen($note)>$len){
	    echo mb_substr($note,0,$len,'utf-8').'...'; 
	}elseif(mb_strlen($note)>0){
	    echo $note;
	}
}
//使用 {$vo.file_note|my_mb_substr}

/**
 * 过滤掉序列中
 * html标签，非字母符号(包括空格、数字)，
 * 并转化成大写
 * @param $str
 */
function dna_filter($str){
    //1.过滤html标签
    $str1=strip_tags($str);
    //2.过滤掉字母之外的序列
    $str2=preg_replace("/\s/","",$str1);//去掉所有空格
    $str3=preg_replace("/\r/","",$str2);//去掉换行
    $str3=preg_replace("/\n/","",$str3);//去掉换行
    $str3=preg_replace("/\d/","",$str3);//去掉数字
    //3.扎化为大写
    $str4=strtoupper($str3);
    //4.返回结果
    return $str4;
}
