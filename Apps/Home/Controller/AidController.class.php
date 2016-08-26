<?php
namespace Home\Controller;
use Think\Controller;
use Think\Verify;

class AidController extends Controller {
    function index(){
    	dump($_SESSION);
    	$this->display();
    }
    function index2(){
        //echo __METHOD__;//ome\Controller\AidController::index
        
    	ob_clean();//http://www.thinkphp.cn/topic/23636.html
    	$Verify = new Verify();
    	$Verify->entry();
    }
}