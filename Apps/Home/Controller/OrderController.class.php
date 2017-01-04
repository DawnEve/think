<?php
namespace Home\Controller;
use Think\Controller;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class OrderController extends Controller {
    public function index($supplier_id=-1){
        if($supplier_id>0){
            //http://tp.dawneve.com/order/index/supplier_id/1
            $data=M('order')->alias('a')
                            ->field('order_id, order_name, order_unit, order_quantity, order_price, order_note, order_time, a.supplier_id,b.supplier_name')
                            ->join('think_supplier b ON a.supplier_id = b.supplier_id', 'LEFT')
                            ->where('a.supplier_id=' . $supplier_id . ' and a.order_status >0')
                            ->order('a.add_time DESC')
                            ->select();
        }else{
            //http://tp.dawneve.com/order/
             $data=M('order')->alias('a')
                            ->field('order_id, order_name, order_unit, order_quantity, order_price, order_note, order_time, a.supplier_id,b.supplier_name')
                            ->join('think_supplier b ON a.supplier_id = b.supplier_id', 'LEFT')
                            ->where('a.order_status >0')
                            ->order('a.add_time DESC')
                            ->select();
        }
        //获取供应商信息
        $supplier=M('supplier')->field("supplier_id,supplier_name")->select();
        //dump(time());
        //dump($supplier);
        
        $this->assign('supplier', $supplier);
        $this->assign('order', $data);
        $this->display('Order/index');
    }


    //插入
    public function insert(){

    }


    //显示全部
    public function archive(){
            $weibo=M('weibo')->alias('a')
                    ->field('a.id, a.uid, a.content, a.add_time, a.cid, b.name, b.pid')
                    ->join('think_weibo_category b ON a.cid = b.id', 'LEFT')
                    ->order('add_time DESC')
                    ->select();

            //dump($weibo);

            $this->assign('weibo', $weibo);
            $this->display();
    }



    //防范非法操作
    function _empty(){
        echo 'This page ['.CONTROLLER_NAME . '->' .ACTION_NAME. '] is not found!';
    }
	
}


