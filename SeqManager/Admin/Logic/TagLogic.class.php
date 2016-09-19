<?php
namespace Admin\Logic;
use Think\Controller;

/**
 * 获取标签信息
 * @author admin
 *
 */
class TagLogic extends Controller{
	/**
	 * 从文字得到标签id，如果没有则新建，
	 * @return: tag_ids 字符串
	 * 
	 */
    function get_tag_ids($tags_list=''){
    	//获取用户
    	$user=session('user');
        //分割标签
        $tags_arr=explode(',',$tags_list);
        $tags_ids='';
        //获取该用户创建的、可用的标签
        $exist_tag_list=getlist('tag');
        //dump($tags_arr);
        
        foreach($tags_arr as $k=>$v){
            //如果该用户的、标签存在、可用
            if(in_array($v, $exist_tag_list)){
                //从数组获取tag_id
                $tags_ids .= array_search($v, $exist_tag_list).',';
            }else{
                //把新标签插入数据库
                $data=array(
                    //拼接数据
	                'tag_name'=>$v,
	                'tag_uid'=>$user['mg_id'],
	                'condition'=>1,
	                'tag_time'=>time(),
	                'tag_mod_time'=>time(),
                );
                $md=M('tag');
                $md->create($data);
                $rs=$md->add();
                if($rs){
                    $tags_ids .= $rs .',';
                }else{
                    $this->error($rs->getError());
                }
            }
        }
        //去掉最后一个逗号，返回字符串
        return rtrim($tags_ids, ',');
    }
}