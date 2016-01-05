<?php

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


/**
 * //
*/









/**
 * //
*/





/**
 * //
*/