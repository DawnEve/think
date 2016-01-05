<?php

function ajax($url,$data=null){
	$c=curl_init($url);
	curl_setopt($c,CURLOPT_USERAGENT,'Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn; c8650 Build/GWK74) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1s');
	curl_setopt($c,CURLOPT_RETURNTRANSFER,1);
	
	$data and $data=http_build_query($data) and curl_setopt($c,CURLOPT_POSTFIELDS,$data);
	
	$s=curl_exec($c);
	curl_close($c);
	return $s;
}


/*
$urldata=ajax('http://www.west.cn/web/domaintrade/historyoftrade');
//$fp = @fopen("Log.html", "w"); //记录捕获到的页面源码
$fp = @fopen("Log.html", "w, ccs=<utf-8>");//保持utf-8格式


fwrite($fp,$urldata); 
fclose($fp);

echo '已经记录完成，<a href="Log.html">查看捕获到的结果</a>';
*/
?>