<?php
namespace Home\Controller;
use Think\Controller;


class WeiboController extends Controller {
	public function index($tag=-1){
		//echo "我的微博<br><a href=".U('Weibo/add').">添加</a>";
		//$weibo=M('weibo')->order('add_time DESC')->select();
		if($tag>0){
			$weibo=M('weibo')->alias('a')
				->field('a.id, a.uid, a.content, a.add_time, a.cid, b.name, b.pid')
				->join('think_weibo_category b ON a.cid = b.id', 'LEFT')
				->where('cid=' . $tag . ' and archive is null')
				->order('add_time DESC')
				->select();
		}else{
			$weibo=M('weibo')->alias('a')
				->field('a.id, a.uid, a.content, a.add_time, a.cid, b.name, b.pid')
				->join('think_weibo_category b ON a.cid = b.id', 'LEFT')
				->where('archive is null')
				->order('add_time DESC')
				->select();
		}
		
			
		//dump($weibo);
		
		
		$this->assign('weibo', $weibo);
		
		$this->show();
	}
		
	
	//插入
	public function insert(){
		$form=D('weibo');
		if($form->create()){
			$result=$form->add();
			if($result){
				$this->success('添加成功');
			}else{
				$this->error('添加失败！');
			}
		}else{
			$this->error($form->getError());
		}
	}
		
	
	//删除
	public function delete($id){
		$weibo = M("weibo"); // 实例化对象
		$result=$weibo->where("id=$id and (cid is null or cid=0)" )->delete();//只能删除没有分类的

		if($result){
			$this->success('删除成功');
		}else{
			$this->error('删除失败！不能删除分类后的数据！');
		}
	}
	
	
	//显示全部
	public function archive(){
		$weibo=M('weibo')->alias('a')
			->field('a.id, a.uid, a.content, a.add_time, a.cid, b.name, b.pid')
			->join('think_weibo_category b ON a.cid = b.id', 'LEFT')
			->order('add_time DESC')
			->select();

		//dump($weibo);
		
		$this->assign('weibo', $weibo);
		$this->display();
	}
	
	//友情链接
	public function links(){
		$links=array(
			//http://www.qkankan.com/north-america/america/medium/200804/848.html
			//array('http','aa','title'),
			array('https://hbr.org','哈佛商业评论','Ideas and Advice for Leaders 财经、管理类文章'),
			array('https://www.yahoo.com/','雅虎新闻','门户新闻'),
			array('http://edition.cnn.com/','CNN','Breaking News, Latest News and Videos'),
			array('http://www.latimes.com/','洛杉矶时报','California, national and world news'),
			array('http://www.thetimes.co.uk/','The Times','News and opinion from The Times & The Sunday Times.'),
			array('http://www.51voa.com/','VOA','新闻'),
			array('http://www.newsweek.com/','Newsweek 新闻周刊','News, Analysis, Politics, Business, Technology, Lifestyle, Photos and Video'),
			array('http://www.nationalgeographic.com/','国家地理','Images of Animals, Nature, and Cultures'),
			array('http://www.ew.com/','娱乐周刊',' Entertainment News | TV News | TV Shows | Movie, Music and DVD Reviews'),
			array('http://www.usatoday.com/','今日美国','Latest World and US News'),
			array('http://www.people.com/people/','美国人物杂志','Celebrity News, Celebrity Photos, Exclusives and Star Style'),
			array('http://fortune.com/','美国财富杂志','Fortune 500 Daily & Breaking Business News'),
			array('http://www.wired.com/','美国连线杂志','科技类月刊杂志，着重于报道科学技术应用于现代和未来人类生活的各个方面，并对文化、经济和政治的影响。'),
			array('http://www.discovery.com/','Discovery探索频道','纪实片内容涵盖自然、科技、古今历史、探险、文化和时事等领域，带领观众深入洞察我们周边世界的内在奥秘。'),
			array('http://www.mckinsey.com/','麦肯锡季刊','麦肯锡公司主办的工商管理战略咨询期刊。该刊旨在为私营公司、上市公司和非营利机构提供工商管理新思路，以帮助企业家以更高效、更有竞争力和更富创新精神的方式去经营管理企业。'),
			array('http://www.seventeen.com/','17岁','内容涉及少女关心的偶像、时尚服饰和情感建议等。'),
			array('http://www.scientificamerican.com/','科学美国人','准确预测全球科学未来的发展趋势，并将科研界的成果和人们的实际应用联系在一起，成为制订政府和企业科技政策和发展战略的首选参考，深入了解各领域科技动态的最佳指南。'),
			array('http://www.prevention.com/','美国预防杂志','杂志侧重实用和自我保健方面的知识，内容包含营养学、减肥方法、美容、预防医学和健身等.'),
			array('http://www.cnbc.com/','CNBC','Consumer News and Business Channel. In-depth world business news from Europe, the Asia-Pacific, Africa, the Middle East, Latin America and global market coverage.'),
			
			
			array('http://www.nytimes.com/','The New York Times','Breaking News, World News & Multimedia'),
		);
//		dump($links);
		$this->assign('links', $links);
		$this->display();
	}
	
}