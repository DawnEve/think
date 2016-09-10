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


