<?php
namespace Home\Controller;
use Think\Controller;
class BlogController extends Controller {
    public function index(){
		echo 'BlogController->index';
		
		//D('User'); //实例化UserModel
		//D('User','Logic'); //实例化UserLogic
	}
}