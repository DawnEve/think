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
>>v0.4.7 ajax()  jquery-3.1.0.min.js
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

>>v0.6.0 Oligo页面:upd($id): tag部分的显示、添加
    使用js现有函数添加的。
>>v0.6.1 Oligo页面:upd($id): 修改被提交的效果。文件上传。
    上传文件异常：老文件、新文件要一起提交会失败。正常了。
    
    
    
================================================
dev branch 开发零碎功能，凑成一个模块了在commit到master分支上。
================================================
>>dev0.6.2 Oligo/add() 使用自定义Mytag标签库修正。
>>dev0.6.3 Search/index() 怎么搜索呢？无解。。。
>>dev0.6.4 File/showlist() 显示文件列表。
    需要使用view的自定义函数。

>>dev0.6.5 File/add() 给出两个链接：添加测序结果、添加引物。

>>dev0.6.6 Oligo/upd(): 文件删除改为修改file的condition=0，这样可以恢复。File/del()借助FileModel/ajaxDel()完成删除。
其他3个不做，（1）删除文件（2）删除file中的记录；(3)删除Oligo中的file_ids中的记录id；
    [TPbug]M('xx')->where("xx=xx")->select($id);//这里面的where会被忽略.

>>dev0.6.7 File/upd(): 允许同名文件，仅仅靠file_id进行区分。 删除旧文件，提交新文件。
     
>>dev0.6.8 File/showlist():显示分类和标签，点击进行筛选。[接口例子]showlist/by/cate/id/xx

>>dev0.6.9 Oligo/showlist()标准化接口showlist/by/tag/id/xx

>>dev0.7.0 File/showlist() 文件名点开显示详情，旁边是下载。vr3.jpg (详情 | 下载)
    (1)添加File/detail权限，用于显示文件信息，给研究生、老板开放该权限。
    (2)修改View/File/showlist.html相关链接。

>>dev0.7.1 思考搜索页面怎么实现。Help/about()页面的版权声明。
比如
File/search,  Search/index/in/File/by/xx1/wd/xx2
Seq/search,   Search/index/in/Seq/by/xx1/wd/xx2
Oligo/search, Search/index/in/Oligo/by/xx1/wd/xx2
以及Search/index怎么搞。
怎么搞？
     (1) 2种分类方式by：cate、tag、keyword，默认是keyword
     (2) 3种查询结果搜索in：seq/oligo/file，默认是seq
     (3) 关键词是wd ，难点是怎么分词？
     

>>dev0.7.2 File/detail($id) 仿照 Oligo/detail() 。nl2br。
    (1)note都要正常显示，不要显示在textarea内。同时nl2br等。模仿Weibo系统。
>>dev0.7.3 修改File、Oligo的upd()成功之后跳转到detail()。
    $this->success('成功！',U('detail',array('id'=>$id)));

>>dev0.7.4 View细节修改：为sequence序列的输入.input和输出.code的样式.
    (1)顶部详情菜单加link;  Oligo/showlist, 
    (2)detail页面修改为 nl2br的，不用textarea: Oligo/detail,
    (3)Oligo/upd()失败,原来是调整了参数位置，把uid统一后调了。
    (4)为sequence序列的输入.input和输出.code的样式。Oligo/add upd, detail.

>>dev0.7.5 File/add(); 添加文件页面和功能。
    为独立上传的文件加一个数据库标示符号 isAttach(0非附件，1附件(默认))
    为showlist和detail显示是否为附件。

>>dev0.7.6 微调视图：File/showlist, my_mb_substr只显示前面的部分。
  //显示备注的前5个字节
    function my_mb_substr($note,$len=5){
        //$note=$vo['file_note'];
        if(mb_strlen($note)>$len){
            echo mb_substr($note,0,$len,'utf-8').'...'; 
        }elseif(mb_strlen($note)>0){
            echo $note;
        }
    }
    //使用 {$vo.file_note|my_mb_substr}
  
>>dev0.7.7 复制Oligo到Seq中，包括控制器和视图。
    替换 引物 为 测序。

==============================================
>>commit到master。

>>dev0.7.8 修复Seq/add();   Seq/showlist();列表显示结果。

每个测序结果只有一个引物，显示name、链接、序列。
    下拉窗口显示自定义的引物。js触发函数。修改Mytag.class.php增加onchange事件、id属性。
    
    
<div class=code>
    &gt;my name<a target="_blank" href='/admin/Oligo/detail/id/2'>[查看该引物]</a><br>
    aaaatttttgggcc
</div>

https://developer.mozilla.org/en-US/docs/Web/API/Document/createTextNode
//内容
var oText1=document.createTextNode('&gt;'+oligo_name);
var oA=document.createElement('a');
oA.setAttribute('target','_blank');
oA.setAttribute('href','/admin/Oligo/detail/id/'+oligo_id);
var oBr=document.createElement('br');
var oText2=document.createTextNode(oligo_sequence);
//外边框div
var oDiv=document.createElement('div');
oDiv.setAttribute('class','code');
//塞入内容
oDiv.appendChild(oText1);
oDiv.appendChild(oA);
oDiv.appendChild(oBr);
oDiv.appendChild(oText2);
//插入文档数
m$('oligo_info').appendChild(oDiv);


>>dev0.7.9 修复Seq/del($id);  showlist中增加seq_name和链接。
<td>测序引物<br>(鼠标悬停显示序列)</td>


>>dev0.8.0 修复Seq/detail($id); 
  ["seq_oligo_ids"] => string(1) "2"
  ["seq_oligo_sequence"] => string(16) "aaaaaaaaaaaaaaaa"
  ["seq_oligo_name"] => string(6) "cd47Up"
  ["file_links"] => string(80) "附件1: <a href="/Public/Uploads/20160926/57e90fdc16644.txt">backup.txt</a><br>"

      

>>dev0.8.1 修复Seq/upd($id); 大文件上传失败，但是不报错：修改最大上传5M（php默认是2M）。
    1.修改配置文件 php.ini 
    ; Maximum allowed size for uploaded files.
    ; http://php.net/upload-max-filesize
    upload_max_filesize=7M
    2.重启apache，可以上传2M多的文件了。

[bug]页面出现错位，不知道什么原因。退出重新登录可以了。


==============================================
>>commit到master。Seq模块基本完工。

开始做搜索代码。


>>dev0.8.2 搜索的界面Search/index.html，响应点击。
http://seq.dawneve.cc/Admin/Search/index/

默认是
http://seq.dawneve.cc/Admin/Search/index/by/keyword/in/seq/

1.搜索方式
/by/cate
/by/tag
/by/keyword

2.搜素内容
/in/seq
/in/oligo
/in/file

3.关键词
/wd/xxx

seq/oligo/file的search()中，使用如下语句。

$this->redirect('Search/index',array('in'=>'file'));


>>dev0.8.2 搜索的结果SearchLogic/getData()，产生数据。    按照关键词、分类搜索。


>>dev0.8.3 搜索的结果SearchLogic/getData()，产生数据。    按照标签搜索。
1.求一个sql语句，需要tag_ids中包含有 "3","5","6","8" 任何一项的记录，其中tag_ids如下
tag_ids
3,5,7
3,5
5,6
3,5,7
15
5,15
6
3,15
5
6
7,8
3,5,6
3,5,7,8
9,10
15,6
3,6,18

select tag_ids from wjl_file
where tag_ids REGEXP '(^|,)3($|,)'  
    or tag_ids REGEXP '(^|,)5($|,)'  
    or tag_ids REGEXP '(^|,)6($|,)'  
    or tag_ids REGEXP '(^|,)8($|,)'  
-
>>dev0.8.4 搜索结果的js展示。

>>dev0.8.5 修改界面。首页的变形是怎么回事？[bug]fixed.
    (1)删掉css?time=20160910等时间。

    (2)删除auth表中的 全局搜索 字段：
    61  全局搜索    9   Search  advSearch   9-61    1   1473822830  1473822831  1   1
    (3)替换左上角图标

[bug]ow 搜索会报控制台错误 ！
[fixed]


>>dev0.8.6 修改2个bug。
[bug]seq/showlist()中tag为空时显示不正常。
锁定问题：
(1)file/showlist()正常，而seq和oligo的showlist不正常。
(2)发现时oligo/add的时候如果没有tag则会添加一个空tag。
修复：对TagLogic.class.php进行修改。
    //如果是空的，则直接返回空
    if(''==trim($tags_list)){
       return '';
    }


[bug] tag/upd()如果name和uid相同，则出错！
1062:Duplicate entry 'xxxx-5' for key 'uc_code' [ SQL语句 ] : UPDATE `wjl_tag` SET `tag_name`='xxxx',`tag_uid`='5',`tag_mod_time`='1474987406' WHERE `tag_id` = 17
   //1.2如果同名条目已经存在，则添加失败
   $rs_num = $md->where("tag_uid = $uid AND tag_name= '".I('tag_name')."'")->count();
   if($rs_num>0){
       //$this->error('添加失败！该样品名已经存在.(可能在回收站)', U(''));
       echo '添加失败！该样品名已经存在.(可能在回收站)<br />';
       myBtn_back();
       exit();
   }

>>dev0.8.6-2 删除顶部暂时无用的搜索框，现在没时间实现了。

>>dev0.8.6-3 右上角图片改写。公司名称改为  MIO WEB SERVICE SYSTEMS 
manager/right.html, search/index.html, Help/about.html底部修改logo text为： MIO WEB SERVICE SYSTEMS 

==============================================
>>commit到master。搜索模块基本完工。

整理系统管理员里列表


>>dev0.8.7 添加 Manager/resetPwd(),密码使用password类型。

>>dev0.8.8 管理员列表不能修改admin！

>>dev0.8.9 如果没有依赖的条件，则提示！创建用户时，自动创建默认盒子、默认分类、默认标签。
    1.测序管理：依赖测序冰箱、盒子、分类、标签。这些在添加用户的时候默认添加！
    
>>dev0.8.9-2 如果没有引物，则提示添加引物。
    请先添加引物！之后才能添加测序结果.


>>dev0.9.0 冰箱-盒子两级联动。 oligo/add,  oligo/upd,
    oligo/upd()如果没有盒子，则oligo/detail/id/23不显示该冰箱？
    
>>dev0.9.0-2 冰箱-盒子两级联动。  seq/add,  seq/upd,

>>dev0.9.0-3 增加admin.css中增加tr:hover

>>dev0.9.1 Help/index 正在开发中. 快速入门。Help/article(),Help/index();



>>dev0.9.2 换个电脑安装该系统。
重建数据表：
1.admin
	21232f297a57a5a743894a0e4a801fc3
	MariaDB [think]> insert into wjl_manager(mg_name,mg_pwd,mg_role_id) values('admin','21232f297a57a5a743894a0e4a801fc3',0);
	Query OK, 1 row affected (0.04 sec)

2.auth表

3.role表
	教授
	研究生
	本科生
	
3.5    新用户如果没有冰箱，则用当前账户创建个默认冰箱。

4.教授新建冰箱。 

5.可以登录系统，添加用户、角色了。

[bug]
1048:Column 'condition' cannot be null [ SQL语句 ] : INSERT INTO `wjl_box` (`box_name`,`condition`,`box_fr_id`,`box_uid`,`box_time`,`box_mod_time`) VALUES ('默认盒子',NULL,NULL,'2','1475126263','1475126263')
[fixed] 'condition'=>1,


[bug]
manager/upd()不改名字则出错。
[fixed]


>>dev0.9.2-2 [bug][fixed]教授不能修改用户密码。
  
>>dev0.9.2-3 [bug][fixed]顶部鼠标悬停出样式冲突变丑。
  
>>dev0.9.2-4 [bug][fixed]只有mg_id为1才能新建冰箱？改为只有role_id为0或1才能新建冰箱。
	(1)如果role_id为0或1，显示 新建冰箱，但是新建后showlist不显示。
SELECT `fr_id`,`fr_name`,`fr_place`,`fr_note`,`fr_time`,`fr_mod_time` FROM wjl_fridge as a,wjl_manager as b WHERE ( a.`condition`>0 and b.`condition`>0 and a.fr_uid=b.mg_id and b.mg_role_id in (0,1) ) [ RunTime:0.0000s ]
    (2)教授可以添加、编辑、删除冰箱
    (4)对于教授，回收站显示冰箱。
    
    
    (5)添加box/oligo/seq的add和upd中，显示所有冰箱。
    $this->assign('fridge_list',A('Fridge','Logic')->getList());
    box/add,box/upd,    oligo/add,oligo/upd,    seq/add,seq/upd,
    
    (6)oligo和seq/detail中cate分类link错误。已经修改。
    
>>dev0.9.2-5 用户体验的改为一致:seq/showlist中单击其他都是分类筛选，而单击引物是显示引物信息。
    td改为th。
    
>>dev0.9.2-6 按照序列搜索 sequence,前台js编写完成。    




==============================================
todo list:
    1.搜索结果的显示 >>dev0.8.2
2.登录页面GUI
3.实时新建分类。
[不可能了]4.合并Model中的File/id2name()和Oligo/id2name(); 无法合并了，又多出来一个Seq/id2name();

[不可能了]5.当前位置：引物管理->引物列表->引物详情 多个附件bug仅保存一个。冰箱无法保存。因为 冰箱决定盒子。
    6.冰箱决定盒子。也就是两级联动。>>dev0.9.0
    7.Manager/resetPwd 正在开发中.1 重置密码。>>dev0.8.7
    8.管理员列表不能修改admin！ >>dev0.8.8

    【没时间了，下次再写这个功能】9.添加序列搜索。

9.RESTFull API供前端显示UI调用。
    https://www.web-tinker.com/article/21099.html
    
-










