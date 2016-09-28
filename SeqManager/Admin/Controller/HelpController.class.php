<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class HelpController extends AdminController {
    public function index(){
        $this->display();
    }
    
    //TODO
    public function article($id=0){
        $this->display();
    }
    
    //关于
    public function about(){
        $this->display();
    }
}