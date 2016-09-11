<?php
namespace Admin\Controller;
use Think\Controller;

class EmptyController extends Controller {
	function _empty(){
	   echo CONTROLLER_NAME . '/' . ACTION_NAME . ' is not found!';
	}
}