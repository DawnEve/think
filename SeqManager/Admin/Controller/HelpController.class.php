<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class HelpController extends AdminController {
    public function index(){
        getName();
    }
    
    //TODO
    public function article($id=0){
        getName();
        echo '/'.$id;
    }
}