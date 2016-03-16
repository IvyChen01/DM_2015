<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :文章模型
* @date: 2015年10月9日 上午10:44:15
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;

use Think\Model;
use Common\Model\CommonModel;

class ArticleModel extends CommonModel {

    /**
      +----------------------------------------------------------
     * 定义
     * @param  string  $model  使用$this->model调用模型名
     * @param  array  $_validate  自动验证
     * @param  array  $_auto  自动完成
     * @param  array  $tableFields  列表字段
     * @param  array  $searchFields  查询字段
      +----------------------------------------------------------
     */
    
    public $model = 'Article';

    protected $_validate = array(
        array('title','require','请输入标题！'),
        array('content','require','请输入内容！')
    );

    protected $_auto = array(
        array('uTime', 'time', 3, 'function')
    );

    public $tableFields = array(
        'id' => array('name'=>'ID', 'order'=>'1'),
        'cid' => array('name'=>'类别', 'order'=>'1'),
        'title' => array('name'=>'标题', 'order'=>'1'),
        'visitNums' => array('name'=>'点击/回复', 'order'=>'0'),
        'cUid' => array('name'=>'创建人', 'order'=>'1'),
        'uTime' => array('name'=>'最后更新', 'order'=>'1')
    );

    /**
      +----------------------------------------------------------
     * 后台数据列表
     * @param  array  $condition  查询条件
     * @return  array  $list  返回列表数据
      +----------------------------------------------------------
     */
    public function index($condition) {
        $list = $this->getPageList($param = array('modelName' => $this->model, 'field' => '*', 'order' => 'uTime DESC', 'listRows' => '20'), $condition);
        foreach ($list['info'] as $k => $v) {
            $list['info'][$k]['title'] = '<a href="'.C('WEB_ROOT').'/index.php?m=Home&c=Article&a=detail&cid'.$list['info'][$k]['cid'].'&id='.$list['info'][$k]['id'].'" target="_blank">'.
			       $list['info'][$k]['title'].'</a>';
            $list['info'][$k]['cUid'] = $this->getUserFullNameByUid($v['cUid']);
            $list['info'][$k]['cid'] = $this->getArticleCategoryNameById($v['cid']);
            $list['info'][$k]['uTime'] = $this->getUserFullNameByUid($v['uUid']) . '  ' . timeFormat($v['uTime']);
            $list['info'][$k]['visitAndReplyNums'] = $v['visitNums'] . ' / ' . $this->getArticleReplyNum($v['id']);
        }
        return $list;
    }

    /**
      +----------------------------------------------------------
     * 获取文章分类信息
     * @return  array  返回文章分类数据
      +----------------------------------------------------------
     */
    public function getArticleCategoryNameById($id){
        //return ChannelModel::getChannelList();
        $category = D('Admin/ArticleCats')->category();
        foreach ($category as $k=>$v){
            if ($id==$v['catId']){
                return $v['catName'];
            }
        }
    }

    /**
      +----------------------------------------------------------
     * 数据详情
     * @param  array  $condition  查询条件
     * @return  array  返回详细数据
      +----------------------------------------------------------
     */
    public function detail($condition){
        return $this->getDetail($param = array('modelName' => $this->model), $condition);
    }

    /**
      +----------------------------------------------------------
     * 数据新增
     * @param  array  $data  要新增的数据
     * @return  array  返回执行结果
      +----------------------------------------------------------
     */
    public function add($data) {
        if($data['summary'] == ""){
            $data['summary'] = cutStr($data['content'],150);
        }
        $data['isDel'] = 0;
        $rs = $this->insert($param = array('modelName' => $this->model), $data);
        if ($rs){
            $rd['status']= 1;
            $rd['statusCode'] = 200;
            $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
            $rd['closeCurrent'] = true;
        }
        return $rd;
    }

    /**
      +----------------------------------------------------------
     * 数据更新
     * @param  array  $data  要更新的数据
     * @return  array  返回执行结果
      +----------------------------------------------------------
     */
    public function edit($data) {
        if($data['summary'] == ""){
            $data['summary'] = cutStr($data['content'],150);
        }
        $rs = $this->update($param = array('modelName' => $this->model), $data, $condition);
       if ($rs){
            $rd['status']= 1;
            $rd['statusCode'] = 200;
            $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
            $rd['closeCurrent'] = true;
        }
        return $rd;
    }

    /**
      +----------------------------------------------------------
     * 数据删除
     * @param  array  $condition  删除条件
     * @return  array  返回执行结果
      +----------------------------------------------------------
     */
    public function remove($condition) {
        //return array('statusCode' => 200, 'message' => '没有真的删除成功');
        $rs = $this->del($param = array('modelName' => $this->model), $condition);
        if(false !== $rs){
            $rd['status']= 1;
            $rd['statusCode'] = 200;
            $rd['message'] = C('ALERT_MSG.DELETE_SUCCESS');
            $rd['closeCurrent'] = false;
        }
        return $rd;
    }

    /**
      +----------------------------------------------------------
     * 获取文章回复数
     * @param  int  $id  文章ID
     * @return  int  返回回复数
      +----------------------------------------------------------
     */
    public function getArticleReplyNum($id){
        return $this->getCount($param = array('modelName' => 'ArticleReply', 'field' => '*'), array('pid' => $id));
    }

    /**
      +----------------------------------------------------------
     * 获取文章回复信息
     * @param  array  $condition  查询条件
     * @return  array  $list  返回回复列表数据
      +----------------------------------------------------------
     */
    public function getReplyList($condition) {
        $list = $this->getPageList($param = array('modelName' => 'ArticleReply', 'field' => '*', 'order' => 'id DESC', 'listRows' => '20'), $condition);
        foreach ($list['info'] as $k => $v) {
            $list['info'][$k]['cName'] = $this->getUserFullNameByUid($v['cUid']);
        }
        return $list;
    }

    /**
      +----------------------------------------------------------
     * 文章浏览次数加1
     * @param  int  $id  文章ID
     * @return  array  返回执行结果
      +----------------------------------------------------------
     */
    public function visitNumAdd($id){
        //return $this->toSetInc($param = array('modelName' => $this->model), 'visitNums', '1', array('id' => $id));
    }

    /**
      +----------------------------------------------------------
     * 新增回复
     * @param  array  $data  一维数组
     * @return  array  返回执行结果
      +----------------------------------------------------------
     */
    public function replyAdd($data) {
        $this->update($param = array('modelName' => 'ArticleReply'), array('uUid' => $this->getMyInfo('uid')), array('id' => $data['pid']));
        return $this->insert($param = array('modelName' => 'ArticleReply'), $data);
    }


    public function getListbyAll($order = 'uTime DESC', $condition) {

        $articleList = $this->getCommonPageList($param = array('modelName' => 'Article', 'field' => '*', 'order' => $order, 'listRows' => '10'), $condition);
        foreach ($articleList["info"] as $k => $v) {
            $articleList['info'][$k]['cUid'] = $this->getUserFullNameByUid($v['cUid']);
            $channelDetail = ChannelModel::getChannelDetailById($v["cid"]);
            $articleList["info"][$k]["channelName"] = $channelDetail['name'];
        }

        return $articleList;
    }

    public function getRandList() {

        $articleList = parent::getPageList($param = array('modelName' => 'Article', 'field' => '*', 'order' => 'rand()', 'listRows' => '10'), $articleMap);
        return $articleList;
    }

    /**
      +----------------------------------------------------------
     * 获取最新文章列表
     * @param  array  $condition  查询条件
     * @return  array  返回查询结果
      +----------------------------------------------------------
     */
    public function getLatestArticleList($condition,$limit = 5) {

        $articleList = parent::getList($param = array('modelName' => 'Article', 'field' => '*', 'order' => 'id DESC', 'limit' => $limit), $condition);
        return $articleList;
    }

    /**
      +----------------------------------------------------------
     * 根据ID获取文章详情
      +----------------------------------------------------------
     */
    public function getDetailById($id) {

        $condition['id'] = $id;
        $articleList = parent::getDetail($param = array('modelName' => 'Article'), $condition);

        $channelDetail = ChannelModel::getChannelDetailById($articleList["cid"]);
        $articleList["channelName"] = $channelDetail['name'];

        return $articleList;
    }

    /**
      +----------------------------------------------------------
     * 获得上一篇文章
      +----------------------------------------------------------
     */
    public function getFront($currentId) {

        $M = M('Article');
        $front = $M->where("id<" . $currentId)->order('id DESC')->limit('1')->find();
        return $f = !$front ? '<a role="button" class="btn btn-lg btn-default col-sm-12 btn-block disabled" style="text-align:left;"><i class="fa fa-backward"></i> 这是最前一篇了</a>' : '<a role="button" class="btn btn-lg btn-default col-sm-12 btn-block" style="text-align:left;overflow:hidden;" href="/article-' . $front['cid'] . '-' . $front['id'] . '.html"><i class="fa fa-backward"></i> ' . $front['title'] . '</a>';
    }

    /**
      +----------------------------------------------------------
     * 获得下一篇文章
      +----------------------------------------------------------
     */
    public function getAfter($currentId) {

        $M = M('Article');
        $after = $M->where("id>" . $currentId)->order('id ASC')->limit('1')->find();
        return $a = !$after ? '<a role="button" class="btn btn-lg btn-default col-sm-12 btn-block disabled" style="text-align:left;"><i class="fa fa-forward"></i> 这是最后一篇了</a>' : '<a role="button" class="btn btn-lg btn-default col-sm-12 btn-block" style="text-align:left;overflow:hidden;" href="/article-' . $after['cid'] . '-' . $after['id'] . '.html"><i class="fa fa-forward"></i> ' . $after['title'] . '</a>';
    }

    /**
      +----------------------------------------------------------
     * 根据代码获取文章列表
      +----------------------------------------------------------
     */
    public function getListByCode() {

        $channelMap['code'] = I('get.code');
        $channelDetail = parent::getDetail($param = array('modelName' => 'Channel'), $channelMap);
        $articleMap['cid'] = $channelDetail["id"];
        $articleList = parent::getPageList($param = array('modelName' => 'Article', 'field' => '*', 'order' => 'uTime DESC', 'listRows' => '10'), $articleMap);
        foreach ($articleList["info"] as $key => $value) {
            if ($value["thumbnail"] == "") {
                $articleList["info"][$key]["thumbnail"] = C("STATIC_PATH") . '/Img/Common/noThumbnail.jpg';
            }
            $channelDetail = ChannelModel::getChannelDetailById($value["cid"]);
            $articleList["info"][$key]["channelName"] = $channelDetail['name'];
        }
        return $articleList;
    }

    public function getListByCid($cid) {

        $channelMap['cid'] = $articleMap['cid'] = $cid;
        $channelDetail = parent::getDetail($param = array('modelName' => 'Channel'), $channelMap);
        $articleList = parent::getPageList($param = array('modelName' => 'Article', 'field' => '*', 'order' => 'uTime DESC', 'listRows' => '10'), $articleMap);
        foreach ($articleList["info"] as $key => $value) {
            if ($value["thumbnail"] == "") {
                $articleList["info"][$key]["thumbnail"] = C("STATIC_PATH") . '/Img/Common/noThumbnail.jpg';
            }
            $channelDetail = ChannelModel::getChannelDetailById($value["cid"]);
            $articleList["info"][$key]["channelName"] = $channelDetail['name'];
        }
        return $articleList;
    }
    public function getListByCidlang($cid,$lang=0) {
    
        $channelMap['cid'] = $articleMap['cid'] = $cid;
        $channelMap['lang'] = $articleMap['lang'] = $lang;
		$channelMap['isDel'] = $articleMap['isDel'] = 0;
        $channelDetail = parent::getDetail($param = array('modelName' => 'Channel'), $channelMap);
        $articleList = parent::getPageList($param = array('modelName' => 'Article', 'field' => '*', 'order' => 'uTime DESC', 'listRows' => '10'), $articleMap);
        foreach ($articleList["info"] as $key => $value) {
            if ($value["thumbnail"] == "") {
                $articleList["info"][$key]["thumbnail"] = C("STATIC_PATH") . '/Img/Common/noThumbnail.jpg';
            }
            $channelDetail = ChannelModel::getChannelDetailById($value["cid"]);
            $articleList["info"][$key]["channelName"] = $channelDetail['name'];
        }
        return $articleList;
    }

    /**
      +----------------------------------------------------------
     * 前台数据列表
      +----------------------------------------------------------
     */
    public function indexFront($firstRow = 0, $listRows = 20) {
        $list = $this->getPageList($param = array('modelName' => $this->model, 'field' => '*', 'order' => 'cTime DESC', 'listRows' => '20'), $map);

        $cidArr = M("Channel")->field("`id`,`name`")->select();
        foreach ($cidArr as $k => $v) {
            $cids[$v['id']] = $v;
        }
        unset($cidArr);

        $statusArr = array("审核状态", "已发布状态");

        foreach ($list['info'] as $k => $v) {
            $list['info'][$k]['nameLink'] = $this->getUserFullNameByUid($v['cUid']);
            $list['info'][$k]['status'] = $statusArr[$v['status']];
            $list['info'][$k]['cidName'] = $cids[$v['cid']]['name'];
        }
        return $list;
    }

    public function category() {
        if (IS_POST) {
            $act = $_POST[act];
            $data = $_POST['data'];
            $data['name'] = addslashes($data['name']);
            $M = M("Category");
            if ($act == "add") { //添加分类
                unset($data[cid]);
                if ($M->where($data)->count() == 0) {
                    return ($M->add($data)) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功添加到系统中', 'url' => U('Article/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 添加失败');
                } else {
                    return array('status' => 0, 'info' => '系统中已经存在分类' . $data['name']);
                }
            } else if ($act == "edit") { //修改分类
                if (empty($data['name'])) {
                    unset($data['name']);
                }
                if ($data['pid'] == $data['cid']) {
                    unset($data['pid']);
                }
                if (empty($data['status'])) {
                    $data['status'] == 0;
                }
                return ($M->save($data)) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功更新', 'url' => U('Article/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 更新失败');
            } else if ($act == "del") { //删除分类
                unset($data['pid'], $data['name'], $data['oid'], $data['type'], $data['status']);
                return ($M->where($data)->delete()) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功删除', 'url' => U('Article/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 删除失败');
            }
        } else {
            $cat = new \Com\Category('Category', array('cid', 'pid', 'name', 'fullname'));
            return $cat->getList();               //获取分类结构
        }
    }

    public function addArticle() {
        $M = M("Article");
        $data = $_POST['info'];
        $data['cTime'] = $data['uTime'] = time();
        $data['cUid'] = $_SESSION['myInfo']['uid'];
        if (empty($data['summary'])) {
            $data['summary'] = cutStr($data['content'], 200);
        }
        if ($M->add($data)) {
            return array('status' => 1, 'info' => "已经发布", 'url' => U('Article/index'));
        } else {
            return array('status' => 0, 'info' => "发布失败，请刷新页面尝试操作");
        }
    }

    /**
     * 
     * @param type $cid
     * @param type $firstRow
     * @param type $listRows
     * @return type
     */
    public function getArticleListPageByCid($cid, $firstRow = 0, $listRows = 20) {
        $Article = M('Article');
        $articleMap["cid"] = $cid;
        $count = $Article->where($articleMap)->count();
        //$Page = new Page($count, $listRows);
        $Page = new \Think\Page($count, $listRows);
        $show = $Page->show();
        $articleList["content"] = $Article->where($articleMap)->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach ($articleList["content"] as $key => $value) {
            if ($value["thumbnail"] == "") {
                $articleList["content"][$key]["thumbnail"] = '/Static/Img/Common/noThumbnail.jpg';
            }
        }
        $articleList["page"] = $show;

        return $articleList;
    }

    public function getArticleListByCid($cid, $limit = 5) {
        $Article = M('Article');
        $articleMap["cid"] = $cid;
        $articleList = $Article->where($articleMap)->order('id desc')->limit($limit)->select();
        foreach ($articleList as $key => $value) {
            if ($value["thumbnail"] == "") {
                $articleList[$key]["thumbnail"] = '/Static/Img/Common/noThumbnail.jpg';
            }
        }
        return $articleList;
    }

    public function getArticleDetailById($articleId) {
        $Article = M('Article');
        return $Article->where('id = ' . $articleId)->find();
    }

}

?>