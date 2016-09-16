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
>>
