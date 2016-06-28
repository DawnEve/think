<?php
namespace Home\Event;
use Think\Controller;

class UserEvent extends Controller{
	function index(){
	   echo 'UserEvent->index()';
	}
	function hi(){
		echo 'UserEvent->hi()';
	}

}