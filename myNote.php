<?php

//利用反射调用对象的方法

//定义类
class Person{
	private $name;
	function __construct($name=''){
	   $this->name=$name;
	}
	
    function say(){
        return 'I am ' . $this->name;
    }
    
    function run($addr, $speed = 0){
        return $this->name . " is runing at ".$addr." now, and the speed is ".$speed;
    }
}


function br(){
    echo '<br>';
}
/*
//常规调用
$p=new Person('Jim');
echo $p->say();
echo '<hr>';
echo $p->run(100);
*/

//使用反射实现对象调用方法
$tom=new Person('Tom');
//没有参数时
$method=new ReflectionMethod($tom, 'say');
echo $method->invoke($tom);br();

//有参数时
$method2=new ReflectionMethod($tom, 'run');
echo $method2->invoke($tom, '河源西路',255); br();
echo $method2->invokeArgs($tom, array('河源东路',133));