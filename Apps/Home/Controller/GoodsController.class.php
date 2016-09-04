<?php
namespace Home\Controller;
use Think\Controller;

class GoodsController extends Controller{
    function index($table='Weibo'){
        $g=M($table)->select();//二维数组，返回1或多条结果
        //$g=M($table)->find();//一维数组，返回一条结果
        dump($g);
    }
    
    
	public function write(){
	//http://zhidao.baidu.com/link?url=3vofadf5vKt7ZfSYvPlJ0rkIKZJlZXehb9KHqeyX-Bm0PSkTUY8ZrV16TY_yNiXVM5tUPjoIQgKTb0alsLgi1u1z3FzAsciQWROjpM-qloO
	    header("Content-Type:text/html; charset=utf-8");
	    // 实例化一个空模型，没有对应任何数据表
	    $Dao = M('Goods');  //或者使用 $Dao = new Model();
	 $sql = <<<EOT
INSERT INTO `think_goods`( `goods_name`,  `goods_weight` ,`goods_price` ,`goods_number` ,`goods_category_id`,`goods_brand_id` , `goods_introduce` ,`goods_big_img`,`goods_small_img`,`goods_create_time` ,`goods_last_time` ,`abc`) 
VALUES ('vivo X7 plus',111,2800.00,201,3,1,'vivo X7 plus参数','32_G_1242110760868.jpg','images/200905/thumb_img/32_thumb_G_1242110760196.jpg',1242110760,1376313168,'')
EOT;
       //echo $sql;	    
	   $num = $Dao->execute($sql);
	   if($num){
	        echo '更新 ',$num,' 条记录。';
	    }else{
	        echo '无记录更新';
	    }
	    
	}
}