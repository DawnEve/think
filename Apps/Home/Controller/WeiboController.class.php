<?php
namespace Home\Controller;
use Think\Controller;


class WeiboController extends Controller {
	public function index(){
		//echo "我的微博<br><a href=".U('Weibo/add').">添加</a>";
		
		$weibo=M('weibo')->order('add_time DESC')->select();
		//dump($weibo);
		$this->assign('weibo', $weibo);
		
		$this->show();
	}
		
	
	
	public function insert(){
		$form=D('weibo');
		if($form->create()){
			$result=$form->add();
			if($result){
				$this->success('添加成功');
			}else{
				$this->error('添加失败！');
			}
		}else{
			$this->error($form->getError());
		}
		
	}
	
	//删除
	public function delete($id){
		$weibo = M("weibo"); // 实例化对象
		$result=$weibo->where("id=$id and cid is null" )->delete();//只能删除没有分类的

		if($result){
			$this->success('删除成功');
		}else{
			$this->error('删除失败！不能删除分类后的数据！');
		}
	}
}