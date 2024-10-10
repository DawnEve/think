<?php
namespace Home\Controller;
use Think\Controller;


class WeiboController extends Controller {
	public function index($tag=-1){
		//echo "我的微博<br><a href=".U('Weibo/add').">添加</a>";
		//$weibo=M('weibo')->order('add_time DESC')->select();
		if($tag>0){
			$weibo=M('weibo')->alias('a')
				->field('a.id, a.uid, a.content, a.add_time, a.cid, b.name, b.pid')
				->join('think_weibo_category b ON a.cid = b.id', 'LEFT')
				->where('cid=' . $tag . ' and archive is null')
				->order('add_time DESC')
				->select();
		}else{
			$weibo=M('weibo')->alias('a')
				->field('a.id, a.uid, a.content, a.add_time, a.cid, b.name, b.pid')
				->join('think_weibo_category b ON a.cid = b.id', 'LEFT')
				->where('archive is null')
				->order('add_time DESC')
				->select();
		}
		
		//dump($weibo);
		
		$this->assign('weibo', $weibo);
		$this->display('Weibo/index');
	}
		
	
	//插入
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
		$result=$weibo->where("id=$id and (cid is null or cid=0)" )->delete();//只能删除没有分类的

		if($result){
			$this->success('删除成功');
		}else{
			$this->error('删除失败！不能删除分类后的数据！');
		}
	}
	
	
	//显示 archive 为1
	public function archive(){
		$weibo=M('weibo')->alias('a')
			->field('a.id, a.uid, a.content, a.add_time, a.cid, b.name, b.pid')
			->join('think_weibo_category b ON a.cid = b.id', 'LEFT')
			->where('a.archive is not null')
			->order('add_time DESC')
			->select();

		//dump($weibo);
		
		$this->assign('weibo', $weibo);
		$this->display();
	}
	
	//友情链接
	public function links(){
		//从WeiboLogic获取数据。
		$links = A('Weibo','Logic')->links();
		//dump($links);
		$this->assign('links', $links);
		$this->display();
	}
	
    //防范非法操作
    function _empty(){
        echo 'This page ['.CONTROLLER_NAME . '->' .ACTION_NAME. '] is not found!';
    }
	
}