<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :base模型
* @date: 2015年11月3日 上午11:07:44
* @author: yanhui.chen
* @version:
*/

namespace Common\Model;

use Think\Model;

class BaseModel extends Model {

    /**
      +----------------------------------------------------------
     * 获取系统当前用户信息
     * @return   string  返回当前用户信息
      +----------------------------------------------------------
     */
    public static function getMyInfo($field) {
        return $_SESSION['myInfo'][$field];
        
    }
    /**
     * 用来处理内容中为空的判断
     */
    public static function checkEmpty($data,$isDie = false){
        foreach ($data as $key=>$v){
            if(trim($v)==''){
                if($isDie)die("{'status':-1,'key':'$key'}");
                return false;
            }
        }
        return true;
    }
    /**
     * 获取一行记录
     */
    public function queryRow($sql){
        $plist = $this->query($sql);
        return empty($plist)?array():$plist[0];
    }
    
    public static function getModel($param){
        if(isset($param['modelType'])){
            if($param['modelType'] == 'viewModel' || $param['modelType'] == 'relationModel'){
                $M = D($param['modelName']);
            }
        }else{
              $M = isset($param['connection']) ? M($param['modelName'], $param['tablePrefix'], $param['connection']) : M($param['modelName']);
        }
        return $M;
    }
    /**
      +----------------------------------------------------------
     * 获取列表
     * @param  array  $param  一维数组数据
     * @param  array  $condition  一维数组数据
     * @return  array  二维数组数据
      +----------------------------------------------------------
     */
    public static function getList($param = array('modelName' => '', 'field' => '*', 'order' => '', 'limit' => '5', 'tablePrefix' => '', 'connection' => '', 'modelType' => '', 'relationModel' => ''), $condition = '') {
        $M = self::getModel($param);
        $list = $M->field($param['field'])->where($condition)->order($param['order'])->limit($param['limit'])->select();
        
        //echo $sqlStr = $M->getlastsql();
        return $list;
    }

    /**
      +----------------------------------------------------------
     * 获取分页列表
     * @return  array  返回列表及分页数据
      +----------------------------------------------------------
     */
    public static function getPageList($param = array('modelName' => '', 'field' => '*', 'order' => 'id DESC', 'listRows' => '20', 'tablePrefix' => '', 'connection' => '', 'modelType' => 'commonModel', 'relationModel' => ''), $condition = '') {

        $data = $_POST;

        // 排序数据
        if($data['orderField'] != ""){
            $param['order'] = $data['orderField'] . " " . $data['orderDirection'];
            session('orderField', $data['orderField']);
            session('orderDirection', $data['orderDirection']);
        }

        // 生成分页session数据
        session('pageCurrent', $data['pageCurrent']);

        if($data['pageSize'] != ""){
            $pageSize = $data['pageSize'];
        } else {
            if(session('pageSize') != "" and $data['pageSize'] == session('pageSize'))
                $pageSize = session('pageSize');
            else
                $pageSize = 20;
        }
        session('pageSize', $pageSize);


        $M = self::getModel($param);

        if($param['modelType'] == 'relationModel'){
            $relationModel = isset($param['relationModel']) ? $param['relationModel'] : true;
            $list['total'] = $M->relation($relationModel)->field($param['field'])->where($condition)->count();
        }else{
            $list['total'] = $M->field($param['field'])->where($condition)->count();
        }

        if($param['modelType'] == 'relationModel'){
            $relationModel = isset($param['relationModel']) ? $param['relationModel'] : true;
            $list['info'] = $M->relation($relationModel)->field($param['field'])->where($condition)->order($param['order'])->page($data['pageCurrent'],$pageSize)->select();
        }else{
            $list['info'] = $M->field($param['field'])->where($condition)->order($param['order'])->page($data['pageCurrent'],$pageSize)->select();
        }

        //echo $sqlStr = $M->getlastsql();
        return $list;
    }

    /**
      +----------------------------------------------------------
     * 获取分页列表
     * @return  array  返回列表及分页数据
      +----------------------------------------------------------
     */
    public static function getCommonPageList($param = array('modelName' => '', 'field' => '*', 'order' => 'id DESC', 'listRows' => '20', 'tablePrefix' => '', 'connection' => '', 'modelType' => 'commonModel', 'relationModel' => ''), $condition = '') {
        $M = self::getModel($param);
        if($param['modelType'] == 'relationModel'){
            $relationModel = isset($param['relationModel']) ? $param['relationModel'] : true;
            $count = $M->relation($relationModel)->field($param['field'])->where($condition)->count();
        }else{
            $count = $M->field($param['field'])->where($condition)->count();
        }
        $Page = new \Think\Page($count, $param['listRows']);
        $Page->setConfig('theme', "<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>");
        $list['page'] = $Page->show();
        if($param['modelType'] == 'relationModel'){
            $relationModel = isset($param['relationModel']) ? $param['relationModel'] : true;
            $list['info'] = $M->relation($relationModel)->field($param['field'])->where($condition)->order($param['order'])->limit($Page->firstRow, $Page->listRows)->select();
        }else{

            $cacheCode = md5($param['modelName'] . $_SERVER['REQUEST_URI']);
            $startTime=microtime(true);
            $cacheList = S($cacheCode);
            $endTime=microtime(true);
            $totalTime=round(($endTime-$startTime)*1000, 3);
            
            // 启用缓存
            if(C('DATA_CACHE_TYPE') == 'redis') {
                S(array('host' => C('DATA_CACHE_HOST'), 'port' => '6379'));
            }

            if(empty($cacheList)){
                $startTime=microtime(true);
                $list['info'] = $M->field($param['field'])->where($condition)->order($param['order'])->limit($Page->firstRow, $Page->listRows)->select();
                $endTime=microtime(true);
                $totalTime=round(($endTime-$startTime)*1000, 3);
                $list['cacheInfo'] = '<i class="fa fa-clock-o fw"></i> <em>耗时 ' . $totalTime . ' 毫秒</em> / <i class="fa fa-database fw"></i> <em>从 MySQL 数据库读取</em>';
            } else {
                $list['info'] = $cacheList['info'];
                $list['cacheInfo'] = '<i class="fa fa-clock-o fw"></i> <em>耗时 ' . $totalTime . ' 毫秒</em> / <i class="fa fa-database fw"></i> <em>从 ' . C('DATA_CACHE_TYPE') . ' 缓存读取</em> / <i class="fa fa-coffee fw"></i> <em>缓存间隔 ' . C('DATA_CACHE_TIME') . ' 秒</em>';
            }

        }
        S($cacheCode,$list);
        //echo $sqlStr = $M->getlastsql();
        return $list;
    }

    /**
      +----------------------------------------------------------
     * 获取记录数
     * @return  int  返回记录条数
      +----------------------------------------------------------
     */
    public static function getCount($param = array('modelName' => '', 'field' => '*', 'tablePrefix' => '', 'connection' => '', 'modelType' => '', 'relationModel' => ''), $condition) {
        $M = self::getModel($param);
        $count = $M->where($condition)->count($param['field']);
        //echo $sqlStr = $M->getlastsql();
        return $count;
    }

    /**
      +----------------------------------------------------------
     * 求和
     * @return  sum  返回求和值
      +----------------------------------------------------------
     */
    public static function getSum($param = array('modelName' => '', 'field' => '*', 'tablePrefix' => '', 'connection' => '', 'modelType' => '', 'relationModel' => ''), $condition) {
        $M = self::getModel($param);
        return $sum = $M->where($condition)->sum($param['field']);
    }

    /**
      +----------------------------------------------------------
     * 获取详细数据
     * @return  array  返回详细数据
      +----------------------------------------------------------
     */
    public static function getDetail($param = array('modelName' => '', 'field' => '*', 'tablePrefix' => '', 'connection' => '', 'modelType' => '', 'relationModel' => ''), $condition) {
        $M = self::getModel($param);
        if($param['modelType'] == 'relationModel'){
            $relationModel = isset($param['relationModel']) ? $param['relationModel'] : true;
            $info = $M->relation($relationModel)->where($condition)->find();
        }else{

            $cacheCode = md5($param['modelName'] . $_SERVER['REQUEST_URI']);
            $startTime=microtime(true);
            $info = S($cacheCode);
            $endTime=microtime(true);
            $totalTime=round(($endTime-$startTime)*1000, 3);
            
            // 启用缓存
            if(C('DATA_CACHE_TYPE') == 'redis') {
                S(array('host' => C('DATA_CACHE_HOST'), 'port' => '6379'));
            }

            if(empty($info)){
                $startTime=microtime(true);
                $info = $M->field($param['field'])->where($condition)->find();
                $endTime=microtime(true);
                $totalTime=round(($endTime-$startTime)*1000, 3);
                $info['cacheInfo'] = '<i class="fa fa-clock-o fw"></i> <em>耗时 ' . $totalTime . ' 毫秒</em> / <i class="fa fa-database fw"></i> <em>从 MySQL 数据库读取</em>';
                S($cacheCode, $info);
            } else {
              $info['cacheInfo'] = '<i class="fa fa-clock-o fw"></i> <em>耗时 ' . $totalTime . ' 毫秒</em> / <i class="fa fa-database fw"></i> <em>从 ' . C('DATA_CACHE_TYPE') . ' 缓存读取</em> / <i class="fa fa-coffee fw"></i> <em>缓存间隔 ' . C('DATA_CACHE_TIME') . ' 秒</em>';
            }
            
        }
        $sqlStr = $M->getlastsql();
        if (!is_array($info)) {
            //exit(C('ALERT_MSG.RECORD_NOT_EXIST'));
        }
        //echo $sqlStr = $M->getlastsql();
        return $info;
    }

    /**
      +----------------------------------------------------------
     * 写入数据表操作
     * @return  array  返回写入状态
      +----------------------------------------------------------
     */
    public static function insert($param = array('modelName' => '', 'returnUrl' => '', 'tablePrefix' => '', 'connection' => '', 'modelType' => '', 'relationModel' => ''), $data) {
        $M = self::getModel($param);
        $data['cUid'] = self::getMyInfo('staffId');
        $data['cTime'] = $data['uTime'] = time();
        if($param['modelType'] == 'relationModel'){
            $relationModel = isset($param['relationModel']) ? $param['relationModel'] : true;
            $result = $M->relation($relationModel)->add($data);
        }else{
            $result = $M->add($data);
        }
        $sqlStr = $M->getlastsql();
        if ($result) {
            self::OperationLogInsert($sqlStr);
            return array('statusCode' => 200, 'message' => C('ALERT_MSG.EXECUTE_SUCCESS'), 'closeCurrent' => true, 'url' => $param['returnUrl']);
        } else {
            return array('statusCode' => 300, 'message' => C('ALERT_MSG.EXECUTE_FAILED'));
        }
    }

    /**
      +----------------------------------------------------------
     * 更新数据操作
     * @return  array  返回更新状态
      +----------------------------------------------------------
     */
    public static function update($param = array('modelName' => '', 'returnUrl' => '', 'tablePrefix' => '', 'connection' => '', 'modelType' => '', 'relationModel' => ''), $data, $condition) {
        $M = self::getModel($param);
        $data['uUid'] = self::getMyInfo('uid');
        $data['uTime'] = time();

        if ($param['modelType'] == 'relationModel'){
            $relationModel = isset($param['relationModel']) ? $param['relationModel'] : true;
            $result = $M->relation($relationModel)->where($condition)->save($data);
        } else {
            $result = $M->where($condition)->save($data);
        }
        $sqlStr = $M->getlastsql();
        if ($result) {
            self::OperationLogInsert($sqlStr);
            return array('statusCode' => 200, 'message' => C('ALERT_MSG.EXECUTE_SUCCESS'), 'closeCurrent' => true, 'url' => $param['returnUrl']);
        } else {
            return array('statusCode' => 300, 'message' => C('ALERT_MSG.EXECUTE_FAILED'));
        }
    }

    /**
      +----------------------------------------------------------
     * 真实删除操作
     * @return  array  返回删除状态
      +----------------------------------------------------------
     */
    public static function del($param = array('modelName' => '', 'returnUrl' => '', 'tablePrefix' => '', 'connection' => ''), $condition) {
        $M = $param['connection'] ? M($param['modelName'], $param['tablePrefix'], $param['connection']) : M($param['modelName']);
        if ($M->where($condition)->save(array('isDel' => '1'))) {
            $sqlStr = $M->getlastsql();
            self::OperationLogInsert($sqlStr);
            return array('statusCode' => 200, 'message' => C('ALERT_MSG.DELETE_SUCCESS'), 'closeCurrent' => false);
        } else {
            return array('statusCode' => 300, 'message' => C('ALERT_MSG.DELETE_FAILED'));
        }
    }

    /**
      +----------------------------------------------------------
     * 给$field字段值增加指定的值$value
      +----------------------------------------------------------
     */
    public static function toSetInc($param = array('modelName' => '', 'tablePrefix' => '', 'connection' => ''), $field, $value, $condition) {
        $M = $param['connection'] ? M($param['modelName'], $param['tablePrefix'], $param['connection']) : M($param['modelName']);
        if($M->where($condition)->setInc($field, $value)){
            $sqlStr = $M->getlastsql();
            self::OperationLogInsert($sqlStr);
        }
    }

    /**
      +----------------------------------------------------------
     * 记录操作日志
      +----------------------------------------------------------
     */
    public static function OperationLogInsert($content) {
        $data['content'] = $content;
        $data['cUid'] = self::getMyInfo('uid');
        $data['cTime'] = time();
        $M = M('Operationlog');
        $M->add($data);
    }
    
    public function getModel2($tables = ''){
        $tables = ($tables!='')?$tables:$this->getTableName();
        $rs =  $this->query('show columns FROM `'.$tables."`");
        $obj =  array();
        if($rs){
            foreach($rs as $key => $v) {
                $obj[$v['Field']] = $v['Default'];
            }
        }
        return $obj;
    }

}

?>
