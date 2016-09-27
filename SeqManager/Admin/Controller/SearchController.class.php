<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class SearchController extends AdminController {
    public function index(){
        //getName();
        //dump($_POST);
        
    	//接收数据
    	$by=I('by');
    	$in=I('in');
    	$wd=I('wd');
    	if(''==$by){ $by='keyword';}
    	if(''==$in){ $in='seq'; }
    	if(''==$wd) $wd='';
    	
    	//debug($in);
    	//传值
    	$this->assign('by',$by);
    	$this->assign('in',$in);
    	$this->assign('wd',$wd);
    	
        //显示
        $this->display('Search/index');
    }
    
    //TODO
    public function advSeach(){
        //getName();
    }
    
    function getData(){
        $this->ajaxReturn(M('Cate')->select());
    }
    
}