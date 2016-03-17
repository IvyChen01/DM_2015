<?php
/**
 * 新闻
 * @author Shines
 */
class News
{
	public function __construct()
	{
	}
	
	/**
	 * 获取所有新闻
	 */
	public function getAllNews()
	{
		Config::$db->connect();
		$tbNews = Config::$tbNews;
		Config::$db->query("select * from $tbNews order by id");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 获取新闻，按id
	 */
	public function getNewsById($id)
	{
		Config::$db->connect();
		$tbNews = Config::$tbNews;
		$sqlId = (int)$id;
		Config::$db->query("select * from $tbNews where id=$sqlId");
		return Config::$db->getRow();
	}
	
	/**
	 * 获取新闻，按页
	 */
	public function getNewsByPage($page, $pagesize)
	{
		Config::$db->connect();
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		$tbNews = Config::$tbNews;
		Config::$db->query("select * from $tbNews order by id desc limit $from, $pagesize");
		
		return Config::$db->getAllRows();
	}
	
	/**
	 * 添加新闻
	 */
	public function addNews($content)
	{
		Config::$db->connect();
		$sqlContent = Security::varSql($content);
		$pubdate = Utils::mdate('Y-m-d H:i:s');
		$sqlPubdate = Security::varSql($pubdate);
		$tbNews = Config::$tbNews;
		Config::$db->query("insert into $tbNews (title, content, pubdate, link) values ('', $sqlContent, $sqlPubdate, '')");
		$id = Config::$db->getInsertId();
		$this->writeNewsById($id, array('id' => $id, 'title' => '', 'content' => $content, 'pubdate' => $pubdate, 'link' => ''));
		$this->writeIndex();
		return $id;
	}
	
	/**
	 * 修改新闻
	 */
	public function modifyNews($id, $content, $pubdate)
	{
		Config::$db->connect();
		$sqlId = (int)$id;
		$sqlContent = Security::varSql($content);
		$pubdate = Utils::mdate('Y-m-d H:i:s', $pubdate);
		$sqlPubdate = Security::varSql($pubdate);
		$tbNews = Config::$tbNews;
		Config::$db->query("update $tbNews set content=$sqlContent, pubdate=$sqlPubdate where id=$sqlId");
		$this->writeNewsById($sqlId, array('id' => $sqlId, 'title' => '', 'content' => $content, 'pubdate' => $pubdate, 'link' => ''));
		$this->writeIndex();
	}
	
	/**
	 * 记录当前修改的新闻id
	 */
	public function setModifyId($id)
	{
		System::setSession('adminNewsModifyId', (int)$id);
	}
	
	/**
	 * 获取当前修改的新闻id
	 */
	public function getModifyId()
	{
		return (int)System::getSession('adminNewsModifyId');
	}
	
	/**
	 * 删除新闻
	 */
	public function deleteNews($id)
	{
		Config::$db->connect();
		$tbNews = Config::$tbNews;
		$sqlId = (int)$id;
		Config::$db->query("delete from $tbNews where id=$sqlId");
		$this->clearNewsById($sqlId);
		$this->writeIndex();
	}
	
	/**
	 * 写入所有新闻缓存
	 */
	public function cacheAll()
	{
		$news = $this->getAllNews();
		foreach ($news as $value)
		{
			FileCache::write(Config::$newsCacheDir . $value['id'] . '.php', json_encode($value));
		}
		$this->writeIndex();
	}
	
	/**
	 * 写入首页缓存
	 */
	public function writeIndex()
	{
		$news = $this->getNewsByPage(1, Config::$newsPagesize);
		$template = file_get_contents('view/index_t.php');
		$tagList = '';
		$tagCount = System::getCountCode();
		
		foreach ($news as $_value)
		{
			$content = System::fixTitle($_value['content']);
			$content = Utils::msubstr($content, 0, 200);
			$tagList .= '<li><a href="?m=news&a=detail&id=' . $_value['id'] . '" target="_self">' . $content . '</a>';
			$tagList .= '<p class="date">' . Utils::mdate('Y-m-d', $_value['pubdate']) . '</p>';
			$tagList .= '</li>' . "\r\n";
		}
		
		$template = str_replace(Config::$viewCheck, '', $template);
		$template = str_replace('{list}', $tagList, $template);
		$template = str_replace('{count}', $tagCount, $template);
		FileCache::write(Config::$cacheDir . 'index.php', $template);
	}
	
	/**
	 * 读取首页缓存
	 */
	public function readIndex()
	{
		return FileCache::read(Config::$cacheDir . 'index.php');
	}
	
	/**
	 * 写入指定id的新闻缓存
	 */
	public function writeNewsById($id, $news)
	{
		$id = (int)$id;
		FileCache::write(Config::$newsCacheDir . $id . '.php', json_encode($news));
	}
	
	/**
	 * 读取指定id的新闻缓存
	 */
	public function readNewsById($id)
	{
		$id = (int)$id;
		return json_decode(FileCache::read(Config::$newsCacheDir . $id . '.php'), true);
	}
	
	/**
	 * 删除指定id的新闻缓存
	 */
	public function clearNewsById($id)
	{
		$id = (int)$id;
		FileCache::clear(Config::$newsCacheDir . $id . '.php');
	}
}
?>
