# Learn thinkPHP by practice  


## 基于web的测序结果管理系统  

SeqManager/ReadMe.txt  




## 单用户微博管理系统  

think/Apps/Home/Controller/WeiboController.class.php  




## github hint  

### …or create a new repository on the command line
```
echo "# think" >> README.md
git init
git add README.md
git commit -m "first commit"
git remote add origin git@github.com:DawnEve/think.git
git push -u origin master
```

### …or push an existing repository from the command line
```
git remote add origin git@github.com:DawnEve/think.git
git push -u origin master
```

### …or import code from another repository

You can initialize this repository with code from a Subversion, Mercurial, or TFS project.




---

```
/**
 * strstr — 查找字符串的首次出现
*/
$email='aaa@bbb.com';

echo strstr($email,'@'),'<hr>'; // @bbb.com
echo strstr($email,'@',true); // @aaa


/**
 * strpos — 查找字符串首次出现的位置
*/
$mystring = 'abc';
$findme   = 'a';
$pos = strpos($mystring, $findme);

echo $pos;//0

//实例2
$mystring = 'abc';
$findme2   = 'd';
$pos2 = strpos($mystring, $findme2);

var_dump($pos2);//bool(false)

```









# weibo system info

## how to start

- create DB `think` at local mysql
- add tables `think_weibo` and `think_weibo_category` in devLog.txt, or insert sql file from backup files.
- put this project in XAMPP under htdocs/
- set apache and hosts file
- browse http://tp.dawneve.cc/weibo


## Backup and recover DB

```
注意：使用cmd，不能是power sehll。后者会中文乱码。

备份语句:
> mysqldump -u root -p"" think > G:\DB_think.sql
> 默认本地登录没有密码。

恢复语句:
> mysql -u root -p mydatabase < mydatabase_backup.sql
```


```
查看字符集
> .\mysql -uroot -p
MariaDB [(none)]> show variables like 'character%';
+--------------------------+--------------------------------+
| Variable_name            | Value                          |
+--------------------------+--------------------------------+
| character_set_client     | gbk                            |
| character_set_connection | gbk                            |
| character_set_database   | latin1                         |
| character_set_filesystem | binary                         |
| character_set_results    | gbk                            |
| character_set_server     | latin1                         |
| character_set_system     | utf8                           |
| character_sets_dir       | D:\xampp\mysql\share\charsets\ |
+--------------------------+--------------------------------+
```


## 已经掌握的单词

登录数据库

```
使用cmd，不能是powerShell:
D:\xampp\mysql\bin>mysql -u root -p
MariaDB [(none)]> use think;
```

已掌握的句子，设置 archive 为年月日
`> update think_weibo set archive =20241010 where id=5;`

又忘了，设置为null
`> update think_weibo set archive=null where id=5;`



