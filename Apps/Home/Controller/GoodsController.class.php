<?php
namespace Home\Controller;
use Think\Controller;

class GoodsController extends Controller{
    function index($table='Goods'){
        $g=M($table)->order('goods_id desc')->select();//二维数组，返回1或多条结果
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

	
	//上传附件 - 备份
	function add_backup(){
       if(!empty($_POST)){
           $goods=D('Goods');
           //判断附件是否上传，
           //如果有附件则实例化upload(),把附件上传到指定位置
           //然后把附件的路径名获得，保存到$_POST中
           if(!empty($_FILES)){
            //dump($_FILES['goods_big_img']);
            /*
array(5) {
  ["name"] => string(26) "QQ图片20160605182806.jpg"
  ["type"] => string(10) "image/jpeg"
  ["tmp_name"] => string(24) "F:\xampp\tmp\php2C80.tmp"
  ["error"] => int(0)
  ["size"] => int(254691)
}
             * */
           	    //实例化类
           	    $config=array(
           	        'rootPath'=>'./Public/',
           	        'savePath'=>'Upload/',
           	        'subName'       =>  array('date', 'Ymd'),
           	    );
           	    $upload=new \Think\Upload($config);
           	    //执行上传
           	    $z=$upload->uploadOne($_FILES['goods_big_img']);
           	        /*
dump($z);
array(9) {
  ["name"] => string(26) "QQ图片20160605182806.jpg"
  ["type"] => string(10) "image/jpeg"
  ["size"] => int(254691)
  ["key"] => int(0)
  ["ext"] => string(3) "jpg"
  ["md5"] => string(32) "2ee1bc65a552a90ee8431696eb4107f9"
  ["sha1"] => string(40) "6393a860ff70080fb9c9c678a0db6f5262ae33bc"
  ["savename"] => string(17) "57d259a6a1b2d.jpg"
  ["savepath"] => string(18) "Upload/2016-09-09/"
}
           	         * */
           	    //判断上传是否成功
           	    if(!$z){
           	        die( $upload->getError() );
           	    }else{
           	    	//拼接图片路径，并添加到$_POST中
           	    	$img_url = $z['savepath'] . $z['savename'];
           	        //dump($img_url);//string(35) "Upload/2016-09-09/57d25a40285bd.jpg"
           	        $_POST['goods_big_img']=$img_url;
           	    }
           }
           
           $goods->create();//收集数据
           $goods->goods_create_time=time();
           $r=$goods->add();
           if($r){
                echo 'success';
           }else{
                echo 'error~~~';
           }
       }else{
           $this->display();
       }
    }
    
    
    //上传附件
    function add(){
       if(!empty($_POST)){
           $goods=D('Goods');
           //判断附件是否上传，
           //如果有附件则实例化upload(),把附件上传到指定位置
           //然后把附件的路径名获得，保存到$_POST中
           if(!empty($_FILES)){
                //实例化类
                $config=array(
                    'maxSize'    =>    3145728, 
                    'rootPath'=>'./Public/',
                    'savePath'=>'Upload/',
                    'subName'       =>  array('date', 'Ymd'),
                    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),  
                );
                $upload=new \Think\Upload($config);
                //执行上传
                $z=$upload->uploadOne($_FILES['goods_big_img']);
                //判断上传是否成功
                if(!$z){
                    die( $upload->getError() );
                }else{
                    //拼接图片路径，并添加到$_POST中
                    $img_url = $z['savepath'] . $z['savename'];
                    //dump($img_url);//string(35) "Upload/20160909/57d25a40285bd.jpg"
                    $_POST['goods_big_img']=$img_url;
                    
                    //生成缩略图
                    $bigimg = $upload->rootPath . $img_url;
                    $image=new \Think\Image();
                    $small_img_url = $upload->rootPath . $z['savepath'] .'small_'. $z['savename'];
                    $image->open($bigimg)->thumb(150,150)->save($small_img_url);
                    $_POST['goods_small_img']=$small_img_url;
                }
           }
           
           $goods->create();//收集数据
           $goods->goods_create_time=time();
           $r=$goods->add();
           if($r){
                echo 'success';
           }else{
                echo 'error~~~';
           }
       }else{
           $this->display();
       }
    }
    
    //制作缩略图
    function thumb(){
        $image = new \Think\Image(); 
        $image->open('./Public/Upload/20160909/57d25f4c19d89.jpg');//将图片裁剪为400x400并保存为corp.jpg
        $thumb_url='/Public/Upload/20160909/thumb_57d25f4c19d89.jpg';
        $image->thumb(300, 350)->save('.'.$thumb_url);
        echo '<img src="'.$thumb_url.'">';
    }
    
    function lang($lang){
        echo L('');
    }
    
    
    //自定义标签库
    function tag2(){      
        $data=array(
            1=>'股东',
            2=>'老板',
            30=>'经理',
            4=>'员工',
        );
        $this->assign('data',$data);
        //选择的部分
        $this->assign('sel',4);
        $this->display();
    }
	
}