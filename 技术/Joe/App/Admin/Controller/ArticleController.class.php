<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :文章控制器
* @date: 2015年10月9日 上午10:46:33
* @author: yanhui.chen
* @version:
*/

namespace Admin\Controller;

use Think\Controller;
use Common\Controller\CommonController;

class ArticleController extends CommonController {

    /**
      +----------------------------------------------------------
     * 定义
      +----------------------------------------------------------
     */
    protected $model;

    /**
      +----------------------------------------------------------
     * 初始化
      +----------------------------------------------------------
     */
    public function _initialize() {
        parent::_initialize();
        $this->model = D('Article');
    }

    /**
      +----------------------------------------------------------
     * 列表
      +----------------------------------------------------------
     */
    public function index() {
        $condition = $this->searchCondition();
        $condition['isDel'] = 0;
        $list = $this->model->index($condition);
        $this->assign('search', $this->searchKeywords());
        $this->assign('tableFields', $this->model->tableFields);
        $this->assign('list', $list['info']);
        $this->assign('total', $list['total']);
        
        $this->display();
    }

    /**
      +----------------------------------------------------------
     * 快速查询
      +----------------------------------------------------------
     */
    public function quickSearch() {
        $fieldsStr = implode('|', $this->model->searchFields);
        $condition[$fieldsStr] = array('like', '%' . I('get.keyWords') . '%');
        session($this->searchConditionName, $condition);
        $this->redirect('index');
    }

    /**
      +----------------------------------------------------------
     * 详情
      +----------------------------------------------------------
     */
    public function detail() {
        $this->model->visitNumAdd(I('get.id', 0 , 'intval'));

        $condition = "id=" . I('get.id', 0, 'intval');
        $info = $this->model->detail($condition);

        $info['cName'] = $this->model->getUserFullNameByUid($info['cUid'], 1);
        $this->assign("info", $info);

        $replyList = $this->model->getReplyList(array('pid' => I('get.id', 0, 'intval')));
        $this->assign("replyList", $replyList['info']);
        $this->assign("replyPage", $replyList['page']);

        $this->display();
    }

    /**
      +----------------------------------------------------------
     * 新增
      +----------------------------------------------------------
     */
    public function add() {
        if (IS_POST) {
            $data = $this->model->create($_POST['info']);
            $Image = new \Com\Image();
            $data['content'] = $Image->getImageToLocal($data['content']);
            $data ? $this->ajaxReturn($this->model->add($data)) : $this->ajaxReturn(array('statusCode' => 300, 'message' => $this->model->getError()));
        } else {
            $list = D('Admin/ArticleCats')->category();
            //var_dump($list);exit;
            $this->assign("list", $list);
            $this->display();
        }
    }

    /**
      +----------------------------------------------------------
     * 编辑
      +----------------------------------------------------------
     */
    public function edit() {
        if (IS_POST) {
            $data = $this->model->create($_POST['info']);
            $Image = new \Com\Image();
            $data['content'] = $Image->getImageToLocal($data['content']);
            $data ? $this->ajaxReturn($this->model->edit($data)) : $this->ajaxReturn(array('statusCode' => 300, 'message' => $this->model->getError()));
        } else {
            $condition = "id=" . I('get.id', 0, 'intval');
            $this->assign("info", $this->model->detail($condition));
            $list = D('Admin/ArticleCats')->category();
            //var_dump($list);exit;
            $this->assign("list", $list);
            $this->display("add");
        }
    }

    /**
      +----------------------------------------------------------
     * 移除
      +----------------------------------------------------------
     */
    public function remove() {
        $condition = "id=" . I('get.id', 0, 'intval');
        $this->ajaxReturn($this->model->remove($condition));
    }

    /**
      +----------------------------------------------------------
     * 新增回复
      +----------------------------------------------------------
     */
    public function replyAdd() {
        if (IS_POST) {
            $info = $_POST['info'];
            if ($data = $this->model->create($info)) {
                $data['pid'] = $info['pid']; //$this->model模型中没有pid字段，需要单独设置$data['pid']
                $this->ajaxReturn($this->model->replyAdd($data));
            } else {
                $this->ajaxReturn(array('statusCode' => 300, 'message' => $this->model->getError()));
            }
        }
    }

    public function category() {
        if (IS_POST) {
            $this->ajaxReturn(D("Article")->category());
        } else {
            $this->assign("list", D("Article")->category());
            $this->display();
        }
    }

    public function checkArticleTitle() {
        $M = M("Article");
        $where = "title='" . $_GET['title'] . "'";
        if (!empty($_GET['id'])) {
            $where.=" And id !=" . (int) $_GET['id'];
        }
        if ($M->where($where)->count() > 0) {
            $this->ajaxReturn(array('statusCode' => 300, 'message' => "已经存在，请修改标题"));
        } else {
            $this->ajaxReturn(array('statusCode' => 200, 'message' => "可以使用"));
        }
    }

}