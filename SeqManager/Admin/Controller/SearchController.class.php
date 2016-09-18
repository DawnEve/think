<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class SearchController extends AdminController {
    public function index(){
        //getName();
        dump($_POST);
        
        $this->display();
    }
    
    //TODO
    public function advSeach(){
        //getName();
    }
    
    function getData(){
        $this->ajaxReturn(M('Cate')->select());
    }
    
}