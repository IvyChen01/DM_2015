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
	
	public function updateNews()
	{
		$res = Http::phpPost(Config::$dataUrl . '/?json=get_recent_posts', array(), 10);
		try
		{
			$arr = json_decode($res, true);
		}
		catch (Exception $e)
		{
			exit;
		}
		
		/////////// debug
		//echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		//Utils::dumpArr($arr);
		//return;
		
		if (!empty($arr))
		{
			if (isset($arr['status']) && $arr['status'] == 'ok')
			{
				//最新新闻列表
				$news = isset($arr['posts']) ? $arr['posts'] : array();
				$len = count($news);
				for ($i = $len - 1; $i>= 0; $i--)
				{
					$id = isset($news[$i]['id']) ? $news[$i]['id'] : 0;
					$type = isset($news[$i]['type']) ? $news[$i]['type'] : '';
					$slug = isset($news[$i]['slug']) ? $news[$i]['slug'] : '';
					$url = isset($news[$i]['url']) ? $news[$i]['url'] : '';
					$status = isset($news[$i]['status']) ? $news[$i]['status'] : '';
					$title = isset($news[$i]['title']) ? $news[$i]['title'] : '';
					$title_plain = isset($news[$i]['title_plain']) ? $news[$i]['title_plain'] : '';
					$content = isset($news[$i]['content']) ? $news[$i]['content'] : '';
					$excerpt = isset($news[$i]['excerpt']) ? $news[$i]['excerpt'] : '';
					$dateStr = isset($news[$i]['date']) ? $news[$i]['date'] : '';
					$date = Utils::mdate('Y-m-d H:i:s', $dateStr);
					$modifiedStr = isset($news[$i]['modified']) ? $news[$i]['modified'] : '';
					$modified = Utils::mdate('Y-m-d H:i:s', $modifiedStr);
					$categories = '';
					$categoriesArr = isset($news[$i]['categories']) ? $news[$i]['categories'] : array();
					if (!empty($categoriesArr))
					{
						$lastCategories = $categoriesArr[count($categoriesArr) - 1];
						$categories = isset($lastCategories['title']) ? trim($lastCategories['title']) : 'Others';
					}
					if (empty($categories))
					{
						continue;
					}
					$tags = '';
					$tagsArr = isset($news[$i]['tags']) ? $news[$i]['tags'] : array();
					$isFirst = true;
					if (!empty($tagsArr))
					{
						foreach ($tagsArr as $value)
						{
							if ($isFirst)
							{
								$isFirst = false;
								$tags = isset($value['title']) ? $value['title'] : '';
							}
							else
							{
								$title = isset($value['title']) ? $value['title'] : '';
								$tags .= ', ' . $title;
							}
						}
					}
					$author = '';
					$authorArr = isset($news[$i]['author']) ? $news[$i]['author'] : null;
					if (!empty($authorArr))
					{
						$author = $authorArr['name'];
						$author = isset($authorArr['name']) ? $authorArr['name'] : '';
					}
					
					if (!$this->existNews($id))
					{
						$this->addNews($id, $type, $slug, $url, $status, $title, $title_plain, $content, $excerpt, $date, $modified, $categories, $tags, $author);
						
						if (!$this->existChannel($categories))
						{
							$this->addChannel($categories);
						}
						
						$attachments = isset($news[$i]['attachments']) ? $news[$i]['attachments'] : array();
						if (!empty($attachments))
						{
							foreach ($attachments as $value)
							{
								$fullImg = isset($value['images']['full']['url']) ? $value['images']['full']['url'] : '';
								$fullWidth = isset($value['images']['full']['width']) ? $value['images']['full']['width'] : 0;
								$fullHeight = isset($value['images']['full']['height']) ? $value['images']['full']['height'] : 0;
								$thumbnailImg = isset($value['images']['thumbnail']['url']) ? $value['images']['thumbnail']['url'] : '';
								$thumbnailWidth = isset($value['images']['thumbnail']['width']) ? $value['images']['thumbnail']['width'] : 0;
								$thumbnailHeight = isset($value['images']['thumbnail']['height']) ? $value['images']['thumbnail']['height'] : 0;
								$mediumImg = isset($value['images']['medium']['url']) ? $value['images']['medium']['url'] : '';
								$mediumWidth = isset($value['images']['medium']['width']) ? $value['images']['medium']['width'] : 0;
								$mediumHeight = isset($value['images']['medium']['height']) ? $value['images']['medium']['height'] : 0;
								$postThumbnailImg = isset($value['images']['post-thumbnail']['url']) ? $value['images']['post-thumbnail']['url'] : '';
								$postThumbnailWidth = isset($value['images']['post-thumbnail']['width']) ? $value['images']['post-thumbnail']['width'] : 0;
								$postThumbnailHeight = isset($value['images']['post-thumbnail']['height']) ? $value['images']['post-thumbnail']['height'] : 0;
								$this->addImage($id, $fullImg, $fullWidth, $fullHeight, $thumbnailImg, $thumbnailWidth, $thumbnailHeight, $mediumImg, $mediumWidth, $mediumHeight, $postThumbnailImg, $postThumbnailWidth, $postThumbnailHeight);
							}
						}
					}
				}
			}
		}
	}
	
	public function existNews($newsId)
	{
		Config::$db->connect();
		$tbNews = Config::$tbNews;
		$sqlNewsId = Security::varSql($newsId);
		Config::$db->query("select id from $tbNews where newsid=$sqlNewsId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function existChannel($channel)
	{
		Config::$db->connect();
		$tbChannel = Config::$tbChannel;
		$sqlChannel = Security::varSql($channel);
		Config::$db->query("select id from $tbChannel where channel=$sqlChannel");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * 添加新闻
	 */
	public function addNews($newsId, $type, $slug, $url, $status, $title, $title_plain, $content, $excerpt, $date, $modified, $categories, $tags, $author)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$sqlType = Security::varSql($type);
		$sqlSlug = Security::varSql($slug);
		$sqlUrl = Security::varSql($url);
		$sqlStatus = Security::varSql($status);
		$sqlTitle = Security::varSql($title);
		$sqlTitlePlain = Security::varSql($title_plain);
		$sqlContent = Security::varSql($content);
		$sqlExcerpt = Security::varSql($excerpt);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s', $date));
		$sqlModified = Security::varSql(Utils::mdate('Y-m-d H:i:s', $modified));
		$sqlCategories = Security::varSql($categories);
		$sqlTags = Security::varSql($tags);
		$sqlAuthor = Security::varSql($author);
		$tbNews = Config::$tbNews;
		Config::$db->query("insert into $tbNews (newsid, type, slug, url, status, title, title_plain, content, excerpt, pubdate, modified, channel, tags, author) values ($sqlNewsId, $sqlType, $sqlSlug, $sqlUrl, $sqlStatus, $sqlTitle, $sqlTitlePlain, $sqlContent, $sqlExcerpt, $sqlDate, $sqlModified, $sqlCategories, $sqlTags, $sqlAuthor)");
	}
	
	public function addChannel($value)
	{
		Config::$db->connect();
		$sqlChannel = Security::varSql($value);
		$tbChannel = Config::$tbChannel;
		Config::$db->query("insert into $tbChannel (channel) values ($sqlChannel)");
	}
	
	public function addImage($newsId, $fullImg, $fullWidth, $fullHeight, $thumbnailImg, $thumbnailWidth, $thumbnailHeight, $mediumImg, $mediumWidth, $mediumHeight, $postThumbnailImg, $postThumbnailWidth, $postThumbnailHeight)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$sqlFullImg = Security::varSql($fullImg);
		$sqlFullWidth = (int)$fullWidth;
		$sqlFullHeight = (int)$fullHeight;
		$sqlThumbnailImg = Security::varSql($thumbnailImg);
		$sqlThumbnailWidth = (int)$thumbnailWidth;
		$sqlThumbnailHeight = (int)$thumbnailHeight;
		$sqlMediumImg = Security::varSql($mediumImg);
		$sqlMediumWidth = (int)$mediumWidth;
		$sqlMediumHeight = (int)$mediumHeight;
		$sqlPostThumbnailImg = Security::varSql($postThumbnailImg);
		$sqlPostThumbnailWidth = (int)$postThumbnailWidth;
		$sqlPostThumbnailHeight = (int)$postThumbnailHeight;
		$tbNewsPic = Config::$tbNewsPic;
		Config::$db->query("insert into $tbNewsPic (newsid, full_img, full_width, full_height, thumbnail_img, thumbnail_width, thumbnail_height, medium_img, medium_width, medium_height, post_thumbnail_img, post_thumbnail_width, post_thumbnail_height) values ($sqlNewsId, $sqlFullImg, $sqlFullWidth, $sqlFullHeight, $sqlThumbnailImg, $sqlThumbnailWidth, $sqlThumbnailHeight, $sqlMediumImg, $sqlMediumWidth, $sqlMediumHeight, $sqlPostThumbnailImg, $sqlPostThumbnailWidth, $sqlPostThumbnailHeight)");
	}
	
	/**
	 * 获取新闻，按页
	 */
	public function getNews($page, $pagesize)
	{
		Config::$db->connect();
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbNews = Config::$tbNews;
		Config::$db->query("select newsid, title, content, excerpt, pubdate, channel, tags, author from $tbNews order by id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			//$res[$key]['title'] = strip_tags($res[$key]['title']);
			$res[$key]['content'] = strip_tags($res[$key]['content']);
		}
		return $res;
	}
	
	/**
	 * 获取指定栏目的新闻，按页
	 */
	public function getChannelNews($channel, $page, $pagesize)
	{
		Config::$db->connect();
		$sqlChannel = Security::varSql($channel);
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbNews = Config::$tbNews;
		Config::$db->query("select newsid, title, content, excerpt, pubdate, channel, tags, author from $tbNews where channel=$sqlChannel order by id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			//$res[$key]['title'] = strip_tags($res[$key]['title']);
			$res[$key]['content'] = strip_tags($res[$key]['content']);
		}
		return $res;
	}
	
	public function countNews()
	{
		Config::$db->connect();
		$tbNews = Config::$tbNews;
		Config::$db->query("select count(*) as num from $tbNews");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function countChannelNews($channel)
	{
		Config::$db->connect();
		$sqlChannel = Security::varSql($channel);
		$tbNews = Config::$tbNews;
		Config::$db->query("select count(*) as num from $tbNews where channel=$sqlChannel");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function getNewsImage($newsId)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$tbNewsPic = Config::$tbNewsPic;
		Config::$db->query("select full_img, full_width, full_height, thumbnail_img, thumbnail_width, thumbnail_height, medium_img, medium_width, medium_height, post_thumbnail_img, post_thumbnail_width, post_thumbnail_height from $tbNewsPic where newsid=$sqlNewsId");
		return Config::$db->getAllRows();
	}
	
	public function getComment($newsId, $page, $pagesize)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbComment = Config::$tbComment;
		$tbUser = Config::$tbUser;
		Config::$db->query("select t1.id as id, t1.newsid as newsid, t1.content as content, t1.comment_date as comment_date, t1.like_count as like_count, t2.username as username, t2.nick as nick, t2.photo as photo from $tbComment as t1 join $tbUser as t2 on t1.uid=t2.uid where t1.newsid=$sqlNewsId limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			if (!empty($res[$key]['photo']))
			{
				$res[$key]['photo'] = Config::$baseUrl . '/' . $res[$key]['photo'];
			}
			$res[$key]['liked'] = 0;
		}
		return $res;
	}
	
	public function countComment($newsId)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$tbComment = Config::$tbComment;
		Config::$db->query("select count(*) as num from $tbComment where newsid=$sqlNewsId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function addComment($newsId, $uid, $content)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$sqlUid = Security::varSql($uid);
		$sqlContent = Security::varSql($content);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$tbComment = Config::$tbComment;
		Config::$db->query("insert into $tbComment (newsid, uid, content, comment_date, like_count) values ($sqlNewsId, $sqlUid, $sqlContent, $sqlDate, 0)");
		return Config::$db->getInsertId();
	}
	
	public function getCommentById($commentId)
	{
		Config::$db->connect();
		$sqlCommentId = (int)$commentId;
		$tbComment = Config::$tbComment;
		Config::$db->query("select id, newsid, content, comment_date, like_count from $tbComment where id=$sqlCommentId");
		return Config::$db->getRow();
	}
	
	public function getChannel()
	{
		Config::$db->connect();
		$tbChannel = Config::$tbChannel;
		Config::$db->query("select channel from $tbChannel");
		return Config::$db->getAllRows();
	}
	
	public function getUserChannel($uid)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$tbUserChannel = Config::$tbUserChannel;
		Config::$db->query("select channel from $tbUserChannel where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['channel'];
		}
		return null;
	}
	
	public function addUserChannel($uid, $channel, $place)
	{
		$place = (int)$place;
		if ($place < 1)
		{
			$place = 1;
		}
		$srcStrChannel = $this->getUserChannel($uid);
		if (empty($srcChannel))
		{
			$newStrChannel = json_encode(array($channel));
		}
		else
		{
			$srcChannelArr = json_decode($srcStrChannel, true);
			array_splice($srcChannelArr, $place - 1, 0, $channel);
			$newStrChannel = json_encode($srcChannelArr);
		}
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlChannel = Security::varSql($newStrChannel);
		$tbUserChannel = Config::$tbUserChannel;
		Config::$db->query("update $tbUserChannel set channel=$sqlChannel where uid=$sqlUid");
	}
	
	public function removeUserChannel($uid, $channel)
	{
		$srcStrChannel = $this->getUserChannel($uid);
		if (empty($srcChannel))
		{
			$newStrChannel = '';
		}
		else
		{
			$srcChannelArr = json_decode($srcStrChannel, true);
			$index = array_search($channel, $srcChannelArr);
			if ($index === false)
			{
				$newStrChannel = $srcStrChannel;
			}
			else
			{
				array_splice($srcChannelArr, $index, 1);
				$newStrChannel = json_encode($srcChannelArr);
			}
		}
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlChannel = Security::varSql($newStrChannel);
		$tbUserChannel = Config::$tbUserChannel;
		Config::$db->query("update $tbUserChannel set channel=$sqlChannel where uid=$sqlUid");
	}
	
	public function moveUserChannel($uid, $channel, $place)
	{
		$place = (int)$place;
		if ($place < 1)
		{
			$place = 1;
		}
		$srcStrChannel = $this->getUserChannel($uid);
		if (empty($srcChannel))
		{
			$newStrChannel = '';
		}
		else
		{
			$srcChannelArr = json_decode($srcStrChannel, true);
			$index = array_search($channel, $srcChannelArr);
			if ($index === false)
			{
				$newStrChannel = $srcStrChannel;
			}
			else
			{
				array_splice($srcChannelArr, $index, 1);
				array_splice($srcChannelArr, $place - 1, 0, $channel);
				$newStrChannel = json_encode($srcChannelArr);
			}
		}
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlChannel = Security::varSql($newStrChannel);
		$tbUserChannel = Config::$tbUserChannel;
		Config::$db->query("update $tbUserChannel set channel=$sqlChannel where uid=$sqlUid");
	}
	
	public function initUserChannel($uid)
	{
		$allChannel = $this->getChannel();
		$userChannel = array();
		for ($i = 0; $i < 8; $i++)
		{
			$userChannel[] = $allChannel[$i]['channel'];
		}
		$strUserChannel = json_encode($userChannel);
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlChannel = Security::varSql($strUserChannel);
		$tbUserChannel = Config::$tbUserChannel;
		Config::$db->query("insert into $tbUserChannel (uid, channel) values ($sqlUid, $sqlChannel)");
	}
	
	public function getCommentLikes($commentId)
	{
		Config::$db->connect();
		$sqlCommentId = (int)$commentId;
		$tbLike = Config::$tbLike;
		$tbUser = Config::$tbUser;
		Config::$db->query("select t1.like_date as like_date, t2.username as username, t2.nick as nick, t2.photo as photo from $tbLike as t1 join $tbUser as t2 on t1.uid=t2.uid where t1.commentid=$sqlCommentId order by t1.id");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			if (!empty($res[$key]['photo']))
			{
				$res[$key]['photo'] = Config::$baseUrl . '/' . $res[$key]['photo'];
			}
		}
		return $res;
	}
	
	public function countCommentLikes($commentId)
	{
		Config::$db->connect();
		$sqlCommentId = (int)$commentId;
		$tbLike = Config::$tbLike;
		Config::$db->query("select count(*) as num from $tbLike where commentid=$sqlCommentId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function likeComment($uid, $commentId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlCommentId = (int)$commentId;
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$tbLike = Config::$tbLike;
		if (!$this->checkCommentLiked($uid, $commentId))
		{
			Config::$db->query("insert into $tbLike (commentid, uid, like_date) values ($sqlCommentId, $sqlUid, $sqlDate)");
			$this->addLike($commentId);
		}
	}
	
	public function checkCommentLiked($uid, $commentId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlCommentId = (int)$commentId;
		$tbLike = Config::$tbLike;
		Config::$db->query("select id from $tbLike where commentid=$sqlCommentId and uid=$sqlUid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return true;
		}
		return false;
	}
	
	public function addLike($commentId)
	{
		Config::$db->connect();
		$sqlCommentId = (int)$commentId;
		$tbComment = Config::$tbComment;
		Config::$db->query("update $tbComment set like_count = like_count+1 where id=$sqlCommentId");
	}
	
	public function reduceLike($commentId)
	{
		Config::$db->connect();
		$sqlCommentId = (int)$commentId;
		$tbComment = Config::$tbComment;
		Config::$db->query("update $tbComment set like_count = like_count-1 where id=$sqlCommentId");
	}
	
	public function unlikeComment($uid, $commentId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlCommentId = (int)$commentId;
		$tbLike = Config::$tbLike;
		if ($this->checkCommentLiked($uid, $commentId))
		{
			Config::$db->query("delete from $tbLike where commentid=$sqlCommentId and uid=$sqlUid");
			$this->reduceLike($commentId);
		}
	}
	
	public function collect($uid, $newsId)
	{
		if (!$this->checkCollect($uid, $newsId))
		{
			Config::$db->connect();
			$sqlUid = Security::varSql($uid);
			$sqlNewsId = Security::varSql($newsId);
			$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
			$tbCollection = Config::$tbCollection;
			Config::$db->query("insert into $tbCollection (uid, newsid, collect_date) values ($sqlUid, $sqlNewsId, $sqlDate)");
		}
	}
	
	public function checkCollect($uid, $newsId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlNewsId = Security::varSql($newsId);
		$tbCollection = Config::$tbCollection;
		Config::$db->query("select id from $tbCollection where uid=$sqlUid and newsid=$sqlNewsId");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return true;
		}
		return false;
	}
	
	public function getCollectDate($uid, $newsId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlNewsId = Security::varSql($newsId);
		$tbCollection = Config::$tbCollection;
		Config::$db->query("select collect_date from $tbCollection where uid=$sqlUid and newsid=$sqlNewsId");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['collect_date'];
		}
		return '';
	}
	
	public function uncollect($uid, $newsId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlNewsId = Security::varSql($newsId);
		$tbCollection = Config::$tbCollection;
		Config::$db->query("delete from $tbCollection where uid=$sqlUid and newsid=$sqlNewsId");
	}
	
	public function getCollection($uid, $page, $pagesize)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbCollection = Config::$tbCollection;
		$tbNews = Config::$tbNews;
		Config::$db->query("select t1.newsid as newsid, t1.collect_date as collect_date, t2.title as title, t2.content as content, t2.excerpt as excerpt, t2.pubdate as pubdate, t2.channel as channel, t2.tags as tags, t2.author as author from $tbCollection as t1 join $tbNews as t2 on t1.newsid=t2.newsid where t1.uid=$sqlUid order by t1.id limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			//$res[$key]['title'] = strip_tags($res[$key]['title']);
			$res[$key]['content'] = strip_tags($res[$key]['content']);
		}
		return $res;
	}
	
	public function countCollection($uid)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$tbCollection = Config::$tbCollection;
		Config::$db->query("select count(*) as num from $tbCollection where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function getUserComments($uid, $page, $pagesize)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbComment = Config::$tbComment;
		$tbNews = Config::$tbNews;
		Config::$db->query("select t1.id as id, t1.newsid as newsid, t1.content as comment, t1.comment_date as comment_date, t1.like_count as like_count, t2.title as title, t2.content as content, t2.excerpt as excerpt, t2.pubdate as pubdate, t2.channel as channel, t2.tags as tags, t2.author as author from $tbComment as t1 join $tbNews as t2 on t1.newsid=t2.newsid where t1.uid=$sqlUid order by t1.id limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			//$res[$key]['title'] = strip_tags($res[$key]['title']);
			$res[$key]['content'] = strip_tags($res[$key]['content']);
		}
		return $res;
	}
	
	public function countUserComments($uid)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$tbComment = Config::$tbComment;
		Config::$db->query("select count(*) as num from $tbComment where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function search($keywords, $page, $pagesize)
	{
		Config::$db->connect();
		$sqlKeywords = Security::varSql('%' . $keywords . '%');
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbNews = Config::$tbNews;
		Config::$db->query("select newsid, title, content, excerpt, pubdate, channel, tags, author from $tbNews where content like $sqlKeywords order by id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			//$res[$key]['title'] = strip_tags($res[$key]['title']);
			$res[$key]['content'] = strip_tags($res[$key]['content']);
		}
		return $res;
	}
	
	public function countSearch($keywords)
	{
		Config::$db->connect();
		$sqlKeywords = Security::varSql('%' . $keywords . '%');
		$tbNews = Config::$tbNews;
		Config::$db->query("select count(*) as num from $tbNews where content like $sqlKeywords");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function test()
	{
		//$res = Http::phpPost('http://IP/?m=news&a=getRecentNews', array('imei' => '11', 'page' => 1, 'pagesize' => 5, 'channel' => 'Dar Live'), 10);
		
		//$res = Http::phpPost('http://IP/publishers/?m=news&a=getMyComments&imei=868455015018234&page=1&pagesize=20&auth=53195939c846146be484b16acdea4abc&saltkey=cbbeccbedghdbb4a25ed75c8c12186c2030a7d89e1095efhaeacfcaeedibeagf', array(), 10);
		
		$res = Http::phpPost('http://127.0.0.1:8015/?m=news&a=getMyComments', array('imei' => '11', 'page' => 1, 'pagesize' => 5, 'channel' => 'Dar Live'), 10);
		
		try
		{
			$arr = json_decode($res, true);
		}
		catch (Exception $e)
		{
			exit;
		}
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		Utils::dumpArr($arr);
	}
}
?>
