<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-11-19 15:37
 * @version 1.0
 * @description 流程处理引擎
 */

namespace Com;

use Think\Model;
use Common\Model\CommonModel;

class Process extends CommonModel{

    /**
      +----------------------------------------------------------
     * 初始化
      +----------------------------------------------------------
     */
    function __construct($param = array()) {
        foreach ($param as $key => $value) {
            $this->$key = $value;
        }

        // 业务模型
        if (!$this->bussinessModel = $param['connection'] ? M($param['businessModelName'], $param['tablePrefix'], $param['connection']) : M($param['businessModelName']))
            $this->error = $param['businessModelName'] . "模型不存在！";

        // 用户视图模型
        $this->userOrgViewModel = D('UserOrgView');
    }


    /**
      +----------------------------------------------------------
     * 流程处理（自动化流程处理）
     * @param  array  $processParam  流程参数
     * @return  array  返回执行结果
      +----------------------------------------------------------
     */
    public function processAutoDeal($processParam){

        $Process = new \Common\Library\Process($model = $this->model, $processParam);
        $data = $Process->getNextStepNoAndDealer();
        if(!isset($data['currentStepNo']) or !isset($data['currentUid'])) {
            return $data; //返回流程流转错误提示信息
        } else {
            // 更新当前环节及当前责任人
            $condition['id'] = $processParam['businessId'];
            $result = $this->update($param = array('modelName' => $this->model), $data, $condition);
            if($result['status'] == '1') {
                // 当前环节更新成功，写入流程流转记录
                return $Process->processRecordInsert(); //返回流程记录写入结果
            } else {
                // 当前环节更新不成功提示
                return array('status' => '0', 'info' => '流程流转失败！'); //返回流程流转结果
            }
        }
    }

    /**
      +----------------------------------------------------------
     * 获得流程下一环节编号及处理人（自动化流程处理）
     * @return  array  $processList  返回下一步步骤编号及处理人
      +----------------------------------------------------------
     */
    function getNextStepNoAndDealer() {

        // 获取流程创建人信息
        $processCreatorInfo = $this->getProcessCreatorInfo($this->processCreatorUid);

        // 获取流程当前步骤信息
        $currentStepInfo = $this->getStepInfoByStepNo($this->currentStepNo);

        // 流程过程记录写入数据表
        //$this->processRecordInsert($this->businessCode, $this->proPid, $this->prorecComment, $this->recordCreatorUid, $currentStepInfo['stepName'], $this->currentStepName, "");

        // 获取流程下一步骤信息
        $nextStepInfo = $this->getStepInfoByStepNo($currentStepInfo['nextStep']);
        //dump($nextStepInfo);

        // 职务和所属部门判断，先判断职务，再判断所属部门
        if ($nextStepInfo["stepName"] == "职务判断") {
            $nextStepInfo = $this->dutyOrDepartmentCheck($nextStepInfo);
        }
        if ($nextStepInfo["stepName"] == "部门判断") {
            $nextStepInfo = $this->dutyOrDepartmentCheck($nextStepInfo);
        }

        if ($nextStepInfo["stepName"] == "知会相关人员") {
            if ($data["processAction"] != "refuse") {
                $proZhihuiArr = explode(";", $nextStepInfo["proZhihui"]);
                foreach ($proZhihuiArr as $nextKey => $nextValue) {
                    //$this->processRecordInsert($this->businessCode, $this->proPid, "", $nextValue, $nextStepInfo["stepNo"], "知会相关人员", "系统添加");
                    //$this->remindInsert($this->businessCode, $this->proPid, $data["remindTitle"], $data["remindUrl"], $nextValue);
                }
            }
            $nextStepInfo = $this->getStepInfoByStepNo($nextStepInfo["nextStep"]);
        }

        //dump($nextStepInfo);

        if ($nextStepInfo["stepNo"] == 0) {
            $processList["currentStepNo"] = '0';
            $processList["currentUid"] = 0;
            //$this->processRecordInsert($this->businessCode, $this->proPid, "", "", $nextStepInfo["stepNo"], $nextStepInfo["stepName"], "存档");
        } else {
            $userCondition = $this->getDealerCondition($nextStepInfo);

            // 查询满足条件的记录数
            $numOfRows = $this->userOrgViewModel->where($userCondition)->count();

            // 检测下一环节责任人是否满足要求
            //$this->nextStepCheck($stepInfo["stepName"], $numOfRows);

            // 获取处理人信息
            $dealerInfo = $this->userOrgViewModel->where($userCondition)->find();
            //echo $this->userOrgViewModel->getlastsql();

            $processList["currentStepNo"] = $nextStepInfo["stepNo"];
            $processList["currentUid"] = $dealerInfo["uid"];
        }

        //print_r($processList);
        if($this->currentStepNo == 0){
            return array('status' => 1, 'info' => '流程已结束了');
        } else {
            if ($nextStepInfo["stepNo"] != 0 && $numOfRows == 0) {
                return array('status' => 0, 'info' => '在【' . $nextStepInfo["stepNo"] . '】环节没有检测下一环节处理人，请与系统管理员联系');
            } else if ($numOfRows > 1) {
                return array('status' => 0, 'info' => '在【' . $nextStepInfo["stepNo"] . '】环节检测到多个下一环节处理人，请与系统管理员联系');
            } else {
                return $processList;
            }
        }
    }

    /**
      +----------------------------------------------------------
     * 获得相应环节的处理人查询条件
     * @param  string  $stepInfo  步骤信息
     * @return  array  $userCondition  返回处理人查询条件
      +----------------------------------------------------------
     */
    private function getDealerCondition($stepInfo) {
        //获取流程创建人信息
        $processCreatorInfo = $this->getProcessCreatorInfo();

        $userCondition["status"] = '1';
        $userCondition["duty"] = $stepInfo["duty"];
        empty($stepInfo["department"]) ? '' : $userCondition["department"] = str_replace("本部门", $processCreatorInfo['department'], $stepInfo["department"]);
        empty($stepInfo["item"]) ? '' : $userCondition["item"] = str_replace("本项目", $processCreatorInfo['item'], $stepInfo["item"]);
        empty($stepInfo["office"]) ? '' : $userCondition["office"] = str_replace("本科室", $processCreatorInfo['office'], $stepInfo["office"]);
        empty($stepInfo["group"]) ? '' : $userCondition["group"] = str_replace("本组别", $processCreatorInfo['group'], $stepInfo["group"]);

        return $userCondition;
    }

    /**
      +----------------------------------------------------------
     * 获取流程创建人第一职务详细信息
     * @param  string  $stepNo  步骤编号
     * @return  array  $rows  返回列表数据
      +----------------------------------------------------------
     */
    private function getProcessCreatorInfo() {
        $condition['uid'] = $this->processCreatorUid;
        $creatorInfo = $this->userOrgViewModel->where($condition)->order('oid ASC')->find();
        return $creatorInfo;
    }


    /**
      +----------------------------------------------------------
     * 职务或部门信息检测
     * @param  string  $stepNo  步骤编号
     * @return  array  $rows  返回列表数据
      +----------------------------------------------------------
     */
    function dutyOrDepartmentCheck($nextStepInfo) {
        $currentStepNo = $nextStepInfo["stepNo"];
        //$this->processRecordInsert($this->businessCode, $this->proPid, "", "", $nextStepInfo["stepNo"], $nextStepInfo["stepName"], "系统进行条件判断");

        // 获取所有
        $condition['businessCode'] = $this->businessCode;
        $condition['stepNo'] = array('like', $currentStepNo . '.%');
        $list = parent::getList($param = array('modelName' => 'Process', 'field' => '*', 'order' => 'stepNo ASC', 'limit' => '', 'tablePrefix' => C('DB_ADMIN_PREFIX'), 'connection' => 'DB_ADMIN'), $condition);

        // 获取流程创建人信息
        $processCreatorInfo = $this->getProcessCreatorInfo();

        foreach ($list as $k => $v) {
            // 流程创建人第一职务判断
            if ($nextStepInfo["stepName"] == "职务判断") {
                $dutyOrDepartment = $processCreatorInfo["duty"];
            } else {
                $dutyOrDepartment = $processCreatorInfo["department"];
            }

            // 流程创建人
            if (strstr($v["param"], $dutyOrDepartment)) {
                $nextStepInfo = $this->getStepInfoByStepNo($v['nextStep']);
                //$this->processRecordInsert($this->businessCode, $this->proPid, "", "", $v['stepName'], $v["stepName"], "系统判断结果");
                break;
            } else {
                // 如果前面的都不匹配，则按最后一个步骤流转
                $nextStepInfo = $this->getStepInfoByStepNo($v['nextStep']);
                //$this->processRecordInsert($this->businessCode, $this->proPid, "", "", $v['stepName'], $v["stepName"], "系统判断结果");
            }
        }
        return $nextStepInfo;
    }

    function zhihuiInsert($data, $nextStepInfo) {
        $proZhihuiArr = explode(";", $nextStepInfo["proZhihui"]);
        $remindModuleName = $this->businessCode;
        $remindPid = $data['proPid'];
        $remindTitle = $data['remindTitle'];
        $remindUrl = $data['remindUrl'];
        $remindSubTime = date("Y-m-d H:i:s");

        $remindReminder = $nextValue;
        $remindSqlStr = "INSERT INTO ims_common_remind (remindModuleName,remindPid,remindTitle,remindUrl,remindReminder,remindSubTime) VALUES ('$remindModuleName','$remindPid','$remindTitle','$remindUrl','$remindReminder','$remindSubTime')";
        $remindResult = mysql_query($remindSqlStr);
    }

    /**
      +----------------------------------------------------------
     * 写入流程过程记录
     * @param  array  $data  流程过程数据
      +----------------------------------------------------------
     */
    function processRecordInsert($data) {
        $currentStepInfo = $this->getStepInfoByStepNo($this->currentStepNo);
        $data['businessCode'] = $this->businessCode;
        $data['businessId'] = $this->businessId;
        $data['stepNo'] = $this->currentStepNo;
        $data['stepName'] = $currentStepInfo['stepName'];
        return parent::insert($param = array('modelName' => 'ProcessRecord', 'returnUrl' => '', 'tablePrefix' => C('DB_ADMIN_PREFIX'), 'connection' => 'DB_ADMIN'), $data);
    }

    /**
      +----------------------------------------------------------
     * 根据步骤编号获取步骤信息
     * @param  string  $stepNo  步骤编号
     * @return  array  $list  返回步骤详细信息
      +----------------------------------------------------------
     */
    function getStepInfoByStepNo($stepNo) {
        $condition['businessCode'] = $this->businessCode;
        $condition['stepNo'] = $stepNo;
        $list = parent::getDetail($param = array('modelName' => 'Process', 'tablePrefix' => C('DB_ADMIN_PREFIX'), 'connection' => 'DB_ADMIN'), $condition);
        return $list;
    }

    /**
      +----------------------------------------------------------
     * 流程处理（自定义流程处理）
     * @param  arrar  $condition  更新条件
     * @param  array  $data  要更新的环节编号及处理人uid
     * @return  array  返回处理结果
      +----------------------------------------------------------
     */
    public function processDeal($data, $processRecordData) {
        if($data['currentStepNo'] != "" and $data['currentUid'] != "") {
            $condition[$this->businessPkName] = $this->businessId;
            $result = parent::update($param = array('modelName' => $this->businessModelName, 'returnUrl' => '', 'tablePrefix' => $this->tablePrefix, 'connection' => $this->connection), $data, $condition);
            if($result['status'] == '1') {
                // 当前环节更新成功，写入流程流转记录
                return $this->processRecordInsert($processRecordData); //返回流程记录写入结果
            } else {
                // 当前环节更新不成功提示
                return array('status' => '0', 'info' => '流程流转失败！'); //返回流程流转结果
            }
        } else {
            return array('status' => '0', 'info' => '无法自动获取到下一环节编号或处理人');
        }
    }

    /**
      +----------------------------------------------------------
     * 作用：流程处理界面相关参数生成（自定义流程处理）
     * @param  string  $stepNo  当前环节编号
     * @return  array  $stepInfo  返回下一环节及下下一环节信息
      +----------------------------------------------------------
     */
    public function getStepParam($stepNo) {
        // 获得当前环节信息
        $currentStepInfo = $this->getStepInfoByStepNo($stepNo);
        //dump($currentStepInfo);

        if (empty($currentStepInfo["nextStep"])) {// 如果当前步骤的下一步骤编号为空，则说明下一步存在多选

            // 获得当前环节可选操作信息
            $stepInfo['nextStep'] = $this->getOptionalStepList($stepNo);

            // 将多选的下一步骤循环检出
            foreach ($stepInfo['nextStep'] as $k => $v) {

                // 获得下一环节的下一环节信息
                $nextNextStepInfo = $this->getStepInfoByStepNo($v["nextStep"]);
                $stepInfo['nextNextStep'][] = $nextNextStepInfo;
                
                // 获取下一环节处理人查询条件
                $userCondition = $this->getDealerCondition($nextNextStepInfo);

                // 查询满足条件的记录数
                //$numOfRows = $this->userOrgViewModel->where($userCondition)->count();

                // 获取下一环节处理人信息
                $stepInfo['dealerInfo'][] = $this->userOrgViewModel->where($userCondition)->find();
            }
        } else {
            // 获得下一环节信息
            $stepInfo['nextStep'] = $this->getStepInfoByStepNo($currentStepInfo["nextStep"]);

            // 获取下一环节处理人查询条件
            $userCondition = $this->getDealerCondition($stepInfo['nextStep']);

            // 查询满足条件的记录数
            //$numOfRows = $this->userOrgViewModel->where($userCondition)->count();

            // 获取下一环节处理人信息
            $stepInfo['dealerInfo'] = $this->userOrgViewModel->where($userCondition)->find();
        }
        return $stepInfo;
    }

    /**
      +----------------------------------------------------------
     * 作用：流程处理界面中下一步骤有多个选项的处理（自定义流程处理）
     * @param  string  $stepNo
     * @return  array  $rows
      +----------------------------------------------------------
     */
    public function getOptionalStepList($stepNo) {
        $condition['stepNo'] = array('LIKE', $stepNo . '.%');
        $list = parent::getList($param = array('modelName' => 'Process', 'field' => '*', 'order' => 'id ASC', 'limit' => '', 'tablePrefix' => C('DB_ADMIN_PREFIX'), 'connection' => 'DB_ADMIN'), $condition);
        return $list;
    }

    /**
      +----------------------------------------------------------
     * 获取流程记录列表
     * @param  array  $condition  查询条件
     * @return  array  $list  返回列表数据
      +----------------------------------------------------------
     */
    public function getProcessRecordList($condition){
        $condition['businessCode'] = isset($condition['businessCode']) ? $condition['businessCode'] : $this->businessCode;
        $condition['businessId'] = isset($condition['businessId']) ? $condition['businessId'] : $this->businessId;
        $list = parent::getList($param = array('modelName' => 'ProcessRecord', 'field' => '*', 'order' => 'id ASC', 'limit' => '', 'tablePrefix' => C('DB_ADMIN_PREFIX'), 'connection' => 'DB_ADMIN'), $condition);
        $userInfo = $this->getUserNameList($type = '1');
        foreach ($list as $k => $v) {
            $list[$k]['cUid'] = $userNameList[$v['cUid']];
        }
        return $list;
    }

    function nextStepCheck($stepName, $numOfRows) {
        if ($numOfRows == 0) {
            echo '<script>alert("在 [' . $stepName . '] 环节没有找到责任人，请与系统管理员联系！");history.back();</script>';
            exit();
        } else if ($numOfRows > 1) {
            echo '<script>alert("在 [' . $stepName . '] 环节存在多个责任人，请与系统管理员联系！");history.back();</script>';
            exit();
        }
    }

    function agent() {
        preg_match("/\((.+?)\)/", $yw_ntzrren, $arr);
        $sql1 = "SELECT agent FROM members WHERE username = '$arr[1]'";
        $rows1 = mysql_fetch_array(mysql_query($sql1));
        if ($rows1['agent'] != "") {
            $yw_ntzrren = $rows1['agent'];
        }
    }

    /* 写入提醒操作 */
    function remindInsert($remindModuleName, $remindPid, $remindTitle, $remindUrl, $remindReminder) {
        $remindSubTime = date("Y-m-d H:i:s");
        include($_SERVER["DOCUMENT_ROOT"] . "/co_connection.php");
        $remindSqlStr = "INSERT INTO ims_common_remind (remindModuleName,remindPid,remindTitle,remindUrl,remindReminder,remindSubTime) VALUES ('$remindModuleName','$remindPid','$remindTitle','$remindUrl','$remindReminder','$remindSubTime')";
        $remindResult = mysql_query($remindSqlStr);
    }

    function remindDelete($zhihuiData) {

        $Model = M('CommonZhihui');
        $Model->db('101', 'DB_COMMON');
        $map["zhihuiId"] = $zhihuiData["zhihuiId"];

        $list = $Model->where($map)->find();
        if ($list["zhihuiAdder"] == $_SESSION["NameUsername"]) {
            $data["zhihuiIsDelete"] = 1;
            $Model->where($map)->save($data);
        } else {
            echo '<script>alert("删除失败！只有添加人才有权限删除！");window.history.back();</script>';
        }
    }

    /* 提醒操作结束 */
}

?>