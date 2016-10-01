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
    	if(!in_array($by,array('cate','tag','keyword','sequence'))){ $by='keyword';}
        if(!in_array($in,array('cate','tag','file'))){ $in='seq';}
    	//if(''==$in){ $in='seq'; }
    	if(''==trim($wd)) $wd='';
    	
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