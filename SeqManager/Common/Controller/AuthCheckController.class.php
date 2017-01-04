<?php 
namespace Common\Controller;
use Think\Controller;
use Think\Auth;

class AuthCheckController extends Controller{
    function _initialize(){
    	$auth=new Auth();
    	//return $auth->check();
        echo ' <u>from authcheck controller</u> ';
        
    }


}


