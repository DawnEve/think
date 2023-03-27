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

