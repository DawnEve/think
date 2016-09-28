<?php
namespace Admin\Logic;
use Think\Controller;

/**
 * 获取所有可用的冰箱信息
 * @author admin
 *
 */
class FridgeLogic extends Controller{
	//从Logic层获取冰箱数据列表array(1=>'1号冰箱',2=>'2号冰箱');
    function getList(){
        $fr_info=M('Fridge')->field('fr_id,fr_name')->where('`condition`>0')->select();   
        return getOneArr($fr_info, 'fr_id', 'fr_name');
    }

}