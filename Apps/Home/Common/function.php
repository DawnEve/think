<?php
//排错
function debug($s,$isDetail=false){
	echo '<pre>';
	if($isDetail){
		var_dump($s);
	}else{
		print_r($s);
	}
	echo '</pre>';
	die();
}

//排错
function MyDump($s,$isDetail=false){
	echo '<pre>';
	if($isDetail){
		var_dump($s);
	}else{
		print_r($s);
	}
	echo '</pre>';
}

//目的：User模型中的自动验证
function checkLength2($str){
    if( strlen($str) < 6){
        return false;
    }
    return true;
}