

2015-12-23 23:07:10
m��Ҫ�����ݿ������Ҳ�����ڴ���ӿڣ�
c�������������߼�����v���ص��������߼��жϣ�ȥ����m


MySql�ֲ��ٲ飺http://c.biancheng.net/cpp/html/1456.html


--------------------------------
11:54 2015/12/24
��ʼѧϰtp�ֲ᣺

�ٷ��ĵ���http://document.thinkphp.cn/manual_3_2.html
�����ĵ���http://www.kancloud.cn/manual/thinkphp/1682
===========================

�������ţ�http://www.kancloud.cn/thinkphp/thinkphp_quickstart

===========================
����
===========================
1.Ŀ¼�ṹ��
	��֪ʶ�㣺
		|- �����ռ䡣	���������ռ���Զ����������ʵ�֣�
		|- �������ô���&��	common�µĺ���
		|- ��Щ�ط����ִ�Сд�������ļ�����thinkPHPתΪСд
		|- 4��URLģʽ��
		|- ģ�������ǩ�����ʵ�֣�
		|- ���԰���һЩ������������ѡ���ô������ã�
	
# Ŀ¼�ṹ
	����Library/Ŀ¼����22��class�ļ�������namespace Think;
		����12���ļ��С�����namespace Think;	

		namespace Think\Cache\Driver;
		use Think\Cache;
	
	����Library/BehaviorĿ¼����18����Ϊ�ࡣ
	����Library/OrgĿ¼����2���ļ��У�Net��Util
	����Library/Vendor    ���������Ŀ¼������smarty��
	
	����Mode ���Ӧ��ģʽĿ¼ 4���ļ���3���ļ��С�
		    // �����ļ���ô�ϲ��ģ����߸���ǰ�ߣ�
			'config'    =>  array(
				THINK_PATH.'Conf/convention.php',   // ϵͳ��������
				CONF_PATH.'config'.CONF_EXT,      // Ӧ�ù�������
			),

	 ����Tpl ϵͳģ��Ŀ¼

# ����ļ�����
	��֪ʶ�㣺
		|- ģ�滺����ô���ɣ�
		|- ����MVC������ʲô��
		
	�Զ������ࣨû��������think.class.php��148�У�public static function autoload($class)
	
	-----------------------------
	>>npp��Ŀ¼��Ԥ�������
	������explorer�����������ص�ַ:http://sourceforge.net/projects/npp-plugins/files/
	-----------------------------

# ������
	��֪ʶ�㣺
	|- Think/Controler�µ�$this->view��ʲô��
		call_user_func(array(&$o, $method));��ʲô��˼��
		
	���������������ʽ�ǣ������������շ巨������ĸ��д��+Controller

# �����淶
http://www.kancloud.cn/manual/thinkphp/1687

	���飺
		��ѭ��ܵ������淶��Ŀ¼�淶��
		���������о�����������ģʽ�����緢�����⣻
		�࿴����־�ļ��������������⣻
			--��־�ļ���λ�ã�F:\xampp\htdocs\think\Runtime\Logs\Home
		����ʹ��I������ȡ��������ĺ�ϰ�ߣ�
		���»��߻����ı������������Ҫ���������RuntimeĿ¼��

		F:\xampp\htdocs\think\Apps\myClass\curl����

		
		
===========================
����
===========================
# ��������
	|- ��ô�������ȡ�������ļ��أ�
	
	֧�ֹ������á��������á�ģ�����á��������úͶ�̬���á�
	��ThinkPHP�У�һ����˵Ӧ�õ������ļ����Զ����صģ����ص�˳���ǣ�
		��������->Ӧ������->ģʽ����->��������->״̬����->ģ������->��չ����->��̬����

# ��̬����
	���Ե�ǰ��ȡ��Ч��


===========================
�ܹ�
===========================
# ģ�黯���
	һ��������ThinkPHPӦ�û���ģ��/������/������ƣ����ң��������Ҫ�Ļ�������֧�ֶ�����ļ��Ͷ༶��������

	ģ�黯��Ƶ�˼������ģ��������Ҫ�Ĳ��֣�ģ����ʵ��һ�����������ļ��������ļ���MVC�ļ���Ŀ¼���ļ��ϡ�


	// ��Adminģ�鵽��ǰ����ļ�================????????����ɶ��˼��
	define('BIND_MODULE','Admin');

	// ����Ӧ��Ŀ¼
	define('APP_PATH','./Apps/');

	//http://serverName/index.php/ģ��/������/����

# URLģʽ
	|- .htaccess�ļ��������д����

	http://tp.dawneve.cc/home/user/login/var/value

# ���MVC
http://www.kancloud.cn/manual/thinkphp/1698
	Ĭ�ϵ�ģ�Ͳ���Model������Ҳ���Ը������ã�����
	��ģ�Ͳ�ķֲ㻮���Ǻ����ģ�������Ա���Ը�����Ŀ����Ҫ���ɶ��������ģ�ͷֲ㣬

	��ͼ��View���㣺
		-- ��ͼ����ģ���ģ��������ɣ���ģ���п���ֱ��ʹ��PHP����
		-- Ĭ�ϵ���ͼ����ViewĿ¼�����ǿ��Ե����������£�
			'DEFAULT_V_LAYER'       =>  'Mobile', // Ĭ�ϵ���ͼ�����Ƹ���ΪMobile
			��ͼ��λ�ã�
				UserController->read
				ģ�����:./Apps/Home/View/User/read.html

	��������Controller����
		���ʿ����� Home/Controller/UserController.class.php �������£�
		
		�¼������� Home/Event/UserEvent.class.php �������£�
		�� UserEvent�����ڲ����¼���Ӧ������ֻ�����ڲ����ã�
		http://www.kancloud.cn/manual/thinkphp/1698
			Home\Event\UserEvent Object
				//ʵ����һ��UserEvent����ֻ���ڲ����á�
				$a=A('User','Event');
				$a->hi();
				echo '<pre>';
				print_r($a);
				
		�û�ֻ��Ҫ������ͼ����û��C�������Ҳ���Զ�ʶ��??????
			http://tp.dawneve.cc/index.php?c=blog&a=list		
				
# CBDģʽ
	ThinkPHP������ȫ�µ�CBD������Core+��ΪBehavior+����Driver���ܹ�ģʽ
	
	Driver�������������°����չ���棬�Ѿ�ȡ����������չ��ģʽ��չ���ĳ����ò�ͬ��Ӧ��ģʽ���ɡ�
	Behavior����Ϊ����
		������Щϵͳ���ñ�ǩ֮�⣬������Ա��������Ӧ��������Լ���Ӧ�ñ�ǩ�����κ���Ҫ���ص�λ��������´��뼴�ɣ�
		����ǩλ��������AOP�����еġ����桱����Ϊ����Χ����������桱�����б�̡�

		������Ϊ�� ������Ϊλ�� ThinkPHP/Behavior/ Ŀ¼����
		��Ϊ���壺



	//-----------------------------------
	call_user_func(array(&$o, $method));
	http://tieba.baidu.com/p/4231187056?pid=81178002953
	//-----------------------------------
	д���ļ�ʱ��ô���ñ����ʽ��
	//$fp = @fopen("Log.html", "w"); //��¼���񵽵�ҳ��Դ��
	$fp = @fopen("Log.html", "w, ccs=<utf-8>");//����utf-8��ʽ
	
	fwrite($fp,'some text here'); 
	fclose($fp);
	//-----------------------------------

===========================
·��
===========================
# ·�ɹ���

1.ȥ��index.php
	��Ҫʹ��.htaccess�ļ���
	
2.ȥ��ģ������
ԭ����http://tp.dawneve.cc/Home/news/year
ϣ����http://tp.dawneve.cc/news/year
��ϵͳ�������ã��������޸ģ�
	'MODULE_ALLOW_LIST'      =>  array('Home','Admin'),//�����ģ�飬������һ���Ĭ��ģ����ܷ��ʡ�
	'DEFAULT_MODULE'        =>  'Home',  // Ĭ��ģ��


3.���þ�̬·�ɣ�
	http://tp.dawneve.cc/u
	
	//router config
	'URL_ROUTER_ON'=>true,
	'URL_ROUTE_RULES'=>array(
		'u'=>'user/index',
	}

	����ͼ�г�����{$Think.get.id}

	·�ɹ���'news/:year/:month/:day' => array('News/archive', 'status=1'),
	url: http://tp.dawneve.cc/news/2015/12/20
	��ͼ�У�{$Think.get.year}��{$Think.get.month}��{$Think.get.day}��


	��̬·�ɣ�http://tp.dawneve.cc/news/top.shtml
	'URL_MAP_RULES'=>array(
		'news/top' => 'news/archive?type=top',
		//��̬·�ɶ��岻��URL��׺Ӱ�졣��̬·������ȫƥ�䡣
	),


	
===========================
��ͼ
===========================
ThinkPHP�е���ͼ��Ҫ����ָģ���ļ���ģ������

