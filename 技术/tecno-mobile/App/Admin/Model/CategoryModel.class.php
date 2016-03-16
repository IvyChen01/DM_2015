<?php


namespace Admin\Model;

use Think\Model;
use Common\Model\CommonModel;

class CategoryModel extends CommonModel {

    protected $connection = 'DB_ADMIN';
    protected $trueTableName =  'ec_category';

    public function category() {
        if (IS_POST) {
            $act = $_POST[act];
            $data = $_POST['data'];
            $data['name'] = addslashes($data['name']);
            $M = M("Category");
            if ($act == "add") { //添加分类
                unset($data[cid]);
                $data["status"] = "1";
                if ($M->where($data)->count() == 0) {
                    return ($M->add($data)) ? array('statusCode' => 200, 'message' => '分类 ' . $data['name'] . ' 已经成功添加到系统中') : array('statusCode' => 300, 'message' => '分类 ' . $data['name'] . ' 添加失败');
                } else {
                    return array('statusCode' => 200, 'message' => '系统中已经存在分类' . $data['name']);
                }
            } else if ($act == "edit") { //修改分类
                if (empty($data['name'])) {
                    unset($data['name']);
                }
                if ($data['fid'] == $data['cid']) {
                    unset($data['fid']);
                }
                return ($M->save($data)) ? array('statusCode' => 200, 'message' => '分类 ' . $data['name'] . ' 已经成功更新') : array('statusCode' => 300, 'message' => '分类 ' . $data['name'] . ' 更新失败');
            } else if ($act == "del") { //删除分类
                unset($data['fid'], $data['name'], $data['oid']);
                return ($M->where($data)->delete()) ? array('statusCode' => 200, 'message' => '分类 ' . $data['name'] . ' 已经成功删除') : array('statusCode' => 300, 'message' => '分类 ' . $data['name'] . ' 删除失败');
                echo $M->getlastsql();
            }
        } else {
            $Category = new \Com\Category('Category', array('cid', 'fid', 'name', 'fullname'));
            $condition['type'] = "dangwei";
            return $Category->getList($condition, $cid = 0, $orderby = 'oid asc'); //获取分类结构
        }
    }

    /**
      +----------------------------------------------------------
     * 用于下拉选择框显示分类信息
     * @param  array  $condition  查询条件
     * @return  array  返回查询结果
      +----------------------------------------------------------
     */
    public static function getCategoryList($condition, $param) {
        $param = isset($param) ? $param : array('modelName' => 'Category', 'field' => '*', 'order' => 'oid ASC', 'tablePrefix' => C('DB_ADMIN_PREFIX'), 'connection' => 'DB_ADMIN');
        $condition['status'] = 1;
        $list = parent::getList($param, $condition);
        //dump($list);
        return $list;
    }

    /**
      +----------------------------------------------------------
     * 用于根据分类id显示分类名称
     * @param  array  $condition  查询条件
     * @return  array  返回查询结果
      +----------------------------------------------------------
     */
    public static function getCategory($condition, $param) {
        $param = isset($param) ? $param : array('modelName' => 'Category', 'field' => '*', 'order' => 'oid ASC');
        $categoryList = self::getCategoryList($condition, $param);
        foreach ($categoryList as $k => $v) {
            $categoryInfo[$v['cid']] = $v;
        }
        return $categoryInfo;
    }

}

?>
