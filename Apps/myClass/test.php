<?php
include('MyCurl.class.php');
include('MyAjax.php');


//$url='http://www.west.cn/web/domaintrade/historyoftrade';
$url='http://www.west.cn/web/domaintrade/historyoftrade?have=&foreclose=&againforeclose=&type=&min_length=&max_length=&dom_ext=&p_type=&p_topmoney_low=&p_topmoney_top=&overtime_low=2015-12-20&overtime_top=2015-12-26&_csrf=SU9jeGpFUkUqLVJOHipnEAF/DiEyByV3EQRUHi4RKDIoIg8PEiYKNA%3D%3D&page=1&pagesize=50';

$curl=new MyCurl();
$data = $curl->_request($url,false);

$fp = @fopen("LogCurl.html", "w, ccs=<utf-8>");//保持utf-8格式


fwrite($fp,$data); 
fclose($fp);

echo '已经记录完成，<a href="LogCurl.html">查看捕获到的结果LogCurl</a>';