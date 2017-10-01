<?php 
namespace Home\Logic;

class WeiboLogic{
    function links(){
        return array(
            //http://www.qkankan.com/north-america/america/medium/200804/848.html
            //array('http','aa','title'),

			array(0=>'新闻news',
				1=>array(
					array('http://www.bbc.com/news','BBC','BBC新闻'),
					array('https://www.yahoo.com/','雅虎新闻','门户新闻'),
					array('http://www.usatoday.com/','今日美国','Latest World and US News'),
					array('http://www.thetimes.co.uk/','The Times','News and opinion from The Times & The Sunday Times.【短小精悍，仅有预览】'),
					array('http://edition.cnn.com/','CNN','Breaking News, Latest News and Videos'),
					array('http://www.latimes.com/','洛杉矶时报','California, national and world news'),
					array('http://www.51voa.com/','VOA','国内转载，听力材料。'),
					array('http://www.newsweek.com/','Newsweek 新闻周刊','News, Analysis, Politics, Business, Technology, Lifestyle, Photos and Video'),
					array('http://www.nytimes.com/','The New York Times','Breaking News, World News & Multimedia'),
			)),

			
			/*商业-经管类*/
			array('商业-经管类',
				array(
					array('https://www.economist.com/','经济学人','《经济学人》的主要读者群体是高级知识分子以及准备考研、考博的同学学习英语的阅读资料。在本科学生中，越来越多的同学也开始关注这份报纸,经济学人相比较于其他国内外语报纸的态度更客观，视角更宽。'),
					array('https://hbr.org','哈佛商业评论','Ideas and Advice for Leaders 财经、管理类文章'),
					array('http://www.cnbc.com/','CNBC','Consumer News and Business Channel. In-depth world business news from Europe, the Asia-Pacific, Africa, the Middle East, Latin America and global market coverage.'),
					array('https://www.wsj.com','华尔街日报','《华尔街日报》的读者主要为政治、经济、教育和医学界的人士，金融大亨和经营管理人员以及股票市场的投资者，其中包括20万名的董事长、总经理。美国500家最大企业的经理人员绝大部分订阅此报。'),
					array('http://fortune.com/','美国财富杂志','Fortune 500 Daily & Breaking Business News'),
					array('http://www.mckinsey.com/','麦肯锡季刊','麦肯锡公司主办的工商管理战略咨询期刊。该刊旨在为私营公司、上市公司和非营利机构提供工商管理新思路，以帮助企业家以更高效、更有竞争力和更富创新精神的方式去经营管理企业。'),
					array('https://www.time.com/','时代周刊TIME','《时代周刊》（Time）又称《时代》，创立于1923年，是半个世纪多以前最先出现的新闻周刊之一，特为新的日益增长的国际读者群开设一个了解全球新闻的窗口。《时代》是美国三大时事性周刊之一，内容广泛，对国际问题发表主张和对国际重大事件进行跟踪报道。'),
					array('https://www.bna.com/','BNA国际事务局','彭博社Bloomberg BNA provides resources that enable legal, tax, compliance, government affairs, and government contracting professionals to make more informed decisions, provide strategic advice, grow their businesses, and remain compliant.'),
			)),
			
			
			
			/*科技类*/
			array('科技类',
				array(
					array('http://www.scientificamerican.com/','科学美国人','准确预测全球科学未来的发展趋势，并将科研界的成果和人们的实际应用联系在一起，成为制订政府和企业科技政策和发展战略的首选参考，深入了解各领域科技动态的最佳指南。很多考试中往往涉及到自然科学和生物学领域的内容。因此，对于此类内容最佳的教材，就是著名的科学类读物《科学美国人》(Scientific American)。 科学60秒 https://www.scientificamerican.com/podcast/60-second-science/'),
					array('http://www.wired.com/','美国连线杂志wired','科技类月刊杂志，着重于报道科学技术应用于现代和未来人类生活的各个方面，并对文化、经济和政治的影响。'),
					array('http://www.discovery.com/','Discovery探索频道','纪实片内容涵盖自然、科技、古今历史、探险、文化和时事等领域，带领观众深入洞察我们周边世界的内在奥秘。'),
					array('http://www.nationalgeographic.com/','国家地理','Images of Animals, Nature, and Cultures'),
					array('http://www.prevention.com/','美国预防杂志','杂志侧重实用和自我保健方面的知识，内容包含营养学、减肥方法、美容、预防医学和健身等.'),
					array('http://money.cnn.com/technology/','cnn科技频道',''),
					array('http://www.technewsworld.com/','technewsworld','ECT News Network is one of the largest e-business and technology news publishers in the United States. Our network of business and technology news publications attracts a targeted audience of buyers and decision-makers who need timely industry news and reliable analysis.'),
            )),
			
			
			/*国内en站点*/
			array('国内英文网站',
				array(
					array('http://www.chinadaily.com.cn/','chinaDaily','堪称 人民日报 英文版。国家级英文刊物，用语规范。'),
					array('http://news.xinhuanet.com/english/','新华网en','新华网 英文版。'),
					array('http://chinaplus.cri.cn/','cri','国际在线(CRI Online) 英文版。'),
					array('https://www.chinaielts.org/','雅思中国','雅思中国'),
					array('http://zhan.renren.com/iloveenglish?tagId=20393&from=template&checked=true','renren','renren小站：浪漫英语屋'),
			)),
			
			
			/*
			* http://zt.zhan.com/gmatbeikao52032.html
			*/
			
				
			/*人物-名人*/
			array(0=>'人物-名人',
				1=>array(
					array('http://www.ew.com/','娱乐周刊',' Entertainment News | TV News | TV Shows | Movie, Music and DVD Reviews'),
					array('http://www.people.com/people/','美国人物杂志','Celebrity News, Celebrity Photos, Exclusives and Star Style'),
					array('http://www.seventeen.com/','17岁','内容涉及少女关心的偶像、时尚服饰和情感建议等。'),
			)),
			
				
			/*电影书籍*/
			array(0=>'电影书籍',
				1=>array(
					array('http://www.hbo.com/game-of-thrones','game-of-thrones','HBO美剧'),
			)),
			
			
			

			
        );
    }
}

