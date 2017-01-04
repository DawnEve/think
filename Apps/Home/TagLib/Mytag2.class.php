<?php
//自定义标签
namespace Home\TagLib;
use Think\Template\TagLib;
defined('THINK_PATH') or exit();

/**
 * Mytag标签库驱动
 */
class Mytag2 extends TagLib{
    // 标签定义
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'read'     => array('attr'=>'name,id,style','close'=>1),
    );
        
    public function _read($tag,$content) {
        $id         =   !empty($tag['id'])?$tag['id']: '_read';
        $name       =   $tag['name'];
        $style      =   $tag['style'];
        $parseStr="<div id='".$id."' style='".$style."'>" . $content . '</div>';
        return $parseStr;
    }
}