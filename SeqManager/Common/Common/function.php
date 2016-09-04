<?php 
//import('Think.Auth');
//$name, $uid, $type=1, $mode='url', $relation='or'

function authcheck($name, $uid, $relation='or',$t,$f='<p>没有权限</p>'){
	$auth=new \Think\Auth();
	//echo '<hr>'.$rule .' - '. $uid .'<hr>';
	return $auth->check($name, $uid, $type=1, $mode='url', $relation)?$t:$f;
}