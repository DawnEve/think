<?php
/**=============================================
 * MyCurl Class
 *
 * 封装好的curll类。
 * 类名时驼峰法，方法名是下划线法。
 * 请求接口用。支持http和https,支持get和post。
 *
 * @version		v1.0.3
 * @revise		2015.12.10
 * @date		2015.10.08
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/

class MyCurl{
	public function _request($curl,$https=true,$method='get',$data='null'){
		$ch=curl_init();
		
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
		//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");

		curl_setopt($ch, CURLOPT_URL, $curl);
		curl_setopt($ch, CURLOPT_HEADER, false);//是否需要头部
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//是否转发到变量，否则输出
		if($https){
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			//curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,true);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
			//CURLOPT_SSL_VERIFYHOST no longer accepts the value 1, value 2 will be used instead
		}
		if($method=='POST'){
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//传输的值
		}
		$content=curl_exec($ch);
		curl_close($ch);
		return $content;
	}
}

/*
$curl=new MyCurl();
//访问百度首页
echo $curl->_request('https://www.baidu.com',true);

*/
