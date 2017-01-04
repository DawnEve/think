<?php 
namespace Home\Behavior;

class AuthCheckBehavior{
	// 行为扩展的执行入口必须是run
	public function run(&$params){
		echo '<div style="color:red">This is AuthCheck behavior.</div>';
	}
}


