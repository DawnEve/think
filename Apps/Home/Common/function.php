<?php
//�Ŵ�
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

//�Ŵ�
function MyDump($s,$isDetail=false){
	echo '<pre>';
	if($isDetail){
		var_dump($s);
	}else{
		print_r($s);
	}
	echo '</pre>';
}