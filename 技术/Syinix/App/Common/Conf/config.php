<?php
$sysConfig = array(
    
    /* 数据库配置 */
    'DB_TYPE' => '', // 数据库类型
    'DB_HOST' => '',
    'DB_NAME' => '',
    'DB_USER' => '',
    'DB_PWD' => '',
    'DB_PORT' => '',
    'DB_PREFIX' => '',

	/* 系统配置信息 */
    'WEB_ROOT' => '',
    'webPath' => '',
    'DB_PARAMS'    => array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL),
    'SHOW_PAGE_TRACE' => false,
    'TOKEN_ON' => false, // 是否开启令牌验证
    'TOKEN_NAME' => '__hash__', // 令牌验证的表单隐藏字段名称
    'TOKEN_TYPE' => 'md5', //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET' => FALSE, //令牌验证出错后是否重置令牌 默认为true
    'MODULE_ALLOW_LIST' => array('Admin', 'Home'),
    'DEFAULT_MODULE' => 'Home',
    'DEFAULT_CONTROLLER' => 'Index', // 默认控制器名称
    'DEFAULT_ACTION' => 'index', // 默认操作名称
    //'PAGE_SIZE'=>15,
    'VAR_PAGE'=>'p',

    /* 自定义配置信息 */
    'STATIC_PATH' => '/Static/',
    'AUTH_CODE' => 'vZwXcj',
    'ADMIN_AUTH_KEY' => '652806154@qq.com',

    /* 提示信息 */
    'ALERT_MSG' => array(
        'EXECUTE_SUCCESS' => '操作成功',
        'EXECUTE_FAILED' => '操作失败，请重试',
        'SAVE_SUCCESS' => '保存成功',
        'SAVE_FAILED' => '保存失败或数据没有被修改',
        'DELETE_SUCCESS' => '删除成功',
        'DELETE_FAILED' => '删除失败',
        'RECORD_EXIST' => '已存在该记录',
        'RECORD_NOT_EXIST' => '不存在该记录',
        'REQUIRED' => ' 必填字段不能为空',
    ),

    'TAGLIB_BUILD_IN'           =>'Cx,Co',

    /* 数据缓存设置 */
    'DATA_CACHE_TIME'       =>  60,
    'DATA_CACHE_PREFIX'     =>  'syinix_',
    'DATA_CACHE_TYPE'       =>  'file',
    'DATA_CACHE_HOST'       =>  '10.127.122.151',
);
$config_site = APP_PATH . "Common/Conf/config_site.php";
$siteConfig = file_exists($config_site) ? include "$config_site" : array();
return array_merge($sysConfig, $siteConfig);
?>
