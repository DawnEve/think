序列管理系统。
-----------------
数据表前缀是seq_
-----------------

F:\xampp\apache\conf\extra



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






