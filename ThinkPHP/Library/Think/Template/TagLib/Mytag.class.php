<?php
//自定义标签
namespace Think\Template\TagLib;
use Think\Template\TagLib;

defined('THINK_PATH') or exit();

/**
 * Mytag标签库驱动
 */
class Mytag extends TagLib{
    // 标签定义
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0不闭合 或者1闭合 默认1） alias 标签别名 level 嵌套层次
        'read'     => array('attr'=>'name,id,style','close'=>1),
        'html_options'     => array('attr'=>'name,options,selected','close'=>0),
    );
    
    //读取并格式化显示闭合标签中的文本
    public function _read($tag,$content) {
        $id         =   !empty($tag['id'])?$tag['id']: '_read';
        $name       =   $tag['name'];
        $style      =   $tag['style'];
        $parseStr="<div id='".$id."' style='".$style."'>" . $content . '</div>';
        return $parseStr;
    }

    //显示array(1=>'',2="")一维数组为select中的options
    public function _html_options($tag,$content) {
    	//接收参数
        $name    =   !empty($tag['name'])?$tag['name']: '_name';
        $options    =   $tag['options'];
	    $selected   =   !empty($tag['selected'])?$tag['selected']: '';
        //处理数据
        $parseStr   = '<select name="'.$name.'">';
        $parseStr  .=   '<?php if(is_array($'.$options.')): foreach($'.$options.' as $k=>$v):';
        if(empty($selected)){
	        $parseStr  .=   '$sel_text="";';
        }else{
	        $parseStr  .=   ' $sel_text="";if($k==$'. $selected .'){ $sel_text=" selected=selected "; }';
        }
        $parseStr  .=   ' echo "<option $sel_text value =$k>$v</option>\n";';
        $parseStr  .=   ' endforeach; endif; ?>';
        $parseStr  .=   '</select>';
        //返回
        if(!empty($parseStr)) {
            return $parseStr;
        }
        return ;
    }
}