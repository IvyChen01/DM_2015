<?php
/**
 * 分页
 */
class Page
{
	public $format = '{first}{preve}{pages}{next}{last} ({current}/{total})';//分页显示格式
	public $url_base = 'index.php?page=';//链接前缀
	public $url_extend = '';//链接后缀
	public $max_items = 10;//最多显示的页码个数
	public $total_page = 0;//总页数
	public $preve_text = '上一页';//上一页显示文本
	public $next_text = '下一页';//下一页显示文本
	public $first_text = '首页';//第一页显示文本
	public $last_text = '尾页';//最后一页显示文本
	public $left_delimiter = '[';//页码前缀
	public $right_delimiter = ']';//页码后缀
	public $spacing_str = ' &nbsp;';//各页码间的空格符，上一页、下一页、第一页、最后一页后也会加入该空格符
	
	public function __construct()
	{
		//
	}
	
	/**
	 * 获取分页文本
	 * $current_page	当前页
	 */
	public function get_pages($current_page)
	{
		//总页数大于1时才返回分页文本，否则返回空字符
		if ($this->total_page > 1)
		{
			//过滤非法的当前页码
			$current_page = (int)$current_page;
			if ($current_page > $this->total_page)
			{
				$current_page = $this->total_page;
			}
			if ($current_page < 1)
			{
				$current_page = 1;
			}
			
			//上一页文本，下一页文本，第一页文本，最后一页文本
			$prev_page_str = ($current_page > 1) ? ('<a href="' . $this->url_base . ($current_page - 1) . $this->url_extend . '">' . $this->preve_text . '</a>' . $this->spacing_str) : '';
			$next_page_str = ($current_page < $this->total_page) ? ('<a href="' . $this->url_base . ($current_page + 1) . $this->url_extend . '">' . $this->next_text . '</a>' . $this->spacing_str) : '';
			$first_page_str = ($current_page > 1) ? ('<a href="' . $this->url_base . '1' . $this->url_extend . '">'. $this->first_text . '</a>' . $this->spacing_str) : '';
			$last_page_str = ($current_page < $this->total_page) ? ('<a href="' . $this->url_base . $this->total_page . $this->url_extend . '">' . $this->last_text . '</a>' . $this->spacing_str) : '';
			
			//将当前页放在所有页码的中间位置
			$page_start = $current_page - (int)($this->max_items / 2);
			if ($page_start > $this->total_page - $this->max_items + 1)
			{
				$page_start = $this->total_page - $this->max_items + 1;
			}
			if ($page_start < 1)
			{
				$page_start = 1;
			}
			
			//从开始页起，记录各页码，当前页不加链接
			$pages_str = '';
			for ($page_offset = 0; $page_offset < $this->max_items; $page_offset++)
			{
				$page_index = $page_start + $page_offset;
				if ($page_index > $this->total_page)
				{
					break;
				}
				if ($page_index == $current_page)
				{
					$pages_str .= $current_page . $this->spacing_str;
				}
				else 
				{
					$pages_str .= '<a href="' . $this->url_base . $page_index . $this->url_extend . '">' . $this->left_delimiter . $page_index . $this->right_delimiter . '</a>' . $this->spacing_str;
				}
			}
			
			//将各分页信息替换到格式文本中
			$res = str_replace(array('{first}', '{preve}', '{pages}', '{next}', '{last}', '{current}', '{total}'), array($first_page_str, $prev_page_str, $pages_str, $next_page_str, $last_page_str, $current_page, $this->total_page), $this->format);
			
			return $res;
		}
		else
		{
			return '';
		}
	}
}
?>
