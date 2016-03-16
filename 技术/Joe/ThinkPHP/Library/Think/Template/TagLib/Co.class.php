<?php

namespace Think\Template\TagLib;
use Think\Template\TagLib;
/**
 * CO标签库解析类
 */
class Co extends TagLib{

    protected $tags = array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'list' => array('attr' => 'model,fields,limit,order', 'close' =>1),
        'detail' => array('attr' => 'model,fields,condition', 'close' =>1),
        'articleList' => array('attr' => 'limit,order', 'close' =>1),
        'articleDetail' => array('attr' => 'model,fields,condition', 'close' =>1)
    );

    // 通用列表标签
    public function _list($tag,$content){
        
        $model=$tag['model'];
        $fields=isset($tag['fields'])?$tag['fields']:"";
        $limit=$tag['limit'];
        $order=$tag['order'];
        if($tag['condition']){
            $conditionArr = explode(",", $tag["condition"]);
            $urlParam = $conditionArr[1];
            $condition = "'$conditionArr[0]=$_GET[$urlParam]'";
        }

        $str='<?php ';
        $str .= '$M = M("'.$model.'");';
        $str .= '$count = $M->where('.$condition.')->count();';
        $str .= '$Page = new \Think\Page($count, '.$limit.');';
        $str .= '$Page->setConfig("theme", "<ul class=\'pagination\'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>");';
        $str .= '$list["page"] = $Page->show();';
        $str .= '$list["info"] = $M->field("'.$fields.'")->where('.$condition.')->order("'.$order.'")->limit($Page->firstRow, $Page->listRows)->select();';

        $str .= 'foreach ($list["info"] as $value):';
        $str .= 'extract($value);';
        $str .= '?>';

        $str .= $content;
        $str .='<?php endforeach ?>';
        return $str;
    }

    // 通用详情标签
    public function _detail($tag,$content){
        
        $model=$tag['model'];
        $fields=isset($tag['fields'])?$tag['fields']:"";
        $conditionArr = explode(",", $tag["condition"]);
        $pkParam = $conditionArr[1];
        $condition = "'$conditionArr[0]=$_GET[$pkParam]'";

        $str = '<?php ';
        $str .= '$_info_detail=M("Article")->field('.$fields.')->where('.$condition.')->find();';
        $str .= 'extract($_info_detail);';
        $str .= '?>';
        $str .= $content;
        return $str;
    }

    // 文章列表标签
    public function _articleList($tag,$content){
        
        $fields=isset($tag['fields'])?$tag['fields']:"";
        $limit=$tag['limit'];
        $order=$tag['order'];

        $str='<?php ';
        $str .= '$_list_news=M("Article")->field('.$fields.')->limit('.$limit.')->order("'.$order.'")->select();';
        $str .= 'foreach ($_list_news as $_list_value):';
        $str .= 'extract($_list_value);';
        $str .= '$channelName=M("Channel")->getFieldByCid($cid,"name");';
        $str .= '?>';

        $str .= $content;
        $str .='<?php endforeach ?>';
        return $str;
    }

    // 文章详情标签
    public function _articleDetail($tag,$content){
        
        $model=$tag['model'];
        $fields=isset($tag['fields'])?$tag['fields']:"";
        $conditionArr = explode(",", $tag["condition"]);
        $pkParam = $conditionArr[1];
        $condition = "'$conditionArr[0]=$_GET[$pkParam]'";

        $str = '<?php ';
        $str .= '$_info_detail=M("Article")->field('.$fields.')->where('.$condition.')->find();';
        $str .= 'extract($_info_detail);';
        $str .= '$channelName=M("Channel")->getFieldByCid($cid,"name");';
        $str .= '?>';
        $str .= $content;
        return $str;
    }

}