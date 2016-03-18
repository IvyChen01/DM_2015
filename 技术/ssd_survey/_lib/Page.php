<?php
/**
 * 分页
 * @author Shines
 */
class Page
{
	public $format = '{first}{preve}{pages}{next}{last} ({current}/{total})';//分页显示格式
	public $urlBase = 'index.php?page=';//链接前缀
	public $urlExtend = '';//链接后缀
	public $maxItems = 10;//最多显示的页码个数
	public $totalPage = 0;//总页数
	public $preveText = '上一页';//上一页显示文本
	public $nextText = '下一页';//下一页显示文本
	public $firstText = '首页';//第一页显示文本
	public $lastText = '尾页';//最后一页显示文本
	public $leftDelimiter = '[';//页码前缀
	public $rightDelimiter = ']';//页码后缀
	public $spacingStr = ' &nbsp;';//各页码间的空格符，上一页、下一页、第一页、最后一页后也会加入该空格符
	
	public function __construct()
	{
		//
	}
	
	/**
	 * 获取分页文本
	 * $currentPage	当前页
	 */
	public function getPages($currentPage)
	{
		//总页数大于1时才返回分页文本，否则返回空字符
		if ($this->totalPage > 1)
		{
			//过滤非法的当前页码
			$currentPage = (int)$currentPage;
			if ($currentPage > $this->totalPage)
			{
				$currentPage = $this->totalPage;
			}
			if ($currentPage < 1)
			{
				$currentPage = 1;
			}
			
			//上一页文本，下一页文本，第一页文本，最后一页文本
			$prevPageStr = ($currentPage > 1) ? ('<a href="' . $this->urlBase . ($currentPage - 1) . $this->urlExtend . '">' . $this->preveText . '</a>' . $this->spacingStr) : '';
			$nextPageStr = ($currentPage < $this->totalPage) ? ('<a href="' . $this->urlBase . ($currentPage + 1) . $this->urlExtend . '">' . $this->nextText . '</a>' . $this->spacingStr) : '';
			$firstPageStr = ($currentPage > 1) ? ('<a href="' . $this->urlBase . '1' . $this->urlExtend . '">'. $this->firstText . '</a>' . $this->spacingStr) : '';
			$lastPageStr = ($currentPage < $this->totalPage) ? ('<a href="' . $this->urlBase . $this->totalPage . $this->urlExtend . '">' . $this->lastText . '</a>' . $this->spacingStr) : '';
			
			//将当前页放在所有页码的中间位置
			$pageStart = $currentPage - (int)($this->maxItems / 2);
			if ($pageStart > $this->totalPage - $this->maxItems + 1)
			{
				$pageStart = $this->totalPage - $this->maxItems + 1;
			}
			if ($pageStart < 1)
			{
				$pageStart = 1;
			}
			
			//从开始页起，记录各页码，当前页不加链接
			$pagesStr = '';
			for ($pageOffset = 0; $pageOffset < $this->maxItems; $pageOffset++)
			{
				$pageIndex = $pageStart + $pageOffset;
				if ($pageIndex > $this->totalPage)
				{
					break;
				}
				if ($pageIndex == $currentPage)
				{
					$pagesStr .= $currentPage . $this->spacingStr;
				}
				else
				{
					$pagesStr .= '<a href="' . $this->urlBase . $pageIndex . $this->urlExtend . '">' . $this->leftDelimiter . $pageIndex . $this->rightDelimiter . '</a>' . $this->spacingStr;
				}
			}
			
			//将各分页信息替换到格式文本中
			$res = str_replace(array('{first}', '{preve}', '{pages}', '{next}', '{last}', '{current}', '{total}'), array($firstPageStr, $prevPageStr, $pagesStr, $nextPageStr, $lastPageStr, $currentPage, $this->totalPage), $this->format);
			
			return $res;
		}
		else
		{
			return '';
		}
	}
}
?>
