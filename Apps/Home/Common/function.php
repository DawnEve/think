<?php
//ее╢М
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

//ее╢М
function MyDump($s,$isDetail=false){
	echo '<pre>';
	if($isDetail){
		var_dump($s);
	}else{
		print_r($s);
	}
	echo '</pre>';
}