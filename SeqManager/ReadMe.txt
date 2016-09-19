序列管理系统。
-----------------
数据表前缀是seq_
-----------------

F:\xampp\apache\conf\extra

http://seq.dawneve.cc

>>v0.1.0 定义模块为当前文件，定义vhosts解析：

<VirtualHost *:80>
    ServerAdmin JimmyMall@live.com
    DocumentRoot "F:/xampp/htdocs/think/SeqManager"
    ServerName seq.dawnEve.cc
	ServerAlias *.dawnEve.cc #开通泛解析
    ErrorLog "logs/dawnEve.cc-film-error.log"
    CustomLog "logs/dawnEve.cc-film-access.log" common
</VirtualHost>



貌似没有配置hosts文件，竟然也解析了。


>>v0.1.1 复制.htaccess文件。
http://seq.dawneve.cc/Index/index.html

>>v0.1.2 rbac 测试
>>v0.1.3 left is OK.根据不同权限相应显示。
>>v0.1.4 超级管理员需要所有权限。Manager/left
>>v0.1.5 没显示权限，但是直接输入url访问敏感权限怎么办？
    在父类控制器中进行权限过滤。
>>v0.1.6 left的链接不对，修正。    
>>v0.1.7 权限修改初步搞定。缺点：权限显示不正常。  
>>v0.1.8 把已经设置的权限显示出来。
    模板中判断：当前权限的id，是否在授权ids中。


[bug]员工无法操作授权管理怎么办？
[solution1]权限操作后需要重新给角色赋予权限。

>>v0.1.9 权限操作，权限列表。
>>v0.2.0 权限添加。
    只允许三层权限分类。
>>v0.2.1 为角色分配权限的时候，也要显示三级权限。

[todo]还差一个用户管理，用来设置用户角色。

>>v0.2.2 完善之前细微差错，css纠正等。
<?php $v=$role_arr[$vo['mg_role_id']]; echo $v?$v:'超级管理员'?>

>>v0.2.3 管理员列表showlist、添加add、更新upd。

>>v0.2.4 管理员列表删除del
 [todo]直接删除，不太好。需要添加js提示确认。

>>v0.2.5 Role/add()

>>v0.2.6 view的细节调整。db中增加：Seq、Oligo

>>v0.2.7 
[fix]添加用户时，密码应该使用md5加密。

===========================================
>>v0.2.8 添加数据表：
用户部分：
    wjl_auth
    wjl_role
    wjl_manager
分类部分：
    wjl_cate
    wjl_tag
保存位置部分：
    wjl_fridge
    wjl_box
核心序列信息：
    wjl_seq
    wjl_oligo
    wjl_file

图纸见：docs/db/db-tables.png
sql语句见：docs/db/db-tables.txt
===========================================
>>v0.2.9 系统分解：分析功能和方法

>>v0.3.0 系统框架基本完成！

>>v0.3.1 auth数据添加完毕
添加的权限数据在 docs/db/wjl_auth.sql.txt 

>>v0.3.2 控制器内方法的微调。
增加修改密码、修改自自密码两个选项。
调整role表中的role_auth_ids为text类型。
修改密码为不需要权限验证的。

>>v0.3.3 Manager/resetMyPwd() 修改自己的密码；
right.html
删掉老模板中的无用php代码。
<?php
/*
    include_once("checksession.php");
    include_once("../db.php");
    $query = "select * from beian_manage where username='$_SESSION[adminusername2]' ";
    $result = mysql_db_query($DataBase, $query); 
    $r2=mysql_fetch_array($result);
    date_default_timezone_set('PRC');
*/
?>

>>v0.3.4 Manager/del() 仅仅是condition=0
$mg_info=M('Manager')->where('`condition`=1')->select();

<td>{$vo.mg_time|date="Y-m-d H:i:s",###}</td>
<td>{$vo.mg_mod_time|date="Y-m-d H:i:s",###}</td>

>>v0.3.5 Recycle/showlist() 两个视图，一个是统计，一个是明细。

>>v0.3.6 Recycle/restore() Recycle/delete() 还原条目 彻底删除

>>v0.3.7 Cate/add() 需要从简单的入手，复杂的就会好搞一点。
>>v0.3.8 Cate/showlist() 
    <td>
        <a href='<?php echo U("Recycle/restore",array("tb_name"=>$tb_name,'id'=>$vo[$prefix.'_id'])) ;?>'>还原条目</a> | 
        <a href='<?php echo U("Recycle/delete",array("tb_name"=>$tb_name,'id'=>$vo[$prefix.'_id'])) ;?>'>彻底删除</a>
    </td>
    
    <td>
        <a href='<?php echo U("upd",array('id'=>$vo['cate_id'])) ;?>'>修改</a> | 
        <a href='<?php echo U("del",array('id'=>$vo['cate_id'])) ;?>'>删除</a> 
    </td>
    
>>v0.3.9 Cate/upd()  Cate/del()  
    但是回收站只能看到统计数字，看不到明细！！
>>v0.3.9 纠正Recycle控制器小错误，模板添加最后修改时间。

[fixed][bug]能重复添加相同标签 Cate/add();
>>v0.4.0 修复刚才的bug。保证Cate/add()不会重名。
    
==============================
>>v0.4.1 标签控制器  Tag/add(), Tag/showlist(), Tag/del(),  Tag/upd() 
>>v0.4.2 冰箱控制器 add(), showlist(), del(), upd()
[fix][bug]发现冰箱不能共享。
    >不需要共享，冰箱是超级管理员添加、删除、修改的。普通研究生只能查看冰箱。

[bug]发现数据表unique key用的不对，应该是name和uid合成的。

http://dev.mysql.com/downloads/workbench/

_______________________________________________
    SQL UNIQUE 约束-- unique key : http://www.w3school.com.cn/sql/sql_unique.asp
UNIQUE 约束唯一标识数据库表中的每条记录。
UNIQUE 和 PRIMARY KEY 约束均为列或列集合提供了唯一性的保证。
PRIMARY KEY 拥有自动定义的 UNIQUE 约束。
请注意，每个表可以有多个 UNIQUE 约束，但是每个表只能有一个 PRIMARY KEY 约束。

(1)创建时添加        CONSTRAINT un_code UNIQUE (`fr_name`,`fr_uid`)
        
    修改3个用户表之外其余的数据表的key？wjl_box / cate / tag
(2)创建后添加
ALTER TABLE wjl_cate
ADD CONSTRAINT uc_code UNIQUE (`cate_name`,`cate_uid`);

ALTER TABLE wjl_tag
ADD CONSTRAINT uc_code UNIQUE (`tag_name`,`tag_uid`);

(3)删除
ALTER TABLE Persons
DROP INDEX uc_PersonID
_______________________________________________
    
>>v0.4.3 fix[0.4.3]的2个bug。
    (1)只有admin用户可以增删改冰箱，普通用户只能看到冰箱列表。视图中用if mg_id==1实现。回收站中不再显示fridge。
    (2)数据表 wjl_box / cate / tag 加入了UNIQUE约束。

>>v0.4.4 box盒子: add(), showlist(), del(), upd()
    showlist()要显示具体某个冰箱中的盒子，

    <taglib name="html" />
    
    <html:select name='role_name' options="data" selected="sel" />

[bug]upd()的时候，名字不能重复！


>>v0.4.5 Help/about(), 点击冰箱显示盒子列表。
>>v0.4.6 搜索页面的按钮。
>>v0.4.7 ajax() 
===========================================
    //http://jquery.com/ jq3.1
    //http://www.tuicool.com/articles/Y7fyUv
    
    var hiddenBox = $( "#banner-message" );
    $( "#button-container button" ).on( "click", function( event ) {
      hiddenBox.show();
    });


    $.ajax({
      url: "/api/getWeather",
      data: {
        zipcode: 97201
      },
      success: function( result ) {
        $( "#weather-temp" ).html( "<strong>" + result + "</strong> degrees" );
      }
    });
===========================================

        {/*选择模板*/}
        <switch name="Think.get.by">
            <case value="cate"><include file="index_cate" /></case>
            <case value="tag"><include file="index_tag" /></case>
            <default /><include file="index_keyword_2" />
        </switch>

>>v0.4.8 改造Search　GUI为js点击、提交数据。初步的ajax提交和返回。
GUI:http://seq.dawneve.cc/Admin/Search/index 
api:http://seq.dawneve.cc/Admin/Api/cate

 <div id='by_btn'> 这一段已经是历史了。
    <a class='btn<?php if(I('by')=='cate') echo " blue";?>'  href="{:U('',array('by'=>'cate'))}">按照类别索引</a>
    <a class='btn<?php if(I('by')=='tag') echo " blue";?>' href="{:U('',array('by'=>'tag'))}">按照标签索引</a>
    <a class='btn<?php if(I('by')=='keyword' or empty(I('by'))) echo " blue";?>' href="{:U('',array('by'=>'keyword'))}">按照关键词搜索</a>
</div>

>>v0.4.9 删减文件。修改头部head链接。

<?php
/*
include_once("checksession.php");
include_once("../db.php");
$query = "select * from beian_manage where username='$_SESSION[adminusername2]' ";
$result = mysql_db_query($DataBase, $query); 
$r2=mysql_fetch_array($result);
*/
?>

>>v0.5.0 搜索页面Ajax基本成型，css基本成型。
    unix时间 http://www.cnblogs.com/freespider/p/3730709.html

>>v0.5.1 Oligo页面 add()。修改数据库Oligo字段错误。 
[TODO]还差文件上传、tag添加提示功能。。
    HTML fieldset 标签 -- 表单分组
    如果一个页面的表单项太多,我们最好把它们分组显示,就像使用p标签分开段落一样,可以使用fieldset与legend标签对表单内容分组.
    fieldset 标签 -- 对表单进行分组
    http://www.dreamdu.com/xhtml/tag_fieldset/
    
    例:冻存管保存在第1行第8列就记做 (1,8). 多个管则用多个表示.
    
    
    /**
     * 更好用的获取列表的函数 goodcode
     */
    //获取数据列表array(1=>'1号冰箱',2=>'2号冰箱');
    function getList($tb_name, $tb_prefix=null,$uid=0){
        if($uid==0){ $user=session('user'); $uid=$user['mg_id'];}
        if(strlen($tb_prefix)>0){}else{ $tb_prefix=$tb_name; }
        $info_arr=M($tb_name)
            ->field($tb_prefix.'_id,'.$tb_prefix.'_name')
            ->where('`condition`>0 AND '.$tb_prefix.'_uid='.$uid)
            ->select();   
        return getOneArr($info_arr, $tb_prefix.'_id', $tb_prefix.'_name');
    }

    调用 $m=getlist('manager','mg');

>>v0.5.1 Oligo页面 add()。上传文件！File数据表添加数据size type ext
    1.多文件上传：缺少添加js代码；
    2.标签添加：缺少用户优化功能。

(1)
    <img src="/Public/Uploads/20160918/57de9c2803c53.jpg">
    保存路径file_path= Uploads/20160918/57de9c2803c53.jpg
    原始名字name= island.jpg
    key 附件上传的表单名称:photo
    savepath 上传文件的保存路径:Uploads/20160918/
    name 上传文件的原始名称:island.jpg
    savename 上传文件的保存名称:57de9c2803c53.jpg
    size 上传文件的大小:73629
    type 上传文件的MIME类型:image/jpeg
    ext 上传文件的后缀类型:jpg
    
[TPbug] call_user_func() expects parameter 1 to be a valid callback, 
no array or string given F:\xampp\htdocs\think\ThinkPHP\Library\Think\Upload.class.php 第 170 行.
[TPbug:url]http://seq.dawneve.cc/Admin/Test/upload
[fix] if($this->callback) $data = call_user_func($this->callback, $file);

(2)
圆角按钮样式：http://bbs.lampbrother.net/read-htm-tid-149269.html

(3)
ThinkPHP批量插入数据addAll(),如何获得数据的受影响行数！
http://www.thinkphp.cn/topic/8684.html

(4)数组和字符串互相转换
    $s1='Mon-Tue-Wed-Thu-Fri';
　　$days_array=explode('-',$s1);
　　$days_array 变量现在是一个有5个元素的数组，其元素 Mon 的索引为0，Tue 的索引为1，等等。
　　$s2=implode(',',$days_array);


>>v0.5.1 Oligo页面 add():多文件上传按钮的添加、删除js代码。

>>v0.5.2 Oligo页面 add():标签的js增删、提示。
    <input type=text name='tag_ids' size=50>
    <span class=red> 请使用空格或回车分隔不同标签, 最多可输入5个 </span>

>>v0.5.3 Oligo页面 add(): 后台标签的存储、与新建。
    php从value求key。
        在数组中搜索键值 "red"，并返回它的键名：
    <?php
    $a=array("a"=>"red","b"=>"green","c"=>"blue");
    echo array_search("red",$a);
    ?>                

    //从tag_name字符串到tag_ids
    $str="protein100,cd47,Good";
    $rs=A('Tag','Logic')->get_tag_ids($str);
    
//TODO 盒子内的坐标没有处理！前台js验证脚本。


>>v0.5.4 Oligo页面 add():单击显示tag提示框，鼠标移出来提示框消失。
>>v0.5.5 解决回收站泄露问题。
    (1)auth,role,manager都添加了_uid属性。
    (2)回收站中统计和显示都使用_uid和condition。

>>v0.5.6 Oligo页面 showlist():  (1)全部显示列表，(2)单击分类，只显示该分类的列表；
    todo (3)单击标签，显示该标签的列表
    
最好用的一句话
<?php 
    if(isset($hint_text)){ echo '->'.$hint_text; }
?>
>>v0.5.6-2 Oligo页面 showlist(): (3)单击标签，显示该标签的列表。
>>v0.5.6-3 Mysql匹配已经严谨。没有该标签id则该标签不显示。
    [bug]html标签库的select如果没有补齐参数，则会报错。
    
    
OligoModel/getData()有TODO问题：mysql匹配不严谨。
求助 http://tieba.baidu.com/p/4790195093
    mysql语句正则匹配，tag_ids字段是标签的id组成的字符串。
    要匹配tag_ids字段带有5的，不能是55或者50等；
    比如可以是 
    5 
    5,6
    2,3,5 
    3,4,5,6,7 这几种情况，
    不能是 3,55,60  

MySql 查询以逗号分隔的字符串的方法(正则)  
解决: select oligo_id, tag_ids from wjl_oligo where tag_ids REGEXP '(^|,)5($|,)';
refer:http://blog.csdn.net/vvhesj/article/details/22299413

2 3,5
3 5,6
5 3,5,7
7 5,15
10 5
13 3,5,6
14 3,5,7,8

http://zhidao.baidu.com/question/2117404446457704387.html?qbl=relate_question_0&word=mysql%20%D5%FD%D4%F2%20%BD%E1%CE%B2%BB%F2%D5%DF%CA%C7%B6%BA%BA%C5&hideOtherAnswer=true&newAnswer=1

>>v0.5.7 Oligo页面 detail($id): (1)cate;(2)tag;(3)files;(4)place;
showlist()增加一列 文件数。
    [2048] Declaration of Admin\Controller\OligoController::show() should be compatible with Think\Controller::show($content, $charset = '', $contentType = '', $prefix = '') 
    因为show()方法报错，所以都改成了detail()方法。


substr_count
在php中查找字符串出现次数的查找可以通过substr_count()函数来实现，下面我来给各位同学详细介绍这些函数了。
substr_count($haystack, $needle [,$offset [,$length]])
/$haystack表示母字符串，$needl表示要查找的字符
//$offset表示查找的起点,$length表示查找的长度,均为可选参数

>>v0.5.8 Oligo页面:del($id)。Recycle/showlist/tb_name/oligo.html 原来第一列是No.编号，现在改为id。
    
>>v0.5.9 Oligo页面:upd($id): upd()视图中使用了自定义的Mytag标签扩展。
    <html:select name='cate_id' options="cate_list" selected="cate_id" />
        使用了自定义的Mytag.class.php 
    <Mytag:html_options name='cate_id' options="cate_list" selected="cate_id" />
    
>>v0.5.9-1 Oligo页面:upd($id): file的显示、ajax彻底删除文件。

    [TODO]FileModel/ajaxDel()的第3有缺陷：怎么sql批量删掉已经删掉的文件id
    比如 
id  file_ids
1    2,3,4    
2    3,5,6    
3    3    
    中间删掉3，变成
1    2,4   
2    5,6   
3    __   

>>v0.5.9-1 Oligo页面:upd($id): addFile js代码出错,原来是div id被删了。



