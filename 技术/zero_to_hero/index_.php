<?php
/**
 * 数据库操作
 */
class Database
{
	private $dbDriver = '';//数据库驱动类型
	private $db = null;//指定驱动的数据库对象
	
	/**
	 * 创建指定驱动的数据库对象
	 * $dbConfig	配置数据
	 */
	public function __construct($dbConfig)
	{
		$this->dbDriver = $dbConfig['dbDriver'];
		switch ($this->dbDriver)
		{
			case 'mysql':
				$this->db = new Mysql($dbConfig);
				break;
			case 'mysqli':
				break;
			case 'oracle':
				break;
			default:
		}
	}
	
	/**
	 * 连接数据库
	 */
	public function connect()
	{
		$this->db->connect();
	}
	
	/**
	 * 执行一个SQL语句
	 * $sql	SQL语句
	 */
	public function query($sql)
	{
		$this->db->query($sql);
	}
	
	/**
	 * 返回当前的一条记录并把游标移向下一记录
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getRow($acctype = MYSQL_ASSOC)
	{
		return $this->db->getRow($acctype);
	}
	
	/**
	 * 返回当前的所有记录并把游标移向表尾
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getAllRows($acctype = MYSQL_ASSOC)
	{
		return $this->db->getAllRows($acctype);
	}
	
	/**
	 * 获取查询的记录个数
	 */
	public function getNumRows()
	{
		return $this->db->getNumRows();
	}
	
	/**
	 * 获取指定表的所有字段名
	 * $tbName	表名
	 */
	public function getAllFields($tbName)
	{
		return $this->db->getAllFields($tbName);
	}
	
	/**
	 * 关闭数据库连接
	 */
	public function close()
	{
		$this->db->close();
	}
	
	/**
	 * 获取连接id
	 */
	public function getLinkId()
	{
		return $this->db->linkId;
	}
	
	/**
	 * 获取查询结果
	 */
	public function getResult()
	{
		return $this->db->result;
	}
	
	/**
	 * 获取新插入记录的id
	 */
	public function getInsertId()
	{
		return $this->db->getInsertId();
	}
	
	/**
	 * 获取当前数据库的所有表名
	 */
	public function getAllTables()
	{
		return $this->db->getAllTables();
	}
}

 /**
  * 内置MYSQL连接，只需要简单配置数据连接
 使用方法如下
 

$db = new Dbbak('localhost','root','','guestbook','utf8','data/dbbak/');

//查找数据库内所有数据表
$tableArry = $db->getTables();

//备份并生成sql文件
if(!$db->exportSql($tableArry))
{
	echo '备份失败';
}
else
{
	echo '备份成功';
}

//恢复导入sql文件夹
if($db->importSql())
{
	echo '恢复成功';
}
else
{
	echo '恢复失败';
}
 */
class Dbbak {
	public $dbhost;//数据库主机
	public $dbuser;//数据库用户名
	public $dbpw;//数据库密码
	public $dbname;//数据库名称
	public $dataDir;	//备份文件存放的路径
	protected   $transfer 	   ="";			//临时存放sql[切勿不要对该属性赋值，否则会生成错误的sql语句]
	
	public function __construct($dbhost,$dbuser,$dbpw,$dbname,$charset='utf8',$dir='data/dbbak/')
	{		
		$this->connect($dbhost,$dbuser,$dbpw,$dbname,$charset);//连接数据
		$this->dataDir=$dir;
	}

/**
 *数据库连接
 *@param string $host 数据库主机名
 *@param string $user 用户名
 *@param string $pwd  密码
 *@param string $db   选择数据库名
 *@param string $charset 编码方式
 */
	public function connect($dbhost,$dbuser,$dbpw,$dbname,$charset='utf8')
	{
		$this->dbhost = $dbhost;
		$this->dbuser = $dbuser;
		$this->dbpw = $dbpw;
		$this->dbname = $dbname;
		if(!$conn = @mysql_connect($dbhost,$dbuser,$dbpw))
		{
			$this->error('无法连接数据库服务器');
			return false;
		}
		@mysql_select_db($this->dbname) or $this->error('选择数据库失败');
		@mysql_query("set names $charset");
		return true;
	}

/**
 *列表数据库中的表
 *@param  database $database 要操作的数据库名
 *@return array    $dbArray  所列表的数据库表
 */
	public function getTables($database='')
	{
		$database=empty($database)?$this->dbname:$database;
		$result=@mysql_query("SHOW TABLES FROM `$database`") or die(@mysql_error());
	//	$result = @mysql_list_tables($database);//mysql_list_tables函数不建议使用
		while($tmpArry = @mysql_fetch_row($result)){
			 $dbArry[]  = $tmpArry[0];
		}
		return $dbArry;
	}

/**
 *生成sql文件，导出数据库
 *@param string $sql sql    语句
 *@param number $subsection 分卷大小，以KB为单位，为0表示不分卷
 */
     public function exportSql($table='',$subsection=0)
	 {
		$table=empty($table)?$this->getTables():$table;
     	if(!$this->_checkDir($this->dataDir))
		{
			$this->error('您没有权限操作目录,备份失败');
			return false;
		}
		
     	if($subsection == 0)
		{
     		if(!is_array($table))
			{
				$this->_setSql($table,0,$this->transfer);
			}
			else
			{
				for($i=0;$i<count($table);$i++)
				{
					$this->_setSql($table[$i],0,$this->transfer);
				}
			}
     		$fileName = $this->dataDir.date("Ymd",time()).'_all.sql.php';
     		if(!$this->_writeSql($fileName,$this->transfer))
			{
				return false;
			}
     	}
		else
		{
     		if(!is_array($table))
			{
				$sqlArry = $this->_setSql($table,$subsection,$this->transfer);
				$sqlArry[] = $this->transfer;
			}
			else
			{
				$sqlArry = array();
				for($i=0;$i<count($table);$i++){
					$tmpArry = $this->_setSql($table[$i],$subsection,$this->transfer);
					$sqlArry = array_merge($sqlArry,$tmpArry);
				}
				$sqlArry[] = $this->transfer;
			}
     		for($i=0;$i<count($sqlArry);$i++)
			{
     			$fileName = $this->dataDir.date("Ymd",time()).'_part'.$i.'.sql.php';
     			if(!$this->_writeSql($fileName,$sqlArry[$i]))
				{
					return false;
				}
     		}
     	}
     	return true;
    }
	
/*
 *载入sql文件，恢复数据库
 *@param diretory $dir
 *@return booln
 *注意:请不在目录下面存放其它文件和目录，以节省恢复时间
*/
    public function importSql($dir=''){
		
		if(is_file($dir))
		{
			return $this->_importSqlFile($dir);
		}
		$dir=empty($dir)?$this->dataDir:$dir;
		if($link = opendir($dir))
		{
			$fileArry = scandir($dir);
			$pattern = "/_part[0-9]+.sql.php$|_all.sql.php$/";
			$num=count($fileArry);
			for($i=0;$i<$num;$i++)
			{
				if(preg_match($pattern,$fileArry[$i]))
				{
					if(false==$this->_importSqlFile($dir.$fileArry[$i]))
					{
						return false;
					}
				}
			}
			return true;
		}
    }
	
//执行sql文件，恢复数据库
    protected function _importSqlFile($filename='')
	{
		$sqls=file_get_contents($filename);
		$sqls=substr($sqls,13);
		$sqls=explode("\n",$sqls);
		if(empty($sqls))
			return false;
			
		foreach($sqls as $sql)
		{
			if(empty($sql))
				continue;
			if(!@mysql_query(trim($sql))) 
			{
				$this->error('恢复失败：'.@mysql_error());
				return false;
			}
		}
		return true;
    }
	
/**
 * 生成sql语句
 * @param   $table     要备份的表
 * @return  $tabledump 生成的sql语句
 */
	protected function _setSql($table,$subsection=0,&$tableDom=''){
		$tableDom .= "DROP TABLE IF EXISTS $table\n";
		$createtable = @mysql_query("SHOW CREATE TABLE $table");
		$create = @mysql_fetch_row($createtable);
		$create[1] = str_replace("\n","",$create[1]);
		$create[1] = str_replace("\t","",$create[1]);

		$tableDom  .= $create[1].";\n";

		$rows = @mysql_query("SELECT * FROM $table");
		$numfields = @mysql_num_fields($rows);
		$numrows = @mysql_num_rows($rows);
		$n = 1;
		$sqlArry = array();
		while ($row = @mysql_fetch_row($rows))
		{
		   $comma = "";
		   $tableDom  .= "INSERT INTO $table VALUES(";
		   for($i = 0; $i < $numfields; $i++)
		   {
				$tableDom  .= $comma."'".@mysql_real_escape_string($row[$i])."'";
				$comma = ",";
		   }
		  $tableDom  .= ")\n";
		   if($subsection != 0 && strlen($this->transfer )>=$subsection*1000){
		   		$sqlArry[$n]= $tableDom;
		   		$tableDom = ''; $n++;
		   }
		}
		return $sqlArry;
   }
   
/**
 *验证目录是否有效，同时删除该目录下的所有文件
 *@param diretory $dir
 *@return booln
 */
	protected function _checkDir($dir){
		if(!is_dir($dir)) {@mkdir($dir, 0777);}
		if(is_dir($dir)){
			if($link = opendir($dir)){
				$fileArry = scandir($dir);
				for($i=0;$i<count($fileArry);$i++){
					if($fileArry[$i]!='.' || $fileArry != '..'){
						@unlink($dir.$fileArry[$i]);
					}
				}
			}
		}
		return true;
	}
	
/**
 *将数据写入到文件中
 *@param file $fileName 文件名
 *@param string $str   要写入的信息
 *@return booln 写入成功则返回true,否则false
 */
	protected function _writeSql($fileName,$str){
		$re= true;
		if(!$fp=@fopen($fileName,"w+"))
		{
			$re=false; $this->error("在打开文件时遇到错误，备份失败!");
		}
		if(!@fwrite($fp,'<?php exit;?>'.$str)) 
		{
			$re=false; $this->error("在写入信息时遇到错误，备份失败!");
		}
		if(!@fclose($fp)) 
		{
			$re=false; $this->error("在关闭文件 时遇到错误，备份失败!");
		}
		return $re;
	}
	public function error($str)
	{
		cpError::show($str);
	}

}


/**
 * Mysql数据库操作
 */
class Mysql
{
	public $linkId = 0;//连接id
	public $result = 0;//查询结果
	
	//数据库配置信息	
	private $hostname = '';//数据库主机
	private $username = '';//用户名
	private $password = '';//密码
	private $dbName = '';//数据库名
	private $dbCharset = '';//数据库字符集
	private $dbCollat = '';//排序规则
	private $dbPconnect = false;//是否长连接
	private $isConnected = false;//是否已连接
	
	/**
	 * 存储配置信息并连接数据库
	 * $dbConfig	配置信息
	 */
	public function __construct($dbConfig)
	{
		$this->hostname = $dbConfig['hostname'];
		$this->username = $dbConfig['username'];
		$this->password = $dbConfig['password'];
		$this->dbName = $dbConfig['dbName'];
		$this->dbCharset = $dbConfig['dbCharset'];
		$this->dbCollat = $dbConfig['dbCollat'];
		$this->dbPconnect = $dbConfig['dbPconnect'];
	}
	
	/**
	 * 连接数据库
	 */
	public function connect()
	{
		if ( ! $this->isConnected)
		{
			if ($this->dbPconnect)
			{
				$this->linkId = @mysql_pconnect($this->hostname, $this->username, $this->password);
			}
			else
			{
				$this->linkId = @mysql_connect($this->hostname, $this->username, $this->password);
			}
			
			//成功连接则选择数据库，否则处理错误
			if ($this->linkId)
			{
				@mysql_select_db($this->dbName);
				@mysql_query("SET NAMES '{$this->dbCharset}', character_set_client=binary, sql_mode='', interactive_timeout=3600;", $this->linkId);
				//标记已连接
				$this->isConnected = true;
			}
			else
			{
				exit('Database error!');
			}
		}
	}
	
	/**
	 * 执行一个SQL语句
	 * $sql	SQL语句
	 */
	public function query($sql)
	{
		if ($this->isConnected)
		{
			$this->result = @mysql_query($sql, $this->linkId);
			if ( ! $this->result)
			{
				exit('Database error!');
			}
		}
		else
		{
			exit('Database not connected!');
		}
	}
	
	/**
	 * 返回当前的一条记录并把游标移向下一记录
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getRow($acctype = MYSQL_ASSOC)
	{
		if ($this->result)
		{
			return @mysql_fetch_array($this->result, $acctype);
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * 获取当前查询的所有记录
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getAllRows($acctype = MYSQL_ASSOC)
	{
		if ($this->result)
		{
			$res = array();
			while ($row = @mysql_fetch_array($this->result, $acctype))
			{
				$res[] = $row;
			}
			
			return $res;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * 获取查询的记录个数
	 */
	public function getNumRows()
	{
		if ($this->result)
		{
			return @mysql_num_rows($this->result);
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 获取指定表的所有字段名
	 * $tbName	表名
	 */
	public function getAllFields($tbName)
	{
		if ($this->isConnected)
		{
			$res = array();
			$fields = @mysql_list_fields($this->dbName, $tbName, $this->linkId);
			if ( ! $fields)
			{
				exit('Database error!');
			}
			$columns = @mysql_num_fields($fields);
			for ($i = 0; $i < $columns; $i++)
			{
				$res[$i] = @mysql_field_name($fields, $i);
			}
			
			return $res;
		}
		else
		{
			exit('Database not connected!');
		}
	}
	
	/**
	 * 关闭数据库连接
	 */
	public function close()
	{
		if ($this->linkId)
		{
			@mysql_close($this->linkId);
		}
		$this->result = 0;
		$this->linkId = 0;
		$this->isConnected = false;
	}
	
	/**
	 * 获取新插入记录的id
	 */
	public function getInsertId()
	{
		if ($this->linkId)
		{
			return @mysql_insert_id($this->linkId);
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 获取当前数据库的所有表名
	 */
	public function getAllTables()
	{
		if ($this->isConnected)
		{
			$res = array();
			$this->query("SHOW TABLES");
			$rows = $this->getAllRows(MYSQL_NUM);
			foreach ($rows as $value)
			{
				$res[] = $value[0];
			}
			
			return $res;
		}
		else
		{
			exit('Database not connected!');
		}
	}
}

/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

if (!function_exists('curl_init')) {
  throw new Exception('Facebook needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('Facebook needs the JSON PHP extension.');
}

/**
 * Thrown when an API call returns an exception.
 *
 * @author Naitik Shah <naitik@facebook.com>
 */
class FacebookApiException extends Exception
{
  /**
   * The result from the API server that represents the exception information.
   *
   * @var mixed
   */
  protected $result;

  /**
   * Make a new API Exception with the given result.
   *
   * @param array $result The result from the API server
   */
  public function __construct($result) {
    $this->result = $result;

    $code = 0;
    if (isset($result['error_code']) && is_int($result['error_code'])) {
      $code = $result['error_code'];
    }

    if (isset($result['error_description'])) {
      // OAuth 2.0 Draft 10 style
      $msg = $result['error_description'];
    } else if (isset($result['error']) && is_array($result['error'])) {
      // OAuth 2.0 Draft 00 style
      $msg = $result['error']['message'];
    } else if (isset($result['error_msg'])) {
      // Rest server style
      $msg = $result['error_msg'];
    } else {
      $msg = 'Unknown Error. Check getResult()';
    }

    parent::__construct($msg, $code);
  }

  /**
   * Return the associated result object returned by the API server.
   *
   * @return array The result from the API server
   */
  public function getResult() {
    return $this->result;
  }

  /**
   * Returns the associated type for the error. This will default to
   * 'Exception' when a type is not available.
   *
   * @return string
   */
  public function getType() {
    if (isset($this->result['error'])) {
      $error = $this->result['error'];
      if (is_string($error)) {
        // OAuth 2.0 Draft 10 style
        return $error;
      } else if (is_array($error)) {
        // OAuth 2.0 Draft 00 style
        if (isset($error['type'])) {
          return $error['type'];
        }
      }
    }

    return 'Exception';
  }

  /**
   * To make debugging easier.
   *
   * @return string The string representation of the error
   */
  public function __toString() {
    $str = $this->getType() . ': ';
    if ($this->code != 0) {
      $str .= $this->code . ': ';
    }
    return $str . $this->message;
  }
}

/**
 * Provides access to the Facebook Platform.  This class provides
 * a majority of the functionality needed, but the class is abstract
 * because it is designed to be sub-classed.  The subclass must
 * implement the four abstract methods listed at the bottom of
 * the file.
 *
 * @author Naitik Shah <naitik@facebook.com>
 */
abstract class BaseFacebook
{
  /**
   * Version.
   */
  const VERSION = '3.2.3';

  /**
   * Signed Request Algorithm.
   */
  const SIGNED_REQUEST_ALGORITHM = 'HMAC-SHA256';

  /**
   * Default options for curl.
   *
   * @var array
   */
  public static $CURL_OPTS = array(
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 60,
    CURLOPT_USERAGENT      => 'facebook-php-3.2',
  );

  /**
   * List of query parameters that get automatically dropped when rebuilding
   * the current URL.
   *
   * @var array
   */
  protected static $DROP_QUERY_PARAMS = array(
    'code',
    'state',
    'signed_request',
  );

  /**
   * Maps aliases to Facebook domains.
   *
   * @var array
   */
  public static $DOMAIN_MAP = array(
    'api'         => 'https://api.facebook.com/',
    'api_video'   => 'https://api-video.facebook.com/',
    'api_read'    => 'https://api-read.facebook.com/',
    'graph'       => 'https://graph.facebook.com/',
    'graph_video' => 'https://graph-video.facebook.com/',
    'www'         => 'https://www.facebook.com/',
  );

  /**
   * The Application ID.
   *
   * @var string
   */
  protected $appId;

  /**
   * The Application App Secret.
   *
   * @var string
   */
  protected $appSecret;

  /**
   * The ID of the Facebook user, or 0 if the user is logged out.
   *
   * @var integer
   */
  protected $user;

  /**
   * The data from the signed_request token.
   *
   * @var string
   */
  protected $signedRequest;

  /**
   * A CSRF state variable to assist in the defense against CSRF attacks.
   *
   * @var string
   */
  protected $state;

  /**
   * The OAuth access token received in exchange for a valid authorization
   * code.  null means the access token has yet to be determined.
   *
   * @var string
   */
  protected $accessToken = null;

  /**
   * Indicates if the CURL based @ syntax for file uploads is enabled.
   *
   * @var boolean
   */
  protected $fileUploadSupport = false;

  /**
   * Indicates if we trust HTTP_X_FORWARDED_* headers.
   *
   * @var boolean
   */
  protected $trustForwarded = false;

  /**
   * Indicates if signed_request is allowed in query parameters.
   *
   * @var boolean
   */
  protected $allowSignedRequest = true;

  /**
   * Initialize a Facebook Application.
   *
   * The configuration:
   * - appId: the application ID
   * - secret: the application secret
   * - fileUpload: (optional) boolean indicating if file uploads are enabled
   * - allowSignedRequest: (optional) boolean indicating if signed_request is
   *                       allowed in query parameters or POST body.  Should be
   *                       false for non-canvas apps.  Defaults to true.
   *
   * @param array $config The application configuration
   */
  public function __construct($config) {
    $this->setAppId($config['appId']);
    $this->setAppSecret($config['secret']);
    if (isset($config['fileUpload'])) {
      $this->setFileUploadSupport($config['fileUpload']);
    }
    if (isset($config['trustForwarded']) && $config['trustForwarded']) {
      $this->trustForwarded = true;
    }
    if (isset($config['allowSignedRequest'])
        && !$config['allowSignedRequest']) {
        $this->allowSignedRequest = false;
    }
    $state = $this->getPersistentData('state');
    if (!empty($state)) {
      $this->state = $state;
    }
  }

  /**
   * Set the Application ID.
   *
   * @param string $appId The Application ID
   *
   * @return BaseFacebook
   */
  public function setAppId($appId) {
    $this->appId = $appId;
    return $this;
  }

  /**
   * Get the Application ID.
   *
   * @return string the Application ID
   */
  public function getAppId() {
    return $this->appId;
  }

  /**
   * Set the App Secret.
   *
   * @param string $apiSecret The App Secret
   *
   * @return BaseFacebook
   * @deprecated Use setAppSecret instead.
   * @see setAppSecret()
   */
  public function setApiSecret($apiSecret) {
    $this->setAppSecret($apiSecret);
    return $this;
  }

  /**
   * Set the App Secret.
   *
   * @param string $appSecret The App Secret
   *
   * @return BaseFacebook
   */
  public function setAppSecret($appSecret) {
    $this->appSecret = $appSecret;
    return $this;
  }

  /**
   * Get the App Secret.
   *
   * @return string the App Secret
   *
   * @deprecated Use getAppSecret instead.
   * @see getAppSecret()
   */
  public function getApiSecret() {
    return $this->getAppSecret();
  }

  /**
   * Get the App Secret.
   *
   * @return string the App Secret
   */
  public function getAppSecret() {
    return $this->appSecret;
  }

  /**
   * Set the file upload support status.
   *
   * @param boolean $fileUploadSupport The file upload support status.
   *
   * @return BaseFacebook
   */
  public function setFileUploadSupport($fileUploadSupport) {
    $this->fileUploadSupport = $fileUploadSupport;
    return $this;
  }

  /**
   * Get the file upload support status.
   *
   * @return boolean true if and only if the server supports file upload.
   */
  public function getFileUploadSupport() {
    return $this->fileUploadSupport;
  }

  /**
   * Get the file upload support status.
   *
   * @return boolean true if and only if the server supports file upload.
   *
   * @deprecated Use getFileUploadSupport instead.
   * @see getFileUploadSupport()
   */
  public function useFileUploadSupport() {
    return $this->getFileUploadSupport();
  }

  /**
   * Sets the access token for api calls.  Use this if you get
   * your access token by other means and just want the SDK
   * to use it.
   *
   * @param string $access_token an access token.
   *
   * @return BaseFacebook
   */
  public function setAccessToken($access_token) {
    $this->accessToken = $access_token;
    return $this;
  }

  /**
   * Extend an access token, while removing the short-lived token that might
   * have been generated via client-side flow. Thanks to http://bit.ly/b0Pt0H
   * for the workaround.
   */
  public function setExtendedAccessToken() {
    try {
      // need to circumvent json_decode by calling _oauthRequest
      // directly, since response isn't JSON format.
      $access_token_response = $this->_oauthRequest(
        $this->getUrl('graph', '/oauth/access_token'),
        $params = array(
          'client_id' => $this->getAppId(),
          'client_secret' => $this->getAppSecret(),
          'grant_type' => 'fb_exchange_token',
          'fb_exchange_token' => $this->getAccessToken(),
        )
      );
    }
    catch (FacebookApiException $e) {
      // most likely that user very recently revoked authorization.
      // In any event, we don't have an access token, so say so.
      return false;
    }

    if (empty($access_token_response)) {
      return false;
    }

    $response_params = array();
    parse_str($access_token_response, $response_params);

    if (!isset($response_params['access_token'])) {
      return false;
    }

    $this->destroySession();

    $this->setPersistentData(
      'access_token', $response_params['access_token']
    );
  }

  /**
   * Determines the access token that should be used for API calls.
   * The first time this is called, $this->accessToken is set equal
   * to either a valid user access token, or it's set to the application
   * access token if a valid user access token wasn't available.  Subsequent
   * calls return whatever the first call returned.
   *
   * @return string The access token
   */
  public function getAccessToken() {
    if ($this->accessToken !== null) {
      // we've done this already and cached it.  Just return.
      return $this->accessToken;
    }

    // first establish access token to be the application
    // access token, in case we navigate to the /oauth/access_token
    // endpoint, where SOME access token is required.
    $this->setAccessToken($this->getApplicationAccessToken());
    $user_access_token = $this->getUserAccessToken();
    if ($user_access_token) {
      $this->setAccessToken($user_access_token);
    }

    return $this->accessToken;
  }

  /**
   * Determines and returns the user access token, first using
   * the signed request if present, and then falling back on
   * the authorization code if present.  The intent is to
   * return a valid user access token, or false if one is determined
   * to not be available.
   *
   * @return string A valid user access token, or false if one
   *                could not be determined.
   */
  protected function getUserAccessToken() {
    // first, consider a signed request if it's supplied.
    // if there is a signed request, then it alone determines
    // the access token.
    $signed_request = $this->getSignedRequest();
    if ($signed_request) {
      // apps.facebook.com hands the access_token in the signed_request
      if (array_key_exists('oauth_token', $signed_request)) {
        $access_token = $signed_request['oauth_token'];
        $this->setPersistentData('access_token', $access_token);
        return $access_token;
      }

      // the JS SDK puts a code in with the redirect_uri of ''
      if (array_key_exists('code', $signed_request)) {
        $code = $signed_request['code'];
        if ($code && $code == $this->getPersistentData('code')) {
          // short-circuit if the code we have is the same as the one presented
          return $this->getPersistentData('access_token');
        }

        $access_token = $this->getAccessTokenFromCode($code, '');
        if ($access_token) {
          $this->setPersistentData('code', $code);
          $this->setPersistentData('access_token', $access_token);
          return $access_token;
        }
      }

      // signed request states there's no access token, so anything
      // stored should be cleared.
      $this->clearAllPersistentData();
      return false; // respect the signed request's data, even
                    // if there's an authorization code or something else
    }

    $code = $this->getCode();
    if ($code && $code != $this->getPersistentData('code')) {
      $access_token = $this->getAccessTokenFromCode($code);
      if ($access_token) {
        $this->setPersistentData('code', $code);
        $this->setPersistentData('access_token', $access_token);
        return $access_token;
      }

      // code was bogus, so everything based on it should be invalidated.
      $this->clearAllPersistentData();
      return false;
    }

    // as a fallback, just return whatever is in the persistent
    // store, knowing nothing explicit (signed request, authorization
    // code, etc.) was present to shadow it (or we saw a code in $_REQUEST,
    // but it's the same as what's in the persistent store)
    return $this->getPersistentData('access_token');
  }

  /**
   * Retrieve the signed request, either from a request parameter or,
   * if not present, from a cookie.
   *
   * @return string the signed request, if available, or null otherwise.
   */
  public function getSignedRequest() {
    if (!$this->signedRequest) {
      if ($this->allowSignedRequest && !empty($_REQUEST['signed_request'])) {
        $this->signedRequest = $this->parseSignedRequest(
          $_REQUEST['signed_request']
        );
      } else if (!empty($_COOKIE[$this->getSignedRequestCookieName()])) {
        $this->signedRequest = $this->parseSignedRequest(
          $_COOKIE[$this->getSignedRequestCookieName()]);
      }
    }
    return $this->signedRequest;
  }

  /**
   * Get the UID of the connected user, or 0
   * if the Facebook user is not connected.
   *
   * @return string the UID if available.
   */
  public function getUser() {
    if ($this->user !== null) {
      // we've already determined this and cached the value.
      return $this->user;
    }

    return $this->user = $this->getUserFromAvailableData();
  }

  /**
   * Determines the connected user by first examining any signed
   * requests, then considering an authorization code, and then
   * falling back to any persistent store storing the user.
   *
   * @return integer The id of the connected Facebook user,
   *                 or 0 if no such user exists.
   */
  protected function getUserFromAvailableData() {
    // if a signed request is supplied, then it solely determines
    // who the user is.
    $signed_request = $this->getSignedRequest();
    if ($signed_request) {
      if (array_key_exists('user_id', $signed_request)) {
        $user = $signed_request['user_id'];

        if($user != $this->getPersistentData('user_id')){
          $this->clearAllPersistentData();
        }

        $this->setPersistentData('user_id', $signed_request['user_id']);
        return $user;
      }

      // if the signed request didn't present a user id, then invalidate
      // all entries in any persistent store.
      $this->clearAllPersistentData();
      return 0;
    }

    $user = $this->getPersistentData('user_id', $default = 0);
    $persisted_access_token = $this->getPersistentData('access_token');

    // use access_token to fetch user id if we have a user access_token, or if
    // the cached access token has changed.
    $access_token = $this->getAccessToken();
    if ($access_token &&
        $access_token != $this->getApplicationAccessToken() &&
        !($user && $persisted_access_token == $access_token)) {
      $user = $this->getUserFromAccessToken();
      if ($user) {
        $this->setPersistentData('user_id', $user);
      } else {
        $this->clearAllPersistentData();
      }
    }

    return $user;
  }

  /**
   * Get a Login URL for use with redirects. By default, full page redirect is
   * assumed. If you are using the generated URL with a window.open() call in
   * JavaScript, you can pass in display=popup as part of the $params.
   *
   * The parameters:
   * - redirect_uri: the url to go to after a successful login
   * - scope: comma separated list of requested extended perms
   *
   * @param array $params Provide custom parameters
   * @return string The URL for the login flow
   */
  public function getLoginUrl($params=array()) {
    $this->establishCSRFTokenState();
    $currentUrl = $this->getCurrentUrl();

    // if 'scope' is passed as an array, convert to comma separated list
    $scopeParams = isset($params['scope']) ? $params['scope'] : null;
    if ($scopeParams && is_array($scopeParams)) {
      $params['scope'] = implode(',', $scopeParams);
    }

    return $this->getUrl(
      'www',
      'dialog/oauth',
      array_merge(
        array(
          'client_id' => $this->getAppId(),
          'redirect_uri' => $currentUrl, // possibly overwritten
          'state' => $this->state,
          'sdk' => 'php-sdk-'.self::VERSION
        ),
        $params
      ));
  }

  /**
   * Get a Logout URL suitable for use with redirects.
   *
   * The parameters:
   * - next: the url to go to after a successful logout
   *
   * @param array $params Provide custom parameters
   * @return string The URL for the logout flow
   */
  public function getLogoutUrl($params=array()) {
    return $this->getUrl(
      'www',
      'logout.php',
      array_merge(array(
        'next' => $this->getCurrentUrl(),
        'access_token' => $this->getUserAccessToken(),
      ), $params)
    );
  }

  /**
   * Get a login status URL to fetch the status from Facebook.
   *
   * @param array $params Provide custom parameters
   * @return string The URL for the logout flow
   */
  public function getLoginStatusUrl($params=array()) {
    return $this->getLoginUrl(
      array_merge(array(
        'response_type' => 'code',
        'display' => 'none',
      ), $params)
    );
  }

  /**
   * Make an API call.
   *
   * @return mixed The decoded response
   */
  public function api(/* polymorphic */) {
    $args = func_get_args();
    if (is_array($args[0])) {
      return $this->_restserver($args[0]);
    } else {
      return call_user_func_array(array($this, '_graph'), $args);
    }
  }

  /**
   * Constructs and returns the name of the cookie that
   * potentially houses the signed request for the app user.
   * The cookie is not set by the BaseFacebook class, but
   * it may be set by the JavaScript SDK.
   *
   * @return string the name of the cookie that would house
   *         the signed request value.
   */
  protected function getSignedRequestCookieName() {
    return 'fbsr_'.$this->getAppId();
  }

  /**
   * Constructs and returns the name of the cookie that potentially contain
   * metadata. The cookie is not set by the BaseFacebook class, but it may be
   * set by the JavaScript SDK.
   *
   * @return string the name of the cookie that would house metadata.
   */
  protected function getMetadataCookieName() {
    return 'fbm_'.$this->getAppId();
  }

  /**
   * Get the authorization code from the query parameters, if it exists,
   * and otherwise return false to signal no authorization code was
   * discoverable.
   *
   * @return mixed The authorization code, or false if the authorization
   *               code could not be determined.
   */
  protected function getCode() {
    if (!isset($_REQUEST['code']) || !isset($_REQUEST['state'])) {
      return false;
    }
    if ($this->state === $_REQUEST['state']) {
        // CSRF state has done its job, so clear it
        $this->state = null;
        $this->clearPersistentData('state');
        return $_REQUEST['code'];
    }
    self::errorLog('CSRF state token does not match one provided.');

    return false;
  }

  /**
   * Retrieves the UID with the understanding that
   * $this->accessToken has already been set and is
   * seemingly legitimate.  It relies on Facebook's Graph API
   * to retrieve user information and then extract
   * the user ID.
   *
   * @return integer Returns the UID of the Facebook user, or 0
   *                 if the Facebook user could not be determined.
   */
  protected function getUserFromAccessToken() {
    try {
      $user_info = $this->api('/me');
      return $user_info['id'];
    } catch (FacebookApiException $e) {
      return 0;
    }
  }

  /**
   * Returns the access token that should be used for logged out
   * users when no authorization code is available.
   *
   * @return string The application access token, useful for gathering
   *                public information about users and applications.
   */
  public function getApplicationAccessToken() {
    return $this->appId.'|'.$this->appSecret;
  }

  /**
   * Lays down a CSRF state token for this process.
   *
   * @return void
   */
  protected function establishCSRFTokenState() {
    if ($this->state === null) {
      $this->state = md5(uniqid(mt_rand(), true));
      $this->setPersistentData('state', $this->state);
    }
  }

  /**
   * Retrieves an access token for the given authorization code
   * (previously generated from www.facebook.com on behalf of
   * a specific user).  The authorization code is sent to graph.facebook.com
   * and a legitimate access token is generated provided the access token
   * and the user for which it was generated all match, and the user is
   * either logged in to Facebook or has granted an offline access permission.
   *
   * @param string $code An authorization code.
   * @param string $redirect_uri Optional redirect URI. Default null
   *
   * @return mixed An access token exchanged for the authorization code, or
   *               false if an access token could not be generated.
   */
  protected function getAccessTokenFromCode($code, $redirect_uri = null) {
    if (empty($code)) {
      return false;
    }

    if ($redirect_uri === null) {
      $redirect_uri = $this->getCurrentUrl();
    }

    try {
      // need to circumvent json_decode by calling _oauthRequest
      // directly, since response isn't JSON format.
      $access_token_response =
        $this->_oauthRequest(
          $this->getUrl('graph', '/oauth/access_token'),
          $params = array('client_id' => $this->getAppId(),
                          'client_secret' => $this->getAppSecret(),
                          'redirect_uri' => $redirect_uri,
                          'code' => $code));
    } catch (FacebookApiException $e) {
      // most likely that user very recently revoked authorization.
      // In any event, we don't have an access token, so say so.
      return false;
    }

    if (empty($access_token_response)) {
      return false;
    }

    $response_params = array();
    parse_str($access_token_response, $response_params);
    if (!isset($response_params['access_token'])) {
      return false;
    }

    return $response_params['access_token'];
  }

  /**
   * Invoke the old restserver.php endpoint.
   *
   * @param array $params Method call object
   *
   * @return mixed The decoded response object
   * @throws FacebookApiException
   */
  protected function _restserver($params) {
    // generic application level parameters
    $params['api_key'] = $this->getAppId();
    $params['format'] = 'json-strings';

    $result = json_decode($this->_oauthRequest(
      $this->getApiUrl($params['method']),
      $params
    ), true);

    // results are returned, errors are thrown
    if (is_array($result) && isset($result['error_code'])) {
      $this->throwAPIException($result);
      // @codeCoverageIgnoreStart
    }
    // @codeCoverageIgnoreEnd

    $method = strtolower($params['method']);
    if ($method === 'auth.expiresession' ||
        $method === 'auth.revokeauthorization') {
      $this->destroySession();
    }

    return $result;
  }

  /**
   * Return true if this is video post.
   *
   * @param string $path The path
   * @param string $method The http method (default 'GET')
   *
   * @return boolean true if this is video post
   */
  protected function isVideoPost($path, $method = 'GET') {
    if ($method == 'POST' && preg_match("/^(\/)(.+)(\/)(videos)$/", $path)) {
      return true;
    }
    return false;
  }

  /**
   * Invoke the Graph API.
   *
   * @param string $path The path (required)
   * @param string $method The http method (default 'GET')
   * @param array $params The query/post data
   *
   * @return mixed The decoded response object
   * @throws FacebookApiException
   */
  protected function _graph($path, $method = 'GET', $params = array()) {
    if (is_array($method) && empty($params)) {
      $params = $method;
      $method = 'GET';
    }
    $params['method'] = $method; // method override as we always do a POST

    if ($this->isVideoPost($path, $method)) {
      $domainKey = 'graph_video';
    } else {
      $domainKey = 'graph';
    }

    $result = json_decode($this->_oauthRequest(
      $this->getUrl($domainKey, $path),
      $params
    ), true);

    // results are returned, errors are thrown
    if (is_array($result) && isset($result['error'])) {
      $this->throwAPIException($result);
      // @codeCoverageIgnoreStart
    }
    // @codeCoverageIgnoreEnd

    return $result;
  }

  /**
   * Make a OAuth Request.
   *
   * @param string $url The path (required)
   * @param array $params The query/post data
   *
   * @return string The decoded response object
   * @throws FacebookApiException
   */
  protected function _oauthRequest($url, $params) {
    if (!isset($params['access_token'])) {
      $params['access_token'] = $this->getAccessToken();
    }

    if (isset($params['access_token'])) {
      $params['appsecret_proof'] = $this->getAppSecretProof($params['access_token']);
    }

    // json_encode all params values that are not strings
    foreach ($params as $key => $value) {
      if (!is_string($value) && !($value instanceof CURLFile)) {
        $params[$key] = json_encode($value);
      }
    }

    return $this->makeRequest($url, $params);
  }

  /**
   * Generate a proof of App Secret
   * This is required for all API calls originating from a server
   * It is a sha256 hash of the access_token made using the app secret
   *
   * @param string $access_token The access_token to be hashed (required)
   *
   * @return string The sha256 hash of the access_token
   */
  protected function getAppSecretProof($access_token) {
    return hash_hmac('sha256', $access_token, $this->getAppSecret());
  }

  /**
   * Makes an HTTP request. This method can be overridden by subclasses if
   * developers want to do fancier things or use something other than curl to
   * make the request.
   *
   * @param string $url The URL to make the request to
   * @param array $params The parameters to use for the POST body
   * @param CurlHandler $ch Initialized curl handle
   *
   * @return string The response text
   */
  protected function makeRequest($url, $params, $ch=null) {
    if (!$ch) {
      $ch = curl_init();
    }

    $opts = self::$CURL_OPTS;
    if ($this->getFileUploadSupport()) {
      $opts[CURLOPT_POSTFIELDS] = $params;
    } else {
      $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
    }
    $opts[CURLOPT_URL] = $url;

    // disable the 'Expect: 100-continue' behaviour. This causes CURL to wait
    // for 2 seconds if the server does not support this header.
    if (isset($opts[CURLOPT_HTTPHEADER])) {
      $existing_headers = $opts[CURLOPT_HTTPHEADER];
      $existing_headers[] = 'Expect:';
      $opts[CURLOPT_HTTPHEADER] = $existing_headers;
    } else {
      $opts[CURLOPT_HTTPHEADER] = array('Expect:');
    }

    curl_setopt_array($ch, $opts);
    $result = curl_exec($ch);

    $errno = curl_errno($ch);
    // CURLE_SSL_CACERT || CURLE_SSL_CACERT_BADFILE
    if ($errno == 60 || $errno == 77) {
      self::errorLog('Invalid or no certificate authority found, '.
                     'using bundled information');
      curl_setopt($ch, CURLOPT_CAINFO,
                  dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fb_ca_chain_bundle.crt');
      $result = curl_exec($ch);
    }

    // With dual stacked DNS responses, it's possible for a server to
    // have IPv6 enabled but not have IPv6 connectivity.  If this is
    // the case, curl will try IPv4 first and if that fails, then it will
    // fall back to IPv6 and the error EHOSTUNREACH is returned by the
    // operating system.
    if ($result === false && empty($opts[CURLOPT_IPRESOLVE])) {
        $matches = array();
        $regex = '/Failed to connect to ([^:].*): Network is unreachable/';
        if (preg_match($regex, curl_error($ch), $matches)) {
          if (strlen(@inet_pton($matches[1])) === 16) {
            self::errorLog('Invalid IPv6 configuration on server, '.
                           'Please disable or get native IPv6 on your server.');
            self::$CURL_OPTS[CURLOPT_IPRESOLVE] = CURL_IPRESOLVE_V4;
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            $result = curl_exec($ch);
          }
        }
    }

    if ($result === false) {
      $e = new FacebookApiException(array(
        'error_code' => curl_errno($ch),
        'error' => array(
        'message' => curl_error($ch),
        'type' => 'CurlException',
        ),
      ));
      curl_close($ch);
      throw $e;
    }
    curl_close($ch);
    return $result;
  }

  /**
   * Parses a signed_request and validates the signature.
   *
   * @param string $signed_request A signed token
   *
   * @return array The payload inside it or null if the sig is wrong
   */
  protected function parseSignedRequest($signed_request) {
    list($encoded_sig, $payload) = explode('.', $signed_request, 2);

    // decode the data
    $sig = self::base64UrlDecode($encoded_sig);
    $data = json_decode(self::base64UrlDecode($payload), true);

    if (strtoupper($data['algorithm']) !== self::SIGNED_REQUEST_ALGORITHM) {
      self::errorLog(
        'Unknown algorithm. Expected ' . self::SIGNED_REQUEST_ALGORITHM);
      return null;
    }

    // check sig
    $expected_sig = hash_hmac('sha256', $payload,
                              $this->getAppSecret(), $raw = true);

    if (strlen($expected_sig) !== strlen($sig)) {
      self::errorLog('Bad Signed JSON signature!');
      return null;
    }

    $result = 0;
    for ($i = 0; $i < strlen($expected_sig); $i++) {
      $result |= ord($expected_sig[$i]) ^ ord($sig[$i]);
    }

    if ($result == 0) {
      return $data;
    } else {
      self::errorLog('Bad Signed JSON signature!');
      return null;
    }
  }

  /**
   * Makes a signed_request blob using the given data.
   *
   * @param array $data The data array.
   *
   * @return string The signed request.
   */
  protected function makeSignedRequest($data) {
    if (!is_array($data)) {
      throw new InvalidArgumentException(
        'makeSignedRequest expects an array. Got: ' . print_r($data, true));
    }
    $data['algorithm'] = self::SIGNED_REQUEST_ALGORITHM;
    $data['issued_at'] = time();
    $json = json_encode($data);
    $b64 = self::base64UrlEncode($json);
    $raw_sig = hash_hmac('sha256', $b64, $this->getAppSecret(), $raw = true);
    $sig = self::base64UrlEncode($raw_sig);
    return $sig.'.'.$b64;
  }

  /**
   * Build the URL for api given parameters.
   *
   * @param string $method The method name.
   *
   * @return string The URL for the given parameters
   */
  protected function getApiUrl($method) {
    static $READ_ONLY_CALLS =
      array('admin.getallocation' => 1,
            'admin.getappproperties' => 1,
            'admin.getbannedusers' => 1,
            'admin.getlivestreamvialink' => 1,
            'admin.getmetrics' => 1,
            'admin.getrestrictioninfo' => 1,
            'application.getpublicinfo' => 1,
            'auth.getapppublickey' => 1,
            'auth.getsession' => 1,
            'auth.getsignedpublicsessiondata' => 1,
            'comments.get' => 1,
            'connect.getunconnectedfriendscount' => 1,
            'dashboard.getactivity' => 1,
            'dashboard.getcount' => 1,
            'dashboard.getglobalnews' => 1,
            'dashboard.getnews' => 1,
            'dashboard.multigetcount' => 1,
            'dashboard.multigetnews' => 1,
            'data.getcookies' => 1,
            'events.get' => 1,
            'events.getmembers' => 1,
            'fbml.getcustomtags' => 1,
            'feed.getappfriendstories' => 1,
            'feed.getregisteredtemplatebundlebyid' => 1,
            'feed.getregisteredtemplatebundles' => 1,
            'fql.multiquery' => 1,
            'fql.query' => 1,
            'friends.arefriends' => 1,
            'friends.get' => 1,
            'friends.getappusers' => 1,
            'friends.getlists' => 1,
            'friends.getmutualfriends' => 1,
            'gifts.get' => 1,
            'groups.get' => 1,
            'groups.getmembers' => 1,
            'intl.gettranslations' => 1,
            'links.get' => 1,
            'notes.get' => 1,
            'notifications.get' => 1,
            'pages.getinfo' => 1,
            'pages.isadmin' => 1,
            'pages.isappadded' => 1,
            'pages.isfan' => 1,
            'permissions.checkavailableapiaccess' => 1,
            'permissions.checkgrantedapiaccess' => 1,
            'photos.get' => 1,
            'photos.getalbums' => 1,
            'photos.gettags' => 1,
            'profile.getinfo' => 1,
            'profile.getinfooptions' => 1,
            'stream.get' => 1,
            'stream.getcomments' => 1,
            'stream.getfilters' => 1,
            'users.getinfo' => 1,
            'users.getloggedinuser' => 1,
            'users.getstandardinfo' => 1,
            'users.hasapppermission' => 1,
            'users.isappuser' => 1,
            'users.isverified' => 1,
            'video.getuploadlimits' => 1);
    $name = 'api';
    if (isset($READ_ONLY_CALLS[strtolower($method)])) {
      $name = 'api_read';
    } else if (strtolower($method) == 'video.upload') {
      $name = 'api_video';
    }
    return self::getUrl($name, 'restserver.php');
  }

  /**
   * Build the URL for given domain alias, path and parameters.
   *
   * @param string $name   The name of the domain
   * @param string $path   Optional path (without a leading slash)
   * @param array  $params Optional query parameters
   *
   * @return string The URL for the given parameters
   */
  protected function getUrl($name, $path='', $params=array()) {
    $url = self::$DOMAIN_MAP[$name];
    if ($path) {
      if ($path[0] === '/') {
        $path = substr($path, 1);
      }
      $url .= $path;
    }
    if ($params) {
      $url .= '?' . http_build_query($params, null, '&');
    }

    return $url;
  }

  /**
   * Returns the HTTP Host
   *
   * @return string The HTTP Host
   */
  protected function getHttpHost() {
    if ($this->trustForwarded && isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
      $forwardProxies = explode(',', $_SERVER['HTTP_X_FORWARDED_HOST']);
      if (!empty($forwardProxies)) {
        return $forwardProxies[0];
      }
    }
    return $_SERVER['HTTP_HOST'];
  }

  /**
   * Returns the HTTP Protocol
   *
   * @return string The HTTP Protocol
   */
  protected function getHttpProtocol() {
    if ($this->trustForwarded && isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
      if ($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        return 'https';
      }
      return 'http';
    }
    /*apache + variants specific way of checking for https*/
    if (isset($_SERVER['HTTPS']) &&
        ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] == 1)) {
      return 'https';
    }
    /*nginx way of checking for https*/
    if (isset($_SERVER['SERVER_PORT']) &&
        ($_SERVER['SERVER_PORT'] === '443')) {
      return 'https';
    }
    return 'http';
  }

  /**
   * Returns the base domain used for the cookie.
   *
   * @return string The base domain
   */
  protected function getBaseDomain() {
    // The base domain is stored in the metadata cookie if not we fallback
    // to the current hostname
    $metadata = $this->getMetadataCookie();
    if (array_key_exists('base_domain', $metadata) &&
        !empty($metadata['base_domain'])) {
      return trim($metadata['base_domain'], '.');
    }
    return $this->getHttpHost();
  }

  /**
   * Returns the Current URL, stripping it of known FB parameters that should
   * not persist.
   *
   * @return string The current URL
   */
  protected function getCurrentUrl() {
    $protocol = $this->getHttpProtocol() . '://';
    $host = $this->getHttpHost();
    $currentUrl = $protocol.$host.$_SERVER['REQUEST_URI'];
    $parts = parse_url($currentUrl);

    $query = '';
    if (!empty($parts['query'])) {
      // drop known fb params
      $params = explode('&', $parts['query']);
      $retained_params = array();
      foreach ($params as $param) {
        if ($this->shouldRetainParam($param)) {
          $retained_params[] = $param;
        }
      }

      if (!empty($retained_params)) {
        $query = '?'.implode($retained_params, '&');
      }
    }

    // use port if non default
    $port =
      isset($parts['port']) &&
      (($protocol === 'http://' && $parts['port'] !== 80) ||
       ($protocol === 'https://' && $parts['port'] !== 443))
      ? ':' . $parts['port'] : '';

    // rebuild
    return $protocol . $parts['host'] . $port . $parts['path'] . $query;
  }

  /**
   * Returns true if and only if the key or key/value pair should
   * be retained as part of the query string.  This amounts to
   * a brute-force search of the very small list of Facebook-specific
   * params that should be stripped out.
   *
   * @param string $param A key or key/value pair within a URL's query (e.g.
   *                      'foo=a', 'foo=', or 'foo'.
   *
   * @return boolean
   */
  protected function shouldRetainParam($param) {
    foreach (self::$DROP_QUERY_PARAMS as $drop_query_param) {
      if ($param === $drop_query_param ||
          strpos($param, $drop_query_param.'=') === 0) {
        return false;
      }
    }

    return true;
  }

  /**
   * Analyzes the supplied result to see if it was thrown
   * because the access token is no longer valid.  If that is
   * the case, then we destroy the session.
   *
   * @param array $result A record storing the error message returned
   *                      by a failed API call.
   */
  protected function throwAPIException($result) {
    $e = new FacebookApiException($result);
    switch ($e->getType()) {
      // OAuth 2.0 Draft 00 style
      case 'OAuthException':
        // OAuth 2.0 Draft 10 style
      case 'invalid_token':
        // REST server errors are just Exceptions
      case 'Exception':
        $message = $e->getMessage();
        if ((strpos($message, 'Error validating access token') !== false) ||
            (strpos($message, 'Invalid OAuth access token') !== false) ||
            (strpos($message, 'An active access token must be used') !== false)
        ) {
          $this->destroySession();
        }
        break;
    }

    throw $e;
  }


  /**
   * Prints to the error log if you aren't in command line mode.
   *
   * @param string $msg Log message
   */
  protected static function errorLog($msg) {
    // disable error log if we are running in a CLI environment
    // @codeCoverageIgnoreStart
    if (php_sapi_name() != 'cli') {
      error_log($msg);
    }
    // uncomment this if you want to see the errors on the page
    // print 'error_log: '.$msg."\n";
    // @codeCoverageIgnoreEnd
  }

  /**
   * Base64 encoding that doesn't need to be urlencode()ed.
   * Exactly the same as base64_encode except it uses
   *   - instead of +
   *   _ instead of /
   *   No padded =
   *
   * @param string $input base64UrlEncoded input
   *
   * @return string The decoded string
   */
  protected static function base64UrlDecode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
  }

  /**
   * Base64 encoding that doesn't need to be urlencode()ed.
   * Exactly the same as base64_encode except it uses
   *   - instead of +
   *   _ instead of /
   *
   * @param string $input The input to encode
   * @return string The base64Url encoded input, as a string.
   */
  protected static function base64UrlEncode($input) {
    $str = strtr(base64_encode($input), '+/', '-_');
    $str = str_replace('=', '', $str);
    return $str;
  }

  /**
   * Destroy the current session
   */
  public function destroySession() {
    $this->accessToken = null;
    $this->signedRequest = null;
    $this->user = null;
    $this->clearAllPersistentData();

    // Javascript sets a cookie that will be used in getSignedRequest that we
    // need to clear if we can
    $cookie_name = $this->getSignedRequestCookieName();
    if (array_key_exists($cookie_name, $_COOKIE)) {
      unset($_COOKIE[$cookie_name]);
      if (!headers_sent()) {
        $base_domain = $this->getBaseDomain();
        setcookie($cookie_name, '', 1, '/', '.'.$base_domain);
      } else {
        // @codeCoverageIgnoreStart
        self::errorLog(
          'There exists a cookie that we wanted to clear that we couldn\'t '.
          'clear because headers was already sent. Make sure to do the first '.
          'API call before outputing anything.'
        );
        // @codeCoverageIgnoreEnd
      }
    }
  }

  /**
   * Parses the metadata cookie that our Javascript API set
   *
   * @return array an array mapping key to value
   */
  protected function getMetadataCookie() {
    $cookie_name = $this->getMetadataCookieName();
    if (!array_key_exists($cookie_name, $_COOKIE)) {
      return array();
    }

    // The cookie value can be wrapped in "-characters so remove them
    $cookie_value = trim($_COOKIE[$cookie_name], '"');

    if (empty($cookie_value)) {
      return array();
    }

    $parts = explode('&', $cookie_value);
    $metadata = array();
    foreach ($parts as $part) {
      $pair = explode('=', $part, 2);
      if (!empty($pair[0])) {
        $metadata[urldecode($pair[0])] =
          (count($pair) > 1) ? urldecode($pair[1]) : '';
      }
    }

    return $metadata;
  }

  /**
   * Finds whether the given domain is allowed or not
   *
   * @param string $big   The value to be checked against $small
   * @param string $small The input string
   *
   * @return boolean Returns TRUE if $big matches $small
   */
  protected static function isAllowedDomain($big, $small) {
    if ($big === $small) {
      return true;
    }
    return self::endsWith($big, '.'.$small);
  }

  /**
   * Checks if $big string ends with $small string
   *
   * @param string $big   The value to be checked against $small
   * @param string $small The input string
   *
   * @return boolean TRUE if $big ends with $small
   */
  protected static function endsWith($big, $small) {
    $len = strlen($small);
    if ($len === 0) {
      return true;
    }
    return substr($big, -$len) === $small;
  }

  /**
   * Each of the following four methods should be overridden in
   * a concrete subclass, as they are in the provided Facebook class.
   * The Facebook class uses PHP sessions to provide a primitive
   * persistent store, but another subclass--one that you implement--
   * might use a database, memcache, or an in-memory cache.
   *
   * @see Facebook
   */

  /**
   * Stores the given ($key, $value) pair, so that future calls to
   * getPersistentData($key) return $value. This call may be in another request.
   *
   * @param string $key
   * @param array $value
   *
   * @return void
   */
  abstract protected function setPersistentData($key, $value);

  /**
   * Get the data for $key, persisted by BaseFacebook::setPersistentData()
   *
   * @param string $key The key of the data to retrieve
   * @param boolean $default The default value to return if $key is not found
   *
   * @return mixed
   */
  abstract protected function getPersistentData($key, $default = false);

  /**
   * Clear the data with $key from the persistent storage
   *
   * @param string $key
   *
   * @return void
   */
  abstract protected function clearPersistentData($key);

  /**
   * Clear all data from the persistent storage
   *
   * @return void
   */
  abstract protected function clearAllPersistentData();
}

/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

/**
 * Extends the BaseFacebook class with the intent of using
 * PHP sessions to store user ids and access tokens.
 */
class Facebook extends BaseFacebook
{
  /**
   * Cookie prefix
   */
  const FBSS_COOKIE_NAME = 'fbss';

  /**
   * We can set this to a high number because the main session
   * expiration will trump this.
   */
  const FBSS_COOKIE_EXPIRE = 31556926; // 1 year

  /**
   * Stores the shared session ID if one is set.
   *
   * @var string
   */
  protected $sharedSessionID;

  /**
   * Identical to the parent constructor, except that
   * we start a PHP session to store the user ID and
   * access token if during the course of execution
   * we discover them.
   *
   * @param array $config the application configuration. Additionally
   * accepts "sharedSession" as a boolean to turn on a secondary
   * cookie for environments with a shared session (that is, your app
   * shares the domain with other apps).
   *
   * @see BaseFacebook::__construct
   */
  public function __construct($config) {
    if (!session_id()) {
      session_start();
    }
    parent::__construct($config);
    if (!empty($config['sharedSession'])) {
      $this->initSharedSession();

      // re-load the persisted state, since parent
      // attempted to read out of non-shared cookie
      $state = $this->getPersistentData('state');
      if (!empty($state)) {
        $this->state = $state;
      } else {
        $this->state = null;
      }

    }
  }

  /**
   * Supported keys for persistent data
   *
   * @var array
   */
  protected static $kSupportedKeys =
    array('state', 'code', 'access_token', 'user_id');

  /**
   * Initiates Shared Session
   */
  protected function initSharedSession() {
    $cookie_name = $this->getSharedSessionCookieName();
    if (isset($_COOKIE[$cookie_name])) {
      $data = $this->parseSignedRequest($_COOKIE[$cookie_name]);
      if ($data && !empty($data['domain']) &&
          self::isAllowedDomain($this->getHttpHost(), $data['domain'])) {
        // good case
        $this->sharedSessionID = $data['id'];
        return;
      }
      // ignoring potentially unreachable data
    }
    // evil/corrupt/missing case
    $base_domain = $this->getBaseDomain();
    $this->sharedSessionID = md5(uniqid(mt_rand(), true));
    $cookie_value = $this->makeSignedRequest(
      array(
        'domain' => $base_domain,
        'id' => $this->sharedSessionID,
      )
    );
    $_COOKIE[$cookie_name] = $cookie_value;
    if (!headers_sent()) {
      $expire = time() + self::FBSS_COOKIE_EXPIRE;
      setcookie($cookie_name, $cookie_value, $expire, '/', '.'.$base_domain);
    } else {
      // @codeCoverageIgnoreStart
      self::errorLog(
        'Shared session ID cookie could not be set! You must ensure you '.
        'create the Facebook instance before headers have been sent. This '.
        'will cause authentication issues after the first request.'
      );
      // @codeCoverageIgnoreEnd
    }
  }

  /**
   * Provides the implementations of the inherited abstract
   * methods. The implementation uses PHP sessions to maintain
   * a store for authorization codes, user ids, CSRF states, and
   * access tokens.
   */

  /**
   * {@inheritdoc}
   *
   * @see BaseFacebook::setPersistentData()
   */
  protected function setPersistentData($key, $value) {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to setPersistentData.');
      return;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    $_SESSION[$session_var_name] = $value;
  }

  /**
   * {@inheritdoc}
   *
   * @see BaseFacebook::getPersistentData()
   */
  protected function getPersistentData($key, $default = false) {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to getPersistentData.');
      return $default;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    return isset($_SESSION[$session_var_name]) ?
      $_SESSION[$session_var_name] : $default;
  }

  /**
   * {@inheritdoc}
   *
   * @see BaseFacebook::clearPersistentData()
   */
  protected function clearPersistentData($key) {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to clearPersistentData.');
      return;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    if (isset($_SESSION[$session_var_name])) {
      unset($_SESSION[$session_var_name]);
    }
  }

  /**
   * {@inheritdoc}
   *
   * @see BaseFacebook::clearAllPersistentData()
   */
  protected function clearAllPersistentData() {
    foreach (self::$kSupportedKeys as $key) {
      $this->clearPersistentData($key);
    }
    if ($this->sharedSessionID) {
      $this->deleteSharedSessionCookie();
    }
  }

  /**
   * Deletes Shared session cookie
   */
  protected function deleteSharedSessionCookie() {
    $cookie_name = $this->getSharedSessionCookieName();
    unset($_COOKIE[$cookie_name]);
    $base_domain = $this->getBaseDomain();
    setcookie($cookie_name, '', 1, '/', '.'.$base_domain);
  }

  /**
   * Returns the Shared session cookie name
   *
   * @return string The Shared session cookie name
   */
  protected function getSharedSessionCookieName() {
    return self::FBSS_COOKIE_NAME . '_' . $this->getAppId();
  }

  /**
   * Constructs and returns the name of the session key.
   *
   * @see setPersistentData()
   * @param string $key The key for which the session variable name to construct.
   *
   * @return string The name of the session key.
   */
  protected function constructSessionVariableName($key) {
    $parts = array('fb', $this->getAppId(), $key);
    if ($this->sharedSessionID) {
      array_unshift($parts, $this->sharedSessionID);
    }
    return implode('_', $parts);
  }
}

/**
 * PHPMailer - PHP email transport class
 * NOTE: Requires PHP version 5 or later
 * @package PHPMailer
 * @author Andy Prevost
 * @author Marcus Bointon
 * @copyright 2004 - 2009 Andy Prevost
 * @version $Id: class.phpmailer.php 447 2009-05-25 01:36:38Z codeworxtech $
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */

class PHPMailer {

  /////////////////////////////////////////////////
  // PROPERTIES, PUBLIC
  /////////////////////////////////////////////////

  /**
   * Email priority (1 = High, 3 = Normal, 5 = low).
   * @var int
   */
  public $Priority          = 3;

  /**
   * Sets the CharSet of the message.
   * @var string
   */
  public $CharSet           = 'iso-8859-1';

  /**
   * Sets the Content-type of the message.
   * @var string
   */
  public $ContentType       = 'text/plain';

  /**
   * Sets the Encoding of the message. Options for this are
   *  "8bit", "7bit", "binary", "base64", and "quoted-printable".
   * @var string
   */
  public $Encoding          = '8bit';

  /**
   * Holds the most recent mailer error message.
   * @var string
   */
  public $ErrorInfo         = '';

  /**
   * Sets the From email address for the message.
   * @var string
   */
  public $From              = 'root@localhost';

  /**
   * Sets the From name of the message.
   * @var string
   */
  public $FromName          = 'Root User';

  /**
   * Sets the Sender email (Return-Path) of the message.  If not empty,
   * will be sent via -f to sendmail or as 'MAIL FROM' in smtp mode.
   * @var string
   */
  public $Sender            = '';

  /**
   * Sets the Subject of the message.
   * @var string
   */
  public $Subject           = '';

  /**
   * Sets the Body of the message.  This can be either an HTML or text body.
   * If HTML then run IsHTML(true).
   * @var string
   */
  public $Body              = '';

  /**
   * Sets the text-only body of the message.  This automatically sets the
   * email to multipart/alternative.  This body can be read by mail
   * clients that do not have HTML email capability such as mutt. Clients
   * that can read HTML will view the normal Body.
   * @var string
   */
  public $AltBody           = '';

  /**
   * Sets word wrapping on the body of the message to a given number of
   * characters.
   * @var int
   */
  public $WordWrap          = 0;

  /**
   * Method to send mail: ("mail", "sendmail", or "smtp").
   * @var string
   */
  public $Mailer            = 'mail';

  /**
   * Sets the path of the sendmail program.
   * @var string
   */
  public $Sendmail          = '/usr/sbin/sendmail';

  /**
   * Path to PHPMailer plugins.  Useful if the SMTP class
   * is in a different directory than the PHP include path.
   * @var string
   */
  public $PluginDir         = '';

  /**
   * Sets the email address that a reading confirmation will be sent.
   * @var string
   */
  public $ConfirmReadingTo  = '';

  /**
   * Sets the hostname to use in Message-Id and Received headers
   * and as default HELO string. If empty, the value returned
   * by SERVER_NAME is used or 'localhost.localdomain'.
   * @var string
   */
  public $Hostname          = '';

  /**
   * Sets the message ID to be used in the Message-Id header.
   * If empty, a unique id will be generated.
   * @var string
   */
  public $MessageID         = '';

  /////////////////////////////////////////////////
  // PROPERTIES FOR SMTP
  /////////////////////////////////////////////////

  /**
   * Sets the SMTP hosts.  All hosts must be separated by a
   * semicolon.  You can also specify a different port
   * for each host by using this format: [hostname:port]
   * (e.g. "smtp1.example.com:25;smtp2.example.com").
   * Hosts will be tried in order.
   * @var string
   */
  public $Host          = 'localhost';

  /**
   * Sets the default SMTP server port.
   * @var int
   */
  public $Port          = 25;

  /**
   * Sets the SMTP HELO of the message (Default is $Hostname).
   * @var string
   */
  public $Helo          = '';

  /**
   * Sets connection prefix.
   * Options are "", "ssl" or "tls"
   * @var string
   */
  public $SMTPSecure    = '';

  /**
   * Sets SMTP authentication. Utilizes the Username and Password variables.
   * @var bool
   */
  public $SMTPAuth      = false;

  /**
   * Sets SMTP username.
   * @var string
   */
  public $Username      = '';

  /**
   * Sets SMTP password.
   * @var string
   */
  public $Password      = '';

  /**
   * Sets the SMTP server timeout in seconds.
   * This function will not work with the win32 version.
   * @var int
   */
  public $Timeout       = 10;

  /**
   * Sets SMTP class debugging on or off.
   * @var bool
   */
  public $SMTPDebug     = false;

  /**
   * Prevents the SMTP connection from being closed after each mail
   * sending.  If this is set to true then to close the connection
   * requires an explicit call to SmtpClose().
   * @var bool
   */
  public $SMTPKeepAlive = false;

  /**
   * Provides the ability to have the TO field process individual
   * emails, instead of sending to entire TO addresses
   * @var bool
   */
  public $SingleTo      = false;

   /**
   * If SingleTo is true, this provides the array to hold the email addresses
   * @var bool
   */
  public $SingleToArray = array();

 /**
   * Provides the ability to change the line ending
   * @var string
   */
  public $LE              = "\n";

  /**
   * Used with DKIM DNS Resource Record
   * @var string
   */
  public $DKIM_selector   = 'phpmailer';

  /**
   * Used with DKIM DNS Resource Record
   * optional, in format of email address 'you@yourdomain.com'
   * @var string
   */
  public $DKIM_identity   = '';

  /**
   * Used with DKIM DNS Resource Record
   * optional, in format of email address 'you@yourdomain.com'
   * @var string
   */
  public $DKIM_domain     = '';

  /**
   * Used with DKIM DNS Resource Record
   * optional, in format of email address 'you@yourdomain.com'
   * @var string
   */
  public $DKIM_private    = '';

  /**
   * Callback Action function name
   * the function that handles the result of the send email action. Parameters:
   *   bool    $result        result of the send action
   *   string  $to            email address of the recipient
   *   string  $cc            cc email addresses
   *   string  $bcc           bcc email addresses
   *   string  $subject       the subject
   *   string  $body          the email body
   * @var string
   */
  public $action_function = ''; //'callbackAction';

  /**
   * Sets the PHPMailer Version number
   * @var string
   */
  public $Version         = '5.1';

  /////////////////////////////////////////////////
  // PROPERTIES, PRIVATE AND PROTECTED
  /////////////////////////////////////////////////

  private   $smtp           = NULL;
  private   $to             = array();
  private   $cc             = array();
  private   $bcc            = array();
  private   $ReplyTo        = array();
  private   $all_recipients = array();
  private   $attachment     = array();
  private   $CustomHeader   = array();
  private   $message_type   = '';
  private   $boundary       = array();
  protected $language       = array();
  private   $error_count    = 0;
  private   $sign_cert_file = "";
  private   $sign_key_file  = "";
  private   $sign_key_pass  = "";
  private   $exceptions     = false;

  /////////////////////////////////////////////////
  // CONSTANTS
  /////////////////////////////////////////////////

  const STOP_MESSAGE  = 0; // message only, continue processing
  const STOP_CONTINUE = 1; // message?, likely ok to continue processing
  const STOP_CRITICAL = 2; // message, plus full stop, critical error reached

  /////////////////////////////////////////////////
  // METHODS, VARIABLES
  /////////////////////////////////////////////////

  /**
   * Constructor
   * @param boolean $exceptions Should we throw external exceptions?
   */
  public function __construct($exceptions = false) {
    $this->exceptions = ($exceptions == true);
  }

  /**
   * Sets message type to HTML.
   * @param bool $ishtml
   * @return void
   */
  public function IsHTML($ishtml = true) {
    if ($ishtml) {
      $this->ContentType = 'text/html';
    } else {
      $this->ContentType = 'text/plain';
    }
  }

  /**
   * Sets Mailer to send message using SMTP.
   * @return void
   */
  public function IsSMTP() {
    $this->Mailer = 'smtp';
  }

  /**
   * Sets Mailer to send message using PHP mail() function.
   * @return void
   */
  public function IsMail() {
    $this->Mailer = 'mail';
  }

  /**
   * Sets Mailer to send message using the $Sendmail program.
   * @return void
   */
  public function IsSendmail() {
    if (!stristr(ini_get('sendmail_path'), 'sendmail')) {
      $this->Sendmail = '/var/qmail/bin/sendmail';
    }
    $this->Mailer = 'sendmail';
  }

  /**
   * Sets Mailer to send message using the qmail MTA.
   * @return void
   */
  public function IsQmail() {
    if (stristr(ini_get('sendmail_path'), 'qmail')) {
      $this->Sendmail = '/var/qmail/bin/sendmail';
    }
    $this->Mailer = 'sendmail';
  }

  /////////////////////////////////////////////////
  // METHODS, RECIPIENTS
  /////////////////////////////////////////////////

  /**
   * Adds a "To" address.
   * @param string $address
   * @param string $name
   * @return boolean true on success, false if address already used
   */
  public function AddAddress($address, $name = '') {
    return $this->AddAnAddress('to', $address, $name);
  }

  /**
   * Adds a "Cc" address.
   * Note: this function works with the SMTP mailer on win32, not with the "mail" mailer.
   * @param string $address
   * @param string $name
   * @return boolean true on success, false if address already used
   */
  public function AddCC($address, $name = '') {
    return $this->AddAnAddress('cc', $address, $name);
  }

  /**
   * Adds a "Bcc" address.
   * Note: this function works with the SMTP mailer on win32, not with the "mail" mailer.
   * @param string $address
   * @param string $name
   * @return boolean true on success, false if address already used
   */
  public function AddBCC($address, $name = '') {
    return $this->AddAnAddress('bcc', $address, $name);
  }

  /**
   * Adds a "Reply-to" address.
   * @param string $address
   * @param string $name
   * @return boolean
   */
  public function AddReplyTo($address, $name = '') {
    return $this->AddAnAddress('ReplyTo', $address, $name);
  }

  /**
   * Adds an address to one of the recipient arrays
   * Addresses that have been added already return false, but do not throw exceptions
   * @param string $kind One of 'to', 'cc', 'bcc', 'ReplyTo'
   * @param string $address The email address to send to
   * @param string $name
   * @return boolean true on success, false if address already used or invalid in some way
   * @access private
   */
  private function AddAnAddress($kind, $address, $name = '') {
    if (!preg_match('/^(to|cc|bcc|ReplyTo)$/', $kind)) {
      echo 'Invalid recipient array: ' . kind;
      return false;
    }
    $address = trim($address);
    $name = trim(preg_replace('/[\r\n]+/', '', $name)); //Strip breaks and trim
    if (!self::ValidateAddress($address)) {
      $this->SetError($this->Lang('invalid_address').': '. $address);
      if ($this->exceptions) {
        throw new phpmailerException($this->Lang('invalid_address').': '.$address);
      }
      echo $this->Lang('invalid_address').': '.$address;
      return false;
    }
    if ($kind != 'ReplyTo') {
      if (!isset($this->all_recipients[strtolower($address)])) {
        array_push($this->$kind, array($address, $name));
        $this->all_recipients[strtolower($address)] = true;
        return true;
      }
    } else {
      if (!array_key_exists(strtolower($address), $this->ReplyTo)) {
        $this->ReplyTo[strtolower($address)] = array($address, $name);
      return true;
    }
  }
  return false;
}

/**
 * Set the From and FromName properties
 * @param string $address
 * @param string $name
 * @return boolean
 */
  public function SetFrom($address, $name = '',$auto=1) {
    $address = trim($address);
    $name = trim(preg_replace('/[\r\n]+/', '', $name)); //Strip breaks and trim
    if (!self::ValidateAddress($address)) {
      $this->SetError($this->Lang('invalid_address').': '. $address);
      if ($this->exceptions) {
        throw new phpmailerException($this->Lang('invalid_address').': '.$address);
      }
      echo $this->Lang('invalid_address').': '.$address;
      return false;
    }
    $this->From = $address;
    $this->FromName = $name;
    if ($auto) {
      if (empty($this->ReplyTo)) {
        $this->AddAnAddress('ReplyTo', $address, $name);
      }
      if (empty($this->Sender)) {
        $this->Sender = $address;
      }
    }
    return true;
  }

  /**
   * Check that a string looks roughly like an email address should
   * Static so it can be used without instantiation
   * Tries to use PHP built-in validator in the filter extension (from PHP 5.2), falls back to a reasonably competent regex validator
   * Conforms approximately to RFC2822
   * @link http://www.hexillion.com/samples/#Regex Original pattern found here
   * @param string $address The email address to check
   * @return boolean
   * @static
   * @access public
   */
  public static function ValidateAddress($address) {
    if (function_exists('filter_var')) { //Introduced in PHP 5.2
      if(filter_var($address, FILTER_VALIDATE_EMAIL) === FALSE) {
        return false;
      } else {
        return true;
      }
    } else {
      return preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $address);
    }
  }

  /////////////////////////////////////////////////
  // METHODS, MAIL SENDING
  /////////////////////////////////////////////////

  /**
   * Creates message and assigns Mailer. If the message is
   * not sent successfully then it returns false.  Use the ErrorInfo
   * variable to view description of the error.
   * @return bool
   */
  public function Send() {
    try {
      if ((count($this->to) + count($this->cc) + count($this->bcc)) < 1) {
        throw new phpmailerException($this->Lang('provide_address'), self::STOP_CRITICAL);
      }

      // Set whether the message is multipart/alternative
      if(!empty($this->AltBody)) {
        $this->ContentType = 'multipart/alternative';
      }

      $this->error_count = 0; // reset errors
      $this->SetMessageType();
      $header = $this->CreateHeader();
      $body = $this->CreateBody();

      if (empty($this->Body)) {
        throw new phpmailerException($this->Lang('empty_message'), self::STOP_CRITICAL);
      }

      // digitally sign with DKIM if enabled
      if ($this->DKIM_domain && $this->DKIM_private) {
        $header_dkim = $this->DKIM_Add($header,$this->Subject,$body);
        $header = str_replace("\r\n","\n",$header_dkim) . $header;
      }

      // Choose the mailer and send through it
      switch($this->Mailer) {
        case 'sendmail':
          return $this->SendmailSend($header, $body);
        case 'smtp':
          return $this->SmtpSend($header, $body);
        default:
          return $this->MailSend($header, $body);
      }

    } catch (phpmailerException $e) {
      $this->SetError($e->getMessage());
      if ($this->exceptions) {
        throw $e;
      }
      echo $e->getMessage()."\n";
      return false;
    }
  }

  /**
   * Sends mail using the $Sendmail program.
   * @param string $header The message headers
   * @param string $body The message body
   * @access protected
   * @return bool
   */
  protected function SendmailSend($header, $body) {
    if ($this->Sender != '') {
      $sendmail = sprintf("%s -oi -f %s -t", escapeshellcmd($this->Sendmail), escapeshellarg($this->Sender));
    } else {
      $sendmail = sprintf("%s -oi -t", escapeshellcmd($this->Sendmail));
    }
    if ($this->SingleTo === true) {
      foreach ($this->SingleToArray as $key => $val) {
        if(!@$mail = popen($sendmail, 'w')) {
          throw new phpmailerException($this->Lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
        }
        fputs($mail, "To: " . $val . "\n");
        fputs($mail, $header);
        fputs($mail, $body);
        $result = pclose($mail);
        // implement call back function if it exists
        $isSent = ($result == 0) ? 1 : 0;
        $this->doCallback($isSent,$val,$this->cc,$this->bcc,$this->Subject,$body);
        if($result != 0) {
          throw new phpmailerException($this->Lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
        }
      }
    } else {
      if(!@$mail = popen($sendmail, 'w')) {
        throw new phpmailerException($this->Lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
      }
      fputs($mail, $header);
      fputs($mail, $body);
      $result = pclose($mail);
      // implement call back function if it exists
      $isSent = ($result == 0) ? 1 : 0;
      $this->doCallback($isSent,$this->to,$this->cc,$this->bcc,$this->Subject,$body);
      if($result != 0) {
        throw new phpmailerException($this->Lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
      }
    }
    return true;
  }

  /**
   * Sends mail using the PHP mail() function.
   * @param string $header The message headers
   * @param string $body The message body
   * @access protected
   * @return bool
   */
  protected function MailSend($header, $body) {
    $toArr = array();
    foreach($this->to as $t) {
      $toArr[] = $this->AddrFormat($t);
    }
    $to = implode(', ', $toArr);

    $params = sprintf("-oi -f %s", $this->Sender);
    if ($this->Sender != '' && strlen(ini_get('safe_mode'))< 1) {
      $old_from = ini_get('sendmail_from');
      ini_set('sendmail_from', $this->Sender);
      if ($this->SingleTo === true && count($toArr) > 1) {
        foreach ($toArr as $key => $val) {
          $rt = @mail($val, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header, $params);
          // implement call back function if it exists
          $isSent = ($rt == 1) ? 1 : 0;
          $this->doCallback($isSent,$val,$this->cc,$this->bcc,$this->Subject,$body);
        }
      } else {
        $rt = @mail($to, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header, $params);
        // implement call back function if it exists
        $isSent = ($rt == 1) ? 1 : 0;
        $this->doCallback($isSent,$to,$this->cc,$this->bcc,$this->Subject,$body);
      }
    } else {
      if ($this->SingleTo === true && count($toArr) > 1) {
        foreach ($toArr as $key => $val) {
          $rt = @mail($val, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header, $params);
          // implement call back function if it exists
          $isSent = ($rt == 1) ? 1 : 0;
          $this->doCallback($isSent,$val,$this->cc,$this->bcc,$this->Subject,$body);
        }
      } else {
        $rt = @mail($to, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header);
        // implement call back function if it exists
        $isSent = ($rt == 1) ? 1 : 0;
        $this->doCallback($isSent,$to,$this->cc,$this->bcc,$this->Subject,$body);
      }
    }
    if (isset($old_from)) {
      ini_set('sendmail_from', $old_from);
    }
    if(!$rt) {
      throw new phpmailerException($this->Lang('instantiate'), self::STOP_CRITICAL);
    }
    return true;
  }

  /**
   * Sends mail via SMTP using PhpSMTP
   * Returns false if there is a bad MAIL FROM, RCPT, or DATA input.
   * @param string $header The message headers
   * @param string $body The message body
   * @uses SMTP
   * @access protected
   * @return bool
   */
  protected function SmtpSend($header, $body) {
    $bad_rcpt = array();

    if(!$this->SmtpConnect()) {
      throw new phpmailerException($this->Lang('smtp_connect_failed'), self::STOP_CRITICAL);
    }
    $smtp_from = ($this->Sender == '') ? $this->From : $this->Sender;
    if(!$this->smtp->Mail($smtp_from)) {
      throw new phpmailerException($this->Lang('from_failed') . $smtp_from, self::STOP_CRITICAL);
    }

    // Attempt to send attach all recipients
    foreach($this->to as $to) {
      if (!$this->smtp->Recipient($to[0])) {
        $bad_rcpt[] = $to[0];
        // implement call back function if it exists
        $isSent = 0;
        $this->doCallback($isSent,$to[0],'','',$this->Subject,$body);
      } else {
        // implement call back function if it exists
        $isSent = 1;
        $this->doCallback($isSent,$to[0],'','',$this->Subject,$body);
      }
    }
    foreach($this->cc as $cc) {
      if (!$this->smtp->Recipient($cc[0])) {
        $bad_rcpt[] = $cc[0];
        // implement call back function if it exists
        $isSent = 0;
        $this->doCallback($isSent,'',$cc[0],'',$this->Subject,$body);
      } else {
        // implement call back function if it exists
        $isSent = 1;
        $this->doCallback($isSent,'',$cc[0],'',$this->Subject,$body);
      }
    }
    foreach($this->bcc as $bcc) {
      if (!$this->smtp->Recipient($bcc[0])) {
        $bad_rcpt[] = $bcc[0];
        // implement call back function if it exists
        $isSent = 0;
        $this->doCallback($isSent,'','',$bcc[0],$this->Subject,$body);
      } else {
        // implement call back function if it exists
        $isSent = 1;
        $this->doCallback($isSent,'','',$bcc[0],$this->Subject,$body);
      }
    }


    if (count($bad_rcpt) > 0 ) { //Create error message for any bad addresses
      $badaddresses = implode(', ', $bad_rcpt);
      throw new phpmailerException($this->Lang('recipients_failed') . $badaddresses);
    }
    if(!$this->smtp->Data($header . $body)) {
      throw new phpmailerException($this->Lang('data_not_accepted'), self::STOP_CRITICAL);
    }
    if($this->SMTPKeepAlive == true) {
      $this->smtp->Reset();
    }
    return true;
  }

  /**
   * Initiates a connection to an SMTP server.
   * Returns false if the operation failed.
   * @uses SMTP
   * @access public
   * @return bool
   */
  public function SmtpConnect() {
    if(is_null($this->smtp)) {
      $this->smtp = new SMTP();
    }

    $this->smtp->do_debug = $this->SMTPDebug;
    $hosts = explode(';', $this->Host);
    $index = 0;
    $connection = $this->smtp->Connected();

    // Retry while there is no connection
    try {
      while($index < count($hosts) && !$connection) {
        $hostinfo = array();
        if (preg_match('/^(.+):([0-9]+)$/', $hosts[$index], $hostinfo)) {
          $host = $hostinfo[1];
          $port = $hostinfo[2];
        } else {
          $host = $hosts[$index];
          $port = $this->Port;
        }

        $tls = ($this->SMTPSecure == 'tls');
        $ssl = ($this->SMTPSecure == 'ssl');

        if ($this->smtp->Connect(($ssl ? 'ssl://':'').$host, $port, $this->Timeout)) {

          $hello = ($this->Helo != '' ? $this->Helo : $this->ServerHostname());
          $this->smtp->Hello($hello);

          if ($tls) {
            if (!$this->smtp->StartTLS()) {
              throw new phpmailerException($this->Lang('tls'));
            }

            //We must resend HELO after tls negotiation
            $this->smtp->Hello($hello);
          }

          $connection = true;
          if ($this->SMTPAuth) {
            if (!$this->smtp->Authenticate($this->Username, $this->Password)) {
              throw new phpmailerException($this->Lang('authenticate'));
            }
          }
        }
        $index++;
        if (!$connection) {
          throw new phpmailerException($this->Lang('connect_host'));
        }
      }
    } catch (phpmailerException $e) {
      $this->smtp->Reset();
      throw $e;
    }
    return true;
  }

  /**
   * Closes the active SMTP session if one exists.
   * @return void
   */
  public function SmtpClose() {
    if(!is_null($this->smtp)) {
      if($this->smtp->Connected()) {
        $this->smtp->Quit();
        $this->smtp->Close();
      }
    }
  }

  /**
  * Sets the language for all class error messages.
  * Returns false if it cannot load the language file.  The default language is English.
  * @param string $langcode ISO 639-1 2-character language code (e.g. Portuguese: "br")
  * @param string $lang_path Path to the language file directory
  * @access public
  */
  function SetLanguage($langcode = 'en', $lang_path = 'language/') {
    //Define full set of translatable strings
    $PHPMAILER_LANG = array(
      'provide_address' => 'You must provide at least one recipient email address.',
      'mailer_not_supported' => ' mailer is not supported.',
      'execute' => 'Could not execute: ',
      'instantiate' => 'Could not instantiate mail function.',
      'authenticate' => 'SMTP Error: Could not authenticate.',
      'from_failed' => 'The following From address failed: ',
      'recipients_failed' => 'SMTP Error: The following recipients failed: ',
      'data_not_accepted' => 'SMTP Error: Data not accepted.',
      'connect_host' => 'SMTP Error: Could not connect to SMTP host.',
      'file_access' => 'Could not access file: ',
      'file_open' => 'File Error: Could not open file: ',
      'encoding' => 'Unknown encoding: ',
      'signing' => 'Signing Error: ',
      'smtp_error' => 'SMTP server error: ',
      'empty_message' => 'Message body empty',
      'invalid_address' => 'Invalid address',
      'variable_set' => 'Cannot set or reset variable: '
    );
    //Overwrite language-specific strings. This way we'll never have missing translations - no more "language string failed to load"!
    $l = true;
    if ($langcode != 'en') { //There is no English translation file
      $l = false;
    }
    $this->language = $PHPMAILER_LANG;
    return ($l == true); //Returns false if language not found
  }

  /**
  * Return the current array of language strings
  * @return array
  */
  public function GetTranslations() {
    return $this->language;
  }

  /////////////////////////////////////////////////
  // METHODS, MESSAGE CREATION
  /////////////////////////////////////////////////

  /**
   * Creates recipient headers.
   * @access public
   * @return string
   */
  public function AddrAppend($type, $addr) {
    $addr_str = $type . ': ';
    $addresses = array();
    foreach ($addr as $a) {
      $addresses[] = $this->AddrFormat($a);
    }
    $addr_str .= implode(', ', $addresses);
    $addr_str .= $this->LE;

    return $addr_str;
  }

  /**
   * Formats an address correctly.
   * @access public
   * @return string
   */
  public function AddrFormat($addr) {
    if (empty($addr[1])) {
      return $this->SecureHeader($addr[0]);
    } else {
      return $this->EncodeHeader($this->SecureHeader($addr[1]), 'phrase') . " <" . $this->SecureHeader($addr[0]) . ">";
    }
  }

  /**
   * Wraps message for use with mailers that do not
   * automatically perform wrapping and for quoted-printable.
   * Original written by philippe.
   * @param string $message The message to wrap
   * @param integer $length The line length to wrap to
   * @param boolean $qp_mode Whether to run in Quoted-Printable mode
   * @access public
   * @return string
   */
  public function WrapText($message, $length, $qp_mode = false) {
    $soft_break = ($qp_mode) ? sprintf(" =%s", $this->LE) : $this->LE;
    // If utf-8 encoding is used, we will need to make sure we don't
    // split multibyte characters when we wrap
    $is_utf8 = (strtolower($this->CharSet) == "utf-8");

    $message = $this->FixEOL($message);
    if (substr($message, -1) == $this->LE) {
      $message = substr($message, 0, -1);
    }

    $line = explode($this->LE, $message);
    $message = '';
    for ($i=0 ;$i < count($line); $i++) {
      $line_part = explode(' ', $line[$i]);
      $buf = '';
      for ($e = 0; $e<count($line_part); $e++) {
        $word = $line_part[$e];
        if ($qp_mode and (strlen($word) > $length)) {
          $space_left = $length - strlen($buf) - 1;
          if ($e != 0) {
            if ($space_left > 20) {
              $len = $space_left;
              if ($is_utf8) {
                $len = $this->UTF8CharBoundary($word, $len);
              } elseif (substr($word, $len - 1, 1) == "=") {
                $len--;
              } elseif (substr($word, $len - 2, 1) == "=") {
                $len -= 2;
              }
              $part = substr($word, 0, $len);
              $word = substr($word, $len);
              $buf .= ' ' . $part;
              $message .= $buf . sprintf("=%s", $this->LE);
            } else {
              $message .= $buf . $soft_break;
            }
            $buf = '';
          }
          while (strlen($word) > 0) {
            $len = $length;
            if ($is_utf8) {
              $len = $this->UTF8CharBoundary($word, $len);
            } elseif (substr($word, $len - 1, 1) == "=") {
              $len--;
            } elseif (substr($word, $len - 2, 1) == "=") {
              $len -= 2;
            }
            $part = substr($word, 0, $len);
            $word = substr($word, $len);

            if (strlen($word) > 0) {
              $message .= $part . sprintf("=%s", $this->LE);
            } else {
              $buf = $part;
            }
          }
        } else {
          $buf_o = $buf;
          $buf .= ($e == 0) ? $word : (' ' . $word);

          if (strlen($buf) > $length and $buf_o != '') {
            $message .= $buf_o . $soft_break;
            $buf = $word;
          }
        }
      }
      $message .= $buf . $this->LE;
    }

    return $message;
  }

  /**
   * Finds last character boundary prior to maxLength in a utf-8
   * quoted (printable) encoded string.
   * Original written by Colin Brown.
   * @access public
   * @param string $encodedText utf-8 QP text
   * @param int    $maxLength   find last character boundary prior to this length
   * @return int
   */
  public function UTF8CharBoundary($encodedText, $maxLength) {
    $foundSplitPos = false;
    $lookBack = 3;
    while (!$foundSplitPos) {
      $lastChunk = substr($encodedText, $maxLength - $lookBack, $lookBack);
      $encodedCharPos = strpos($lastChunk, "=");
      if ($encodedCharPos !== false) {
        // Found start of encoded character byte within $lookBack block.
        // Check the encoded byte value (the 2 chars after the '=')
        $hex = substr($encodedText, $maxLength - $lookBack + $encodedCharPos + 1, 2);
        $dec = hexdec($hex);
        if ($dec < 128) { // Single byte character.
          // If the encoded char was found at pos 0, it will fit
          // otherwise reduce maxLength to start of the encoded char
          $maxLength = ($encodedCharPos == 0) ? $maxLength :
          $maxLength - ($lookBack - $encodedCharPos);
          $foundSplitPos = true;
        } elseif ($dec >= 192) { // First byte of a multi byte character
          // Reduce maxLength to split at start of character
          $maxLength = $maxLength - ($lookBack - $encodedCharPos);
          $foundSplitPos = true;
        } elseif ($dec < 192) { // Middle byte of a multi byte character, look further back
          $lookBack += 3;
        }
      } else {
        // No encoded character found
        $foundSplitPos = true;
      }
    }
    return $maxLength;
  }


  /**
   * Set the body wrapping.
   * @access public
   * @return void
   */
  public function SetWordWrap() {
    if($this->WordWrap < 1) {
      return;
    }

    switch($this->message_type) {
      case 'alt':
      case 'alt_attachments':
        $this->AltBody = $this->WrapText($this->AltBody, $this->WordWrap);
        break;
      default:
        $this->Body = $this->WrapText($this->Body, $this->WordWrap);
        break;
    }
  }

  /**
   * Assembles message header.
   * @access public
   * @return string The assembled header
   */
  public function CreateHeader() {
    $result = '';

    // Set the boundaries
    $uniq_id = md5(uniqid(time()));
    $this->boundary[1] = 'b1_' . $uniq_id;
    $this->boundary[2] = 'b2_' . $uniq_id;

    $result .= $this->HeaderLine('Date', self::RFCDate());
    if($this->Sender == '') {
      $result .= $this->HeaderLine('Return-Path', trim($this->From));
    } else {
      $result .= $this->HeaderLine('Return-Path', trim($this->Sender));
    }

    // To be created automatically by mail()
    if($this->Mailer != 'mail') {
      if ($this->SingleTo === true) {
        foreach($this->to as $t) {
          $this->SingleToArray[] = $this->AddrFormat($t);
        }
      } else {
        if(count($this->to) > 0) {
          $result .= $this->AddrAppend('To', $this->to);
        } elseif (count($this->cc) == 0) {
          $result .= $this->HeaderLine('To', 'undisclosed-recipients:;');
        }
      }
    }

    $from = array();
    $from[0][0] = trim($this->From);
    $from[0][1] = $this->FromName;
    $result .= $this->AddrAppend('From', $from);

    // sendmail and mail() extract Cc from the header before sending
    if(count($this->cc) > 0) {
      $result .= $this->AddrAppend('Cc', $this->cc);
    }

    // sendmail and mail() extract Bcc from the header before sending
    if((($this->Mailer == 'sendmail') || ($this->Mailer == 'mail')) && (count($this->bcc) > 0)) {
      $result .= $this->AddrAppend('Bcc', $this->bcc);
    }

    if(count($this->ReplyTo) > 0) {
      $result .= $this->AddrAppend('Reply-to', $this->ReplyTo);
    }

    // mail() sets the subject itself
    if($this->Mailer != 'mail') {
      $result .= $this->HeaderLine('Subject', $this->EncodeHeader($this->SecureHeader($this->Subject)));
    }

    if($this->MessageID != '') {
      $result .= $this->HeaderLine('Message-ID',$this->MessageID);
    } else {
      $result .= sprintf("Message-ID: <%s@%s>%s", $uniq_id, $this->ServerHostname(), $this->LE);
    }
    $result .= $this->HeaderLine('X-Priority', $this->Priority);
    $result .= $this->HeaderLine('X-Mailer', 'PHPMailer '.$this->Version.' (phpmailer.sourceforge.net)');

    if($this->ConfirmReadingTo != '') {
      $result .= $this->HeaderLine('Disposition-Notification-To', '<' . trim($this->ConfirmReadingTo) . '>');
    }

    // Add custom headers
    for($index = 0; $index < count($this->CustomHeader); $index++) {
      $result .= $this->HeaderLine(trim($this->CustomHeader[$index][0]), $this->EncodeHeader(trim($this->CustomHeader[$index][1])));
    }
    if (!$this->sign_key_file) {
      $result .= $this->HeaderLine('MIME-Version', '1.0');
      $result .= $this->GetMailMIME();
    }

    return $result;
  }

  /**
   * Returns the message MIME.
   * @access public
   * @return string
   */
  public function GetMailMIME() {
    $result = '';
    switch($this->message_type) {
      case 'plain':
        $result .= $this->HeaderLine('Content-Transfer-Encoding', $this->Encoding);
        $result .= sprintf("Content-Type: %s; charset=\"%s\"", $this->ContentType, $this->CharSet);
        break;
      case 'attachments':
      case 'alt_attachments':
        if($this->InlineImageExists()){
          $result .= sprintf("Content-Type: %s;%s\ttype=\"text/html\";%s\tboundary=\"%s\"%s", 'multipart/related', $this->LE, $this->LE, $this->boundary[1], $this->LE);
        } else {
          $result .= $this->HeaderLine('Content-Type', 'multipart/mixed;');
          $result .= $this->TextLine("\tboundary=\"" . $this->boundary[1] . '"');
        }
        break;
      case 'alt':
        $result .= $this->HeaderLine('Content-Type', 'multipart/alternative;');
        $result .= $this->TextLine("\tboundary=\"" . $this->boundary[1] . '"');
        break;
    }

    if($this->Mailer != 'mail') {
      $result .= $this->LE.$this->LE;
    }

    return $result;
  }

  /**
   * Assembles the message body.  Returns an empty string on failure.
   * @access public
   * @return string The assembled message body
   */
  public function CreateBody() {
    $body = '';

    if ($this->sign_key_file) {
      $body .= $this->GetMailMIME();
    }

    $this->SetWordWrap();

    switch($this->message_type) {
      case 'alt':
        $body .= $this->GetBoundary($this->boundary[1], '', 'text/plain', '');
        $body .= $this->EncodeString($this->AltBody, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->GetBoundary($this->boundary[1], '', 'text/html', '');
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->EndBoundary($this->boundary[1]);
        break;
      case 'plain':
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        break;
      case 'attachments':
        $body .= $this->GetBoundary($this->boundary[1], '', '', '');
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        $body .= $this->LE;
        $body .= $this->AttachAll();
        break;
      case 'alt_attachments':
        $body .= sprintf("--%s%s", $this->boundary[1], $this->LE);
        $body .= sprintf("Content-Type: %s;%s" . "\tboundary=\"%s\"%s", 'multipart/alternative', $this->LE, $this->boundary[2], $this->LE.$this->LE);
        $body .= $this->GetBoundary($this->boundary[2], '', 'text/plain', '') . $this->LE; // Create text body
        $body .= $this->EncodeString($this->AltBody, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->GetBoundary($this->boundary[2], '', 'text/html', '') . $this->LE; // Create the HTML body
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->EndBoundary($this->boundary[2]);
        $body .= $this->AttachAll();
        break;
    }

    if ($this->IsError()) {
      $body = '';
    } elseif ($this->sign_key_file) {
      try {
        $file = tempnam('', 'mail');
        file_put_contents($file, $body); //TODO check this worked
        $signed = tempnam("", "signed");
        if (@openssl_pkcs7_sign($file, $signed, "file://".$this->sign_cert_file, array("file://".$this->sign_key_file, $this->sign_key_pass), NULL)) {
          @unlink($file);
          @unlink($signed);
          $body = file_get_contents($signed);
        } else {
          @unlink($file);
          @unlink($signed);
          throw new phpmailerException($this->Lang("signing").openssl_error_string());
        }
      } catch (phpmailerException $e) {
        $body = '';
        if ($this->exceptions) {
          throw $e;
        }
      }
    }

    return $body;
  }

  /**
   * Returns the start of a message boundary.
   * @access private
   */
  private function GetBoundary($boundary, $charSet, $contentType, $encoding) {
    $result = '';
    if($charSet == '') {
      $charSet = $this->CharSet;
    }
    if($contentType == '') {
      $contentType = $this->ContentType;
    }
    if($encoding == '') {
      $encoding = $this->Encoding;
    }
    $result .= $this->TextLine('--' . $boundary);
    $result .= sprintf("Content-Type: %s; charset = \"%s\"", $contentType, $charSet);
    $result .= $this->LE;
    $result .= $this->HeaderLine('Content-Transfer-Encoding', $encoding);
    $result .= $this->LE;

    return $result;
  }

  /**
   * Returns the end of a message boundary.
   * @access private
   */
  private function EndBoundary($boundary) {
    return $this->LE . '--' . $boundary . '--' . $this->LE;
  }

  /**
   * Sets the message type.
   * @access private
   * @return void
   */
  private function SetMessageType() {
    if(count($this->attachment) < 1 && strlen($this->AltBody) < 1) {
      $this->message_type = 'plain';
    } else {
      if(count($this->attachment) > 0) {
        $this->message_type = 'attachments';
      }
      if(strlen($this->AltBody) > 0 && count($this->attachment) < 1) {
        $this->message_type = 'alt';
      }
      if(strlen($this->AltBody) > 0 && count($this->attachment) > 0) {
        $this->message_type = 'alt_attachments';
      }
    }
  }

  /**
   *  Returns a formatted header line.
   * @access public
   * @return string
   */
  public function HeaderLine($name, $value) {
    return $name . ': ' . $value . $this->LE;
  }

  /**
   * Returns a formatted mail line.
   * @access public
   * @return string
   */
  public function TextLine($value) {
    return $value . $this->LE;
  }

  /////////////////////////////////////////////////
  // CLASS METHODS, ATTACHMENTS
  /////////////////////////////////////////////////

  /**
   * Adds an attachment from a path on the filesystem.
   * Returns false if the file could not be found
   * or accessed.
   * @param string $path Path to the attachment.
   * @param string $name Overrides the attachment name.
   * @param string $encoding File encoding (see $Encoding).
   * @param string $type File extension (MIME) type.
   * @return bool
   */
  public function AddAttachment($path, $name = '', $encoding = 'base64', $type = 'application/octet-stream') {
    try {
      if ( !@is_file($path) ) {
        throw new phpmailerException($this->Lang('file_access') . $path, self::STOP_CONTINUE);
      }
      $filename = basename($path);
      if ( $name == '' ) {
        $name = $filename;
      }

      $this->attachment[] = array(
        0 => $path,
        1 => $filename,
        2 => $name,
        3 => $encoding,
        4 => $type,
        5 => false,  // isStringAttachment
        6 => 'attachment',
        7 => 0
      );

    } catch (phpmailerException $e) {
      $this->SetError($e->getMessage());
      if ($this->exceptions) {
        throw $e;
      }
      echo $e->getMessage()."\n";
      if ( $e->getCode() == self::STOP_CRITICAL ) {
        return false;
      }
    }
    return true;
  }

  /**
  * Return the current array of attachments
  * @return array
  */
  public function GetAttachments() {
    return $this->attachment;
  }

  /**
   * Attaches all fs, string, and binary attachments to the message.
   * Returns an empty string on failure.
   * @access private
   * @return string
   */
  private function AttachAll() {
    // Return text of body
    $mime = array();
    $cidUniq = array();
    $incl = array();

    // Add all attachments
    foreach ($this->attachment as $attachment) {
      // Check for string attachment
      $bString = $attachment[5];
      if ($bString) {
        $string = $attachment[0];
      } else {
        $path = $attachment[0];
      }

      if (in_array($attachment[0], $incl)) { continue; }
      $filename    = $attachment[1];
      $name        = $attachment[2];
      $encoding    = $attachment[3];
      $type        = $attachment[4];
      $disposition = $attachment[6];
      $cid         = $attachment[7];
      $incl[]      = $attachment[0];
      if ( $disposition == 'inline' && isset($cidUniq[$cid]) ) { continue; }
      $cidUniq[$cid] = true;

      $mime[] = sprintf("--%s%s", $this->boundary[1], $this->LE);
      $mime[] = sprintf("Content-Type: %s; name=\"%s\"%s", $type, $this->EncodeHeader($this->SecureHeader($name)), $this->LE);
      $mime[] = sprintf("Content-Transfer-Encoding: %s%s", $encoding, $this->LE);

      if($disposition == 'inline') {
        $mime[] = sprintf("Content-ID: <%s>%s", $cid, $this->LE);
      }

      $mime[] = sprintf("Content-Disposition: %s; filename=\"%s\"%s", $disposition, $this->EncodeHeader($this->SecureHeader($name)), $this->LE.$this->LE);

      // Encode as string attachment
      if($bString) {
        $mime[] = $this->EncodeString($string, $encoding);
        if($this->IsError()) {
          return '';
        }
        $mime[] = $this->LE.$this->LE;
      } else {
        $mime[] = $this->EncodeFile($path, $encoding);
        if($this->IsError()) {
          return '';
        }
        $mime[] = $this->LE.$this->LE;
      }
    }

    $mime[] = sprintf("--%s--%s", $this->boundary[1], $this->LE);

    return join('', $mime);
  }

  /**
   * Encodes attachment in requested format.
   * Returns an empty string on failure.
   * @param string $path The full path to the file
   * @param string $encoding The encoding to use; one of 'base64', '7bit', '8bit', 'binary', 'quoted-printable'
   * @see EncodeFile()
   * @access private
   * @return string
   */
  private function EncodeFile($path, $encoding = 'base64') {
    try {
      if (!is_readable($path)) {
        throw new phpmailerException($this->Lang('file_open') . $path, self::STOP_CONTINUE);
      }
      if (function_exists('get_magic_quotes')) {
        function get_magic_quotes() {
          return false;
        }
      }
      if (PHP_VERSION < 6) {
        $magic_quotes = get_magic_quotes_runtime();
        set_magic_quotes_runtime(0);
      }
      $file_buffer  = file_get_contents($path);
      $file_buffer  = $this->EncodeString($file_buffer, $encoding);
      if (PHP_VERSION < 6) { set_magic_quotes_runtime($magic_quotes); }
      return $file_buffer;
    } catch (Exception $e) {
      $this->SetError($e->getMessage());
      return '';
    }
  }

  /**
   * Encodes string to requested format.
   * Returns an empty string on failure.
   * @param string $str The text to encode
   * @param string $encoding The encoding to use; one of 'base64', '7bit', '8bit', 'binary', 'quoted-printable'
   * @access public
   * @return string
   */
  public function EncodeString ($str, $encoding = 'base64') {
    $encoded = '';
    switch(strtolower($encoding)) {
      case 'base64':
        $encoded = chunk_split(base64_encode($str), 76, $this->LE);
        break;
      case '7bit':
      case '8bit':
        $encoded = $this->FixEOL($str);
        //Make sure it ends with a line break
        if (substr($encoded, -(strlen($this->LE))) != $this->LE)
          $encoded .= $this->LE;
        break;
      case 'binary':
        $encoded = $str;
        break;
      case 'quoted-printable':
        $encoded = $this->EncodeQP($str);
        break;
      default:
        $this->SetError($this->Lang('encoding') . $encoding);
        break;
    }
    return $encoded;
  }

  /**
   * Encode a header string to best (shortest) of Q, B, quoted or none.
   * @access public
   * @return string
   */
  public function EncodeHeader($str, $position = 'text') {
    $x = 0;

    switch (strtolower($position)) {
      case 'phrase':
        if (!preg_match('/[\200-\377]/', $str)) {
          // Can't use addslashes as we don't know what value has magic_quotes_sybase
          $encoded = addcslashes($str, "\0..\37\177\\\"");
          if (($str == $encoded) && !preg_match('/[^A-Za-z0-9!#$%&\'*+\/=?^_`{|}~ -]/', $str)) {
            return ($encoded);
          } else {
            return ("\"$encoded\"");
          }
        }
        $x = preg_match_all('/[^\040\041\043-\133\135-\176]/', $str, $matches);
        break;
      case 'comment':
        $x = preg_match_all('/[()"]/', $str, $matches);
        // Fall-through
      case 'text':
      default:
        $x += preg_match_all('/[\000-\010\013\014\016-\037\177-\377]/', $str, $matches);
        break;
    }

    if ($x == 0) {
      return ($str);
    }

    $maxlen = 75 - 7 - strlen($this->CharSet);
    // Try to select the encoding which should produce the shortest output
    if (strlen($str)/3 < $x) {
      $encoding = 'B';
      if (function_exists('mb_strlen') && $this->HasMultiBytes($str)) {
        // Use a custom function which correctly encodes and wraps long
        // multibyte strings without breaking lines within a character
        $encoded = $this->Base64EncodeWrapMB($str);
      } else {
        $encoded = base64_encode($str);
        $maxlen -= $maxlen % 4;
        $encoded = trim(chunk_split($encoded, $maxlen, "\n"));
      }
    } else {
      $encoding = 'Q';
      $encoded = $this->EncodeQ($str, $position);
      $encoded = $this->WrapText($encoded, $maxlen, true);
      $encoded = str_replace('='.$this->LE, "\n", trim($encoded));
    }

    $encoded = preg_replace('/^(.*)$/m', " =?".$this->CharSet."?$encoding?\\1?=", $encoded);
    $encoded = trim(str_replace("\n", $this->LE, $encoded));

    return $encoded;
  }

  /**
   * Checks if a string contains multibyte characters.
   * @access public
   * @param string $str multi-byte text to wrap encode
   * @return bool
   */
  public function HasMultiBytes($str) {
    if (function_exists('mb_strlen')) {
      return (strlen($str) > mb_strlen($str, $this->CharSet));
    } else { // Assume no multibytes (we can't handle without mbstring functions anyway)
      return false;
    }
  }

  /**
   * Correctly encodes and wraps long multibyte strings for mail headers
   * without breaking lines within a character.
   * Adapted from a function by paravoid at http://uk.php.net/manual/en/function.mb-encode-mimeheader.php
   * @access public
   * @param string $str multi-byte text to wrap encode
   * @return string
   */
  public function Base64EncodeWrapMB($str) {
    $start = "=?".$this->CharSet."?B?";
    $end = "?=";
    $encoded = "";

    $mb_length = mb_strlen($str, $this->CharSet);
    // Each line must have length <= 75, including $start and $end
    $length = 75 - strlen($start) - strlen($end);
    // Average multi-byte ratio
    $ratio = $mb_length / strlen($str);
    // Base64 has a 4:3 ratio
    $offset = $avgLength = floor($length * $ratio * .75);

    for ($i = 0; $i < $mb_length; $i += $offset) {
      $lookBack = 0;

      do {
        $offset = $avgLength - $lookBack;
        $chunk = mb_substr($str, $i, $offset, $this->CharSet);
        $chunk = base64_encode($chunk);
        $lookBack++;
      }
      while (strlen($chunk) > $length);

      $encoded .= $chunk . $this->LE;
    }

    // Chomp the last linefeed
    $encoded = substr($encoded, 0, -strlen($this->LE));
    return $encoded;
  }

  /**
  * Encode string to quoted-printable.
  * Only uses standard PHP, slow, but will always work
  * @access public
  * @param string $string the text to encode
  * @param integer $line_max Number of chars allowed on a line before wrapping
  * @return string
  */
  public function EncodeQPphp( $input = '', $line_max = 76, $space_conv = false) {
    $hex = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
    $lines = preg_split('/(?:\r\n|\r|\n)/', $input);
    $eol = "\r\n";
    $escape = '=';
    $output = '';
    while( list(, $line) = each($lines) ) {
      $linlen = strlen($line);
      $newline = '';
      for($i = 0; $i < $linlen; $i++) {
        $c = substr( $line, $i, 1 );
        $dec = ord( $c );
        if ( ( $i == 0 ) && ( $dec == 46 ) ) { // convert first point in the line into =2E
          $c = '=2E';
        }
        if ( $dec == 32 ) {
          if ( $i == ( $linlen - 1 ) ) { // convert space at eol only
            $c = '=20';
          } else if ( $space_conv ) {
            $c = '=20';
          }
        } elseif ( ($dec == 61) || ($dec < 32 ) || ($dec > 126) ) { // always encode "\t", which is *not* required
          $h2 = floor($dec/16);
          $h1 = floor($dec%16);
          $c = $escape.$hex[$h2].$hex[$h1];
        }
        if ( (strlen($newline) + strlen($c)) >= $line_max ) { // CRLF is not counted
          $output .= $newline.$escape.$eol; //  soft line break; " =\r\n" is okay
          $newline = '';
          // check if newline first character will be point or not
          if ( $dec == 46 ) {
            $c = '=2E';
          }
        }
        $newline .= $c;
      } // end of for
      $output .= $newline.$eol;
    } // end of while
    return $output;
  }

  /**
  * Encode string to RFC2045 (6.7) quoted-printable format
  * Uses a PHP5 stream filter to do the encoding about 64x faster than the old version
  * Also results in same content as you started with after decoding
  * @see EncodeQPphp()
  * @access public
  * @param string $string the text to encode
  * @param integer $line_max Number of chars allowed on a line before wrapping
  * @param boolean $space_conv Dummy param for compatibility with existing EncodeQP function
  * @return string
  * @author Marcus Bointon
  */
  public function EncodeQP($string, $line_max = 76, $space_conv = false) {
    if (function_exists('quoted_printable_encode')) { //Use native function if it's available (>= PHP5.3)
      return quoted_printable_encode($string);
    }
    $filters = stream_get_filters();
    if (!in_array('convert.*', $filters)) { //Got convert stream filter?
      return $this->EncodeQPphp($string, $line_max, $space_conv); //Fall back to old implementation
    }
    $fp = fopen('php://temp/', 'r+');
    $string = preg_replace('/\r\n?/', $this->LE, $string); //Normalise line breaks
    $params = array('line-length' => $line_max, 'line-break-chars' => $this->LE);
    $s = stream_filter_append($fp, 'convert.quoted-printable-encode', STREAM_FILTER_READ, $params);
    fputs($fp, $string);
    rewind($fp);
    $out = stream_get_contents($fp);
    stream_filter_remove($s);
    $out = preg_replace('/^\./m', '=2E', $out); //Encode . if it is first char on a line, workaround for bug in Exchange
    fclose($fp);
    return $out;
  }

  /**
   * Encode string to q encoding.
   * @link http://tools.ietf.org/html/rfc2047
   * @param string $str the text to encode
   * @param string $position Where the text is going to be used, see the RFC for what that means
   * @access public
   * @return string
   */
  public function EncodeQ ($str, $position = 'text') {
    // There should not be any EOL in the string
    $encoded = preg_replace('/[\r\n]*/', '', $str);

    switch (strtolower($position)) {
      case 'phrase':
        $encoded = preg_replace("/([^A-Za-z0-9!*+\/ -])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
        break;
      case 'comment':
        $encoded = preg_replace("/([\(\)\"])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
      case 'text':
      default:
        // Replace every high ascii, control =, ? and _ characters
        //TODO using /e (equivalent to eval()) is probably not a good idea
        $encoded = preg_replace('/([\000-\011\013\014\016-\037\075\077\137\177-\377])/e',
              "'='.sprintf('%02X', ord('\\1'))", $encoded);
        break;
    }

    // Replace every spaces to _ (more readable than =20)
    $encoded = str_replace(' ', '_', $encoded);

    return $encoded;
  }

  /**
   * Adds a string or binary attachment (non-filesystem) to the list.
   * This method can be used to attach ascii or binary data,
   * such as a BLOB record from a database.
   * @param string $string String attachment data.
   * @param string $filename Name of the attachment.
   * @param string $encoding File encoding (see $Encoding).
   * @param string $type File extension (MIME) type.
   * @return void
   */
  public function AddStringAttachment($string, $filename, $encoding = 'base64', $type = 'application/octet-stream') {
    // Append to $attachment array
    $this->attachment[] = array(
      0 => $string,
      1 => $filename,
      2 => basename($filename),
      3 => $encoding,
      4 => $type,
      5 => true,  // isStringAttachment
      6 => 'attachment',
      7 => 0
    );
  }

  /**
   * Adds an embedded attachment.  This can include images, sounds, and
   * just about any other document.  Make sure to set the $type to an
   * image type.  For JPEG images use "image/jpeg" and for GIF images
   * use "image/gif".
   * @param string $path Path to the attachment.
   * @param string $cid Content ID of the attachment.  Use this to identify
   *        the Id for accessing the image in an HTML form.
   * @param string $name Overrides the attachment name.
   * @param string $encoding File encoding (see $Encoding).
   * @param string $type File extension (MIME) type.
   * @return bool
   */
  public function AddEmbeddedImage($path, $cid, $name = '', $encoding = 'base64', $type = 'application/octet-stream') {

    if ( !@is_file($path) ) {
      $this->SetError($this->Lang('file_access') . $path);
      return false;
    }

    $filename = basename($path);
    if ( $name == '' ) {
      $name = $filename;
    }

    // Append to $attachment array
    $this->attachment[] = array(
      0 => $path,
      1 => $filename,
      2 => $name,
      3 => $encoding,
      4 => $type,
      5 => false,  // isStringAttachment
      6 => 'inline',
      7 => $cid
    );

    return true;
  }

  /**
   * Returns true if an inline attachment is present.
   * @access public
   * @return bool
   */
  public function InlineImageExists() {
    foreach($this->attachment as $attachment) {
      if ($attachment[6] == 'inline') {
        return true;
      }
    }
    return false;
  }

  /////////////////////////////////////////////////
  // CLASS METHODS, MESSAGE RESET
  /////////////////////////////////////////////////

  /**
   * Clears all recipients assigned in the TO array.  Returns void.
   * @return void
   */
  public function ClearAddresses() {
    foreach($this->to as $to) {
      unset($this->all_recipients[strtolower($to[0])]);
    }
    $this->to = array();
  }

  /**
   * Clears all recipients assigned in the CC array.  Returns void.
   * @return void
   */
  public function ClearCCs() {
    foreach($this->cc as $cc) {
      unset($this->all_recipients[strtolower($cc[0])]);
    }
    $this->cc = array();
  }

  /**
   * Clears all recipients assigned in the BCC array.  Returns void.
   * @return void
   */
  public function ClearBCCs() {
    foreach($this->bcc as $bcc) {
      unset($this->all_recipients[strtolower($bcc[0])]);
    }
    $this->bcc = array();
  }

  /**
   * Clears all recipients assigned in the ReplyTo array.  Returns void.
   * @return void
   */
  public function ClearReplyTos() {
    $this->ReplyTo = array();
  }

  /**
   * Clears all recipients assigned in the TO, CC and BCC
   * array.  Returns void.
   * @return void
   */
  public function ClearAllRecipients() {
    $this->to = array();
    $this->cc = array();
    $this->bcc = array();
    $this->all_recipients = array();
  }

  /**
   * Clears all previously set filesystem, string, and binary
   * attachments.  Returns void.
   * @return void
   */
  public function ClearAttachments() {
    $this->attachment = array();
  }

  /**
   * Clears all custom headers.  Returns void.
   * @return void
   */
  public function ClearCustomHeaders() {
    $this->CustomHeader = array();
  }

  /////////////////////////////////////////////////
  // CLASS METHODS, MISCELLANEOUS
  /////////////////////////////////////////////////

  /**
   * Adds the error message to the error container.
   * @access protected
   * @return void
   */
  protected function SetError($msg) {
    $this->error_count++;
    if ($this->Mailer == 'smtp' and !is_null($this->smtp)) {
      $lasterror = $this->smtp->getError();
      if (!empty($lasterror) and array_key_exists('smtp_msg', $lasterror)) {
        $msg .= '<p>' . $this->Lang('smtp_error') . $lasterror['smtp_msg'] . "</p>\n";
      }
    }
    $this->ErrorInfo = $msg;
  }

  /**
   * Returns the proper RFC 822 formatted date.
   * @access public
   * @return string
   * @static
   */
  public static function RFCDate() {
    $tz = date('Z');
    $tzs = ($tz < 0) ? '-' : '+';
    $tz = abs($tz);
    $tz = (int)($tz/3600)*100 + ($tz%3600)/60;
    $result = sprintf("%s %s%04d", date('D, j M Y H:i:s'), $tzs, $tz);

    return $result;
  }

  /**
   * Returns the server hostname or 'localhost.localdomain' if unknown.
   * @access private
   * @return string
   */
  private function ServerHostname() {
    if (!empty($this->Hostname)) {
      $result = $this->Hostname;
    } elseif (isset($_SERVER['SERVER_NAME'])) {
      $result = $_SERVER['SERVER_NAME'];
    } else {
      $result = 'localhost.localdomain';
    }

    return $result;
  }

  /**
   * Returns a message in the appropriate language.
   * @access private
   * @return string
   */
  private function Lang($key) {
    if(count($this->language) < 1) {
      $this->SetLanguage('en'); // set the default language
    }

    if(isset($this->language[$key])) {
      return $this->language[$key];
    } else {
      return 'Language string failed to load: ' . $key;
    }
  }

  /**
   * Returns true if an error occurred.
   * @access public
   * @return bool
   */
  public function IsError() {
    return ($this->error_count > 0);
  }

  /**
   * Changes every end of line from CR or LF to CRLF.
   * @access private
   * @return string
   */
  private function FixEOL($str) {
    $str = str_replace("\r\n", "\n", $str);
    $str = str_replace("\r", "\n", $str);
    $str = str_replace("\n", $this->LE, $str);
    return $str;
  }

  /**
   * Adds a custom header.
   * @access public
   * @return void
   */
  public function AddCustomHeader($custom_header) {
    $this->CustomHeader[] = explode(':', $custom_header, 2);
  }

  /**
   * Evaluates the message and returns modifications for inline images and backgrounds
   * @access public
   * @return $message
   */
  public function MsgHTML($message, $basedir = '') {
    preg_match_all("/(src|background)=\"(.*)\"/Ui", $message, $images);
    if(isset($images[2])) {
      foreach($images[2] as $i => $url) {
        // do not change urls for absolute images (thanks to corvuscorax)
        if (!preg_match('#^[A-z]+://#',$url)) {
          $filename = basename($url);
          $directory = dirname($url);
          ($directory == '.')?$directory='':'';
          $cid = 'cid:' . md5($filename);
          $ext = pathinfo($filename, PATHINFO_EXTENSION);
          $mimeType  = self::_mime_types($ext);
          if ( strlen($basedir) > 1 && substr($basedir,-1) != '/') { $basedir .= '/'; }
          if ( strlen($directory) > 1 && substr($directory,-1) != '/') { $directory .= '/'; }
          if ( $this->AddEmbeddedImage($basedir.$directory.$filename, md5($filename), $filename, 'base64',$mimeType) ) {
            $message = preg_replace("/".$images[1][$i]."=\"".preg_quote($url, '/')."\"/Ui", $images[1][$i]."=\"".$cid."\"", $message);
          }
        }
      }
    }
    $this->IsHTML(true);
    $this->Body = $message;
    $textMsg = trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/s','',$message)));
    if (!empty($textMsg) && empty($this->AltBody)) {
      $this->AltBody = html_entity_decode($textMsg);
    }
    if (empty($this->AltBody)) {
      $this->AltBody = 'To view this email message, open it in a program that understands HTML!' . "\n\n";
    }
  }

  /**
   * Gets the MIME type of the embedded or inline image
   * @param string File extension
   * @access public
   * @return string MIME type of ext
   * @static
   */
  public static function _mime_types($ext = '') {
    $mimes = array(
      'hqx'   =>  'application/mac-binhex40',
      'cpt'   =>  'application/mac-compactpro',
      'doc'   =>  'application/msword',
      'bin'   =>  'application/macbinary',
      'dms'   =>  'application/octet-stream',
      'lha'   =>  'application/octet-stream',
      'lzh'   =>  'application/octet-stream',
      'exe'   =>  'application/octet-stream',
      'class' =>  'application/octet-stream',
      'psd'   =>  'application/octet-stream',
      'so'    =>  'application/octet-stream',
      'sea'   =>  'application/octet-stream',
      'dll'   =>  'application/octet-stream',
      'oda'   =>  'application/oda',
      'pdf'   =>  'application/pdf',
      'ai'    =>  'application/postscript',
      'eps'   =>  'application/postscript',
      'ps'    =>  'application/postscript',
      'smi'   =>  'application/smil',
      'smil'  =>  'application/smil',
      'mif'   =>  'application/vnd.mif',
      'xls'   =>  'application/vnd.ms-excel',
      'ppt'   =>  'application/vnd.ms-powerpoint',
      'wbxml' =>  'application/vnd.wap.wbxml',
      'wmlc'  =>  'application/vnd.wap.wmlc',
      'dcr'   =>  'application/x-director',
      'dir'   =>  'application/x-director',
      'dxr'   =>  'application/x-director',
      'dvi'   =>  'application/x-dvi',
      'gtar'  =>  'application/x-gtar',
      'php'   =>  'application/x-httpd-php',
      'php4'  =>  'application/x-httpd-php',
      'php3'  =>  'application/x-httpd-php',
      'phtml' =>  'application/x-httpd-php',
      'phps'  =>  'application/x-httpd-php-source',
      'js'    =>  'application/x-javascript',
      'swf'   =>  'application/x-shockwave-flash',
      'sit'   =>  'application/x-stuffit',
      'tar'   =>  'application/x-tar',
      'tgz'   =>  'application/x-tar',
      'xhtml' =>  'application/xhtml+xml',
      'xht'   =>  'application/xhtml+xml',
      'zip'   =>  'application/zip',
      'mid'   =>  'audio/midi',
      'midi'  =>  'audio/midi',
      'mpga'  =>  'audio/mpeg',
      'mp2'   =>  'audio/mpeg',
      'mp3'   =>  'audio/mpeg',
      'aif'   =>  'audio/x-aiff',
      'aiff'  =>  'audio/x-aiff',
      'aifc'  =>  'audio/x-aiff',
      'ram'   =>  'audio/x-pn-realaudio',
      'rm'    =>  'audio/x-pn-realaudio',
      'rpm'   =>  'audio/x-pn-realaudio-plugin',
      'ra'    =>  'audio/x-realaudio',
      'rv'    =>  'video/vnd.rn-realvideo',
      'wav'   =>  'audio/x-wav',
      'bmp'   =>  'image/bmp',
      'gif'   =>  'image/gif',
      'jpeg'  =>  'image/jpeg',
      'jpg'   =>  'image/jpeg',
      'jpe'   =>  'image/jpeg',
      'png'   =>  'image/png',
      'tiff'  =>  'image/tiff',
      'tif'   =>  'image/tiff',
      'css'   =>  'text/css',
      'html'  =>  'text/html',
      'htm'   =>  'text/html',
      'shtml' =>  'text/html',
      'txt'   =>  'text/plain',
      'text'  =>  'text/plain',
      'log'   =>  'text/plain',
      'rtx'   =>  'text/richtext',
      'rtf'   =>  'text/rtf',
      'xml'   =>  'text/xml',
      'xsl'   =>  'text/xml',
      'mpeg'  =>  'video/mpeg',
      'mpg'   =>  'video/mpeg',
      'mpe'   =>  'video/mpeg',
      'qt'    =>  'video/quicktime',
      'mov'   =>  'video/quicktime',
      'avi'   =>  'video/x-msvideo',
      'movie' =>  'video/x-sgi-movie',
      'doc'   =>  'application/msword',
      'word'  =>  'application/msword',
      'xl'    =>  'application/excel',
      'eml'   =>  'message/rfc822'
    );
    return (!isset($mimes[strtolower($ext)])) ? 'application/octet-stream' : $mimes[strtolower($ext)];
  }

  /**
  * Set (or reset) Class Objects (variables)
  *
  * Usage Example:
  * $page->set('X-Priority', '3');
  *
  * @access public
  * @param string $name Parameter Name
  * @param mixed $value Parameter Value
  * NOTE: will not work with arrays, there are no arrays to set/reset
  * @todo Should this not be using __set() magic function?
  */
  public function set($name, $value = '') {
    try {
      if (isset($this->$name) ) {
        $this->$name = $value;
      } else {
        throw new phpmailerException($this->Lang('variable_set') . $name, self::STOP_CRITICAL);
      }
    } catch (Exception $e) {
      $this->SetError($e->getMessage());
      if ($e->getCode() == self::STOP_CRITICAL) {
        return false;
      }
    }
    return true;
  }

  /**
   * Strips newlines to prevent header injection.
   * @access public
   * @param string $str String
   * @return string
   */
  public function SecureHeader($str) {
    $str = str_replace("\r", '', $str);
    $str = str_replace("\n", '', $str);
    return trim($str);
  }

  /**
   * Set the private key file and password to sign the message.
   *
   * @access public
   * @param string $key_filename Parameter File Name
   * @param string $key_pass Password for private key
   */
  public function Sign($cert_filename, $key_filename, $key_pass) {
    $this->sign_cert_file = $cert_filename;
    $this->sign_key_file = $key_filename;
    $this->sign_key_pass = $key_pass;
  }

  /**
   * Set the private key file and password to sign the message.
   *
   * @access public
   * @param string $key_filename Parameter File Name
   * @param string $key_pass Password for private key
   */
  public function DKIM_QP($txt) {
    $tmp="";
    $line="";
    for ($i=0;$i<strlen($txt);$i++) {
      $ord=ord($txt[$i]);
      if ( ((0x21 <= $ord) && ($ord <= 0x3A)) || $ord == 0x3C || ((0x3E <= $ord) && ($ord <= 0x7E)) ) {
        $line.=$txt[$i];
      } else {
        $line.="=".sprintf("%02X",$ord);
      }
    }
    return $line;
  }

  /**
   * Generate DKIM signature
   *
   * @access public
   * @param string $s Header
   */
  public function DKIM_Sign($s) {
    $privKeyStr = file_get_contents($this->DKIM_private);
    if ($this->DKIM_passphrase!='') {
      $privKey = openssl_pkey_get_private($privKeyStr,$this->DKIM_passphrase);
    } else {
      $privKey = $privKeyStr;
    }
    if (openssl_sign($s, $signature, $privKey)) {
      return base64_encode($signature);
    }
  }

  /**
   * Generate DKIM Canonicalization Header
   *
   * @access public
   * @param string $s Header
   */
  public function DKIM_HeaderC($s) {
    $s=preg_replace("/\r\n\s+/"," ",$s);
    $lines=explode("\r\n",$s);
    foreach ($lines as $key=>$line) {
      list($heading,$value)=explode(":",$line,2);
      $heading=strtolower($heading);
      $value=preg_replace("/\s+/"," ",$value) ; // Compress useless spaces
      $lines[$key]=$heading.":".trim($value) ; // Don't forget to remove WSP around the value
    }
    $s=implode("\r\n",$lines);
    return $s;
  }

  /**
   * Generate DKIM Canonicalization Body
   *
   * @access public
   * @param string $body Message Body
   */
  public function DKIM_BodyC($body) {
    if ($body == '') return "\r\n";
    // stabilize line endings
    $body=str_replace("\r\n","\n",$body);
    $body=str_replace("\n","\r\n",$body);
    // END stabilize line endings
    while (substr($body,strlen($body)-4,4) == "\r\n\r\n") {
      $body=substr($body,0,strlen($body)-2);
    }
    return $body;
  }

  /**
   * Create the DKIM header, body, as new header
   *
   * @access public
   * @param string $headers_line Header lines
   * @param string $subject Subject
   * @param string $body Body
   */
  public function DKIM_Add($headers_line,$subject,$body) {
    $DKIMsignatureType    = 'rsa-sha1'; // Signature & hash algorithms
    $DKIMcanonicalization = 'relaxed/simple'; // Canonicalization of header/body
    $DKIMquery            = 'dns/txt'; // Query method
    $DKIMtime             = time() ; // Signature Timestamp = seconds since 00:00:00 - Jan 1, 1970 (UTC time zone)
    $subject_header       = "Subject: $subject";
    $headers              = explode("\r\n",$headers_line);
    foreach($headers as $header) {
      if (strpos($header,'From:') === 0) {
        $from_header=$header;
      } elseif (strpos($header,'To:') === 0) {
        $to_header=$header;
      }
    }
    $from     = str_replace('|','=7C',$this->DKIM_QP($from_header));
    $to       = str_replace('|','=7C',$this->DKIM_QP($to_header));
    $subject  = str_replace('|','=7C',$this->DKIM_QP($subject_header)) ; // Copied header fields (dkim-quoted-printable
    $body     = $this->DKIM_BodyC($body);
    $DKIMlen  = strlen($body) ; // Length of body
    $DKIMb64  = base64_encode(pack("H*", sha1($body))) ; // Base64 of packed binary SHA-1 hash of body
    $ident    = ($this->DKIM_identity == '')? '' : " i=" . $this->DKIM_identity . ";";
    $dkimhdrs = "DKIM-Signature: v=1; a=" . $DKIMsignatureType . "; q=" . $DKIMquery . "; l=" . $DKIMlen . "; s=" . $this->DKIM_selector . ";\r\n".
                "\tt=" . $DKIMtime . "; c=" . $DKIMcanonicalization . ";\r\n".
                "\th=From:To:Subject;\r\n".
                "\td=" . $this->DKIM_domain . ";" . $ident . "\r\n".
                "\tz=$from\r\n".
                "\t|$to\r\n".
                "\t|$subject;\r\n".
                "\tbh=" . $DKIMb64 . ";\r\n".
                "\tb=";
    $toSign   = $this->DKIM_HeaderC($from_header . "\r\n" . $to_header . "\r\n" . $subject_header . "\r\n" . $dkimhdrs);
    $signed   = $this->DKIM_Sign($toSign);
    return "X-PHPMAILER-DKIM: phpmailer.worxware.com\r\n".$dkimhdrs.$signed."\r\n";
  }

  protected function doCallback($isSent,$to,$cc,$bcc,$subject,$body) {
    if (!empty($this->action_function) && function_exists($this->action_function)) {
      $params = array($isSent,$to,$cc,$bcc,$subject,$body);
      call_user_func_array($this->action_function,$params);
    }
  }
}

class phpmailerException extends Exception {
  public function errorMessage() {
    $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
    return $errorMsg;
  }
}

/**
 * PHPMailer - PHP SMTP email transport class
 * NOTE: Designed for use with PHP version 5 and up
 * @package PHPMailer
 * @author Andy Prevost
 * @author Marcus Bointon
 * @copyright 2004 - 2008 Andy Prevost
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 * @version $Id: class.smtp.php 444 2009-05-05 11:22:26Z coolbru $
 */

/**
 * SMTP is rfc 821 compliant and implements all the rfc 821 SMTP
 * commands except TURN which will always return a not implemented
 * error. SMTP also provides some utility methods for sending mail
 * to an SMTP server.
 * original author: Chris Ryan
 */

class SMTP {
  /**
   *  SMTP server port
   *  @var int
   */
  public $SMTP_PORT = 25;

  /**
   *  SMTP reply line ending
   *  @var string
   */
  public $CRLF = "\r\n";

  /**
   *  Sets whether debugging is turned on
   *  @var bool
   */
  public $do_debug;       // the level of debug to perform

  /**
   *  Sets VERP use on/off (default is off)
   *  @var bool
   */
  public $do_verp = false;

  /////////////////////////////////////////////////
  // PROPERTIES, PRIVATE AND PROTECTED
  /////////////////////////////////////////////////

  private $smtp_conn; // the socket to the server
  private $error;     // error if any on the last call
  private $helo_rply; // the reply the server sent to us for HELO

  /**
   * Initialize the class so that the data is in a known state.
   * @access public
   * @return void
   */
  public function __construct() {
    $this->smtp_conn = 0;
    $this->error = null;
    $this->helo_rply = null;

    $this->do_debug = 0;
  }

  /////////////////////////////////////////////////
  // CONNECTION FUNCTIONS
  /////////////////////////////////////////////////

  /**
   * Connect to the server specified on the port specified.
   * If the port is not specified use the default SMTP_PORT.
   * If tval is specified then a connection will try and be
   * established with the server for that number of seconds.
   * If tval is not specified the default is 30 seconds to
   * try on the connection.
   *
   * SMTP CODE SUCCESS: 220
   * SMTP CODE FAILURE: 421
   * @access public
   * @return bool
   */
  public function Connect($host, $port = 0, $tval = 30) {
    // set the error val to null so there is no confusion
    $this->error = null;

    // make sure we are __not__ connected
    if($this->connected()) {
      // already connected, generate error
      $this->error = array("error" => "Already connected to a server");
      return false;
    }

    if(empty($port)) {
      $port = $this->SMTP_PORT;
    }

    // connect to the smtp server
    $this->smtp_conn = @fsockopen($host,    // the host of the server
                                 $port,    // the port to use
                                 $errno,   // error number if any
                                 $errstr,  // error message if any
                                 $tval);   // give up after ? secs
    // verify we connected properly
    if(empty($this->smtp_conn)) {
      $this->error = array("error" => "Failed to connect to server",
                           "errno" => $errno,
                           "errstr" => $errstr);
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": $errstr ($errno)" . $this->CRLF . '<br />';
      }
      return false;
    }

    // SMTP server can take longer to respond, give longer timeout for first read
    // Windows does not have support for this timeout function
    if(substr(PHP_OS, 0, 3) != "WIN")
     socket_set_timeout($this->smtp_conn, $tval, 0);

    // get any announcement
    $announce = $this->get_lines();

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $announce . $this->CRLF . '<br />';
    }

    return true;
  }

  /**
   * Initiate a TLS communication with the server.
   *
   * SMTP CODE 220 Ready to start TLS
   * SMTP CODE 501 Syntax error (no parameters allowed)
   * SMTP CODE 454 TLS not available due to temporary reason
   * @access public
   * @return bool success
   */
  public function StartTLS() {
    $this->error = null; # to avoid confusion

    if(!$this->connected()) {
      $this->error = array("error" => "Called StartTLS() without being connected");
      return false;
    }

    fputs($this->smtp_conn,"STARTTLS" . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 220) {
      $this->error =
         array("error"     => "STARTTLS not accepted from server",
               "smtp_code" => $code,
               "smtp_msg"  => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    // Begin encrypted connection
    if(!stream_socket_enable_crypto($this->smtp_conn, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
      return false;
    }

    return true;
  }

  /**
   * Performs SMTP authentication.  Must be run after running the
   * Hello() method.  Returns true if successfully authenticated.
   * @access public
   * @return bool
   */
  public function Authenticate($username, $password) {
    // Start authentication
    fputs($this->smtp_conn,"AUTH LOGIN" . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($code != 334) {
      $this->error =
        array("error" => "AUTH not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    // Send encoded username
    fputs($this->smtp_conn, base64_encode($username) . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($code != 334) {
      $this->error =
        array("error" => "Username not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    // Send encoded password
    fputs($this->smtp_conn, base64_encode($password) . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($code != 235) {
      $this->error =
        array("error" => "Password not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    return true;
  }

  /**
   * Returns true if connected to a server otherwise false
   * @access public
   * @return bool
   */
  public function Connected() {
    if(!empty($this->smtp_conn)) {
      $sock_status = socket_get_status($this->smtp_conn);
      if($sock_status["eof"]) {
        // the socket is valid but we are not connected
        if($this->do_debug >= 1) {
            echo "SMTP -> NOTICE:" . $this->CRLF . "EOF caught while checking if connected";
        }
        $this->Close();
        return false;
      }
      return true; // everything looks good
    }
    return false;
  }

  /**
   * Closes the socket and cleans up the state of the class.
   * It is not considered good to use this function without
   * first trying to use QUIT.
   * @access public
   * @return void
   */
  public function Close() {
    $this->error = null; // so there is no confusion
    $this->helo_rply = null;
    if(!empty($this->smtp_conn)) {
      // close the connection and cleanup
      fclose($this->smtp_conn);
      $this->smtp_conn = 0;
    }
  }

  /////////////////////////////////////////////////
  // SMTP COMMANDS
  /////////////////////////////////////////////////

  /**
   * Issues a data command and sends the msg_data to the server
   * finializing the mail transaction. $msg_data is the message
   * that is to be send with the headers. Each header needs to be
   * on a single line followed by a <CRLF> with the message headers
   * and the message body being seperated by and additional <CRLF>.
   *
   * Implements rfc 821: DATA <CRLF>
   *
   * SMTP CODE INTERMEDIATE: 354
   *     [data]
   *     <CRLF>.<CRLF>
   *     SMTP CODE SUCCESS: 250
   *     SMTP CODE FAILURE: 552,554,451,452
   * SMTP CODE FAILURE: 451,554
   * SMTP CODE ERROR  : 500,501,503,421
   * @access public
   * @return bool
   */
  public function Data($msg_data) {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Data() without being connected");
      return false;
    }

    fputs($this->smtp_conn,"DATA" . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 354) {
      $this->error =
        array("error" => "DATA command not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    /* the server is ready to accept data!
     * according to rfc 821 we should not send more than 1000
     * including the CRLF
     * characters on a single line so we will break the data up
     * into lines by \r and/or \n then if needed we will break
     * each of those into smaller lines to fit within the limit.
     * in addition we will be looking for lines that start with
     * a period '.' and append and additional period '.' to that
     * line. NOTE: this does not count towards limit.
     */

    // normalize the line breaks so we know the explode works
    $msg_data = str_replace("\r\n","\n",$msg_data);
    $msg_data = str_replace("\r","\n",$msg_data);
    $lines = explode("\n",$msg_data);

    /* we need to find a good way to determine is headers are
     * in the msg_data or if it is a straight msg body
     * currently I am assuming rfc 822 definitions of msg headers
     * and if the first field of the first line (':' sperated)
     * does not contain a space then it _should_ be a header
     * and we can process all lines before a blank "" line as
     * headers.
     */

    $field = substr($lines[0],0,strpos($lines[0],":"));
    $in_headers = false;
    if(!empty($field) && !strstr($field," ")) {
      $in_headers = true;
    }

    $max_line_length = 998; // used below; set here for ease in change

    while(list(,$line) = @each($lines)) {
      $lines_out = null;
      if($line == "" && $in_headers) {
        $in_headers = false;
      }
      // ok we need to break this line up into several smaller lines
      while(strlen($line) > $max_line_length) {
        $pos = strrpos(substr($line,0,$max_line_length)," ");

        // Patch to fix DOS attack
        if(!$pos) {
          $pos = $max_line_length - 1;
          $lines_out[] = substr($line,0,$pos);
          $line = substr($line,$pos);
        } else {
          $lines_out[] = substr($line,0,$pos);
          $line = substr($line,$pos + 1);
        }

        /* if processing headers add a LWSP-char to the front of new line
         * rfc 822 on long msg headers
         */
        if($in_headers) {
          $line = "\t" . $line;
        }
      }
      $lines_out[] = $line;

      // send the lines to the server
      while(list(,$line_out) = @each($lines_out)) {
        if(strlen($line_out) > 0)
        {
          if(substr($line_out, 0, 1) == ".") {
            $line_out = "." . $line_out;
          }
        }
        fputs($this->smtp_conn,$line_out . $this->CRLF);
      }
    }

    // message data has been sent
    fputs($this->smtp_conn, $this->CRLF . "." . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 250) {
      $this->error =
        array("error" => "DATA not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }

  /**
   * Sends the HELO command to the smtp server.
   * This makes sure that we and the server are in
   * the same known state.
   *
   * Implements from rfc 821: HELO <SP> <domain> <CRLF>
   *
   * SMTP CODE SUCCESS: 250
   * SMTP CODE ERROR  : 500, 501, 504, 421
   * @access public
   * @return bool
   */
  public function Hello($host = '') {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
            "error" => "Called Hello() without being connected");
      return false;
    }

    // if hostname for HELO was not specified send default
    if(empty($host)) {
      // determine appropriate default to send to server
      $host = "localhost";
    }

    // Send extended hello first (RFC 2821)
    if(!$this->SendHello("EHLO", $host)) {
      if(!$this->SendHello("HELO", $host)) {
        return false;
      }
    }

    return true;
  }

  /**
   * Sends a HELO/EHLO command.
   * @access private
   * @return bool
   */
  private function SendHello($hello, $host) {
    fputs($this->smtp_conn, $hello . " " . $host . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER: " . $rply . $this->CRLF . '<br />';
    }

    if($code != 250) {
      $this->error =
        array("error" => $hello . " not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    $this->helo_rply = $rply;

    return true;
  }

  /**
   * Starts a mail transaction from the email address specified in
   * $from. Returns true if successful or false otherwise. If True
   * the mail transaction is started and then one or more Recipient
   * commands may be called followed by a Data command.
   *
   * Implements rfc 821: MAIL <SP> FROM:<reverse-path> <CRLF>
   *
   * SMTP CODE SUCCESS: 250
   * SMTP CODE SUCCESS: 552,451,452
   * SMTP CODE SUCCESS: 500,501,421
   * @access public
   * @return bool
   */
  public function Mail($from) {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Mail() without being connected");
      return false;
    }

    $useVerp = ($this->do_verp ? "XVERP" : "");
    fputs($this->smtp_conn,"MAIL FROM:<" . $from . ">" . $useVerp . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 250) {
      $this->error =
        array("error" => "MAIL not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }

  /**
   * Sends the quit command to the server and then closes the socket
   * if there is no error or the $close_on_error argument is true.
   *
   * Implements from rfc 821: QUIT <CRLF>
   *
   * SMTP CODE SUCCESS: 221
   * SMTP CODE ERROR  : 500
   * @access public
   * @return bool
   */
  public function Quit($close_on_error = true) {
    $this->error = null; // so there is no confusion

    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Quit() without being connected");
      return false;
    }

    // send the quit command to the server
    fputs($this->smtp_conn,"quit" . $this->CRLF);

    // get any good-bye messages
    $byemsg = $this->get_lines();

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $byemsg . $this->CRLF . '<br />';
    }

    $rval = true;
    $e = null;

    $code = substr($byemsg,0,3);
    if($code != 221) {
      // use e as a tmp var cause Close will overwrite $this->error
      $e = array("error" => "SMTP server rejected quit command",
                 "smtp_code" => $code,
                 "smtp_rply" => substr($byemsg,4));
      $rval = false;
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $e["error"] . ": " . $byemsg . $this->CRLF . '<br />';
      }
    }

    if(empty($e) || $close_on_error) {
      $this->Close();
    }

    return $rval;
  }

  /**
   * Sends the command RCPT to the SMTP server with the TO: argument of $to.
   * Returns true if the recipient was accepted false if it was rejected.
   *
   * Implements from rfc 821: RCPT <SP> TO:<forward-path> <CRLF>
   *
   * SMTP CODE SUCCESS: 250,251
   * SMTP CODE FAILURE: 550,551,552,553,450,451,452
   * SMTP CODE ERROR  : 500,501,503,421
   * @access public
   * @return bool
   */
  public function Recipient($to) {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Recipient() without being connected");
      return false;
    }

    fputs($this->smtp_conn,"RCPT TO:<" . $to . ">" . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 250 && $code != 251) {
      $this->error =
        array("error" => "RCPT not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }

  /**
   * Sends the RSET command to abort and transaction that is
   * currently in progress. Returns true if successful false
   * otherwise.
   *
   * Implements rfc 821: RSET <CRLF>
   *
   * SMTP CODE SUCCESS: 250
   * SMTP CODE ERROR  : 500,501,504,421
   * @access public
   * @return bool
   */
  public function Reset() {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Reset() without being connected");
      return false;
    }

    fputs($this->smtp_conn,"RSET" . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 250) {
      $this->error =
        array("error" => "RSET failed",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    return true;
  }

  /**
   * Starts a mail transaction from the email address specified in
   * $from. Returns true if successful or false otherwise. If True
   * the mail transaction is started and then one or more Recipient
   * commands may be called followed by a Data command. This command
   * will send the message to the users terminal if they are logged
   * in and send them an email.
   *
   * Implements rfc 821: SAML <SP> FROM:<reverse-path> <CRLF>
   *
   * SMTP CODE SUCCESS: 250
   * SMTP CODE SUCCESS: 552,451,452
   * SMTP CODE SUCCESS: 500,501,502,421
   * @access public
   * @return bool
   */
  public function SendAndMail($from) {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
          "error" => "Called SendAndMail() without being connected");
      return false;
    }

    fputs($this->smtp_conn,"SAML FROM:" . $from . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 250) {
      $this->error =
        array("error" => "SAML not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }

  /**
   * This is an optional command for SMTP that this class does not
   * support. This method is here to make the RFC821 Definition
   * complete for this class and __may__ be implimented in the future
   *
   * Implements from rfc 821: TURN <CRLF>
   *
   * SMTP CODE SUCCESS: 250
   * SMTP CODE FAILURE: 502
   * SMTP CODE ERROR  : 500, 503
   * @access public
   * @return bool
   */
  public function Turn() {
    $this->error = array("error" => "This method, TURN, of the SMTP ".
                                    "is not implemented");
    if($this->do_debug >= 1) {
      echo "SMTP -> NOTICE: " . $this->error["error"] . $this->CRLF . '<br />';
    }
    return false;
  }

  /**
  * Get the current error
  * @access public
  * @return array
  */
  public function getError() {
    return $this->error;
  }

  /////////////////////////////////////////////////
  // INTERNAL FUNCTIONS
  /////////////////////////////////////////////////

  /**
   * Read in as many lines as possible
   * either before eof or socket timeout occurs on the operation.
   * With SMTP we can tell if we have more lines to read if the
   * 4th character is '-' symbol. If it is a space then we don't
   * need to read anything else.
   * @access private
   * @return string
   */
  private function get_lines() {
    $data = "";
    while($str = @fgets($this->smtp_conn,515)) {
      if($this->do_debug >= 4) {
        echo "SMTP -> get_lines(): \$data was \"$data\"" . $this->CRLF . '<br />';
        echo "SMTP -> get_lines(): \$str is \"$str\"" . $this->CRLF . '<br />';
      }
      $data .= $str;
      if($this->do_debug >= 4) {
        echo "SMTP -> get_lines(): \$data is \"$data\"" . $this->CRLF . '<br />';
      }
      // if 4th character is a space, we are done reading, break the loop
      if(substr($str,3,1) == " ") { break; }
    }
    return $data;
  }

}


//邮件发送类,基于PHPMailer类
//静态类
class Email
{
	static public $config;//存储配置的静态变量
	//设定邮件参数
    static public function init($config = array()) 
    {
 		self::$config['SMTP_HOST']=isset($config['SMTP_HOST'])?$config['SMTP_HOST']:'smtp.qq.com';//smtp服务器地址
		self::$config['SMTP_PORT']=isset($config['SMTP_PORT'])?$config['SMTP_PORT']:25;//smtp服务器端口
		self::$config['SMTP_SSL']=isset($config['SMTP_SSL'])?$config['SMTP_SSL']:false;//是否启用SSL安全连接	，gmail需要启用sll安全连接
		self::$config['SMTP_USERNAME']=isset($config['SMTP_USERNAME'])?$config['SMTP_USERNAME']:'404352772@qq.com';//smtp服务器帐号，如：你的qq邮箱
		self::$config['SMTP_PASSWORD']=isset($config['SMTP_PASSWORD'])?$config['SMTP_PASSWORD']:'123456';//smtp服务器帐号密码，如你的qq邮箱密码
		self::$config['SMTP_AUTH']=isset($config['SMTP_AUTH'])?$config['SMTP_AUTH']:true;//启用SMTP验证功能，一般需要开启
		self::$config['SMTP_CHARSET']=isset($config['SMTP_CHARSET'])?$config['SMTP_CHARSET']:'utf-8';//发送的邮件内容编码	
		self::$config['SMTP_FROM_TO']=isset($config['SMTP_FROM_TO'])?$config['SMTP_FROM_TO']:'404352772@qq.com';//发件人邮件地址
		self::$config['SMTP_FROM_NAME']=isset($config['SMTP_FROM_NAME'])?$config['SMTP_FROM_NAME']:'CanPHP官方';//发件人姓名
		self::$config['SMTP_DEBUG']=isset($config['SMTP_DEBUG'])?$config['SMTP_DEBUG']:false;//是否显示调试信息	

    }
	//发送邮件
	static public function send($mail_to,$mail_subject,$mail_body,$mail_attach=NULL)
	{
		@error_reporting(E_ERROR | E_WARNING | E_PARSE);//屏蔽出错信息
	    $mail             = new PHPMailer();
		//没有调用配置方法，则调用一次config方法
		if(!isset(self::$config)||empty(self::$config))
		{
			self::init();
		}
		$mail->IsSMTP(); //// 使用SMTP方式发送
		$mail->Host       = self::$config['SMTP_HOST']; //smtp服务器地址
		$mail->Port       = self::$config['SMTP_PORT'];    //smtp服务器端口
		$mail->Username   = self::$config['SMTP_USERNAME']; //smtp服务器帐号，
		$mail->Password   = self::$config['SMTP_PASSWORD'];  // smtp服务器帐号密码
		$mail->SMTPAuth   = self::$config['SMTP_AUTH'];//启用SMTP验证功能，一般需要开启
		$mail->CharSet = self::$config['SMTP_CHARSET'];//发送的邮件内容编码	
		$mail->SetFrom(self::$config['SMTP_FROM_TO'], self::$config['SMTP_FROM_NAME']);	// 发件人的邮箱和姓名
		$mail->AddReplyTo(self::$config['SMTP_FROM_TO'],self::$config['SMTP_FROM_NAME']);// 回复时的邮箱和姓名，一般跟发件人一样
		//是否启用SSL安全连接	
		if(self::$config['SMTP_SSL'])
		{
			$mail->SMTPSecure = "ssl"; //gmail需要启用sll安全连接
		}
		//开启调试信息
		if(self::$config['SMTP_DEBUG'])
		{
			$mail->SMTPDebug  = 1; 
		}
		
		$mail->Subject    = $mail_subject;//邮件标题
		$mail->MsgHTML($mail_body);//邮件内容，支持html代码
		//发送邮件
		if(is_array($mail_to))
		{
				//同时发送给多个人
				foreach($mail_to as $key=>$value)
				{
					$mail->AddAddress($value,"");  // 收件人邮箱和姓名
				}
		}
		else
		{		//只发送给一个人
				$mail->AddAddress($mail_to,"");  // 收件人邮箱和姓名
		}

		//发送多个附件
		if(is_array($mail_attach))
		{
			foreach($mail_attach as $value)
			{
				if(file_exists($value))//附件必须存在，才会发送
				{
					$mail->AddAttachment($value); // attachment
				}
			}
		}
		//发送一个附件
		if(!empty($mail_attach)&&is_string($mail_attach))
		{
		
				if(file_exists($mail_attach))//附件必须存在，才会发送
				{
					$mail->AddAttachment($mail_attach); //发送附件
				}
		}
		
		if(!$mail->Send()) 
		{
			if(self::$config['SMTP_DEBUG'])
		 	{
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
		  	return false;		  
		} 
		else 
		{
		    return true;
		}
	}
}

//表单验证类
//静态类
class Check
{
	//执行验证规则
	/*
		用法：
		Check::rule(
					array(验证函数1，'错误返回值1'),
					array(验证函数2，'错误返回值2'),
					);
		若有一个验证函数返回false,则返回对应的错误返回值，若全部通过验证，则返回true。
		验证函数，可以是自定义的函数或类方法，返回true表示通过，返回false，表示没有通过
	*/
	public static function rule($array=array())
	{
		//可以采用数组传参，也可以采用无限个参数方式传参
		if(!isset($array[0][0]))
			$array=func_get_args();
			
		if(is_array($array))
		{
			foreach($array as $vo)
			{
				if(is_array($vo)&&isset($vo[0])&&isset($vo[1]))
				{
					if(!$vo[0])
						return $vo[1];
				}
			}
		}
		return true;
	}
	
	//检查字符串长度
    public static function len($str,$min=0,$max=255)
   {
		$str=trim($str);
		if(empty($str))
			return true;
		$len=strlen($str);
		if(($len>=$min)&&($len<=$max))
			return true;		
		else
			return false;	  
	}
	
	//检查字符串是否为空
	public static function must($str)
	{
		$str=trim($str);
		return !empty($str);
	}  
	
	//检查两次输入的值是否相同
    public static function same($str1,$str2)
    {
   		return $str1==$str2;
    }
	
	//检查用户名
	public static function userName($str,$len_min=0,$len_max=255,$type='ALL')
	{
		if(empty($str))
			return true;
		if(self::len($str,$len_min,$len_max)==false)
		{
			return false;
		}
		
		switch($type)
		{
			//纯英文
			case "EN":$pattern="/^[a-zA-Z]+$/";break;
				//英文数字
			case "ENNUM":$pattern="/^[a-zA-Z0-9]+$/"; break;
			  //允许的符号(|-_字母数字)
			case "ALL":$pattern="/^[\-\_a-zA-Z0-9]+$/"; break;
			//用户自定义正则
			default:$pattern=$type;break;
		}
		
		if(preg_match($pattern,$str))
			 return true;
		else
			 return false;
	}
	
	//验证邮箱
	public static function email($str)
	{
		if(empty($str))
			return false;
		$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
		if (strpos($str, '@') !== false && strpos($str, '.') !== false){
			if (preg_match($chars, $str)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	//验证手机号码
	public  static function mobile($str)
	{
		if (empty($str)) {
			return true;
		}
		
		return preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$#', $str);
	}
	
	//验证固定电话
	public  static function tel($str)
	{
		if (empty($str)) {
			return true;
		}
		return preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/', trim($str));
	}

	//验证qq号码
	public  static function qq($str)
	{
		if (empty($str)) {
			return true;
		}
		
		return preg_match('/^[1-9]\d{4,12}$/', trim($str));
	}
	
	//验证邮政编码
	public  static function zipCode($str)
	{
		if (empty($str)) {
			return true;
		}
		
		return preg_match('/^[1-9]\d{5}$/', trim($str));
	}
	
	//验证ip
	public static function ip($str)
	{
		if(empty($str))
			return true;	
		
		if (!preg_match('#^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$#', $str)) {
			return false;			
		}
		
		$ip_array = explode('.', $str);
		
		//真实的ip地址每个数字不能大于255（0-255）		
		return ($ip_array[0]<=255 && $ip_array[1]<=255 && $ip_array[2]<=255 && $ip_array[3]<=255) ? true : false;
	}	
	
    //验证身份证(中国)
    public  static function idCard($str)
    {
		$str=trim($str);
		if(empty($str))
			return true;	
			
		if(preg_match("/^([0-9]{15}|[0-9]{17}[0-9a-z])$/i",$str))
			 return true;
		else
			 return false;
     }

	//验证网址
	public  static function url($str) 
	{
		if(empty($str))
			return true;	
		
		return preg_match('#(http|https|ftp|ftps)://([\w-]+\.)+[\w-]+(/[\w-./?%&=]*)?#i', $str) ? true : false;
	}
}

/**
 * 调试
 * 静态类
 */
class Debug
{
	public static $logFile = 'log.php';//日志文件
	public static $timeFile = 'time_log.php';//日志文件
	public static $srcTime = 0;//开始时间
	public static $maxTime = 0.01;//最大时间，超过最大时间则加粗显示
	
	/**
	 * 程序执行时间
	 */
	public static function runtime()
	{
		$time = microtime(true) - self::$srcTime;
		$time = round($time, 3);
		return $time;
	}
	
	/**
	 * 添加日志记录
	 * $str	记录内容
	 */
	public static function log($str)
	{
		$fileExists = file_exists(self::$logFile);
		$file = fopen(self::$logFile, 'a+');
		if (!$fileExists)
		{
			fwrite($file, '<?php if(!defined(\'VIEW\')) exit(0); ?>' . "\r\n");
			fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n");
		}
		fwrite($file, '[' . Utils::mdate('H:i:s') . ' ' . Utils::getClientIp() . ']	' . $str . "<br />\r\n");
		fclose($file);
	}
	
	/**
	 * 添加执行时间日志记录
	 * $str	记录内容
	 */
	public static function logTime($str)
	{
		$fileExists = file_exists(self::$timeFile);
		$file = fopen(self::$timeFile, 'a+');
		if (!$fileExists)
		{
			fwrite($file, '<?php if(!defined(\'VIEW\')) exit(0); ?>' . "\r\n");
			fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n");
		}
		$time = self::runtime();
		if ($time >= self::$maxTime)
		{
			fwrite($file, '<b>[' . Utils::mdate('H:i:s') . ' ' . Utils::getClientIp() . ']	' . $str . ' time: ' . self::runtime() . "</b><br />\r\n");
		}
		else
		{
			fwrite($file, '[' . Utils::mdate('H:i:s') . ' ' . Utils::getClientIp() . ']	' . $str . ' time: ' . self::runtime() . "<br />\r\n");
		}
		fclose($file);
	}
}

/**
 * 文件缓存
 * 静态类
 */
class FileCache
{
	private static $header = '<?php exit(0);//file cache rnd:jfs@#$%$%gieu89v7kfnkf^*^*%^&n34805f ?>';//缓存头部，防止单独打开文件
	
	/**
	 * 写入文件缓存
	 */
	public static function write($filename, $str)
	{
		$file = fopen($filename, 'w');
		fwrite($file, self::$header . $str);
		fclose($file);
	}
	
	/**
	 * 读取文件缓存
	 */
	public static function read($filename)
	{
		if (file_exists($filename))
		{
			return str_replace(self::$header, '', file_get_contents($filename));
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * 删除文件缓存
	 */
	public static function clear($filename)
	{
		if (file_exists($filename))
		{
			@unlink($filename);
		}
	}
}

//数据采集，doGET,doPOST,文件下载，
//静态类
class Http
{
	static public $way=0;
	//手动设置访问方式
	static public function setWay($way)
	{
		self::$way=intval($way);
	}
	static public function getSupport()
	{
		//如果指定访问方式，则按指定的方式去访问
		if (isset(self::$way) && in_array(self::$way, array(1, 2, 3)))
		{
			return self::$way;
		}
		
		//自动获取最佳访问方式	
		if (function_exists('curl_init'))//curl方式
		{
			return 1;
		}
		else if (function_exists('fsockopen'))//socket
		{
			return 2;
		}
		else if (function_exists('file_get_contents'))//php系统函数file_get_contents
		{
			return 3;
		}
		else
		{
			return 0;
		}	
	}
	
	//通过get方式获取数据
	static public function doGet($url,$timeout=5,$header="") 
	{	
		if(empty($url)||empty($timeout))
			return false;
		if(!preg_match('/^(http|https)/is',$url))
			$url="http://".$url;
		$code=self::getSupport();
		switch($code)
		{
			case 1:return self::curlGet($url,$timeout,$header);break;
			case 2:return self::socketGet($url,$timeout,$header);break;
			case 3:return self::phpGet($url,$timeout,$header);break;
			default:return false;	
		}
	}
	
	//通过POST方式发送数据
	static public function doPost($url, $post_data=array(), $timeout=5,$header="") 
	{
		if(empty($url)||empty($post_data)||empty($timeout))
			return false;
		if(!preg_match('/^(http|https)/is',$url))
			$url="http://".$url;
		$code=self::getSupport();
		switch($code)
		{
			case 1:return self::curlPost($url,$post_data,$timeout,$header);break;
			case 2:return self::socketPost($url,$post_data,$timeout,$header);break;
			case 3:return self::phpPost($url,$post_data,$timeout,$header);break;
			default:return false;	
		}
	}
	
	//通过curl get数据
	static public function curlGet($url,$timeout=5,$header="") 
	{
		$header=empty($header)?self::defaultHeader():$header;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));//模拟的header头
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	
	//通过curl post数据
	static public function curlPost($url, $post_data=array(), $timeout=5,$header="") 
	{
		$header=empty($header)?'':$header;
		$post_string = http_build_query($post_data);  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));//模拟的header头
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	
	//通过socket get数据
	static public function socketGet($url,$timeout=5,$header="")
	{
		$header=empty($header)?self::defaultHeader():$header;
		$url2 = parse_url($url);
		$url2["path"] = isset($url2["path"])? $url2["path"]: "/" ;
		$url2["port"] = isset($url2["port"])? $url2["port"] : 80;
		$url2["query"] = isset($url2["query"])? "?".$url2["query"] : "";
		$host_ip = @gethostbyname($url2["host"]);

		if(($fsock = fsockopen($host_ip, $url2['port'], $errno, $errstr, $timeout)) < 0){
			return false;
		}
		$request =  $url2["path"] .$url2["query"];
		$in  = "GET " . $request . " HTTP/1.0\r\n";
		if(false===strpos($header, "Host:"))
		{	
			 $in .= "Host: " . $url2["host"] . "\r\n";
		}
		$in .= $header;
		$in .= "Connection: Close\r\n\r\n";
		
		if(!@fwrite($fsock, $in, strlen($in))){
			@fclose($fsock);
			return false;
		}
		return self::GetHttpContent($fsock);
	}
	
	//通过socket post数据
	static public function socketPost($url, $post_data=array(), $timeout=5,$header="") 
	{
		$header=empty($header)?self::defaultHeader():$header;
		$post_string = http_build_query($post_data);  
		
		
		$url2 = parse_url($url);
		$url2["path"] = ($url2["path"] == "" ? "/" : $url2["path"]);
		$url2["port"] = ($url2["port"] == "" ? 80 : $url2["port"]);
		$host_ip = @gethostbyname($url2["host"]);
		$fsock_timeout = $timeout; //超时时间
		if(($fsock = fsockopen($host_ip, $url2['port'], $errno, $errstr, $fsock_timeout)) < 0){
			return false;
		}
		$request =  $url2["path"].($url2["query"] ? "?" . $url2["query"] : "");
		$in  = "POST " . $request . " HTTP/1.0\r\n";
		$in .= "Host: " . $url2["host"] . "\r\n";
		$in .= $header;
		$in .= "Content-type: application/x-www-form-urlencoded\r\n";
		$in .= "Content-Length: " . strlen($post_string) . "\r\n";
		$in .= "Connection: Close\r\n\r\n";
		$in .= $post_string . "\r\n\r\n";
		unset($post_string);
		if(!@fwrite($fsock, $in, strlen($in))){
			@fclose($fsock);
			return false;
		}
		return self::GetHttpContent($fsock);
	}
	
	//通过file_get_contents函数get数据
	static public function phpGet($url,$timeout=5,$header="") 
	{
		$header=empty($header)?self::defaultHeader():$header;
		$opts = array( 
				'http'=>array(
							'protocol_version'=>'1.0', //http协议版本(若不指定php5.2系默认为http1.0)
							'method'=>"GET",//获取方式
							'timeout' => $timeout ,//超时时间
							'header'=> $header)
				  ); 
		$context = stream_context_create($opts);
		return  @file_get_contents($url,false,$context);
	}
	
	//通过file_get_contents 函数post数据
	static public function phpPost($url, $post_data = array(), $timeout = 5, $header = "")
	{
		$header=empty($header)?self::defaultHeader():$header;
		$post_string = http_build_query($post_data);
		$header.="Content-length: ".strlen($post_string);
		$opts = array(
				'http'=>array(
							'protocol_version'=>'1.0',//http协议版本(若不指定php5.2系默认为http1.0)
							'method'=>"POST",//获取方式
							'timeout' => $timeout ,//超时时间
							'header'=> $header,
							'content'=> $post_string)
				  );
		$context = stream_context_create($opts);
		return  @file_get_contents($url,false,$context);
	}
	
	//默认模拟的header头
	static private function defaultHeader()
	{
		$header="User-Agent:Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12\r\n";
		$header.="Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n";
		$header.="Accept-language: zh-cn,zh;q=0.5\r\n";
		$header.="Accept-Charset: GB2312,utf-8;q=0.7,*;q=0.7\r\n";
		return $header;
	}
	
	//获取通过socket方式get和post页面的返回数据
	static private function GetHttpContent($fsock=null)
	{
		$out = null;
		while($buff = @fgets($fsock, 2048)){
			 $out .= $buff;
		}
		fclose($fsock);
		$pos = strpos($out, "\r\n\r\n");
		$head = substr($out, 0, $pos);//http head
		$status = substr($head, 0, strpos($head, "\r\n"));//http status line
		$body = substr($out, $pos + 4, strlen($out) - ($pos + 4));//page body
		if(preg_match("/^HTTP\/\d\.\d\s([\d]+)\s.*$/", $status, $matches))
		{
			if(intval($matches[1]) / 100 == 2)
			{
				return $body;  
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/*
     功能： 下载文件
     参数:$filename 下载文件路径
     $showname 下载显示的文件名
     $expire  下载内容浏览器缓存时间
	*/
    static public function download($filename, $showname='',$expire=1800) 
	{
        if(file_exists($filename)&&is_file($filename)) 
		{
            $length = filesize($filename);
        }
		else 
		{
          die('下载文件不存在！');
        }

	    $type = mime_content_type($filename);

        //发送Http Header信息 开始下载
        header("Pragma: public");
        header("Cache-control: max-age=".$expire);
        //header('Cache-Control: no-store, no-cache, must-revalidate');
        header("Expires: " . gmdate("D, d M Y H:i:s",time()+$expire) . "GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s",time()) . "GMT");
        header("Content-Disposition: attachment; filename=".$showname);
        header("Content-Length: ".$length);
        header("Content-type: ".$type);
        header('Content-Encoding: none');
        header("Content-Transfer-Encoding: binary" );
        readfile($filename);
        return true;
    }
}

if( !function_exists ('mime_content_type')) {
    /**
     +----------------------------------------------------------
     * 获取文件的mime_content类型
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    function mime_content_type($filename)
    {
       static $contentType = array(
			'ai'	=> 'application/postscript',
				'aif'	=> 'audio/x-aiff',
				'aifc'	=> 'audio/x-aiff',
				'aiff'	=> 'audio/x-aiff',
				'asc'	=> 'application/pgp', //changed by skwashd - was text/plain
				'asf'	=> 'video/x-ms-asf',
				'asx'	=> 'video/x-ms-asf',
				'au'	=> 'audio/basic',
				'avi'	=> 'video/x-msvideo',
				'bcpio'	=> 'application/x-bcpio',
				'bin'	=> 'application/octet-stream',
				'bmp'	=> 'image/bmp',
				'c'	=> 'text/plain', // or 'text/x-csrc', //added by skwashd
				'cc'	=> 'text/plain', // or 'text/x-c++src', //added by skwashd
				'cs'	=> 'text/plain', //added by skwashd - for C# src
				'cpp'	=> 'text/x-c++src', //added by skwashd
				'cxx'	=> 'text/x-c++src', //added by skwashd
				'cdf'	=> 'application/x-netcdf',
				'class'	=> 'application/octet-stream',//secure but application/java-class is correct
				'com'	=> 'application/octet-stream',//added by skwashd
				'cpio'	=> 'application/x-cpio',
				'cpt'	=> 'application/mac-compactpro',
				'csh'	=> 'application/x-csh',
				'css'	=> 'text/css',
				'csv'	=> 'text/comma-separated-values',//added by skwashd
				'dcr'	=> 'application/x-director',
				'diff'	=> 'text/diff',
				'dir'	=> 'application/x-director',
				'dll'	=> 'application/octet-stream',
				'dms'	=> 'application/octet-stream',
				'doc'	=> 'application/msword',
				'dot'	=> 'application/msword',//added by skwashd
				'dvi'	=> 'application/x-dvi',
				'dxr'	=> 'application/x-director',
				'eps'	=> 'application/postscript',
				'etx'	=> 'text/x-setext',
				'exe'	=> 'application/octet-stream',
				'ez'	=> 'application/andrew-inset',
				'gif'	=> 'image/gif',
				'gtar'	=> 'application/x-gtar',
				'gz'	=> 'application/x-gzip',
				'h'	=> 'text/plain', // or 'text/x-chdr',//added by skwashd
				'h++'	=> 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hh'	=> 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hpp'	=> 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hxx'	=> 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hdf'	=> 'application/x-hdf',
				'hqx'	=> 'application/mac-binhex40',
				'htm'	=> 'text/html',
				'html'	=> 'text/html',
				'ice'	=> 'x-conference/x-cooltalk',
				'ics'	=> 'text/calendar',
				'ief'	=> 'image/ief',
				'ifb'	=> 'text/calendar',
				'iges'	=> 'model/iges',
				'igs'	=> 'model/iges',
				'jar'	=> 'application/x-jar', //added by skwashd - alternative mime type
				'java'	=> 'text/x-java-source', //added by skwashd
				'jpe'	=> 'image/jpeg',
				'jpeg'	=> 'image/jpeg',
				'jpg'	=> 'image/jpeg',
				'js'	=> 'application/x-javascript',
				'kar'	=> 'audio/midi',
				'latex'	=> 'application/x-latex',
				'lha'	=> 'application/octet-stream',
				'log'	=> 'text/plain',
				'lzh'	=> 'application/octet-stream',
				'm3u'	=> 'audio/x-mpegurl',
				'man'	=> 'application/x-troff-man',
				'me'	=> 'application/x-troff-me',
				'mesh'	=> 'model/mesh',
				'mid'	=> 'audio/midi',
				'midi'	=> 'audio/midi',
				'mif'	=> 'application/vnd.mif',
				'mov'	=> 'video/quicktime',
				'movie'	=> 'video/x-sgi-movie',
				'mp2'	=> 'audio/mpeg',
				'mp3'	=> 'audio/mpeg',
				'mpe'	=> 'video/mpeg',
				'mpeg'	=> 'video/mpeg',
				'mpg'	=> 'video/mpeg',
				'mpga'	=> 'audio/mpeg',
				'ms'	=> 'application/x-troff-ms',
				'msh'	=> 'model/mesh',
				'mxu'	=> 'video/vnd.mpegurl',
				'nc'	=> 'application/x-netcdf',
				'oda'	=> 'application/oda',
				'patch'	=> 'text/diff',
				'pbm'	=> 'image/x-portable-bitmap',
				'pdb'	=> 'chemical/x-pdb',
				'pdf'	=> 'application/pdf',
				'pgm'	=> 'image/x-portable-graymap',
				'pgn'	=> 'application/x-chess-pgn',
				'pgp'	=> 'application/pgp',//added by skwashd
				'php'	=> 'application/x-httpd-php',
				'php3'	=> 'application/x-httpd-php3',
				'pl'	=> 'application/x-perl',
				'pm'	=> 'application/x-perl',
				'png'	=> 'image/png',
				'pnm'	=> 'image/x-portable-anymap',
				'po'	=> 'text/plain',
				'ppm'	=> 'image/x-portable-pixmap',
				'ppt'	=> 'application/vnd.ms-powerpoint',
				'ps'	=> 'application/postscript',
				'qt'	=> 'video/quicktime',
				'ra'	=> 'audio/x-realaudio',
				'rar'=>'application/octet-stream',
				'ram'	=> 'audio/x-pn-realaudio',
				'ras'	=> 'image/x-cmu-raster',
				'rgb'	=> 'image/x-rgb',
				'rm'	=> 'audio/x-pn-realaudio',
				'roff'	=> 'application/x-troff',
				'rpm'	=> 'audio/x-pn-realaudio-plugin',
				'rtf'	=> 'text/rtf',
				'rtx'	=> 'text/richtext',
				'sgm'	=> 'text/sgml',
				'sgml'	=> 'text/sgml',
				'sh'	=> 'application/x-sh',
				'shar'	=> 'application/x-shar',
				'shtml'	=> 'text/html',
				'silo'	=> 'model/mesh',
				'sit'	=> 'application/x-stuffit',
				'skd'	=> 'application/x-koan',
				'skm'	=> 'application/x-koan',
				'skp'	=> 'application/x-koan',
				'skt'	=> 'application/x-koan',
				'smi'	=> 'application/smil',
				'smil'	=> 'application/smil',
				'snd'	=> 'audio/basic',
				'so'	=> 'application/octet-stream',
				'spl'	=> 'application/x-futuresplash',
				'src'	=> 'application/x-wais-source',
				'stc'	=> 'application/vnd.sun.xml.calc.template',
				'std'	=> 'application/vnd.sun.xml.draw.template',
				'sti'	=> 'application/vnd.sun.xml.impress.template',
				'stw'	=> 'application/vnd.sun.xml.writer.template',
				'sv4cpio'	=> 'application/x-sv4cpio',
				'sv4crc'	=> 'application/x-sv4crc',
				'swf'	=> 'application/x-shockwave-flash',
				'sxc'	=> 'application/vnd.sun.xml.calc',
				'sxd'	=> 'application/vnd.sun.xml.draw',
				'sxg'	=> 'application/vnd.sun.xml.writer.global',
				'sxi'	=> 'application/vnd.sun.xml.impress',
				'sxm'	=> 'application/vnd.sun.xml.math',
				'sxw'	=> 'application/vnd.sun.xml.writer',
				't'	=> 'application/x-troff',
				'tar'	=> 'application/x-tar',
				'tcl'	=> 'application/x-tcl',
				'tex'	=> 'application/x-tex',
				'texi'	=> 'application/x-texinfo',
				'texinfo'	=> 'application/x-texinfo',
				'tgz'	=> 'application/x-gtar',
				'tif'	=> 'image/tiff',
				'tiff'	=> 'image/tiff',
				'tr'	=> 'application/x-troff',
				'tsv'	=> 'text/tab-separated-values',
				'txt'	=> 'text/plain',
				'ustar'	=> 'application/x-ustar',
				'vbs'	=> 'text/plain', //added by skwashd - for obvious reasons
				'vcd'	=> 'application/x-cdlink',
				'vcf'	=> 'text/x-vcard',
				'vcs'	=> 'text/calendar',
				'vfb'	=> 'text/calendar',
				'vrml'	=> 'model/vrml',
				'vsd'	=> 'application/vnd.visio',
				'wav'	=> 'audio/x-wav',
				'wax'	=> 'audio/x-ms-wax',
				'wbmp'	=> 'image/vnd.wap.wbmp',
				'wbxml'	=> 'application/vnd.wap.wbxml',
				'wm'	=> 'video/x-ms-wm',
				'wma'	=> 'audio/x-ms-wma',
				'wmd'	=> 'application/x-ms-wmd',
				'wml'	=> 'text/vnd.wap.wml',
				'wmlc'	=> 'application/vnd.wap.wmlc',
				'wmls'	=> 'text/vnd.wap.wmlscript',
				'wmlsc'	=> 'application/vnd.wap.wmlscriptc',
				'wmv'	=> 'video/x-ms-wmv',
				'wmx'	=> 'video/x-ms-wmx',
				'wmz'	=> 'application/x-ms-wmz',
				'wrl'	=> 'model/vrml',
				'wvx'	=> 'video/x-ms-wvx',
				'xbm'	=> 'image/x-xbitmap',
				'xht'	=> 'application/xhtml+xml',
				'xhtml'	=> 'application/xhtml+xml',
				'xls'	=> 'application/vnd.ms-excel',
				'xlt'	=> 'application/vnd.ms-excel',
				'xml'	=> 'application/xml',
				'xpm'	=> 'image/x-xpixmap',
				'xsl'	=> 'text/xml',
				'xwd'	=> 'image/x-xwindowdump',
				'xyz'	=> 'chemical/x-xyz',
				'z'	=> 'application/x-compress',
				'zip'	=> 'application/zip',
       );
       $type = strtolower(substr(strrchr($filename, '.'),1));
       if(isset($contentType[$type])) {
            $mime = $contentType[$type];
       }else {
       	    $mime = 'application/octet-stream';
       }
       return $mime;
    }
}

if(!function_exists('image_type_to_extension'))
{
   function image_type_to_extension($imagetype)
   {
       if(empty($imagetype)) return false;
       switch($imagetype)
       {
           case IMAGETYPE_GIF    : return '.gif';
           case IMAGETYPE_JPEG    : return '.jpg';
           case IMAGETYPE_PNG    : return '.png';
           case IMAGETYPE_SWF    : return '.swf';
           case IMAGETYPE_PSD    : return '.psd';
           case IMAGETYPE_BMP    : return '.bmp';
           case IMAGETYPE_TIFF_II : return '.tiff';
           case IMAGETYPE_TIFF_MM : return '.tiff';
           case IMAGETYPE_JPC    : return '.jpc';
           case IMAGETYPE_JP2    : return '.jp2';
           case IMAGETYPE_JPX    : return '.jpf';
           case IMAGETYPE_JB2    : return '.jb2';
           case IMAGETYPE_SWC    : return '.swc';
           case IMAGETYPE_IFF    : return '.aiff';
           case IMAGETYPE_WBMP    : return '.wbmp';
           case IMAGETYPE_XBM    : return '.xbm';
           default                : return false;
       }
   }
}

//生成图像缩略图和生成验证码
//静态类
class Image
{//类定义开始

    /**
     +----------------------------------------------------------
     * 取得图像信息
     *
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $image 图像文件名
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    static function getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if( $imageInfo!== false)
		 {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]),1));
            $imageSize = filesize($img);
            $info = array(
                "width"=>$imageInfo[0],
                "height"=>$imageInfo[1],
                "type"=>$imageType,
                "size"=>$imageSize,
                "mime"=>$imageInfo['mime']
            );
            return $info;
        }else {
            return false;
        }
    }



    /**
     +----------------------------------------------------------
     * 生成缩略图
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $image  原图
     * @param string $type 图像格式
     * @param string $thumbname 缩略图文件名
     * @param string $maxWidth  宽度
     * @param string $maxHeight  高度
     * @param string $position 缩略图保存目录
     * @param boolean $interlace 启用隔行扫描
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static function thumb($image,$thumbname,$type='',$maxWidth=200,$maxHeight=50,$interlace=true)
    {
        // 获取原图信息
        $info  = Image::getImageInfo($image);
         if($info !== false)
		  {
            $srcWidth  = $info['width'];
            $srcHeight = $info['height'];
            $type = empty($type)?$info['type']:$type;
			$type = strtolower($type);
            $interlace  =  $interlace? 1:0;
            unset($info);
            $scale = min($maxWidth/$srcWidth, $maxHeight/$srcHeight); // 计算缩放比例
            if($scale>=1) 
			{
                // 超过原图大小不再缩略
                $width   =  $srcWidth;
                $height  =  $srcHeight;
            }
			else
			{
                // 缩略图尺寸
                $width  = (int)($srcWidth*$scale);
                $height = (int)($srcHeight*$scale);
            }

            // 载入原图
            $createFun = 'ImageCreateFrom'.($type=='jpg'?'jpeg':$type);
            $srcImg     = $createFun($image);

            //创建缩略图
            if($type!='gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($width, $height);
            else
                $thumbImg = imagecreate($width, $height);

            // 复制图片
            if(function_exists("ImageCopyResampled"))
                imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth,$srcHeight);
            else
                imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height,  $srcWidth,$srcHeight);
				
            if('gif'==$type || 'png'==$type) 
			{
                $background_color  =  imagecolorallocate($thumbImg,  0,255,0);  //  指派一个绿色
				imagecolortransparent($thumbImg,$background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
            }

            // 对jpeg图形设置隔行扫描
            if('jpg'==$type || 'jpeg'==$type) 	
			     imageinterlace($thumbImg,$interlace);

            // 生成图片
            $imageFun = 'image'.($type=='jpg'?'jpeg':$type);
            $imageFun($thumbImg,$thumbname);
            imagedestroy($thumbImg);
            imagedestroy($srcImg);
            return $thumbname;
         }
         return false;
    }


    /**
     +----------------------------------------------------------
     * 生成图像验证码
     +----------------------------------------------------------
     * @static
     * @access public
     * @param string $width  宽度
     * @param string $height  高度
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    static function buildImageVerify($width=48,$height=22,$randval=NULL,$verifyName='verify')
    {
        if(!isset($_SESSION))
	    {
	   		session_start();//如果没有开启，session，则开启session
	    }
		
		$randval =empty($randval)? ("".rand(1000,9999)):$randval;
		
        $_SESSION[$verifyName]= $randval;
		$length=4;
        $width = ($length*10+10)>$width?$length*10+10:$width;

        $im = imagecreate($width,$height);
  
        $r = array(225,255,255,223);
        $g = array(225,236,237,255);
        $b = array(225,236,166,125);
        $key = mt_rand(0,3);

        $backColor = imagecolorallocate($im, $r[$key],$g[$key],$b[$key]);    //背景色（随机）
		$borderColor = imagecolorallocate($im, 100, 100, 100);                    //边框色
        $pointColor = imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));                 //点颜色

        @imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);
        @imagerectangle($im, 0, 0, $width-1, $height-1, $borderColor);
        $stringColor = imagecolorallocate($im,mt_rand(0,200),mt_rand(0,120),mt_rand(0,120));
		// 干扰
		for($i=0;$i<10;$i++){
			$fontcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagearc($im,mt_rand(-10,$width),mt_rand(-10,$height),mt_rand(30,300),mt_rand(20,200),55,44,$fontcolor);
		}
		for($i=0;$i<25;$i++){
			$fontcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagesetpixel($im,mt_rand(0,$width),mt_rand(0,$height),$pointColor);
		}
		for($i=0;$i<$length;$i++) {
			imagestring($im,5,$i*10+5,mt_rand(1,8),$randval{$i}, $stringColor);
		}
        Image::output($im,'png');
    }

    static function output($im,$type='png',$filename='')
    {
        header("Content-type: image/".$type);
        $ImageFun='image'.$type;
		if(empty($filename)) {
	        $ImageFun($im);
		}else{
	        $ImageFun($im,$filename);
		}
        imagedestroy($im);
		exit;
    }
	
     /**
     * +----------------------------------------------------------
     * 图片水印
     * +----------------------------------------------------------
     * @$image  原图
     * @$water 水印图片
     * @$$waterPos 水印位置(0-9) 0为随机，其他代表上中下9个部分位置
     * +----------------------------------------------------------
     */

    static function water($image, $water, $waterPos =9)
    {
	    //检查图片是否存在
        if (!file_exists($image) || !file_exists($water))
            return false;
	   //读取原图像文件
        $imageInfo = self::getImageInfo($image);
        $image_w = $imageInfo['width']; //取得水印图片的宽
        $image_h = $imageInfo['height']; //取得水印图片的高
        $imageFun = "imagecreatefrom" . $imageInfo['type'];
        $image_im = $imageFun($image);
        
        //读取水印文件
        $waterInfo = self::getImageInfo($water);
        $w = $water_w = $waterInfo['width']; //取得水印图片的宽
        $h = $water_h = $waterInfo['height']; //取得水印图片的高
        $waterFun = "imagecreatefrom" . $waterInfo['type'];
        $water_im = $waterFun($water);

        switch ($waterPos) {
            case 0: //随机
                $posX = rand(0, ($image_w - $w));
                $posY = rand(0, ($image_h - $h));
                break;
            case 1: //1为顶端居左
                $posX = 0;
                $posY = 0;
                break;
            case 2: //2为顶端居中
                $posX = ($image_w - $w) / 2;
                $posY = 0;
                break;
            case 3: //3为顶端居右
                $posX = $image_w - $w;
                $posY = 0;
                break;
            case 4: //4为中部居左
                $posX = 0;
                $posY = ($image_h - $h) / 2;
                break;
            case 5: //5为中部居中
                $posX = ($image_w - $w) / 2;
                $posY = ($image_h - $h) / 2;
                break;
            case 6: //6为中部居右
                $posX = $image_w - $w;
                $posY = ($image_h - $h) / 2;
                break;
            case 7: //7为底端居左
                $posX = 0;
                $posY = $image_h - $h;
                break;
            case 8: //8为底端居中
                $posX = ($image_w - $w) / 2;
                $posY = $image_h - $h;
                break;
            case 9: //9为底端居右
                $posX = $image_w - $w;
                $posY = $image_h - $h;
                break;
            default: //随机
                $posX = rand(0, ($image_w - $w));
                $posY = rand(0, ($image_h - $h));
                break;
        }

        //设定图像的混色模式
        
        imagealphablending($image_im, true);

        imagecopy($image_im, $water_im, $posX, $posY, 0, 0, $water_w, $water_h); //拷贝水印到目标文件

        //生成水印后的图片
        $bulitImg = "image" . $imageInfo['type'];
        $bulitImg($image_im, $image);
        //释放内存
        $waterInfo = $imageInfo = null;
        imagedestroy($image_im);
    }

}//类定义结束

/**
 * 分页
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

/*
汉字转化为拼音类
 */
class Pinyin{
	
	/**
	 * 汉字ASCII码库
	 * 
	 * @var array
	 */
	protected $lib;
	
	
	/**
	 * 构造函数
	 * 
	 * @return void
	 */
	public function __construct(){
		
	}
	/**
	 * 汉字转化并输出拼音
	 * 
	 * @param string $str		所要转化拼音的汉字
	 * @param boolean $utf8 	汉字编码是否为utf8
	 * @return string
	 */
	public function output($str, $utf8 = true)
	{		
		//参数分析
		if (!$str) {
			return false;
		}
		
		//编码转换.
		$str = ($utf8==true) ? $this->iconvStr('utf-8', 'gbk', $str) : $str;
		$num = strlen($str);
		
		$pinyin = '';
		for ($i=0; $i<$num; $i++) {
			$temp = ord(substr($str, $i, 1));
			if ($temp>160) {				
				$temp2=ord(substr($str,++$i,1));
				$temp=$temp*256+$temp2-65536;
			}
			$pinyin .= $this->num2str($temp);
		}
				
		//输出的拼音编码转换.
		return ($utf8==true) ? $this->iconvStr('gbk', 'utf-8', $pinyin) : $pinyin;
	}
	/**
	 * 将ASCII编码转化为字符串.
	 * 
	 * @param integer $num
	 * @return string
	 */
	protected function num2str($num) {		
		
		if (!$this->lib) {			
			$this->parse_lib();
		}
				
		if ($num>0&&$num<160) {	
			
   			return chr($num);
		} elseif($num<-20319||$num>-10247) {
			
			return '';
		} else{
			$total =sizeof($this->lib)-1;
			for($i=$total; $i>=0; $i--) {
				if($this->lib[$i][1]<=$num) {					
					break;
				}
			}
			
			return $this->lib[$i][0];
		}
	}

	/**
	 * 返回汉字编码库
	 * 
	 * @return array
	 */
	protected function parse_lib() {
		
		return $this->lib = array(
			array("a",-20319),
			array("ai",-20317),
			array("an",-20304),
			array("ang",-20295),
			array("ao",-20292),
			array("ba",-20283),
			array("bai",-20265),
			array("ban",-20257),
			array("bang",-20242),
			array("bao",-20230),
			array("bei",-20051),
			array("ben",-20036),
			array("beng",-20032),
			array("bi",-20026),
			array("bian",-20002),
			array("biao",-19990),
			array("bie",-19986),
			array("bin",-19982),
			array("bing",-19976),
			array("bo",-19805),
			array("bu",-19784),
			array("ca",-19775),
			array("cai",-19774),
			array("can",-19763),
			array("cang",-19756),
			array("cao",-19751),
			array("ce",-19746),
			array("ceng",-19741),
			array("cha",-19739),
			array("chai",-19728),
			array("chan",-19725),
			array("chang",-19715),
			array("chao",-19540),
			array("che",-19531),
			array("chen",-19525),
			array("cheng",-19515),
			array("chi",-19500),
			array("chong",-19484),
			array("chou",-19479),
			array("chu",-19467),
			array("chuai",-19289),
			array("chuan",-19288),
			array("chuang",-19281),
			array("chui",-19275),
			array("chun",-19270),
			array("chuo",-19263),
			array("ci",-19261),
			array("cong",-19249),
			array("cou",-19243),
			array("cu",-19242),
			array("cuan",-19238),
			array("cui",-19235),
			array("cun",-19227),
			array("cuo",-19224),
            array("da",-19218),
            array("dai",-19212),
            array("dan",-19038),
            array("dang",-19023),
            array("dao",-19018),
            array("de",-19006),
            array("deng",-19003),
            array("di",-18996),
            array("dian",-18977),
            array("diao",-18961),
            array("die",-18952),
            array("ding",-18783),
            array("diu",-18774),
            array("dong",-18773),
            array("dou",-18763),
            array("du",-18756),
            array("duan",-18741),
            array("dui",-18735),
            array("dun",-18731),
            array("duo",-18722),
            array("e",-18710),
            array("en",-18697),
            array("er",-18696),
            array("fa",-18526),
            array("fan",-18518),
            array("fang",-18501),
            array("fei",-18490),
            array("fen",-18478),
            array("feng",-18463),
            array("fo",-18448),
            array("fou",-18447),
            array("fu",-18446),
            array("ga",-18239),
            array("gai",-18237),
            array("gan",-18231),
            array("gang",-18220),
            array("gao",-18211),
            array("ge",-18201),
            array("gei",-18184),
            array("gen",-18183),
            array("geng",-18181),
            array("gong",-18012),
            array("gou",-17997),
            array("gu",-17988),
            array("gua",-17970),
            array("guai",-17964),
            array("guan",-17961),
            array("guang",-17950),
            array("gui",-17947),
            array("gun",-17931),
            array("guo",-17928),
            array("ha",-17922),
            array("hai",-17759),
            array("han",-17752),
            array("hang",-17733),
            array("hao",-17730),
            array("he",-17721),
            array("hei",-17703),
            array("hen",-17701),
            array("heng",-17697),
            array("hong",-17692),
            array("hou",-17683),
            array("hu",-17676),
            array("hua",-17496),
            array("huai",-17487),
            array("huan",-17482),
            array("huang",-17468),
            array("hui",-17454),
            array("hun",-17433),
            array("huo",-17427),
            array("ji",-17417),
            array("jia",-17202),
            array("jian",-17185),
            array("jiang",-16983),
            array("jiao",-16970),
            array("jie",-16942),
            array("jin",-16915),
            array("jing",-16733),
            array("jiong",-16708),
            array("jiu",-16706),
            array("ju",-16689),
            array("juan",-16664),
            array("jue",-16657),
            array("jun",-16647),
            array("ka",-16474),
            array("kai",-16470),
            array("kan",-16465),
            array("kang",-16459),
            array("kao",-16452),
            array("ke",-16448),
            array("ken",-16433),
            array("keng",-16429),
            array("kong",-16427),
            array("kou",-16423),
            array("ku",-16419),
            array("kua",-16412),
            array("kuai",-16407),
            array("kuan",-16403),
            array("kuang",-16401),
            array("kui",-16393),
            array("kun",-16220),
            array("kuo",-16216),
            array("la",-16212),
            array("lai",-16205),
            array("lan",-16202),
            array("lang",-16187),
            array("lao",-16180),
            array("le",-16171),
            array("lei",-16169),
            array("leng",-16158),
            array("li",-16155),
            array("lia",-15959),
            array("lian",-15958),
            array("liang",-15944),
            array("liao",-15933),
            array("lie",-15920),
            array("lin",-15915),
            array("ling",-15903),
            array("liu",-15889),
            array("long",-15878),
            array("lou",-15707),
            array("lu",-15701),
            array("lv",-15681),
            array("luan",-15667),
            array("lue",-15661),
            array("lun",-15659),
            array("luo",-15652),
            array("ma",-15640),
            array("mai",-15631),
            array("man",-15625),
            array("mang",-15454),
            array("mao",-15448),
            array("me",-15436),
            array("mei",-15435),
            array("men",-15419),
            array("meng",-15416),
            array("mi",-15408),
            array("mian",-15394),
            array("miao",-15385),
            array("mie",-15377),
            array("min",-15375),
            array("ming",-15369),
            array("miu",-15363),
            array("mo",-15362),
            array("mou",-15183),
            array("mu",-15180),
            array("na",-15165),
            array("nai",-15158),
            array("nan",-15153),
            array("nang",-15150),
            array("nao",-15149),
            array("ne",-15144),
            array("nei",-15143),
            array("nen",-15141),
            array("neng",-15140),
            array("ni",-15139),
            array("nian",-15128),
            array("niang",-15121),
            array("niao",-15119),
            array("nie",-15117),
            array("nin",-15110),
            array("ning",-15109),
            array("niu",-14941),
            array("nong",-14937),
            array("nu",-14933),
            array("nv",-14930),
            array("nuan",-14929),
            array("nue",-14928),
            array("nuo",-14926),
            array("o",-14922),
            array("ou",-14921),
            array("pa",-14914),
            array("pai",-14908),
            array("pan",-14902),
            array("pang",-14894),
            array("pao",-14889),
            array("pei",-14882),
            array("pen",-14873),
            array("peng",-14871),
            array("pi",-14857),
            array("pian",-14678),
            array("piao",-14674),
            array("pie",-14670),
            array("pin",-14668),
            array("ping",-14663),
            array("po",-14654),
            array("pu",-14645),
            array("qi",-14630),
            array("qia",-14594),
            array("qian",-14429),
            array("qiang",-14407),
            array("qiao",-14399),
            array("qie",-14384),
            array("qin",-14379),
            array("qing",-14368),
            array("qiong",-14355),
            array("qiu",-14353),
            array("qu",-14345),
            array("quan",-14170),
            array("que",-14159),
            array("qun",-14151),
            array("ran",-14149),
            array("rang",-14145),
            array("rao",-14140),
            array("re",-14137),
            array("ren",-14135),
            array("reng",-14125),
            array("ri",-14123),
            array("rong",-14122),
            array("rou",-14112),
            array("ru",-14109),
            array("ruan",-14099),
            array("rui",-14097),
            array("run",-14094),
            array("ruo",-14092),
            array("sa",-14090),
            array("sai",-14087),
            array("san",-14083),
            array("sang",-13917),
            array("sao",-13914),
            array("se",-13910),
            array("sen",-13907),
            array("seng",-13906),
            array("sha",-13905),
            array("shai",-13896),
            array("shan",-13894),
            array("shang",-13878),
            array("shao",-13870),
            array("she",-13859),
            array("shen",-13847),
            array("sheng",-13831),
            array("shi",-13658),
            array("shou",-13611),
            array("shu",-13601),
            array("shua",-13406),
            array("shuai",-13404),
            array("shuan",-13400),
            array("shuang",-13398),
            array("shui",-13395),
            array("shun",-13391),
            array("shuo",-13387),
            array("si",-13383),
            array("song",-13367),
            array("sou",-13359),
            array("su",-13356),
            array("suan",-13343),
            array("sui",-13340),
            array("sun",-13329),
            array("suo",-13326),
            array("ta",-13318),
            array("tai",-13147),
            array("tan",-13138),
            array("tang",-13120),
            array("tao",-13107),
            array("te",-13096),
            array("teng",-13095),
            array("ti",-13091),
            array("tian",-13076),
            array("tiao",-13068),
            array("tie",-13063),
            array("ting",-13060),
            array("tong",-12888),
            array("tou",-12875),
            array("tu",-12871),
            array("tuan",-12860),
            array("tui",-12858),
            array("tun",-12852),
            array("tuo",-12849),
            array("wa",-12838),
            array("wai",-12831),
            array("wan",-12829),
            array("wang",-12812),
            array("wei",-12802),
            array("wen",-12607),
            array("weng",-12597),
            array("wo",-12594),
            array("wu",-12585),
            array("xi",-12556),
            array("xia",-12359),
            array("xian",-12346),
            array("xiang",-12320),
            array("xiao",-12300),
            array("xie",-12120),
            array("xin",-12099),
            array("xing",-12089),
            array("xiong",-12074),
            array("xiu",-12067),
            array("xu",-12058),
            array("xuan",-12039),
            array("xue",-11867),
            array("xun",-11861),
            array("ya",-11847),
            array("yan",-11831),
            array("yang",-11798),
            array("yao",-11781),
            array("ye",-11604),
            array("yi",-11589),
            array("yin",-11536),			
			array("ying",-11358),
            array("yo",-11340),	
            array("yo",-11340),
            array("yong",-11339),
            array("you",-11324),
            array("yu",-11303),
            array("yuan",-11097),
            array("yue",-11077),
            array("yun",-11067),
            array("za",-11055),
            array("zai",-11052),
            array("zan",-11045),
            array("zang",-11041),
            array("zao",-11038),
            array("ze",-11024),
            array("zei",-11020),
            array("zen",-11019),
            array("zeng",-11018),
            array("zha",-11014),
            array("zhai",-10838),
            array("zhan",-10832),
            array("zhang",-10815),
            array("zhao",-10800),
            array("zhe",-10790),
            array("zhen",-10780),
            array("zheng",-10764),
            array("zhi",-10587),
            array("zhong",-10544),
            array("zhou",-10533),
            array("zhu",-10519),
            array("zhua",-10331),
            array("zhuai",-10329),
            array("zhuan",-10328),
            array("zhuang",-10322),
            array("zhui",-10315),
            array("zhun",-10309),
            array("zhuo",-10307),
            array("zi",-10296),
            array("zong",-10281),
            array("zou",-10274),
            array("zu",-10270),
            array("zuan",-10262),                        		
			array("zui",-10260),
			array("zun",-10256),
			array("zuo",-10254),
		);
	}
	
	//编码转换
	protected function iconvStr($from,$to,$fContents)
	{
			if(is_string($fContents) ) 
			{
				if(function_exists('mb_convert_encoding'))
				{
					return mb_convert_encoding ($fContents, $to, $from);
				}
				else if(function_exists('iconv'))
				{
					return iconv($from,$to,$fContents);
				}
				else
				{
					return $fContents;
				}
		}
	}
	/**
	 * 析构函数
	 * 
	 * @access public
	 * @return void
	 */
	public function __destruct()
	{		
		if (isset($this->lib)) {
			unset($this->lib);
		}
	}
}

/**
 * 安全
 * des加密
 * 静态类
 */
class Security
{
	/**
	 * GET变量去除斜杠
	 */
	public static function varGet($value)
	{
		$res = isset($_GET[$value]) ? trim($_GET[$value]) : '';
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$res = stripslashes($res);
		}
		
		return $res;
	}
	
	/**
	 * POST变量去除斜杠
	 */
	public static function varPost($value)
	{
		$res = isset($_POST[$value]) ? trim($_POST[$value]) : '';
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$res = stripslashes($res);
		}
		
		return $res;
	}
	
	/**
	 * SQL安全变量
	 */
	public static function varSql($value)
	{
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$value = stripslashes($value);
		}
		$value = "'" . @mysql_real_escape_string($value) . "'";
		
		return $value;
	}
	
	/**
	 * 多次md5加密
	 * $id: 原文
	 * $key: 密钥
	 */
	public static function multiMd5($id, $key)
	{
		$idKey = $key . $id;
		$str1 = md5(substr(md5($idKey), 3, 16) . substr(md5($key), 5, 11) . $idKey);
		$str2 = md5($idKey);
		$code = '';
		for ($i = 0; $i < 32; $i++)
		{
			$t = substr($str2, $i, 1);
			$tCode = ord($t);
			if ($tCode >= 48 && $tCode <= 57)
			{
				$t = chr(97 + $tCode - 48);
			}
			$code .= $t;
		}
		
		return substr($code, 0, 13) . $str1 . substr($code, 13, 19);
	}
	
	//加密函数，可用decrypt()函数解密，$data：待加密的字符串或数组；$key：密钥；$expire 过期时间
	public static function encrypt($data, $key = '', $expire = 0)
	{
		$string=serialize($data);
		$ckeyLength = 4;
		$key = md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = substr(md5(microtime()), -$ckeyLength);
	
		$cryptkey = $keya.md5($keya.$keyc);
		$keyLength = strlen($cryptkey);
		
		$string =  sprintf('%010d', $expire ? $expire + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$stringLength = strlen($string);
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) 
		{
			$rndkey[$i] = ord($cryptkey[$i % $keyLength]);
		}
	
		for($j = $i = 0; $i < 256; $i++) 
		{
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $stringLength; $i++) 
		{
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		return $keyc.str_replace('=', '', base64_encode($result));
	}
	
	//encrypt之后的解密函数，$string待解密的字符串，$key，密钥
	public static function decrypt($string, $key = '')
	{
		$ckeyLength = 4;
		$key = md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = substr($string, 0, $ckeyLength);
		
		$cryptkey = $keya.md5($keya.$keyc);
		$keyLength = strlen($cryptkey);
		
		$string =  base64_decode(substr($string, $ckeyLength));
		$stringLength = strlen($string);
		
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) 
		{
			$rndkey[$i] = ord($cryptkey[$i % $keyLength]);
		}
	
		for($j = $i = 0; $i < 256; $i++) 
		{
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $stringLength; $i++) 
		{
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return unserialize(substr($result, 26));
		}
		else
		{
			return '';
		}
	}
	
	/**
	 * 功能：用来过滤字符串和字符串数组，防止被挂马和sql注入
	 * 参数$data，待过滤的字符串或字符串数组，
	 * $force为true，忽略get_magic_quotes_gpc
	 */
	public static function in($data, $force = false)
	{
		if (is_string($data))
		{
			$data = trim(htmlspecialchars($data));//防止被挂马，跨站攻击
			if (($force == true) || (!get_magic_quotes_gpc()))
			{
				$data = addslashes($data);//防止sql注入
			}
			return  $data;
		}
		else if (is_array($data))//如果是数组采用递归过滤
		{
			foreach($data as $key => $value)
			{
				$data[$key]=self::in($value,$force);
			}
			return $data;
		}
		else
		{
			return $data;
		}
	}
	
	//用来还原字符串和字符串数组，把已经转义的字符还原回来
	public static function out($data)
	{
		if (is_string($data))
		{
			return $data = stripslashes($data);
		}
		else if (is_array($data))//如果是数组采用递归过滤
		{
			foreach ($data as $key => $value)
			{
				 $data[$key]=self::out($value);
			}
			return $data;
		}
		else
		{
			return $data;
		}
	}
	
	//文本输入
	public static function textIn($str)
	{
		$str=strip_tags($str,'<br>');
		$str = str_replace(" ", "&nbsp;", $str);
		$str = str_replace("\n", "<br>", $str);
		if (!get_magic_quotes_gpc())
		{
			$str = addslashes($str);
		}
		return $str;
	}
	
	//文本输出
	public static function textOut($str)
	{
		$str = str_replace("&nbsp;", " ", $str);
		$str = str_replace("<br>", "\n", $str);
		$str = stripslashes($str);
		return $str;
	}
	
	//html代码输出
	public static function htmlOut($str)
	{
		if (function_exists('htmlspecialchars_decode'))
		{
			$str = htmlspecialchars_decode($str);
		}
		else
		{
			$str = html_entity_decode($str);
		}
		$str = stripslashes($str);
		return $str;
	}
	
	/**
	 * html转换输出
	 */
	public static function htmlspecialcharsArray($arr)
	{
		if (is_array($arr))
		{
			$res = array();
			foreach ($arr as $key => $value)
			{
				$res[$key] = self::htmlspecialcharsArray($value);
			}
			
			return $res;
		}
		else
		{
			return htmlspecialchars($arr, ENT_QUOTES);
		}
	}
	
	//html代码输入
	public static function htmlIn($str)
	{
		$search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
						 "'<iframe[^>]*?>.*?</iframe>'si", // 去掉iframe
						);
		$replace = array ("",
						  "",
						);
		$str = @preg_replace($search, $replace, $str);
		$str = htmlspecialchars($str);
		if (!get_magic_quotes_gpc())
		{
			$str = addslashes($str);
		}
		return $str;
	}
}

//文件和图片上传类
class Upload
{//类定义开始

    // 上传文件的最大值
    public $maxSize = -1;

    // 是否支持多文件上传
    public $supportMulti = true;

    // 允许上传的文件后缀
    //  留空不作后缀检查
    public $allowExts = array();

    // 允许上传的文件类型
    // 留空不做检查
    public $allowTypes = array();

    // 使用对上传图片进行缩略图处理
    public $thumb   =  false;
    // 缩略图最大宽度
    public $thumbMaxWidth;
    // 缩略图最大高度
    public $thumbMaxHeight;
    // 缩略图前缀
    public $thumbPrefix   =  'thumb_';
    public $thumbSuffix  =  '';
    // 缩略图保存路径
    public $thumbPath = '';
    // 缩略图文件名
    public $thumbFile		=	'';
    // 是否移除原图
    public $thumbRemoveOrigin = false;
    // 压缩图片文件上传
    public $zipImages = false;
    // 启用子目录保存文件
    public $autoSub   =  false;
    // 子目录创建方式 可以使用hash date
    public $subType   = 'hash';
    public $dateFormat = 'Ymd';
    public $hashLevel =  1; // hash的目录层次
    // 上传文件保存路径
    public $savePath = '';
    public $autoCheck = true; // 是否自动检查附件
    // 存在同名是否覆盖
    public $uploadReplace = false;

    // 上传文件命名规则
    // 例如可以是 time uniqid com_create_guid 等
    // 必须是一个无需任何参数的函数名 可以使用自定义函数
    public $saveRule = '';

    // 上传文件Hash规则函数名
    // 例如可以是 md5_file sha1_file 等
    public $hashType = 'md5_file';

    // 错误信息
    private $error = '';

    // 上传成功的文件信息
    private $uploadFileInfo ;

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function __construct($maxSize='',$allowExts='',$allowTypes='',$savePath='',$saveRule='')
    {
        if(!empty($maxSize) && is_numeric($maxSize)) {
            $this->maxSize = $maxSize;
        }
        if(!empty($allowExts)) {
            if(is_array($allowExts)) {
                $this->allowExts = array_map('strtolower',$allowExts);
            }else {
                $this->allowExts = explode(',',strtolower($allowExts));
            }
        }
        if(!empty($allowTypes)) {
            if(is_array($allowTypes)) {
                $this->allowTypes = array_map('strtolower',$allowTypes);
            }else {
                $this->allowTypes = explode(',',strtolower($allowTypes));
            }
        }
	   if(!empty($savePath)) {
            $this->savePath = $savePath;
        }	
        if(!empty($saveRule)) {
            $this->saveRule = $saveRule;
        }
	
        
    }

    private function save($file)
    {
        $filename = $file['savepath'].$file['savename'];
        if(!$this->uploadReplace && is_file($filename)) {
            // 不覆盖同名文件
            $this->error	=	'文件已经存在！'.$filename;
            return false;
        }
        // 如果是图像文件 检测文件格式
        if( in_array(strtolower($file['extension']),array('gif','jpg','jpeg','bmp','png','swf')) && false === getimagesize($file['tmp_name'])) {
            $this->error = '非法图像文件';
            return false;
        }
        if(!move_uploaded_file($file['tmp_name'], iconv('utf-8','gbk',$filename))) {
            $this->error = '文件上传保存错误！';
            return false;
        }
        if($this->thumb && in_array(strtolower($file['extension']),array('gif','jpg','jpeg','bmp','png'))) {
            $image =  getimagesize($filename);
            if(false !== $image) {
                //是图像文件生成缩略图
                $thumbWidth		=	explode(',',$this->thumbMaxWidth);
                $thumbHeight		=	explode(',',$this->thumbMaxHeight);
                $thumbPrefix		=	explode(',',$this->thumbPrefix);
                $thumbSuffix = explode(',',$this->thumbSuffix);
                $thumbFile			=	explode(',',$this->thumbFile);
                $thumbPath    =  $this->thumbPath?$this->thumbPath:$file['savepath'];
                // 生成图像缩略图
				if(file_exists(dirname(__FILE__).'/Image.php'))
				{
					$realFilename  =  $this->autoSub?basename($file['savename']):$file['savename'];
					for($i=0,$len=count($thumbWidth); $i<$len; $i++) {
						$thumbname	=	$thumbPath.$thumbPrefix[$i].substr($realFilename,0,strrpos($realFilename, '.')).$thumbSuffix[$i].'.'.$file['extension'];
						Image::thumb($filename,$thumbname,'',$thumbWidth[$i],$thumbHeight[$i],true);
					}
					if($this->thumbRemoveOrigin) {
						// 生成缩略图之后删除原图
						unlink($filename);
					}
				}
            }
        }
        if($this->zipImages) {
            // TODO 对图片压缩包在线解压

        }
        return true;
    }

    /**
     +----------------------------------------------------------
     * 上传文件
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $savePath  上传文件保存路径
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function upload($savePath ='')
    {
        //如果不指定保存文件名，则由系统默认
        if(empty($savePath))
            $savePath = $this->savePath;
        // 检查上传目录
        if(!is_dir($savePath)) {
            // 检查目录是否编码后的
            if(is_dir(base64_decode($savePath))) {
                $savePath	=	base64_decode($savePath);
            }else{
                // 尝试创建目录
                if(!mkdir($savePath)){
                    $this->error  =  '上传目录'.$savePath.'不存在';
                    return false;
                }
            }
        }else {
            if(!is_writeable($savePath)) {
                $this->error  =  '上传目录'.$savePath.'不可写';
                return false;
            }
        }
        $fileInfo = array();
        $isUpload   = false;

        // 获取上传的文件信息
        // 对$_FILES数组信息处理
        $files	 =	 $this->dealFiles($_FILES);
        foreach($files as $key => $file) {
            //过滤无效的上传
            if(!empty($file['name'])) {
                //登记上传文件的扩展信息
                $file['key']          =  $key;
                $file['extension']  = $this->getExt($file['name']);
                $file['savepath']   = $savePath;
                $file['savename']   = $this->getSaveName($file);

                // 自动检查附件
                if($this->autoCheck) {
                    if(!$this->check($file))
                        return false;
                }

                //保存上传文件
                if(!$this->save($file)) return false;
				/*
                if(function_exists($this->hashType)) {
                    $fun =  $this->hashType;
                    $file['hash']   =  $fun(auto_charset($file['savepath'].$file['savename'],'utf-8','gbk'));
                }
				*/
                //上传成功后保存文件信息，供其他地方调用
                unset($file['tmp_name'],$file['error']);
                $fileInfo[] = $file;
                $isUpload   = true;
            }
        }
        if($isUpload) {
            $this->uploadFileInfo = $fileInfo;
            return true;
        }else {
            $this->error  =  '没有选择上传文件';
            return false;
        }
    }

    /**
     +----------------------------------------------------------
     * 转换上传文件数组变量为正确的方式
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param array $files  上传的文件变量
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    private function dealFiles($files) {
       $fileArray = array();
       foreach ($files as $file){
           if(is_array($file['name'])) {
               $keys = array_keys($file);
               $count	 =	 count($file['name']);
               for ($i=0; $i<$count; $i++) {
                   foreach ($keys as $key)
                       $fileArray[$i][$key] = $file[$key][$i];
               }
           }else{
               $fileArray	=	$files;
           }
           break;
       }
       return $fileArray;
    }

    /**
     +----------------------------------------------------------
     * 获取错误代码信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $errorNo  错误号码
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    protected function error($errorNo)
    {
         switch($errorNo) {
            case 1:
                $this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
                break;
            case 2:
                $this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
                break;
            case 3:
                $this->error = '文件只有部分被上传';
                break;
            case 4:
                $this->error = '没有文件被上传';
                break;
            case 6:
                $this->error = '找不到临时文件夹';
                break;
            case 7:
                $this->error = '文件写入失败';
                break;
            default:
                $this->error = '未知上传错误！';
        }
        return ;
    }

    /**
     +----------------------------------------------------------
     * 根据上传文件命名规则取得保存文件名
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $filename 数据
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    private function getSaveName($filename)
    {
        $rule = $this->saveRule;
        if(empty($rule)) {//没有定义命名规则，则保持文件名不变
            $saveName = $filename['name'];
        }else {
			//使用给定的文件名作为标识号
			$saveName = $rule.".".$filename['extension'];
			/*
            if(function_exists($rule)) {
                //使用函数生成一个唯一文件标识号
                $saveName = $rule().".".$filename['extension'];
            }else {
                //使用给定的文件名作为标识号
                $saveName = $rule.".".$filename['extension'];
            }
			*/
        }
        if($this->autoSub) {
            // 使用子目录保存文件
            $saveName   =  $this->getSubName($filename).'/'.$saveName;
        }
        return $saveName;
    }

    /**
     +----------------------------------------------------------
     * 获取子目录的名称
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param array $file  上传的文件信息
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    private function getSubName($file)
    {
        switch($this->subType) {
            case 'date':
                $dir   =  date($this->dateFormat,time());
                break;
            case 'hash':
            default:
                $name = md5($file['savename']);
                $dir   =  '';
                for($i=0;$i<$this->hashLevel;$i++) {
                    $dir   .=  $name{0}.'/';
                }
                break;
        }
        if(!is_dir($file['savepath'].$dir)) {
            mkdir($file['savepath'].$dir);
        }
        return $dir;
    }

    /**
     +----------------------------------------------------------
     * 检查上传的文件
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param array $file 文件信息
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function check($file) {
        if($file['error']!== 0) {
            //文件上传失败
            //捕获错误代码
            $this->error($file['error']);
            return false;
        }

        //检查文件Mime类型
        if(!$this->checkType($file['type'])) {
            $this->error = '上传文件MIME类型不允许！';
            return false;
        }
        //检查文件类型
        if(!$this->checkExt($file['extension'])) {
            $this->error ='上传文件类型不允许';
            return false;
        }
        //文件上传成功，进行自定义规则检查
        //检查文件大小
        if(!$this->checkSize($file['size'])) {
            $this->error = '上传文件大小超出限制！';
            return false;
        }

        //检查是否合法上传
        if(!$this->checkUpload($file['tmp_name'])) {
            $this->error = '非法上传文件！';
            return false;
        }
        return true;
    }

    /**
     +----------------------------------------------------------
     * 检查上传的文件类型是否合法
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $type 数据
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkType($type)
    {
        if(!empty($this->allowTypes))
            return in_array(strtolower($type),$this->allowTypes);
        return true;
    }


    /**
     +----------------------------------------------------------
     * 检查上传的文件后缀是否合法
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $ext 后缀名
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkExt($ext)
    {
        if(!empty($this->allowExts))
            return in_array(strtolower($ext),$this->allowExts,true);
        return true;
    }

    /**
     +----------------------------------------------------------
     * 检查文件大小是否合法
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param integer $size 数据
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkSize($size)
    {
        return !($size > $this->maxSize) || (-1 == $this->maxSize);
    }

    /**
     +----------------------------------------------------------
     * 检查文件是否非法提交
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $filename 文件名
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkUpload($filename)
    {
        return is_uploaded_file($filename);
    }

    /**
     +----------------------------------------------------------
     * 取得上传文件的后缀
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $filename 文件名
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function getExt($filename)
    {
        $pathinfo = pathinfo($filename);
        return $pathinfo['extension'];
    }

    /**
     +----------------------------------------------------------
     * 取得上传文件的信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function getUploadFileInfo()
    {
        return $this->uploadFileInfo;
    }

    /**
     +----------------------------------------------------------
     * 取得最后一次错误信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getErrorMsg()
    {
        return $this->error;
    }

}//类定义结束

/**
 * 公共函数库
 * 静态类
 */
class Utils
{
	/**
	 * 获取日期时间
	 */
	public static function mdate($format, $dateStr = '')
	{
		if (empty($dateStr))
		{
			$date = new DateTime();
		}
		else
		{
			try
			{
				$date = new DateTime($dateStr);
			}
			catch (Exception $e)
			{
				$date = new DateTime('1970-01-01 08:00:00');
			}
		}
		
		return $date->format($format);
	}
	
	/**
	 * 获取客户端IP地址
	 */
	public static function getClientIp()
	{
	   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		   $ip = getenv("HTTP_CLIENT_IP");
	   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		   $ip = getenv("HTTP_X_FORWARDED_FOR");
	   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		   $ip = getenv("REMOTE_ADDR");
	   else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		   $ip = $_SERVER['REMOTE_ADDR'];
	   else
		   $ip = "unknown";
		
	   return $ip;
	}
	
	/**
	 * 递归创建文件夹	Utils::createDir('2012/02/10")
	 * $path	路径
	 */
	public static function createDir($path)
	{
		if (!file_exists($path))
		{
			self::createDir(dirname($path));
			mkdir($path, 0777);
		}
	}
	
	/**
	 * 遍历删除目录和目录下所有文件
	 */
	public static function delDir($dir)
	{
		if (!is_dir($dir))
		{
			return false;
		}
		$handle = opendir($dir);
		while (($file = readdir($handle)) !== false)
		{
			if ($file != "." && $file != "..")
			{
				is_dir("$dir/$file") ? self::delDir("$dir/$file") : @unlink("$dir/$file");
			}
		}
		if (readdir($handle) == false)
		{
			closedir($handle);
			@rmdir($dir);
		}
	}
	
	/**
	 * 中文字符串截取，有多余字符末尾自动加“...”
	 */
	public static function msubstr($str, $start, $length, $autoExtend = true, $charset='utf-8')
	{
		$srcLen = mb_strlen($str, $charset);
		$newStr = mb_substr($str, $start, $length, $charset);
		$newLen = mb_strlen($newStr, $charset);
		if ($autoExtend && $srcLen > $newLen)
		{
			$newStr .= '...';
		}
		
		return $newStr;
	}
	
	/**
	 * 检查字符串是否是UTF8编码,是返回true,否则返回false
	 */
	public static function isUtf8($string)
	{
		return preg_match('%^(?:
			 [\x09\x0A\x0D\x20-\x7E]            # ASCII
		   | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
		   |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
		   | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
		   |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
		   |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
		   | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
		   |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
	   )*$%xs', $string);
	}
	
	/**
	 * 浏览器友好的变量输出
	 */
	public static function dump($var, $exit=false)
	{
		ob_start();
		var_dump($var);
		$output = ob_get_clean();
		if(!extension_loaded('xdebug'))
		{
				$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
				$output = '<pre>'. htmlspecialchars($output, ENT_QUOTES). '</pre>';
		}
		echo $output;
		
		if ($exit)
		{
			exit;//终止程序
		}
		else
		{
			return;
		}
	}
	
	/**
	 * 生成唯一的值
	 */
	public static function genUniqid()
	{
		return md5(uniqid(rand(), true));
	}
	
	/**
	 * 获取两个日期相隔的天数
	 * return $day2 - $day1
	 */
	public static function restDays($day1, $day2)
	{
		return ceil((strtotime($day2) - strtotime($day1)) / (3600 * 24));
	}
	
	/**
	 * 获取两个日期相隔的秒数
	 * return $day2 - $day1
	 */
	public static function restSeconds($day1, $day2)
	{
		return strtotime($day2) - strtotime($day1);
	}
	
	/**
	 * 生成$n个字符串
	 */
	public static function replicate($str, $n)
	{
		$res = '';
		for ($i = 0; $i < $n; $i++)
		{
			$res .= $str;
		}
		
		return $res;
	}
	
	/**
	 * 获取指定格式日期
	 */
	public static function formatDate($date)
	{
		$monthEn = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$month = (int)self::mdate('m', $date);
		
		return $monthEn[$month - 1] . self::mdate(' j, Y', $date);
	}
	
	/**
	 * 返回数据到客户端
	 */
	public static function echoData($code = 0, $info = 'ok', $param = null)
	{
		$res = array('code' => $code, 'info' => $info);
		if (is_array($param))
		{
			$res = array_merge($res, $param);
		}
		
		echo json_encode($res);
	}
	
	/**
	 * 判断是否用移动设备打开网站
	 */
	public static function checkMobile()
	{
		$touchBrowserList = array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
					'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
					'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
					'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource',
					'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
					'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
					'benq', 'haier', '^lct', '320x320', '240x320', '176x220', 'windows phone');
		$wmlBrowserList = array('cect', 'compal', 'ctl', 'lg', 'nec', 'tcl', 'alcatel', 'ericsson', 'bird', 'daxian', 'dbtel', 'eastcom',
				'pantech', 'dopod', 'philips', 'haier', 'konka', 'kejian', 'lenovo', 'benq', 'mot', 'soutec', 'nokia', 'sagem', 'sgh',
				'sed', 'capitel', 'panasonic', 'sonyericsson', 'sharp', 'amoi', 'panda', 'zte', 'linux');
		$padList = array('ipad');
		$brower = array('mozilla', 'chrome', 'safari', 'opera', 'm3gate', 'winwap', 'openwave', 'myop');
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		
		if(self::dstrpos($useragent, $padList)) {
			return false;
		}
		
		$v = self::dstrpos($useragent, $touchBrowserList, true);
		if($v) {
			return $v;
		}
		
		if(self::dstrpos($useragent, $wmlBrowserList)) {
			return true;
		}
		
		if(self::dstrpos($useragent, $brower)) {
			return false;
		}
		
		return false;
		
		/*
		if (strpos(strtolower($_SERVER['REQUEST_URI']), 'wap'))
		{
			return true;
		}
		else
		{
			return false;
		}
		*/
	}
	
	/**
	 * 判断数组里是否包含指定字符串
	 */
	public static function dstrpos($string, $arr, $returnvalue = false) {
		if (empty($string)) return false;
		foreach ((array)$arr as $v) {
			if(strpos($string, $v) !== false) {
				$return = $returnvalue ? $v : true;
				return $return;
			}
		}
		
		return false;
	}
	
	/**
	 * 生成惟一文件名
	 */
	public static function genFilename($extend = '')
	{
		return time() . rand(100000, 999999) . $extend;
	}
	
	/**
	 * 编译PHP文件
	 * $files	待编译的PHP文件
	 * $fileMake	编译生成的PHP文件
	 */
	public static function makePhp($files, $fileMake, $extendsCode)
	{
		$fileWrite = fopen($fileMake, 'w');
		fwrite($fileWrite, "<?php");
		foreach ($files as $value)
		{
			$str = file_get_contents($value);
			$str = preg_replace('/^<\?php/', '', $str, 1);
			$str = preg_replace("/\?>\r\n$/", '', $str, 1);
			fwrite($fileWrite, $str);
		}
		if (!empty($extendsCode))
		{
			fwrite($fileWrite, $extendsCode . "\r\n");
		}
		fwrite($fileWrite, "?>\r\n");
		fclose($fileWrite);
	}
}

/**
 * 管理后台控制器
 */
class AdminController
{
	private $admin = null;//管理员模型
	
	public function __construct()
	{
		$this->admin = new Admin();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'verify':
				$this->verify();
				return;
			case 'doLogin':
				$this->doLogin();
				return;
			default:
		}
		
		if ($this->admin->checkLogin())
		{
			switch ($action)
			{
				case 'changePassword':
					$this->changePassword();
					return;
				case 'doChangePassword':
					$this->doChangePassword();
					return;
				case 'logout':
					$this->logout();
					return;
				case 'log':
					$this->log();
					return;
				case 'logTime':
					$this->logTime();
					return;
				case 'db':
					$this->db();
					return;
				case 'dbUser':
					$this->dbUser();
					return;
				case 'backup':
					$this->backup();
					return;
				case 'recover':
					//return;//disable
					$this->recover();
					return;
				case 'upgrade':
					$this->upgrade();
					return;
				case 'install':
					return;//disable
					$this->install();
					return;
				case 'find':
					$this->find();
					return;
				case 'phpinfo':
					$this->showPhpinfo();
					return;
				case 'exportUser':
					$this->exportUser();
					return;
				default:
					$this->main();
			}
		}
		else
		{
			$this->login();
		}
	}
	
	/**
	 * 生成验证码
	 */
	private function verify()
	{
		$this->admin->getVerify();
	}
	
	/**
	 * 登录
	 */
	private function doLogin()
	{
		System::fixSubmit('doLogin');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		$verify = Security::varPost('verify');
		
		if ($this->admin->checkVerify($verify))
		{
			if (empty($username) || empty($password))
			{
				Utils::echoData(2, '用户名和密码不能为空！');
			}
			else
			{
				if ($this->admin->login($username, $password))
				{
					Utils::echoData(0, '登录成功！');
				}
				else
				{
					Utils::echoData(1, '用户名或密码不正确！');
				}
			}
		}
		else
		{
			Utils::echoData(3, '验证码不正确！');
		}
	}
	
	/**
	 * 显示修改密码页
	 */
	private function changePassword()
	{
		include('view/admin/change_password.php');
	}
	
	/**
	 * 修改密码
	 */
	private function doChangePassword()
	{
		System::fixSubmit('doChangePassword');
		$srcPassword = Security::varPost('srcPassword');
		$newPassword = Security::varPost('newPassword');
		if (empty($srcPassword) || empty($newPassword))
		{
			Utils::echoData(2, '原密码和新密码不能为空！');
		}
		else
		{
			if ($this->admin->checkPassword($srcPassword))
			{
				$this->admin->changePassword($newPassword);
				$this->admin->logout();
				Utils::echoData(0, '修改成功！');
			}
			else
			{
				Utils::echoData(1, '原密码错误！');
			}
		}
	}
	
	/**
	 * 退出
	 */
	private function logout()
	{
		$this->admin->logout();
		$this->login();
	}
	
	/**
	 * 查看日志
	 */
	private function log()
	{
		$date = Security::varGet('date');
		if (empty($date))
		{
			if (file_exists(Debug::$logFile))
			{
				include(Debug::$logFile);
			}
			else
			{
				echo 'No log!';
			}
		}
		else
		{
			$logFile = Config::$dirLog . Utils::mdate('Y-m-d', $date) . '.php';
			if (file_exists($logFile))
			{
				include($logFile);
			}
			else
			{
				echo 'No log!';
			}
		}
	}
	
	/**
	 * 查看执行时间日志
	 */
	private function logTime()
	{
		$date = Security::varGet('date');
		if (empty($date))
		{
			if (file_exists(Debug::$timeFile))
			{
				include(Debug::$timeFile);
			}
			else
			{
				echo 'No log!';
			}
		}
		else
		{
			$timeFile = Config::$dirLog . 'time_' . Utils::mdate('Y-m-d', $date) . '.php';
			if (file_exists($timeFile))
			{
				include($timeFile);
			}
			else
			{
				echo 'No log!';
			}
		}
	}
	
	/**
	 * 查看数据库数据
	 */
	private function db()
	{
		$install = new Install();
		$allTables = $install->getAllTables();
		$_tableList = array();
		foreach ($allTables as $tbName)
		{
			$tableInfo = array();
			$tableInfo['tbname'] = $tbName;
			$tableInfo['fields'] = $install->getAllFields($tbName);
			$tableInfo['records'] = $install->getRecords($tbName, 0, 1000);
			$_tableList[] = $tableInfo;
		}
		include('view/admin/db.php');
	}
	
	private function dbUser()
	{
		$install = new Install();
		$allTables = array(Config::$tbUser);
		$_tableList = array();
		foreach ($allTables as $tbName)
		{
			$tableInfo = array();
			$tableInfo['tbname'] = $tbName;
			$tableInfo['fields'] = $install->getAllFields($tbName);
			$tableInfo['records'] = $install->getUserRecords($tbName, 0, 100);
			$_tableList[] = $tableInfo;
		}
		include('view/admin/db.php');
	}
	
	/**
	 * 备份数据库
	 */
	private function backup()
	{
		System::fixSubmit('backup');
		$install = new Install();
		$install->backup();
		echo 'ok';
	}
	
	/**
	 * 恢复数据库
	 */
	private function recover()
	{
		System::fixSubmit('recover');
		$install = new Install();
		$install->recover();
		echo 'ok';
	}
	
	/**
	 * 升级系统
	 */
	private function upgrade()
	{
		System::fixSubmit('upgrade');
		$install = new Install();
		$install->upgrade();
		echo 'ok';
	}
	
	/**
	 * 安装系统
	 */
	private function install()
	{
		System::fixSubmit('install');
		$install = new Install();
		$install->install();
		echo 'ok';
	}
	
	private function find()
	{
		$keywords = Security::varGet('keywords');
		$install = new Install();
		$_tableList = $install->find($keywords);
		include('view/admin/db.php');
	}
	
	private function showPhpinfo()
	{
		phpinfo();
	}
	
	private function exportUser()
	{
		$install = new Install();
		$install->exportUser();
	}
	
	/**
	 * 管理首页
	 */
	private function main()
	{
		include('view/admin/main.php');
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function login()
	{
		include('view/admin/login.php');
	}
}

/**
 * 管理后台控制器
 */
class AdminZeroController
{
	private $admin = null;//管理员模型
	private $zero = null;
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->zero = new FbZero();
		$action = Security::varGet('a');//操作标识
		
		if ($this->admin->checkLogin())
		{
			switch ($action)
			{
				case 'mainCount':
					$this->mainCount();
					return;
				case 'listPic':
					$this->listPic();
					return;
				case 'deletePic':
					$this->deletePic();
					return;
				default:
			}
		}
		else
		{
			$this->login();
		}
	}
	
	private function mainCount()
	{
		$_usersTotal = $this->zero->getUsersCount();
		$_picturesTotal = $this->zero->getPicCount();
		$_likesTotal = $this->zero->getLikesCount();
		$_commentsTotal = $this->zero->getCommentsCount();
		
		$_fbUsersTotal = $this->zero->usersCountByType(1);
		$_fbPicturesTotal = $this->zero->picCountByType(1);
		$_fbLikesTotal = $this->zero->likesCountByType(1);
		$_fbCommentsTotal = $this->zero->commentsCountByType(1);
		
		$_mUsersTotal = $this->zero->usersCountByType(2);
		$_mPicturesTotal = $this->zero->picCountByType(2);
		$_mLikesTotal = $this->zero->likesCountByType(2);
		$_mCommentsTotal = $this->zero->commentsCountByType(2);
		
		$_mwUsersTotal = $this->zero->usersCountByType(3);
		$_mwPicturesTotal = $this->zero->picCountByType(3);
		$_mwLikesTotal = $this->zero->likesCountByType(3);
		$_mwCommentsTotal = $this->zero->commentsCountByType(3);
		
		switch (Config::$configType)
		{
			case 5:
				$_country = 'Nigeria';
				break;
			case 6:
				$_country = 'Kenya';
				break;
			case 7:
				$_country = 'Egypt';
				break;
			case 8:
				$_country = 'Saudi Abrabia';
				break;
			case 9:
				$_country = 'Pakistan';
				break;
			case 10:
				$_country = 'Indonesia';
				break;
			default:
				$_country = 'Test Version';
		}
		include('view/admin/main_count.php');
	}
	
	private function listPic()
	{
		$page = (int) Security::varGet('page');
		$this->showPic($page);
	}
	
	private function showPic($page)
	{
		$pagesize = 20;
		if ($page < 1)
		{
			$page = 1;
		}
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=adminZero&a=listPic&page=';
		$pagelist->leftDelimiter = '';
		$pagelist->rightDelimiter = '';
		$allCount = $this->zero->getPicCount();
		$pagelist->totalPage = ceil($allCount / $pagesize);
		$_pagelist = $pagelist->getPages($page);
		$_page = $page;
		$_pagesize = $pagesize;
		$_data = $this->zero->getPics($page, $pagesize);
		$_appUrl = Config::$fbAppUrl;
		include('view/admin/list_pic.php');
	}
	
	private function deletePic()
	{
		$picId = (int) Security::varGet('id');
		$page = (int) Security::varGet('page');
		$this->zero->deletePic($picId);
		$this->showPic($page);
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function login()
	{
		include('view/admin/login.php');
	}
}

/**
 * Facebook控制器
 */
class FbController
{
	private $fb = null;//会员模型
	
	public function __construct()
	{
		$this->fb = new Fb();
		
		//奇偶页跳转登录
		$pageFlag = $this->fb->getPageFlag();
		if (1 == $pageFlag)
		{
			$this->fb->setPageFlag(0);
			echo '<a href="' . Config::$fbAppUrl . '" target="_top">Refresh</a><script type="text/javascript"> top.location.href = "' . Config::$fbAppUrl . '"; </script>';
			return;
		}
		
		if ($this->fb->checkLogin())
		{
			$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
			switch ($action)
			{
				case 'me':
					$this->me();
					break;
				case 'feed':
					$this->feed();
					break;
				case 'apprequests':
					$this->apprequests();
					break;
				case 'photos':
					$this->photos();
					break;
				case 'friends':
					$this->friends();
					break;
				case 'naitik':
					$this->naitik();
					break;
				case 'like':
					$this->like();
					break;
				case 'logFeed':
					$this->logFeed();
					break;
				case 'logInvite':
					$this->logInvite();
					break;
				default:
					//$this->main();
					$this->me();
			}
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function redirectLogin()
	{
		$this->fb->setPageFlag(1);
		$loginUrl = $this->fb->getLoginUrl();
		echo '<a href="' . $loginUrl . '" target="_top">Login with Facebook</a><script type="text/javascript"> top.location.href = "' . $loginUrl . '"; </script>';
	}
	
	private function me()
	{
		$res = $this->fb->me();
		$code = $res['code'];
		$userProfile = $res['userProfile'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$userProfile:<br />';
			var_dump($userProfile);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function feed()
	{
		$res = $this->fb->feed();
		$code = $res['code'];
		$feed = $res['feed'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$feed:<br />';
			var_dump($feed);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function apprequests()
	{
		$res = $this->fb->apprequests();
		$code = $res['code'];
		$apprequests = $res['apprequests'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$apprequests:<br />';
			var_dump($apprequests);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function photos()
	{
		$res = $this->fb->photos();
		$code = $res['code'];
		$photos = $res['photos'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$photos:<br />';
			var_dump($photos);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function friends()
	{
		$res = $this->fb->friends();
		$code = $res['code'];
		$friends = $res['friends'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$friends:<br />';
			var_dump($friends);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function naitik()
	{
		$res = $this->fb->naitik();
		$code = $res['code'];
		$naitik = $res['naitik'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$naitik:<br />';
			var_dump($naitik);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function like()
	{
		$res = $this->fb->like();
		$code = $res['code'];
		$info = $res['info'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$info:<br />';
			var_dump($info);
			echo '<br />';
		}
		else
		{
			echo 'error<br />';
			//$this->redirectLogin();
		}
	}
	
	private function logFeed()
	{
		$user = new User();
		$user->add_feed($this->fb->userId);
	}
	
	private function logInvite()
	{
		$user = new User();
		$user->add_invite($this->fb->userId);
	}
	
	private function main()
	{
		$res = $this->fb->me();
		$code = $res['code'];
		$userProfile = $res['userProfile'];
		if (0 == $code && !empty($userProfile))
		{
			$this->addUser($userProfile);
			$_['fbAppId'] = Config::$fbAppId;
			$_['userId'] = $this->fb->userId;
			$_['pagetab_uri'] = Config::$fbAppRedirectUrl;
			include('view/index.php');
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function addUser($userProfile)
	{
		$user = new User();
		$fbid = $this->fb->userId;
		if (!empty($fbid) && !empty($userProfile) && !$user->exist_user($fbid))
		{
			$username = isset($userProfile['username']) ? $userProfile['username'] : '';
			$email = isset($userProfile['email']) ? $userProfile['email'] : '';
			$link = isset($userProfile['link']) ? $userProfile['link'] : '';
			$realname = isset($userProfile['name']) ? $userProfile['name'] : '';
			$gender = isset($userProfile['gender']) ? $userProfile['gender'] : '';
			$timezone = isset($userProfile['timezone']) ? $userProfile['timezone'] : '';
			$locale = isset($userProfile['locale']) ? $userProfile['locale'] : '';
			$user->addUser($fbid, $username, $email, $link, $realname, $gender, $timezone, $locale);
		}
	}
}

/**
 * Zero控制器
 */
class FbZeroController
{
	private $zero = null;
	private $user = null;
	private $fb = null;
	
	public function __construct()
	{
		$this->zero = new FbZero();
		$this->user = new FbUser();
		$this->fb = new Fb();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'addPage':
				$_fbAppId = Config::$fbAppId;
				$_isFb = Config::$isFb;
				$_appSrcUrl = Config::$fbAppRedirectUrl;
				$_configType = Config::$configType;
				include('view/addPage.php');
				return;
			case 'testLogin':
				$testCode = Security::varPost('code');
				if ($testCode != 'zero')
				{
					Utils::echoData(1, 'code error');
					return;
				}
				else
				{
					System::setSession('userTestCode', 'zero');
					System::setSession('userTestFbid', rand(10000000, 99999999));
					Utils::echoData(0, 'ok');
				}
				return;
			case 'agreement':
				$this->agreement();
				return;
			case 'upload':
				$this->upload();
				return;
			case 'like':
				$this->like();
				return;
			case 'topTotal':
				$this->topTotal();
				return;
			case 'myRank':
				$this->myRank();
				return;
			case 'viewPic':
				$this->viewPic();
				return;
			case 'addComment':
				$this->addComment();
				return;
			case 'latest':
				$this->latest();
				return;
			default:
				$this->main();
		}
	}
	
	private function agreement()
	{
		System::fixSubmit('agreement');
		$nick = Security::varPost('nick');
		$email = Security::varPost('email');
		if (empty($nick))
		{
			Utils::echoData(2, 'Please enter the nickname!');
		}
		else
		{
			if ($this->user->existUsername($nick))
			{
				Utils::echoData(3, 'Nickname exist!');
			}
			else
			{
				if (!Check::email($email))
				{
					Utils::echoData(1, 'Please enter the correct email!');
				}
				else
				{
					$this->checkLogin();
					$userId = $this->user->getUserId();
					$fbid = $this->fb->userId;
					$photo = 'https://graph.facebook.com/' . $fbid . '/picture';
					//$this->zero->agreement($userId);
					$this->zero->agreementEmail($userId, $nick, $email, $photo);
					Utils::echoData(0, 'ok');
				}
			}
		}
	}
	
	private function upload()
	{
		System::fixSubmit('upload');
		$this->checkLogin();
		$userId = $this->user->getUserId();
		$param = $this->zero->upload($userId, 1);
		$code = $param['code'];
		$pic = $param['pic'];
		$smallPic = $param['smallPic'];
		$picId = $param['picId'];
		
		switch ($code)
		{
			case 0:
				$shareUrl = Config::$fbAppUrl . '?m=fbzero&a=viewPic&picId=' . $picId;
				Utils::echoData(0, 'ok', array('pic' => $pic, 'smallPic' => $smallPic, 'shareUrl' => $shareUrl, 'sharePic' => $smallPic));
				break;
			case 1:
				Utils::echoData(1, 'empty error!');
				break;
			case 2:
				Utils::echoData(2, 'size error!');
				break;
			default:
				Utils::echoData(3, 'upload error!');
		}
	}
	
	private function like()
	{
		System::fixSubmit('like');
		$this->checkLogin();
		$picId = (int)Security::varPost('picId');
		$userId = $this->user->getUserId();
		if ($this->zero->checkLikeToday($picId, $userId))
		{
			Utils::echoData(1, 'Liked Today!');
		}
		else
		{
			if ($picId > 0)
			{
				$this->zero->like($picId, $userId, 1);
				Utils::echoData(0, 'ok');
			}
			else
			{
				Utils::echoData(2, 'picId not exist!');
			}
		}
	}
	
	private function topTotal()
	{
		$this->checkLogin(true);
		$userId = $this->user->getUserId();
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		else if ($page > 25)
		{
			$page = 25;
		}
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=fbzero&a=topTotal&page=';
		$pagelist->leftDelimiter = '';
		$pagelist->rightDelimiter = '';
		$allCount = $this->zero->getPicCount();
		if ($allCount > 100)
		{
			$allCount = 100;
		}
		$pagelist->totalPage = ceil($allCount / 4);
		$_pagelist = $pagelist->getPages($page);
		$res = $this->zero->topTotal($page, 4);
		$_data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$_data[] = array_merge($row, array('liked' => $liked));
		}
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/rank_total.php');
	}
	
	private function latest()
	{
		$this->checkLogin(true);
		$userId = $this->user->getUserId();
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		else if ($page > 5)
		{
			$page = 5;
		}
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=fbzero&a=latest&page=';
		$pagelist->leftDelimiter = '';
		$pagelist->rightDelimiter = '';
		$allCount = $this->zero->getPicCount();
		if ($allCount > 20)
		{
			$allCount = 20;
		}
		$pagelist->totalPage = ceil($allCount / 4);
		$_pagelist = $pagelist->getPages($page);
		$res = $this->zero->latest($page, 4);
		$_data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$_data[] = array_merge($row, array('liked' => $liked));
		}
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/latest_upload.php');
	}
	
	private function myRank()
	{
		$this->checkLogin(true);
		$userId = $this->user->getUserId();
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=fbzero&a=myRank&page=';
		$pagelist->leftDelimiter = '';
		$pagelist->rightDelimiter = '';
		$res = $this->zero->myRank($userId);
		$pagelist->totalPage = ceil(count($res) / 4);
		$_pagelist = $pagelist->getPages($page);
		$_data = array();
		$index = 0;
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$index++;
			if ($index > ($page - 1) * 4 && $index <= $page * 4)
			{
				$picId = $row['pic_id'];
				//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
				$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
				$_data[] = array_merge($row, array('liked' => $liked));
			}
			if ($index > $page * 4)
			{
				break;
			}
		}
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/rank_self.php');
	}
	
	private function viewPic()
	{
		$_isPic = false;
		$_isLogin = false;
		$_picInfo = array();
		$_comment = array();
		$_selfPhoto = 'images/comment_photo.png';
		$_fbAppId = Config::$fbAppId;
		$_shareLink = '';
		
		$picId = (int) Security::varGet('picId');
		$_isLogin = $this->user->checkLogin();
		$_picInfo = $this->zero->getPicInfo($picId);
		$_shareLink = Config::$fbAppUrl . '?m=fbzero&a=viewPic&picId=' . $picId;
		
		if (!empty($_picInfo))
		{
			$_isPic = true;
			if ($_isLogin)
			{
				$userId = $this->user->getUserId();
				$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
				$_selfPhoto = $this->user->getUserPhoto();
			}
			else
			{
				$liked = 0;
			}
			$_picInfo['liked'] = $liked;
			$_comment = $this->zero->getComment($picId);
		}
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/view_pic.php');
	}
	
	private function addComment()
	{
		System::fixSubmit('addComment');
		$this->checkLogin();
		$picId = (int)Security::varPost('picId');
		$comment = Security::varPost('comment');
		$userId = $this->user->getUserId();
		if ($this->zero->checkCommentLock($picId, $userId))
		{
			Utils::echoData(1, 'Comments interval 60s.');
		}
		else
		{
			if ($picId > 0)
			{
				if (empty($comment))
				{
					Utils::echoData(3, 'Comments empty!');
				}
				else
				{
					$this->zero->addComment($picId, $userId, $comment, 1);
					$res = $this->zero->getComment($picId);
					Utils::echoData(0, 'ok', array('comments' => $res));
				}
			}
			else
			{
				Utils::echoData(2, 'picId not exist!');
			}
		}
	}
	
	private function main()
	{
		$this->checkLogin(true);
		$userId = $this->user->getUserId();
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_isFb = Config::$isFb;
		
		if ($this->zero->checkAgreement($userId))
		{
			include('view/main.php');
		}
		else
		{
			include('view/agreement.php');
		}
	}
	
	private function checkLogin($isPage = false)
	{
		if (!Config::$isFb)
		{
			$this->checkTestCode();
		}
		
		if (!$this->user->checkLogin())
		{
			if ($this->fb->checkLogin())
			{
				$fbid = $this->fb->userId;
				if (!$this->user->existFbid($this->fb->userId))
				{
					$this->user->addFbid($fbid);
				}
				$this->user->loginFb($fbid);
			}
			else
			{
				if ($isPage)
				{
					$this->login();
				}
				else
				{
					Utils::echoData(101, 'Not logged in!');
				}
				exit(0);
			}
		}
	}
	
	private function checkTestCode()
	{
		$userTestFbid = System::getSession('userTestFbid');
		if (empty($userTestFbid))
		{
			$userTestFbid = rand(10000000, 99999999);
			System::setSession('userTestFbid', $userTestFbid);
		}
		else
		{
			$userTestFbid = System::getSession('userTestFbid');
		}
		$this->fb->userId = $userTestFbid;
	}
	
	/**
	 * 显示登录界面
	 */
	private function login()
	{
		$_fbAppId = Config::$fbAppId;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/agreement.php');
		//$this->redirectLogin();
	}
	
	private function flagRedirect()
	{
		//奇偶页跳转登录
		$pageFlag = $this->fb->getPageFlag();
		if (1 == $pageFlag)
		{
			$this->fb->setPageFlag(0);
			echo '<a href="' . Config::$fbAppUrl . '" target="_top">Refresh</a><script type="text/javascript"> top.location.href = "' . Config::$fbAppUrl . '"; </script>';
			exit(0);
		}
	}
	
	private function redirectLogin()
	{
		$this->fb->setPageFlag(1);
		$loginUrl = $this->fb->getLoginUrl();
		echo '<a href="' . $loginUrl . '" target="_top">Login with Facebook</a><script type="text/javascript"> top.location.href = "' . $loginUrl . '"; </script>';
		exit(0);
	}
}

/**
 * 系统安装控制器
 */
class InstallController
{
	private $install = null;//安装模型
	
	public function __construct()
	{
		if (file_exists(Config::$installLock))
		{
			exit('Locked!');
		}
		else
		{
			$this->install = new Install();
			$action = Security::varGet('a');//操作标识
			switch ($action)
			{
				case 'createDatabase':
					$this->createDatabase();
					break;
				case 'install':
					$this->install();
					break;
				default:
			}
		}
	}
	
	/**
	 * 创建数据库
	 */
	private function createDatabase()
	{
		System::fixSubmit('createDatabase');
		$this->install->createDatabase();
		echo 'Succeed!';
	}
	
	/**
	 * 安装数据库
	 */
	private function install()
	{
		System::fixSubmit('install');
		$this->install->install();
		$this->createLockFile();
		echo 'Succeed!';
	}
	
	/**
	 * 生成锁定文件
	 */
	private function createLockFile()
	{
		$file = fopen(Config::$installLock, 'a');
		fwrite($file, '<?php //重要，请勿删除！需重新安装数据库或升级数据库时才可删除。?>');
		fclose($file);
	}
}

/**
 * 主入口控制器
 */
class MainController
{
	public function __construct()
	{
		Config::init();
		
		/////// debug
		if (Config::$configType == 2)
		{
			Debug::log('$_GET: ' . substr(@json_encode($_GET), 0, 500));
			Debug::log('$_POST: ' . substr(@json_encode($_POST), 0, 500));
		}
		
		$module = Security::varGet('m');//模块标识
		switch ($module)
		{
			case 'install':
				new InstallController();
				break;
			case 'admin':
				new AdminController();
				break;
			case 'adminZero':
				new AdminZeroController();
				break;
			case 'fb':
				new FbController();
				break;
			case 'fbzero':
				new FbZeroController();
				break;
			case 'user':
				new UserController();
				break;
			case 'zero':
				new ZeroController();
				break;
			case 'mwzero':
				new MwZeroController();
				break;
			case 'mwuser':
				new MwUserController();
				break;
			default:
				//new MwZeroController();
				//return;
				
				if (Utils::checkMobile())
				{
					//手机版
					new MwZeroController();
				}
				else
				{
					//PC版
					new FbZeroController();
				}
		}
		
		$action = Security::varGet('a');//操作标识
		if (!('admin' == $module && 'log' == $action) && !('admin' == $module && 'logTime' == $action))
		{
			Debug::logTime("[$module][$action]");
		}
	}
}

/**
 * 移动Web用户控制器
 */
class MwUserController
{
	private $user = null;//用户模型
	private $fb = null;
	
	public function __construct()
	{
		$this->user = new MwUser();
		$this->fb = new Fb();
		$action = Security::varGet('a');//操作标识
		
		switch ($action)
		{
			case 'register':
				$this->register();
				return;
			case 'login':
				$this->login();
				return;
			case 'profile':
				$this->profile();
				return;
			case 'logout':
				$this->logout();
				return;
			case 'verify':
				$this->user->getVerify();
				return;
			case 'doRegister':
				$this->doRegister();
				return;
			case 'doLogin':
				$this->doLogin();
				return;
			case 'getBaseInfo':
				$this->getBaseInfo();
				return;
			case 'doChangePassword':
				$this->doChangePassword();
				return;
			case 'doChangeName':
				$this->doChangeName();
				return;
			case 'doChangeGender':
				$this->doChangeGender();
				return;
			case 'doChangeAge':
				$this->doChangeAge();
				return;
			case 'doChangeLocale':
				$this->doChangeLocale();
				return;
			case 'doChangeEmail':
				$this->doChangeEmail();
				return;
			case 'doChangePhone':
				$this->doChangePhone();
				return;
			case 'doChangePhoto':
				$this->doChangePhoto();
				return;
			case 'doLogout':
				$this->doLogout();
				return;
			case 'doLoginFb':
				$this->doLoginFb();
				return;
			default:
		}
	}
	
	private function register()
	{
		include('view/mobile/register.php');
	}
	
	private function login()
	{
		include('view/mobile/login.php');
	}
	
	private function profile()
	{
		$this->checkLogin(true);
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_isFb = Config::$isFb;
		$_data = $this->user->getBaseInfo();
		include('view/mobile/profile.php');
	}
	
	private function logout()
	{
		$this->user->logout();
		$this->login();
	}
	
	private function doRegister()
	{
		System::fixSubmit('doRegister');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		$phone = Security::varPost('phone');
		$realname = Security::varPost('nick');
		
		if (empty($username) || empty($password))
		{
			Utils::echoData(1, 'Username & password cannot be empty!');
			return;
		}
		if (empty($phone))
		{
			Utils::echoData(4, 'Phone number cannot be empty!');
			return;
		}
		if (empty($realname))
		{
			Utils::echoData(2, 'Nickname cannot be empty!');
			return;
		}
		if ($this->user->existUsername($username))
		{
			Utils::echoData(3, 'Username exist!');
			return;
		}
		$this->user->register($username, $password, $phone, $realname);
		$this->user->login($username, $password);
		Utils::echoData(0, 'ok');
	}
	
	/**
	 * 登录
	 */
	private function doLogin()
	{
		System::fixSubmit('doLogin');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		if (empty($username) || empty($password))
		{
			Utils::echoData(1, 'Username & password cannot be empty!');
			return;
		}
		$isLogin = $this->user->login($username, $password);
		if ($isLogin)
		{
			Utils::echoData(0, 'ok');
		}
		else
		{
			Utils::echoData(2, 'Username or password error!');
		}
	}
	
	private function getBaseInfo()
	{
		$this->checkLogin();
		$data = $this->user->getBaseInfo();
		Utils::echoData(0, 'ok', array('data' => $data));
	}
	
	/**
	 * 修改密码
	 */
	private function doChangePassword()
	{
		$this->checkLogin();
		$srcPassword = Security::varPost('srcPassword');
		$newPassword = Security::varPost('newPassword');
		if (empty($srcPassword) || empty($newPassword))
		{
			Utils::echoData(106, '原密码和新密码不能为空！');
			return;
		}
		if ($this->user->checkPassword($srcPassword))
		{
			$this->user->changePassword($newPassword);
			//$this->user->logoutImei($uid);
			Utils::echoData(0, '修改成功！', array('imei' => $imei, 'uid' => $uid));
		}
		else
		{
			Utils::echoData(107, '原密码错误！');
		}
	}
	
	private function doChangeName()
	{
		$this->checkLogin();
		$realname = Security::varPost('realname');
		if (empty($realname))
		{
			Utils::echoData(1, 'Name cannot be empty!');
			return;
		}
		$this->user->changeName($realname);
		Utils::echoData(0, 'ok');
	}
	
	private function doChangeGender()
	{
		$this->checkLogin();
		$gender = Security::varPost('gender');
		if (empty($gender))
		{
			Utils::echoData(1, 'Gender cannot be empty!');
			return;
		}
		$this->user->changeGender($gender);
		Utils::echoData(0, 'ok');
	}
	
	private function doChangeAge()
	{
		$this->checkLogin();
		$age = (int) Security::varPost('age');
		if ($age <= 0 || $age >= 200)
		{
			Utils::echoData(1, 'Age error!');
			return;
		}
		$this->user->changeAge($age);
		Utils::echoData(0, 'ok');
	}
	
	private function doChangeLocale()
	{
		$this->checkLogin();
		$locale = Security::varPost('locale');
		if (empty($locale))
		{
			Utils::echoData(1, 'Area cannot be empty!');
			return;
		}
		$this->user->changeLocale($locale);
		Utils::echoData(0, 'ok');
	}
	
	private function doChangeEmail()
	{
		$this->checkLogin();
		$email = Security::varPost('email');
		if (Check::email($email))
		{
			$this->user->changeEmail($email);
			Utils::echoData(0, 'ok');
		}
		else
		{
			Utils::echoData(1, 'Please enter the correct email!');
		}
	}
	
	private function doChangePhone()
	{
		$this->checkLogin();
		$phone = Security::varPost('phone');
		if (empty($phone))
		{
			Utils::echoData(1, 'Phone number cannot be empty!');
			return;
		}
		$this->user->changePhone($phone);
		Utils::echoData(0, 'ok');
	}
	
	private function doChangePhoto()
	{
		$this->checkLogin();
		$param = $this->user->uploadPhoto();
		$code = $param['code'];
		$info = $param['info'];
		$pic = $param['pic'];
		Utils::echoData($code, $info, array('local_photo' => $pic));
	}
	
	private function doLogout()
	{
		$this->checkLogin();
		$this->user->logoutImei($uid);
		Utils::echoData(0, 'ok');
	}
	
	private function doLoginFb()
	{
		$fb = new Fb();
		$imei = Security::varPost('imei');
		$fbid = Security::varPost('fbid');
		$realname = Security::varPost('realname');
		$photo = Security::varPost('local_photo');
		if (empty($imei) || empty($fbid) || empty($realname) || empty($photo))
		{
			Utils::echoData(201, 'IMEI、fbid、姓名、头像地址不能为空！');
			return;
		}
		$uid = $this->user->getUidByFbid($fbid);
		if ('' == $uid)
		{
			$uid = $this->user->genUid();
			if ('' == $uid)
			{
				Utils::echoData(2, '用户id生成出错！');
			}
			else
			{
				$this->user->addFbid($fbid, $imei, $uid, $realname, $photo);
				$data = $this->user->getBaseInfo($uid);
				Utils::echoData(0, 'ok', array_merge(array('imei' => $imei), $data));
			}
		}
		else
		{
			$this->user->loginUid($uid);
			$data = $this->user->getBaseInfo($uid);
			Utils::echoData(0, 'ok', array_merge(array('imei' => $imei), $data));
		}
	}
	
	private function checkLogin($isPage = false)
	{
		if (!Config::$isFb)
		{
			$this->checkTestCode();
		}
		
		if (!$this->user->checkLogin())
		{
			if (!$this->user->loginCookie())
			{
				if ($isPage)
				{
					$this->login();
				}
				else
				{
					Utils::echoData(101, 'Not logged in!');
				}
				exit(0);
			}
		}
	}
	
	private function checkTestCode()
	{
		$userTestFbid = System::getSession('userTestFbid');
		if (empty($userTestFbid))
		{
			$userTestFbid = rand(10000000, 99999999);
			System::setSession('userTestFbid', $userTestFbid);
		}
		else
		{
			$userTestFbid = System::getSession('userTestFbid');
		}
		$this->fb->userId = $userTestFbid;
	}
}

/**
 * 移动Web Zero控制器
 */
class MwZeroController
{
	private $zero = null;
	private $user = null;
	private $fb = null;
	
	public function __construct()
	{
		$this->zero = new MwZero();
		$this->user = new MwUser();
		$this->fb = new Fb();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'rank':
				$this->rank();
				return;
			case 'latest':
				$this->latest();
				return;
			case 'create':
				$this->create();
				return;
			case 'history':
				$this->history();
				return;
			case 'uploadPic':
				$this->uploadPic();
				return;
			case 'getRank':
				$this->getRank();
				return;
			case 'like':
				$this->like();
				return;
			case 'viewPic':
				$this->viewPic();
				return;
			default:
				$this->rank();
		}
	}
	
	private function rank()
	{
		$this->checkLogin(true);
		$res = $this->zero->topTotal(1, 100);
		$_data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		$userId = (int)$this->user->getUserId();
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$_data[] = array_merge($row, array('liked' => $liked));
		}
		$_allCount = $this->zero->getPicCount();
		if ($_allCount > 100)
		{
			$_allCount = 100;
		}
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		include('view/mobile/rank.php');
	}
	
	private function latest()
	{
		$this->checkLogin(true);
		$res = $this->zero->latest(1, 20);
		$_data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		$userId = (int)$this->user->getUserId();
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$_data[] = array_merge($row, array('liked' => $liked));
		}
		$_allCount = $this->zero->getPicCount();
		if ($_allCount > 20)
		{
			$_allCount = 20;
		}
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		include('view/mobile/latest.php');
	}
	
	private function create()
	{
		$this->checkLogin(true);
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_isFb = Config::$isFb;
		include('view/mobile/create.php');
	}
	
	private function history()
	{
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_bestRank = 0;
		$_totalLikes = 0;
		$_data = array();
		$_userinfo = array();
		
		$this->checkLogin(true);
		$res = $this->zero->myRank();
		$index = 0;
		$isFirst = true;
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		$userId = (int)$this->user->getUserId();
		foreach ($res as $key => $row)
		{
			$index++;
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$row['upload_time'] = Utils::mdate('Y-m-d', $row['upload_time']);
			$_data[] = array_merge($row, array('liked' => $liked));
			if ($isFirst)
			{
				$isFirst = false;
				$_bestRank = $row['rank'];
			}
			$_totalLikes += $row['num'];
			if ($index >= 500)
			{
				break;
			}
		}
		$_userinfo = $this->user->getBaseInfo();
		include('view/mobile/history.php');
	}
	
	private function uploadPic()
	{
		System::fixSubmit('uploadPic');
		$this->checkLogin();
		$param = $this->zero->upload();
		$code = $param['code'];
		$pic = $param['pic'];
		$smallPic = $param['smallPic'];
		$picId = $param['picId'];
		
		switch ($code)
		{
			case 0:
				$shareUrl = Config::$fbAppUrl . '?m=fbzero&a=viewPic&picId=' . $picId;
				Utils::echoData(0, 'ok', array('pic' => $pic, 'smallPic' => $smallPic, 'shareUrl' => $shareUrl, 'sharePic' => $smallPic));
				break;
			case 1:
				Utils::echoData(1, 'empty error!');
				break;
			case 2:
				Utils::echoData(2, 'size error!');
				break;
			default:
				Utils::echoData(3, 'upload error!');
		}
	}
	
	private function getRank()
	{
		
	}
	
	private function checkLogin($isPage = false)
	{
		if (!Config::$isFb)
		{
			$this->checkTestCode();
		}
		
		if (!$this->user->checkLogin())
		{
			if (!$this->user->loginCookie())
			{
				if ($isPage)
				{
					$this->login();
				}
				else
				{
					Utils::echoData(101, 'Not logged in!');
				}
				exit(0);
			}
		}
	}
	
	private function checkTestCode()
	{
		$userTestFbid = System::getSession('userTestFbid');
		if (empty($userTestFbid))
		{
			$userTestFbid = rand(10000000, 99999999);
			System::setSession('userTestFbid', $userTestFbid);
		}
		else
		{
			$userTestFbid = System::getSession('userTestFbid');
		}
		$this->fb->userId = $userTestFbid;
	}
	
	/**
	 * 显示登录界面
	 */
	private function login()
	{
		$_fbAppId = Config::$fbAppId;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/mobile/login.php');
		//$this->redirectLogin();
	}
	
	private function like()
	{
		System::fixSubmit('like');
		$this->checkLogin();
		$picId = (int)Security::varPost('picId');
		if ($this->zero->checkLikeToday($picId))
		{
			Utils::echoData(1, 'Liked Today!');
		}
		else
		{
			if ($picId > 0)
			{
				$this->zero->like($picId);
				Utils::echoData(0, 'ok');
			}
			else
			{
				Utils::echoData(2, 'picId not exist!');
			}
		}
	}
	
	private function viewPic()
	{
		$_isPic = false;
		$_isLogin = false;
		$_picInfo = array();
		$_comment = array();
		$_selfPhoto = 'images/comment_photo.png';
		$_fbAppId = Config::$fbAppId;
		$_shareLink = '';
		
		$picId = (int) Security::varGet('picId');
		$pageFlag = (int) Security::varGet('pageFlag');
		$_isLogin = $this->user->checkLogin();
		$_picInfo = $this->zero->getPicInfo($picId);
		$_shareLink = Config::$fbAppUrl . '?m=fbzero&a=viewPic&picId=' . $picId;
		
		if (!empty($_picInfo))
		{
			$_isPic = true;
			if ($_isLogin)
			{
				$liked = $this->zero->checkLikeToday($picId) ? 1 : 0;
				$_selfPhoto = $this->user->getUserPhoto();
			}
			else
			{
				$liked = 0;
			}
			$_picInfo['liked'] = $liked;
			$_comment = $this->zero->getComment($picId);
		}
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		
		$_backUrl = '';
		switch ($pageFlag)
		{
			case 1:
				$_backUrl = '?m=mwzero&a=rank';
				break;
			case 2:
				$_backUrl = '?m=mwzero&a=latest';
				break;
			case 3:
				$_backUrl = '?m=mwzero&a=history';
				break;
			default:
				$_backUrl = '?m=mwzero&a=rank';
		}
		include('view/mobile/view_pic.php');
	}
}

/**
 * 手机端用户控制器
 */
class UserController
{
	private $user = null;//用户模型
	
	public function __construct()
	{
		$this->user = new User();
		$action = Security::varGet('a');//操作标识
		
		switch ($action)
		{
			case 'verify':
				$this->verify();
				return;
			case 'doRegister':
				$this->doRegister();
				return;
			case 'doLogin':
				$this->doLogin();
				return;
			case 'getBaseInfo':
				$this->getBaseInfo();
				return;
			case 'doChangePassword':
				$this->doChangePassword();
				return;
			case 'doChangeName':
				$this->doChangeName();
				return;
			case 'doChangeGender':
				$this->doChangeGender();
				return;
			case 'doChangeAge':
				$this->doChangeAge();
				return;
			case 'doChangeLocale':
				$this->doChangeLocale();
				return;
			case 'doChangeEmail':
				$this->doChangeEmail();
				return;
			case 'doChangePhoto':
				$this->doChangePhoto();
				return;
			case 'doLogout':
				$this->doLogout();
				return;
			case 'viewInfo':
				$this->viewInfo();
				return;
			case 'doLoginFb':
				$this->doLoginFb();
				return;
			default:
		}
	}
	
	/**
	 * 生成验证码
	 */
	private function verify()
	{
		$this->user->getVerify();
	}
	
	private function doRegister()
	{
		$imei = Security::varPost('imei');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		$realname = Security::varPost('nick');
		$gender = Security::varPost('gender');
		$email = Security::varPost('email');
		
		if (empty($username) || empty($password) || empty($imei))
		{
			Utils::echoData(103, 'Username & password cannot be empty!');
			return;
		}
		if (!empty($email) && !Check::email($email))
		{
			Utils::echoData(121, 'Please enter the correct email!');
			return;
		}
		if ($this->user->existUsername($username))
		{
			Utils::echoData(102, 'Username exist!');
			return;
		}
		$uid = $this->user->genUid();
		if (empty($uid))
		{
			Utils::echoData(203, 'User ID create error, please try again!');
			return;
		}
		$this->user->register($username, $password, $realname, $gender, $email, $imei, $uid);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	/**
	 * 登录
	 */
	private function doLogin()
	{
		$imei = Security::varPost('imei');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		if (empty($username) || empty($password) || empty($imei))
		{
			Utils::echoData(104, '用户名和密码不能为空！');
			return;
		}
		$param = $this->user->loginImei($username, $password);
		$state = $param['state'];
		if ($state)
		{
			$uid = $param['uid'];
			$data = $this->user->getBaseInfo($uid);
			Utils::echoData(0, 'ok', array_merge(array('imei' => $imei), $data));
		}
		else
		{
			Utils::echoData(105, '用户名或密码错误！');
		}
	}
	
	private function getBaseInfo()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$data = $this->user->getBaseInfo($uid);
		Utils::echoData(0, 'ok', array_merge(array('imei' => $imei), $data));
	}
	
	/**
	 * 修改密码
	 */
	private function doChangePassword()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$srcPassword = Security::varPost('srcPassword');
		$newPassword = Security::varPost('newPassword');
		$this->checkLogin($uid);
		if (empty($srcPassword) || empty($newPassword) || empty($imei) || empty($uid))
		{
			Utils::echoData(106, '原密码和新密码不能为空！');
			return;
		}
		if ($this->user->checkPassword($uid, $srcPassword))
		{
			$this->user->changePassword($uid, $newPassword);
			//$this->user->logoutImei($uid);
			Utils::echoData(0, '修改成功！', array('imei' => $imei, 'uid' => $uid));
		}
		else
		{
			Utils::echoData(107, '原密码错误！');
		}
	}
	
	private function doChangeName()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$realname = Security::varPost('realname');
		$this->checkLogin($uid);
		$this->user->changeName($uid, $realname);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	private function doChangeGender()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$gender = Security::varPost('gender');
		$this->checkLogin($uid);
		$this->user->changeGender($uid, $gender);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	private function doChangeAge()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$age = (int) Security::varPost('age');
		$this->checkLogin($uid);
		$this->user->changeAge($uid, $age);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	private function doChangeLocale()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$locale = Security::varPost('locale');
		$this->checkLogin($uid);
		$this->user->changeLocale($uid, $locale);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	private function doChangeEmail()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$email = Security::varPost('email');
		if (Check::email($email))
		{
			$this->checkLogin($uid);
			$this->user->changeEmail($uid, $email);
			Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
		}
		else
		{
			Utils::echoData(121, 'Please enter the correct email!');
		}
	}
	
	private function doChangePhoto()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$param = $this->user->uploadPhoto($uid);
		$code = $param['code'];
		$msg = $param['msg'];
		switch ($code)
		{
			case 0:
				$photo = $param['photo'];
				Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'local_photo' => $photo));
				break;
			case 1:
				Utils::echoData(1, $msg, array('imei' => $imei, 'uid' => $uid));
				break;
			default:
				Utils::echoData(1, $msg, array('imei' => $imei, 'uid' => $uid));
		}
	}
	
	private function doLogout()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$this->user->logoutImei($uid);
		Utils::echoData(0, 'ok');
	}
	
	private function viewInfo()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$openId = Security::varPost('openId');
		$data = $this->user->getUserInfo($openId);
		Utils::echoData(0, 'ok', array_merge(array('imei' => $imei, 'uid' => $uid, 'openId' => $openId), $data));
	}
	
	private function doLoginFb()
	{
		$fb = new Fb();
		$imei = Security::varPost('imei');
		$fbid = Security::varPost('fbid');
		$realname = Security::varPost('realname');
		$photo = Security::varPost('local_photo');
		if (empty($imei) || empty($fbid) || empty($realname) || empty($photo))
		{
			Utils::echoData(201, 'fbid、name、photo cannot be empty！');
			return;
		}
		if ($this->user->existUsername($realname))
		{
			Utils::echoData(202, 'Name exist！');
			return;
		}
		$uid = $this->user->getUidByFbid($fbid);
		if ('' == $uid)
		{
			$uid = $this->user->genUid();
			if ('' == $uid)
			{
				Utils::echoData(203, 'User ID create error, please try again!');
			}
			else
			{
				$this->user->addFbid($fbid, $imei, $uid, $realname, $photo);
				$data = $this->user->getBaseInfo($uid);
				Utils::echoData(0, 'ok', array_merge(array('imei' => $imei), $data));
			}
		}
		else
		{
			$this->user->loginUid($uid);
			$data = $this->user->getBaseInfo($uid);
			Utils::echoData(0, 'ok', array_merge(array('imei' => $imei), $data));
		}
	}
	
	private function checkLogin($uid)
	{
		if (!$this->user->checkLoginImei($uid))
		{
			Utils::echoData(101, 'Not logged in!');
			exit(0);
		}
	}
}

/**
 * Zero控制器
 */
class ZeroController
{
	private $zero = null;
	private $user = null;
	
	public function __construct()
	{
		$this->zero = new Zero();
		$this->user = new User();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'agreement':
				$this->agreement();
				return;
			case 'upload':
				$this->upload();
				return;
			case 'like':
				$this->like();
				return;
			case 'getTopTotal':
				$this->getTopTotal();
				return;
			case 'getLatest':
				$this->getLatest();
				return;
			case 'getMyRank':
				$this->getMyRank();
				return;
			case 'viewRank':
				$this->viewRank();
				return;
			case 'findUser':
				$this->findUser();
				return;
			case 'getComment':
				$this->getComment();
				return;
			case 'addComment':
				$this->addComment();
				return;
			default:
		}
	}
	
	private function agreement()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$userId = $this->user->getUserId($uid);
		$this->zero->agreement($userId);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	private function upload()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$userId = $this->user->getUserId($uid);
		$param = $this->zero->upload($userId, 2);
		$code = $param['code'];
		$pic = $param['pic'];
		$smallPic = $param['smallPic'];
		$msg = $param['msg'];
		$picId = $param['picId'];
		
		switch ($code)
		{
			case 0:
				Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'pic' => $pic, 'smallPic' => $smallPic, 'picId' => $picId));
				break;
			case 1:
				Utils::echoData(1, $msg, array('imei' => $imei, 'uid' => $uid));
				break;
			default:
				Utils::echoData(1, $msg, array('imei' => $imei, 'uid' => $uid));
		}
	}
	
	private function like()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$picId = Security::varPost('picId');
		$this->checkLogin($uid);
		$userId = $this->user->getUserId($uid);
		if ($this->zero->checkLikeToday($picId, $userId))
		{
			Utils::echoData(1, 'liked');
		}
		else
		{
			$this->zero->like($picId, $userId, 2);
			$num = $this->zero->getPicLikeNum($picId);
			Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'num' => $num));
		}
	}
	
	private function getTopTotal()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$page = (int)Security::varPost('page');
		$pagesize = (int) Security::varPost('pagesize');
		if ($page < 1)
		{
			$page =  1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 100;
		}
		if ($pagesize > 1000)
		{
			$pagesize = 1000;
		}
		$from = ($page - 1) * $pagesize;
		$total = $this->zero->getPicCount();
		if ($total > 1000)
		{
			$total = 1000;
		}
		$isLogin = $this->user->checkLoginImei($uid);
		if ($isLogin)
		{
			$userId = $this->user->getUserId($uid);
		}
		$res = $this->zero->topTotal(1000);
		$data = array();
		$index = 0;
		$count = 0;
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			if ($index >= $from)
			{
				$picId = $row['pic_id'];
				if ($isLogin)
				{
					//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
					$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
				}
				else
				{
					$liked = 0;
				}
				$data[] = array_merge($row, array('liked' => $liked));
				$count++;
				if ($count >= $pagesize)
				{
					break;
				}
			}
			$index++;
		}
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'total' => $total, 'data' => $data));
	}
	
	private function getLatest()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$page = (int)Security::varPost('page');
		$pagesize = (int) Security::varPost('pagesize');
		if ($page < 1)
		{
			$page =  1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 100;
		}
		if ($pagesize > 1000)
		{
			$pagesize = 1000;
		}
		$isLogin = $this->user->checkLoginImei($uid);
		if ($isLogin)
		{
			$userId = $this->user->getUserId($uid);
		}
		$total = $this->zero->getPicCount();
		$res = $this->zero->latest($page, $pagesize);
		$data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			if ($isLogin)
			{
				//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
				$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			}
			else
			{
				$liked = 0;
			}
			$data[] = array_merge($row, array('liked' => $liked));
		}
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'total' => $total, 'data' => $data));
	}
	
	private function getMyRank()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$userId = $this->user->getUserId($uid);
		$res = $this->zero->myRank($userId);
		$data = array();
		$index = 0;
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$index++;
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$data[] = array_merge($row, array('liked' => $liked));
			if ($index >= 500)
			{
				break;
			}
		}
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'data' => $data));
	}
	
	private function viewRank()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$openId = Security::varPost('openId');
		$isLogin = $this->user->checkLoginImei($uid);
		if ($isLogin)
		{
			$userId = $this->user->getUserId($uid);
		}
		$res = $this->zero->myRank($openId);
		$data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			if ($isLogin)
			{
				//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
				$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			}
			else
			{
				$liked = 0;
			}
			$data[] = array_merge($row, array('liked' => $liked));
		}
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'openId' => $openId, 'data' => $data));
	}
	
	private function findUser()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$username = Security::varPost('username');
		$openId = $this->user->getIdByName($username);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'openId' => $openId));
	}
	
	private function getComment()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$picId = Security::varPost('picId');
		$data = $this->zero->getComment($picId);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'data' => $data));
	}
	
	private function addComment()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$picId = Security::varPost('picId');
		$comment = Security::varPost('comment');
		$this->checkLogin($uid);
		$userId = $this->user->getUserId($uid);
		if ($this->zero->checkCommentLock($picId, $userId))
		{
			Utils::echoData(111, 'Comments interval 60s.');
		}
		else
		{
			if ($picId > 0)
			{
				if (empty($comment))
				{
					Utils::echoData(113, 'Comments empty!');
				}
				else
				{
					$this->zero->addComment($picId, $userId, $comment, 2);
					$data = $this->zero->getComment($picId);
					Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'data' => $data));
				}
			}
			else
			{
				Utils::echoData(112, 'picId not exist!');
			}
		}
	}
	
	private function checkLogin($uid)
	{
		if (!$this->user->checkLoginImei($uid))
		{
			Utils::echoData(101, 'Not logged in!');
			exit(0);
		}
	}
}

/**
 *	管理员
 */
class Admin
{
	public function __construct()
	{
	}
	
	/**
	 * 登录
	 */
	public function login($username, $password)
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$password = Security::multiMd5($password, Config::$key);
		$sqlUsername = Security::varSql($username);
		Config::$db->query("SELECT * FROM $tbAdmin WHERE username=$sqlUsername");
		$res = Config::$db->getRow();
		
		if (!empty($res))
		{
			if ($password == $res['password'])
			{
				System::setSession('adminUserId', (int)$res['id']);
				System::setSession('adminUsername', $res['username']);
				System::setSession('adminPassword', $res['password']);
				Debug::log('[admin login] userId: ' . $res['id'] . ', username: ' . $res['username']);
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 检测是否登录
	 */
	public function checkLogin()
	{
		if ($this->getUserId() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 注销
	 */
	public function logout()
	{
		System::clearSession('adminUserId');
		System::clearSession('adminUsername');
		System::clearSession('adminPassword');
	}
	
	/**
	 * 检测密码是否正确
	 */
	public function checkPassword($password)
	{
		$sessionPassword = $this->getPassword();
		$inPassword = Security::multiMd5($password, Config::$key);
		if ($sessionPassword == $inPassword)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 修改密码
	 */
	public function changePassword($newPassword)
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$sqlId = (int)$this->getUserId();
		$newPassword = Security::multiMd5($newPassword, Config::$key);
		$sqlNewPassword = Security::varSql($newPassword);
		Config::$db->query("UPDATE $tbAdmin SET password=$sqlNewPassword WHERE id=$sqlId");
	}
	
	/**
	 * 获取用户编号
	 */
	public function getUserId()
	{
		return (int)System::getSession('adminUserId');
	}
	
	/**
	 * 获取用户名
	 */
	public function getUsername()
	{
		return System::getSession('adminUsername');
	}
	
	/**
	 * 获取密码
	 */
	public function getPassword()
	{
		return System::getSession('adminPassword');
	}
	
	/**
	 * 生成验证码
	 */
	public function getVerify()
	{
		Image::buildImageVerify('48', '22', null, Config::$systemName . '_adminVerify');
	}
	
	/**
	 * 检查验证码
	 */
	public function checkVerify($code)
	{
		$verify = isset($_SESSION[Config::$systemName . '_adminVerify']) ? $_SESSION[Config::$systemName . '_adminVerify'] : '';
		unset($_SESSION[Config::$systemName . '_adminVerify']);
		if (!empty($verify) && $code == $verify)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

/**
 * 配置信息
 */
class Config
{
	public static $configType = 10;//配置方案//5：尼日利亚，6：肯尼亚，7：埃及，8：沙特阿拉伯，9：巴基斯坦，10：印尼
	public static $isLocal = false;//调试开关
	public static $isFb = false;//是否连接Facebook
	public static $systemName = 'p67_zero_to_hero';//系统名称
	public static $key = '22a,p67__zer.,o_to_hero1.f9f';//密钥
	public static $dirBackup = 'extends/db_backup/';//数据库备份目录
	public static $dirRecover = 'extends/db_recover/';//数据库恢复目录
	public static $dirLog = 'extends/log/';//日志目录
	public static $dirUploads = 'extends/uploads/';//上传目录
	public static $dirCache = 'extends/cache/';//缓存主目录
	public static $dirCacheNews = 'extends/cache/news/';//新闻缓存目录
	public static $installLock = 'extends/lock/install.php';//数据库安装锁定文件
	public static $viewCheck = '<?php if(!defined(\'VIEW\')) exit(0); ?>';//VIEW入口检测代码
	public static $countCode = '';//统计代码
	
	public static $maxUpload = 3;//3次上传机会
	public static $startDate = '2015-5-4';//活动的开始日期，用于计算当前为第几周
	public static $loginTypes = array('fb', 'apk', 'wap');//账号类型
	public static $maxPrize = 10;//最大奖品数
	public static $prizeName = array('奖品1', '奖品2', '奖品3', '奖品4', '奖品5', '奖品6', '奖品7', '奖品8', '奖品9', '奖品10');//奖品名称
	public static $prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	
	public static $fbAppId = '728451010610692';//facebook app id
	public static $fbAppKey = '8befd93e19e95fef3bc2cebf8c69839f';//facebook app key
	public static $fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/infinixzero/';//facebook app跳转地址
	public static $fbAppUrl = 'https://apps.facebook.com/infinixzero/';//facebook app地址
	
	public static $tbAdmin = 'zero_admin';//管理员表
	public static $tbUser = 'zero_user';//会员表
	public static $tbPic = 'zero_pic';//图片表
	public static $tbLike = 'zero_like';//点赞表
	public static $tbComment = 'zero_comment';//评论表
	
	public static $db = null;//数据库
	public static $dbConfig = null;//数据库配置信息，线上或本地
	public static $baseUrl = '';//当前网址，线上或本地
	
	//本地数据库配置信息
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'zero',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//qumuwu数据库配置信息
	private static $dbQumuwu = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'zero',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//infinixmobility数据库配置信息
	private static $dbInfinix = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'zero',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//infinix2数据库配置信息
	private static $dbInfinixZero = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'zerotohero',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//尼日利亚数据库配置信息
	private static $dbZeroNg = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_ng',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//肯尼亚数据库配置信息
	private static $dbZeroKe = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_ke',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//埃及数据库配置信息
	private static $dbZeroEg = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_eg',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//沙特阿拉伯数据库配置信息
	private static $dbZeroSa = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_sa',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//巴基斯坦数据库配置信息
	private static $dbZeroPk = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_pk',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//印尼数据库配置信息
	private static $dbZeroId = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_id',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	/**
	 * 初始化状态
	 */
	public static function init()
	{
		//设置中国时区，开启session
		@date_default_timezone_set('PRC');
		@session_start();
		if (self::$isLocal)
		{
			@error_reporting(E_ALL);
			self::$configType = 1;
		}
		else
		{
			@error_reporting(0);
		}
		
		switch (self::$configType)
		{
			case 1:
				//localhost
				self::$systemName = 'local_zero';
				self::$dbConfig = self::$dbLocal;
				self::$baseUrl = 'http://localhost:8008';
				self::$isFb = false;
				break;
			case 2:
				//qumuwu
				self::$systemName = 'qumuwu_zero';
				self::$dbConfig = self::$dbQumuwu;
				self::$baseUrl = 'http://zero.infinixmobility.qumuwu.com';
				self::$isFb = false;
				break;
			case 3:
				//infinixmobility
				self::$systemName = 'infinix_zero';
				self::$dbConfig = self::$dbInfinix;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/zerotohero';
				self::$isFb = false;
				break;
			case 4:
				//infinix线上
				self::$systemName = 'common_zero';
				self::$dbConfig = self::$dbInfinixZero;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/infinixzero';
				self::$isFb = true;
				self::$fbAppId = '728451010610692';
				self::$fbAppKey = '8befd93e19e95fef3bc2cebf8c69839f';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/infinixzero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixzero/';
				break;
			case 5:
				//尼日利亚
				self::$systemName = 'ng_zero';
				self::$dbConfig = self::$dbZeroNg;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/ngzero';
				self::$isFb = true;
				self::$fbAppId = '634236150045400';
				self::$fbAppKey = 'a50a59a5aaaf1792e15987469ca30ac8';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/ngzero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixng_zerotohero/';
				break;
			case 6:
				//肯尼亚
				self::$systemName = 'ke_zero';
				self::$dbConfig = self::$dbZeroKe;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/kezero';
				self::$isFb = true;
				self::$fbAppId = '726708487440435';
				self::$fbAppKey = '977a982884057f8a8362756e6ae0f6c0';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/kezero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixke_zerotohero/';
				break;
			case 7:
				//埃及
				self::$systemName = 'eg_zero';
				self::$dbConfig = self::$dbZeroEg;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/egzero';
				self::$isFb = true;
				self::$fbAppId = '459057217590512';
				self::$fbAppKey = '0dfe0c4d9803fbb026282be61c98ded1';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/egzero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixeg_zerotohero/';
				break;
			case 8:
				//沙特阿拉伯
				self::$systemName = 'sa_zero';
				self::$dbConfig = self::$dbZeroSa;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/sazero';
				self::$isFb = true;
				self::$fbAppId = '834409353313840';
				self::$fbAppKey = 'f78bc9de4ac686f041a02905fb115cc1';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/sazero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixsa_zerotohero/';
				break;
			case 9:
				//巴基斯坦
				self::$systemName = 'pk_zero';
				self::$dbConfig = self::$dbZeroPk;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/pkzero';
				self::$isFb = true;
				self::$fbAppId = '300775696781186';
				self::$fbAppKey = '7242a09640089ea86994eb3bd0d6c002';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/pkzero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixpk_zerotohero/';
				break;
			case 10:
				//印尼
				self::$systemName = 'id_zero';
				self::$dbConfig = self::$dbZeroId;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/idzero';
				self::$isFb = true;
				self::$fbAppId = '1598722133727859';
				self::$fbAppKey = '5198f892ec6a3e8bac73b7f036c9580d';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/idzero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixid_zerotohero/';
				break;
			default:
		}
		
		if (!self::$isFb)
		{
			self::$fbAppUrl = self::$baseUrl . '/';
		}
		
		//记录执行程序的当前时间，配置log文件位置
		Debug::$srcTime = microtime(true);
		Debug::$logFile = self::$dirLog . Utils::mdate('Y-m-d') . '.php';
		Debug::$timeFile = self::$dirLog . 'time_' . Utils::mdate('Y-m-d') . '.php';
		self::$db = new Database(self::$dbConfig);
		
		//限制视图文件须由控制器调用才可执行
		define('VIEW', true);
	}
}

/**
 *	Facebook操作
 */
class Fb
{
	public $userId = 0;
	
	private $facebook = null;//Facebook API
	
	public function __construct()
	{
		if (!Config::$isFb)
		{
			return;
		}
		
		$this->facebook = new Facebook(array(
			'appId'  => Config::$fbAppId,
			'secret' => Config::$fbAppKey,
		));
		$this->userId = $this->facebook->getUser();
	}
	
	public function checkLogin()
	{
		return !empty($this->userId);
	}
	
	function getLoginUrl()
	{
		//$loginUrl = $this->facebook->getLoginUrl();
		$loginUrl = $this->facebook->getLoginUrl(array(
			"response_type"=>"token",
			"redirect_uri"=>Config::$fbAppRedirectUrl,
			'scope' => 'user_about_me,friends_about_me,publish_actions,publish_stream,status_update,read_friendlists,email,user_location,friends_location'
		));
		
		return $loginUrl;
	}
	
	/**
	 * 奇偶标识
	 */
	public function getPageFlag()
	{
		$pageFlag = isset($_SESSION[Config::$systemName . '_facebookPageFlag']) ? (int)$_SESSION[Config::$systemName . '_facebookPageFlag'] : 0;
		
		return $pageFlag;
	}
	
	/**
	 * 奇偶标识
	 */
	public function setPageFlag($value)
	{
		$_SESSION[Config::$systemName . '_facebookPageFlag'] = $value;
	}
	
	public function me()
	{
		$errorCode = 0;
		$userProfile = null;
		try
		{
			$userProfile = $this->facebook->api('/me');
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'userProfile' => $userProfile);
	}
	
	public function feed()
	{
		$errorCode = 0;
		$feed = null;
		try
		{
			$feed = $this->facebook->api('/me/feed', 'post', array(
				'link' => 'http://www.geyaa.com',
				'picture' => 'http://www.geyaa.com/images/logo.png',
				'name' => 'geyaa name' . rand(1, 1000),
				'caption' => 'geyaa caption',
				'description' => 'geyaa description'
			));
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'feed' => $feed);
	}
	
	public function apprequests()
	{
		$errorCode = 0;
		$apprequests = null;
		try
		{
			$apprequests = $this->facebook->api('/me/apprequests', 'post', array(
				'message' => 'http://www.geyaa.com'
			));
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'apprequests' => $apprequests);
	}
	
	public function photos()
	{
		$errorCode = 0;
		$photos = null;
		try
		{
			$photos = $this->facebook->api('/me/photos');
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'photos' => $photos);
	}
	
	public function friends()
	{
		$errorCode = 0;
		$friends = null;
		try
		{
			$friends = $this->facebook->api('/me/friends');
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'friends' => $friends);
	}
	
	public function naitik()
	{
		$errorCode = 0;
		$naitik = null;
		try
		{
			$naitik = $this->facebook->api('/naitik');
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'naitik' => $naitik);
	}
	
	public function like()
	{
		$errorCode = 0;
		$info = null;
		try
		{
			//$info = $this->facebook->api('/me/og.likes');
			
			$info = $this->facebook->api('/me/og.likes', 'post', array(
				'object' => 'http://samples.ogp.me/226075010839791'
			));
			//http://samples.ogp.me/285576404819047
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'info' => $info);
	}
}

/**
 *	用户
 */
class FbUser
{
	public function __construct()
	{
	}
	
	public function existUsername($username)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select id from $tbUser where username=$sqlUsername");
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
	
	public function register($username, $password, $imei, $uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		$sqlImei = Security::varSql($imei);
		$sqlUid = Security::varSql($uid);
		$registerTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (username, password, imei, uid, register_time, upload_times, agreement, login_type, login_status) values ($sqlUsername, $sqlPassword, $sqlImei, $sqlUid, $registerTime, 0, 0, 2, 0)");
	}
	
	/**
	 * 登录
	 */
	public function login($username, $password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select * from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			$libPassword = $res['password'];
			$inputPassword = Security::multiMd5($password, Config::$key);
			if ($libPassword == $inputPassword)
			{
				$userId = (int)$res['id'];
				$username = $res['username'];
				System::setSession('userUserId', $userId);
				Debug::log('[user login] userId: ' . $userId . ', username: ' . $username);
				
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	/**
	 * 检测是否登录
	 */
	public function checkLogin()
	{
		if ($this->getUserId() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 用户编号
	 */
	public function getUserId()
	{
		return (int)System::getSession('userUserId');
	}
	
	public function getUserPhoto()
	{
		return System::getSession('userUserPhoto');
	}
	
	public function existFbid($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select id from $tbUser where fbid=$sqlFbid");
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
	
	public function addFbUser($fbid, $userProfile)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$username = isset($userProfile['username']) ? $userProfile['username'] : '';
		$email = isset($userProfile['email']) ? $userProfile['email'] : '';
		$link = isset($userProfile['link']) ? $userProfile['link'] : '';
		$realname = isset($userProfile['name']) ? $userProfile['name'] : '';
		$gender = isset($userProfile['gender']) ? $userProfile['gender'] : '';
		$timezone = isset($userProfile['timezone']) ? $userProfile['timezone'] : '';
		$locale = isset($userProfile['locale']) ? $userProfile['locale'] : '';
		
		$sqlFbid = Security::varSql($fbid);
		$sqlUsername = Security::varSql($username);
		$sqlEmail = Security::varSql($email);
		$sqlLink = Security::varSql($link);
		$sqlRealname = Security::varSql($realname);
		$sqlGender = Security::varSql($gender);
		$sqlTimezone = Security::varSql($timezone);
		$sqlLocale = Security::varSql($locale);
		$sqlRegisterTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlPhoto = Security::varSql('https://graph.facebook.com/' . $fbid . '/picture');
		Config::$db->query("insert into $tbUser (fbid, username, email, photo, link, realname, gender, timezone, locale, register_time, upload_times, agreement, login_type, login_status, local_photo) values ($sqlFbid, $sqlUsername, $sqlEmail, $sqlPhoto, $sqlLink, $sqlRealname, $sqlGender, $sqlTimezone, $sqlLocale, $sqlRegisterTime, 0, 0, 1, 0, $sqlPhoto)");
	}
	
	public function addFbid($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		$sqlPhoto = Security::varSql('https://graph.facebook.com/' . $fbid . '/picture');
		$sqlRegisterTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (fbid, photo, register_time, upload_times, agreement, login_type, login_status, local_photo) values ($sqlFbid, $sqlPhoto, $sqlRegisterTime, 0, 0, 1, 0, $sqlPhoto)");
	}
	
	public function loginFb($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select * from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$userId = (int)$res['id'];
			$username = $res['username'];
			System::setSession('userUserId', $userId);
			System::setSession('userUserPhoto', $res['local_photo']);
			Debug::log('[user fb login] userId: ' . $userId . ', username: ' . $username);
		}
	}
}

/**
 *	Zero
 */
class FbZero
{
	public function __construct()
	{
	}
	
	public function agreement($userId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$userId;
		Config::$db->query("UPDATE $tbUser SET agreement=1 WHERE id=$sqlUserId");
	}
	
	public function agreementEmail($userId, $nick, $email)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$userId;
		$sqlNick = Security::varSql($nick);
		$sqlEmail = Security::varSql($email);
		Config::$db->query("UPDATE $tbUser SET agreement=1, username=$sqlNick, realname=$sqlNick, email=$sqlEmail WHERE id=$sqlUserId");
	}
	
	public function checkAgreement($userId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$userId;
		Config::$db->query("select agreement from $tbUser WHERE id=$sqlUserId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			if (1 == $res['agreement'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function upload($userId, $loginType)
	{
		$baseName = Config::$dirUploads . time() . rand(100000, 999999);
		$tempPic = $baseName . '_temp.jpg';
		$pic = $baseName . '.jpg';
		$smallPic = $baseName . '_small.jpg';
		//$postStr =  $GLOBALS[HTTP_RAW_POST_DATA];
		$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
		if (empty($postStr))
		{
			$postStr = file_get_contents('php://input');
		}
		if (empty($postStr))
		{
			return array('code' => 1, 'pic' => '', 'smallPic' => '');
		}
		if (strlen($postStr) > 500000)
		{
			return array('code' => 2, 'pic' => '', 'smallPic' => '');
		}
		$file = fopen($tempPic, 'w');
		fwrite($file, $postStr);
		fclose($file);
		Image::thumb($tempPic, $pic, "", 764, 616);
		Image::thumb($tempPic, $smallPic, "", 248, 200);
		@unlink($tempPic);
		
		$picUrl = Config::$baseUrl . '/' . $pic;
		$smallPicUrl = Config::$baseUrl . '/' . $smallPic;
		$picId = $this->savePic($picUrl, $smallPicUrl, $userId, $loginType);
		
		return array('code' => 0, 'pic' => $picUrl, 'smallPic' => $smallPicUrl, 'picId' => $picId);
	}
	
	public function savePic($pic, $smallPic, $userId, $loginType)
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		$tbUser = Config::$tbUser;
		$sqlPic = Security::varSql($pic);
		$sqlSmallPic = Security::varSql($smallPic);
		$sqlUserId = (int)$userId;
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoginType = (int)$loginType;
		Config::$db->query("insert into $tbPic (pic, small_pic, user_id, do_time, login_type) values ($sqlPic, $sqlSmallPic, $sqlUserId, $sqlDoTime, $sqlLoginType)");
		$picId = Config::$db->getInsertId();
		Config::$db->query("update $tbUser set upload_times = upload_times+1 where id=$sqlUserId");
		return $picId;
	}
	
	public function checkLikeToday($picId, $userId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select id from $tbLike where pic_id=$sqlPicId and user_id=$sqlUserId and date_format(do_time, '%Y-%m-%d')=$sqlDate");
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
	
	public function checkLiked($picId, $userId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		Config::$db->query("select id from $tbLike where pic_id=$sqlPicId and user_id=$sqlUserId");
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
	
	public function like($picId, $userId, $loginType)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		$sqlWeek = $this->getCurrentWeek();
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoginType = (int)$loginType;
		Config::$db->query("insert into $tbLike (pic_id, user_id, week, do_time, login_type) values ($sqlPicId, $sqlUserId, $sqlWeek, $sqlDoTime, $sqlLoginType)");
	}
	
	public function topTotal($page, $pagesize)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		return $res;
	}
	
	public function latest($page, $pagesize)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by t1.id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		return $res;
	}
	
	public function myRank($userId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$sqlWeek = $this->getCurrentWeek();
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc");
		$res = Config::$db->getAllRows();
		
		$rankIndex = 1;
		$selfRank = array();
		if (!empty($res))
		{
			foreach ($res as $row)
			{
				if ($userId == $row['open_id'])
				{
					$selfRank[] = array_merge($row, array('rank' => $rankIndex));
				}
				$rankIndex++;
			}
		}
		
		return $selfRank;
	}
	
	public function getCurrentWeek()
	{
		$day = Utils::restDays(Config::$startDate, Utils::mdate('Y-m-d'));
		$week = (int)($day / 7) + 1;
		return $week;
	}
	
	public function addComment($picId, $userId, $content, $loginType)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		$content = json_encode(mb_substr($content, 0, 500));
		$sqlContent = Security::varSql($content);
		$sqlLoginType = (int)$loginType;
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbComment (pic_id, user_id, content, do_time, login_type) values ($sqlPicId, $sqlUserId, $sqlContent, $sqlDoTime, $sqlLoginType)");
	}
	
	public function checkCommentLock($picId, $userId)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		Config::$db->query("select do_time from $tbComment where pic_id=$sqlPicId and user_id=$sqlUserId order by id desc limit 0, 1");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			$lastTime = $res['do_time'];
			$now = Utils::mdate('Y-m-d H:i:s');
			if (Utils::restSeconds($lastTime, $now) <= 60)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function getComment($picId)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$tbUser = Config::$tbUser;
		$sqlPicId = (int)$picId;
		Config::$db->query("select t1.id id, t1.pic_id pic_id, t1.user_id user_id, t1.content content, t1.do_time comment_time, t2.username username, t2.local_photo photo from $tbComment t1 join $tbUser t2 on t1.user_id=t2.id where pic_id=$sqlPicId order by id desc limit 0, 1000");
		$res = Config::$db->getAllRows();
		if (!empty($res))
		{
			foreach ($res as $key => $row)
			{
				$res[$key]['comment_time'] = Utils::mdate('Y-m-d', $row['comment_time']);
				$res[$key]['content'] = htmlspecialchars(json_decode($row['content'], true), ENT_QUOTES);
			}
		}
		return $res;
	}
	
	public function getPicInfo($picId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$picId = (int)$picId;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc");
		$res = Config::$db->getAllRows();
		
		$rankIndex = 1;
		$picInfo = array();
		if (!empty($res))
		{
			foreach ($res as $row)
			{
				if ($picId == $row['pic_id'])
				{
					$picInfo = array_merge($row, array('rank' => $rankIndex));
					$picInfo['upload_time'] = Utils::mdate('Y-m-d', $picInfo['upload_time']);
					break;
				}
				$rankIndex++;
			}
		}
		
		return $picInfo;
	}
	
	public function getUsersCount()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		Config::$db->query("select count(*) as num from $tbUser");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function getPicCount()
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		Config::$db->query("select count(*) as num from $tbPic");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function getLikesCount()
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		Config::$db->query("select count(*) as num from $tbLike");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function getCommentsCount()
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		Config::$db->query("select count(*) as num from $tbComment");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function usersCountByType($type)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlType = (int)$type;
		Config::$db->query("select count(*) as num from $tbUser where login_type=$sqlType");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function picCountByType($type)
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		$sqlType = (int)$type;
		Config::$db->query("select count(*) as num from $tbPic where login_type=$sqlType");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function likesCountByType($type)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlType = (int)$type;
		Config::$db->query("select count(*) as num from $tbLike where login_type=$sqlType");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function commentsCountByType($type)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlType = (int)$type;
		Config::$db->query("select count(*) as num from $tbComment where login_type=$sqlType");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function getLikesKey()
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		Config::$db->query("select pic_id, user_id, do_time from $tbLike");
		$res = Config::$db->getAllRows();
		$arr = array();
		if (!empty($res))
		{
			foreach ($res as $row)
			{
				$arr[$row['pic_id'] . '_' . $row['user_id'] . '_' . Utils::mdate('Y-m-d', $row['do_time'])] = 1;
			}
		}
		return $arr;
	}
	
	public function getPics($page, $pagesize)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id, t3.phone as phone, t3.email as email from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		return $res;
	}
	
	public function deletePic($picId)
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		Config::$db->query("delete from $tbLike where pic_id=$sqlPicId");
		Config::$db->query("delete from $tbComment where pic_id=$sqlPicId");
		Config::$db->query("delete from $tbPic where id=$sqlPicId");
	}
}

/**
 * 安装系统
 */
class Install
{
	public function __construct()
	{
	}
	
	/**
	 * 创建数据库
	 */
	public function createDatabase()
	{
		$dbName = Config::$dbConfig['dbName'];
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		Config::$db->connect();
		Config::$db->query("create database if not exists $dbName default character set $dbCharset collate $dbCollat");
	}
	
	/**
	 * 安装系统
	 */
	public function install()
	{
		$this->createTable();
		$this->insert();
	}
	
	/**
	 * 创建表
	 */
	private function createTable()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$tbComment = Config::$tbComment;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		Config::$db->query("drop table if exists $tbAdmin");
		Config::$db->query("create table $tbAdmin (
			id int not null auto_increment primary key,
			username varchar(50) not null,
			password varchar(200) not null
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbUser");
		Config::$db->query("create table $tbUser (
			id int not null auto_increment primary key,
			username varchar(100) not null,
			password varchar(200) not null,
			fbid varchar(50) not null,
			phone varchar(50) not null,
			email varchar(320) not null,
			photo varchar(256) not null,
			link varchar(256) not null,
			realname varchar(50) not null,
			gender varchar(50) not null,
			timezone varchar(10) not null,
			locale varchar(50) not null,
			age int not null,
			register_time datetime not null,
			login_time datetime not null,
			upload_times int not null,
			agreement int not null,
			login_type int not null,
			imei varchar(50) not null,
			uid varchar(50) not null,
			login_status int not null,
			local_photo varchar(256) not null
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbPic");
		Config::$db->query("create table $tbPic (
			id int not null auto_increment primary key,
			pic varchar(256) not null,
			small_pic varchar(256) not null,
			user_id int not null,
			do_time datetime not null,
			login_type int not null
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbLike");
		Config::$db->query("create table $tbLike (
			id int not null auto_increment primary key,
			pic_id int not null,
			user_id int not null,
			week int not null,
			do_time datetime not null,
			login_type int not null,
			index (pic_id),
			index (user_id)
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbComment");
		Config::$db->query("create table $tbComment (
			id int not null auto_increment primary key,
			pic_id int not null,
			user_id int not null,
			content varchar(3010) not null,
			do_time datetime not null,
			login_type int not null,
			index (pic_id)
		) engine = myisam character set $dbCharset collate $dbCollat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$sqlPassword = Security::multiMd5('admin', Config::$key);
		Config::$db->query("insert into $tbAdmin (username, password) values ('admin', '$sqlPassword')");
	}
	
	/**
	 * 获取所有的表名
	 */
	public function getAllTables()
	{
		Config::$db->connect();
		return Config::$db->getAllTables();
	}
	
	/**
	 * 获取指定表的所有字段名
	 */
	public function getAllFields($tbName)
	{
		Config::$db->connect();
		return Config::$db->getAllFields($tbName);
	}
	
	/**
	 * 获取指定表的所有记录
	 */
	public function getRecords($tbName, $start = 0, $recordCount = 10)
	{
		Config::$db->connect();
		$res = array();
		$resIndex = 0;
		$sqlStart = (int)$start;
		$sqlRecordCount = (int)$recordCount;
		Config::$db->query("select * from $tbName limit $sqlStart, $sqlRecordCount");
		while ($row = Config::$db->getRow(MYSQL_NUM))
		{
			$fieldsCount = count($row);
			for ($i = 0; $i < $fieldsCount; $i++)
			{
				$res[$resIndex][$i] = htmlspecialchars($row[$i], ENT_QUOTES);
			}
			$resIndex++;
		}
		
		return $res;
	}
	
	/**
	 * 备份数据库
	 */
	public function backup()
	{
		$path = Config::$dirBackup . Utils::mdate('Y-m-d') . '/';
		Utils::createDir($path);
		$db = new Dbbak(Config::$dbConfig['hostname'], Config::$dbConfig['username'], Config::$dbConfig['password'], Config::$dbConfig['dbName'], Config::$dbConfig['dbCharset'], $path);
		$tableArray = $db->getTables();
		$db->exportSql($tableArray);
	}
	
	/**
	 * 恢复数据库
	 */
	public function recover()
	{
		$db = new Dbbak(Config::$dbConfig['hostname'], Config::$dbConfig['username'], Config::$dbConfig['password'], Config::$dbConfig['dbName'], Config::$dbConfig['dbCharset'], Config::$dirRecover);
		$db->importSql();
	}
	
	public function find($keywords)
	{
		Config::$db->connect();
		$res = array();
		$sqlKeywords = Security::varSql('%' . $keywords . '%');
		$tables = $this->getAllTables();
		foreach ($tables as $tb)
		{
			echo '$tb: ' . $tb . '<br />';
			$fields = $this->getAllFields($tb);
			foreach ($fields as $fd)
			{
				if ('register_time' == $fd)
				{
					continue;
				}
				echo '$fd: ' . $fd . '<br />';
				$sqlTb = '`' . $tb . '`';
				$sqlFd = '`' . $fd . '`';
				Config::$db->query("select $sqlFd from $sqlTb where $sqlFd like $sqlKeywords");
				$rows = Config::$db->getAllRows();
				if (!empty($rows))
				{
					$tableInfo = array();
					$tableInfo['tbname'] = $tb;
					$tableInfo['fields'] = array($fd);
					$tableInfo['records'] = $rows;
					$res[] = $tableInfo;
				}
			}
		}
		
		return $res;
	}
	
	private function createComment()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$tbComment = Config::$tbComment;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		Config::$db->query("drop table if exists $tbComment");
		Config::$db->query("create table $tbComment (
			id int not null auto_increment primary key,
			pic_id int not null,
			user_id int not null,
			content varchar(3010) not null,
			do_time datetime not null,
			login_type int not null,
			index (pic_id)
		) engine = myisam character set $dbCharset collate $dbCollat;");
	}
	
	/**
	 * 获取指定表的所有记录
	 */
	public function getUserRecords($tbName, $start = 0, $recordCount = 10)
	{
		Config::$db->connect();
		$res = array();
		$resIndex = 0;
		$sqlStart = (int)$start;
		$sqlRecordCount = (int)$recordCount;
		//Config::$db->query("select * from $tbName where realname='' limit $sqlStart, $sqlRecordCount");
		//Config::$db->query("select * from $tbName where username='' limit $sqlStart, $sqlRecordCount");
		Config::$db->query("select * from $tbName limit 0, 100");
		while ($row = Config::$db->getRow(MYSQL_NUM))
		{
			$fieldsCount = count($row);
			for ($i = 0; $i < $fieldsCount; $i++)
			{
				$res[$resIndex][$i] = htmlspecialchars($row[$i], ENT_QUOTES);
			}
			$resIndex++;
		}
		
		return $res;
	}
	
	public function exportUser()
	{
		require_once('classes/PHPExcel.php');
		$excel = new PHPExcel();
		//设置文件的详细信息
		$excel->getProperties()->setCreator("Administrators")
			->setLastModifiedBy("Administrators")
			->setTitle("Data")
			->setSubject("")
			->setDescription("")
			->setKeywords("")
			->setCategory("");
		
		//操作第一个工作表
		$excel->setActiveSheetIndex(0);
		//设置工作薄名称
		$excel->getActiveSheet()->setTitle('Data');
		//设置默认字体和大小
		$excel->getDefaultStyle()->getFont()->setName('Times New Roman');
		$excel->getDefaultStyle()->getFont()->setSize(14);
		
		/*
		//设置列宽度
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(148);
		*/
		
		/*
		//设置行高度
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(169);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(60);
		*/
		
		/*
		//设置水平居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		*/
		
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		/*
		//设置垂直居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		*/
		
		/*
		//合并单元格
		$excel->getActiveSheet()->mergeCells('A1:D1');
		*/
		
		/*
		//给单元格中放入图片
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('images/test.png');
		$objDrawing->setWidth(148);
		$objDrawing->setHeight(169);
		$objDrawing->setCoordinates('D2');
		$objDrawing->setWorksheet($excel->getActiveSheet());
		*/
		
		//设置单元格数据
		$excel->getActiveSheet()
			->setCellValue('A1', 'Nickname')
			->setCellValue('B1', 'Email')
			->setCellValue('C1', 'Gender')
			->setCellValue('D1', 'Age')
			->setCellValue('E1', 'Register Time');
		
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser");
		$res = Config::$db->getAllRows();
		$rowIndex = 2;
		foreach ($res as $row)
		{
			$excel->getActiveSheet()
				->setCellValue('A' . $rowIndex, $row['username'])
				->setCellValue('B' . $rowIndex, $row['email'])
				->setCellValue('C' . $rowIndex, $row['gender'])
				->setCellValue('D' . $rowIndex, $row['age'])
				->setCellValue('E' . $rowIndex, $row['register_time']);
			$rowIndex++;
		}
		
		$fileFormat = 'excel';
		$filename = 'data.xls';
		if ('excel' == $fileFormat)
		{
			//输出EXCEL格式
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
			//从浏览器直接输出$filename
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
			header("Content-Type:application/force-download");
			header("Content-Type: application/vnd.ms-excel;");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");
			header("Content-Disposition:attachment;filename=" . $filename);
			header("Content-Transfer-Encoding:binary");
			$objWriter->save("php://output");
		}
		else if ('pdf' == $fileFormat)
		{
			//输出PDF格式
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'PDF');
			$objWriter->setSheetIndex(0);
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
			header("Content-Type:application/force-download");
			header("Content-Type: application/pdf");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");
			header("Content-Disposition:attachment;filename=" . $filename);
			header("Content-Transfer-Encoding:binary");
			$objWriter->save("php://output");
		}
	}
	
	private function fixStr($str)
	{
		$newStr = '';
		$strLen = strlen($str);
		for ($i = 0; $i < $strLen; $i++)
		{
			//$char = substr($str, $i, 1);
			$char = $str[$i];
			if ($char == ' ' || $char == '@' || $char == "'")
			{
				break;
			}
			$newStr .= $char;
		}
		return $newStr;
	}
	
	private function fixEmail()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser where email=''");
		$res = Config::$db->getAllRows();
		foreach ($res as $value)
		{
			$id = (int)$value['id'];
			$sqlEmail =  Security::varSql($this->fixStr($value['username']) . '@gmail.com');
			Config::$db->query("update $tbUser set email=$sqlEmail where id=$id");
		}
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$tbComment = Config::$tbComment;
		
		//Config::$db->query("select * from $tbUser where email=''");
	}
}

/**
 *	用户
 */
class MwUser
{
	public function __construct()
	{
	}
	
	public function existUsername($username)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select id from $tbUser where username=$sqlUsername");
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
	
	public function register($username, $password, $phone = '', $realname = '', $gender = '', $email = '')
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		$sqlPhone = Security::varSql($phone);
		$sqlRealname = Security::varSql($realname);
		$sqlGender = Security::varSql($gender);
		$sqlEmail = Security::varSql($email);
		$sqlPhoto = Security::varSql(Config::$baseUrl . '/images/mobile/photo3.png');
		$registerTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (username, password, phone, realname, gender, email, register_time, upload_times, agreement, login_type, login_status, photo, local_photo) values ($sqlUsername, $sqlPassword, $sqlPhone, $sqlRealname, $sqlGender, $sqlEmail, $registerTime, 0, 1, 3, 1, $sqlPhoto, $sqlPhoto)");
	}
	
	/**
	 * 登录
	 */
	public function login($username, $password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select * from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			$libPassword = $res['password'];
			$inputPassword = Security::multiMd5($password, Config::$key);
			if ($libPassword == $inputPassword)
			{
				$userId = (int)$res['id'];
				$username = $res['username'];
				System::setSession('userUserId', $userId);
				System::setSession('userUsername', $username);
				System::setSession('userPassword', $libPassword);
				$this->setCookie($userId, $username, $libPassword);
				Debug::log('[mwuser login] userId: ' . $userId . ', username: ' . $username);
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	/**
	 * 检测是否登录
	 */
	public function checkLogin()
	{
		if ($this->getUserId() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 用户编号
	 */
	public function getUserId()
	{
		return (int)System::getSession('userUserId');
	}
	
	/**
	 * 用户名
	 */
	public function getUsername()
	{
		return System::getSession('userUsername');
	}
	
	/**
	 * 密码
	 */
	public function getPassword()
	{
		return System::getSession('userPassword');
	}
	
	public function getUserPhoto()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		Config::$db->query("select local_photo from $tbUser where id=$sqlUserId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return '';
		}
		else
		{
			return $res['local_photo'];
		}
	}
	
	public function existFbid($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select id from $tbUser where fbid=$sqlFbid");
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
	
	public function addFbid($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		$sqlPhoto = Security::varSql('https://graph.facebook.com/' . $fbid . '/picture');
		$sqlRegisterTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (fbid, photo, register_time, upload_times, agreement, login_type, login_status, local_photo) values ($sqlFbid, $sqlPhoto, $sqlRegisterTime, 0, 0, 1, 0, $sqlPhoto)");
	}
	
	public function loginFb($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select * from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$userId = (int)$res['id'];
			$username = $res['username'];
			System::setSession('userUserId', $userId);
			System::setSession('userUsername', $username);
			Debug::log('[user fb login] userId: ' . $userId . ', username: ' . $username);
		}
	}
	
	/**
	 * 注销
	 */
	public function logout()
	{
		System::clearSession('userUserId');
		System::clearSession('userUsername');
		System::clearSession('userPassword');
		$this->clearCookie();
	}
	
	/**
	 * 检测密码是否正确
	 */
	public function checkPassword($password)
	{
		$sessionPassword = $this->getPassword();
		$inputPassword = Security::multiMd5($password, Config::$key);
		if ($sessionPassword == $inputPassword)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 修改密码
	 */
	public function changePassword($password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		Config::$db->query("UPDATE $tbUser SET password=$sqlPassword WHERE id=$sqlUserId");
	}
	
	public function changeName($realname)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlRealname = Security::varSql($realname);
		Config::$db->query("UPDATE $tbUser SET realname=$sqlRealname WHERE id=$sqlUserId");
	}
	
	public function changeGender($gender)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlGender = Security::varSql($gender);
		Config::$db->query("UPDATE $tbUser SET gender=$sqlGender WHERE id=$sqlUserId");
	}
	
	public function changeAge($age)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlAge = (int)$age;
		Config::$db->query("UPDATE $tbUser SET age=$sqlAge WHERE id=$sqlUserId");
	}
	
	public function changeLocale($locale)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlLocale = Security::varSql($locale);
		Config::$db->query("UPDATE $tbUser SET locale=$sqlLocale WHERE id=$sqlUserId");
	}
	
	public function changeEmail($email)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlEmail = Security::varSql($email);
		Config::$db->query("UPDATE $tbUser SET email=$sqlEmail WHERE id=$sqlUserId");
	}
	
	public function changePhone($phone)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlPhone = Security::varSql($phone);
		Config::$db->query("UPDATE $tbUser SET phone=$sqlPhone WHERE id=$sqlUserId");
	}
	
	public function uploadPhoto()
	{
		$img = Security::varPost('img');
		if (empty($img))
		{
			return array('code' => 1, 'info' => 'Empty error!', 'pic' => '');
		}
		if (strlen($img) > 500000)
		{
			return array('code' => 2, 'info' => 'Size error!', 'pic' => '');
		}
		$baseName = Config::$dirUploads . time() . rand(100000, 999999);
		$tempPic = $baseName . '_temp.jpg';
		$pic = $baseName . '.jpg';
		$data = base64_decode($img);
		file_put_contents($tempPic, $data);
		Image::thumb($tempPic, $pic, "", 200, 200);
		@unlink($tempPic);
		
		$picUrl = Config::$baseUrl . '/' . $pic;
		$this->savePhoto($picUrl);
		return array('code' => 0, 'info' => 'ok', 'pic' => $picUrl);
	}
	
	public function savePhoto($photo)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlPhoto = Security::varSql($photo);
		Config::$db->query("UPDATE $tbUser SET local_photo=$sqlPhoto WHERE id=$sqlUserId");
	}
	
	/**
	 * 生成验证码
	 */
	public function getVerify()
	{
		Image::buildImageVerify('48', '22', null, Config::$systemName . '_userVerify');
	}
	
	/**
	 * 检查验证码
	 */
	public function checkVerify($code)
	{
		$verify = isset($_SESSION[Config::$systemName . '_userVerify']) ? $_SESSION[Config::$systemName . '_userVerify'] : '';
		unset($_SESSION[Config::$systemName . '_userVerify']);
		if (!empty($verify) && $code == $verify)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function setCookie($userId, $username, $password)
	{
		$cookieKey = Security::multiMd5($userId . $username . $password, Config::$key);
		setcookie(Config::$systemName . "_userCookieUserId", $userId, time() + 12 * 30 * 24 * 60 * 60);
		setcookie(Config::$systemName . "_userCookieUsername", $username, time() + 12 * 30 * 24 * 60 * 60);
		setcookie(Config::$systemName . "_userCookiePassword", $password, time() + 12 * 30 * 24 * 60 * 60);
		setcookie(Config::$systemName . "_userCookieKey", $cookieKey, time() + 12 * 30 * 24 * 60 * 60);
	}
	
	public function clearCookie()
	{
		setcookie(Config::$systemName . "_userCookieUserId", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookieUsername", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookiePassword", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookieKey", '', time() - 3600);
	}
	
	public function loginCookie()
	{
		$cookieUserId = isset($_COOKIE[Config::$systemName . "_userCookieUserId"]) ? (int)$_COOKIE[Config::$systemName . "_userCookieUserId"] : 0;
		$cookieUsername = isset($_COOKIE[Config::$systemName . "_userCookieUsername"]) ? $_COOKIE[Config::$systemName . "_userCookieUsername"] : '';
		$cookiePassword = isset($_COOKIE[Config::$systemName . "_userCookiePassword"]) ? $_COOKIE[Config::$systemName . "_userCookiePassword"] : '';
		$cookieKey = isset($_COOKIE[Config::$systemName . "_userCookieKey"]) ? $_COOKIE[Config::$systemName . "_userCookieKey"] : '';
		$safeKey = Security::multiMd5($cookieUserId . $cookieUsername . $cookiePassword, Config::$key);
		
		if (!empty($cookieUserId) && !empty($cookieUsername) && !empty($cookiePassword) && $cookieKey == $safeKey)
		{
			System::setSession('userUserId', $cookieUserId);
			System::setSession('userUsername', $cookieUsername);
			System::setSession('userPassword', $cookiePassword);
			Debug::log('[user cookieLogin] userId: ' . $cookieUserId . ', username: ' . $cookieUsername);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getBaseInfo()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		Config::$db->query("select uid, realname, gender, age, locale, email, upload_times, agreement, local_photo, phone from $tbUser where id=$sqlUserId");
		$res = Config::$db->getRow();
		
		if (empty($res))
		{
			$res = array('uid' => '', 'realname' => '', 'gender' => '', 'age' => 0, 'locale' => '', 'email' => '', 'upload_times' => 0, 'agreement' => 0, 'local_photo' => '');
		}
		return $res;
	}
	
	public function getUserInfo($id)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlId = (int)$id;
		Config::$db->query("select realname, gender, age, locale, email, upload_times, local_photo, phone from $tbUser where id=$sqlId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			$res = array('realname' => '', 'gender' => '', 'age' => 0, 'locale' => '', 'email' => '', 'upload_times' => 0, 'local_photo' => '');
		}
		return $res;
	}
	
	public function getIdByName($username)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select id from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return (int)$res['id'];
		}
	}
}

/**
 *	Zero
 */
class MwZero
{
	private $user = null;//用户模型
	
	public function __construct()
	{
		$this->user = new MwUser();
	}
	
	public function upload()
	{
		$img = Security::varPost('img');
		if (empty($img))
		{
			return array('code' => 1, 'info' => 'Empty error!', 'pic' => '', 'smallPic' => '');
		}
		if (strlen($img) > 500000)
		{
			return array('code' => 2, 'info' => 'Size error!', 'pic' => '', 'smallPic' => '');
		}
		$baseName = Config::$dirUploads . time() . rand(100000, 999999);
		$tempPic = $baseName . '_temp.jpg';
		$pic = $baseName . '.jpg';
		$smallPic = $baseName . '_small.jpg';
		$data = base64_decode($img);
		file_put_contents($tempPic, $data);
		Image::thumb($tempPic, $pic, "", 764, 616);
		Image::thumb($tempPic, $smallPic, "", 248, 200);
		@unlink($tempPic);
		
		$picUrl = Config::$baseUrl . '/' . $pic;
		$smallPicUrl = Config::$baseUrl . '/' . $smallPic;
		$picId = $this->savePic($picUrl, $smallPicUrl);
		return array('code' => 0, 'pic' => $picUrl, 'smallPic' => $smallPicUrl, 'picId' => $picId);
	}
	
	public function savePic($pic, $smallPic)
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		$tbUser = Config::$tbUser;
		$sqlPic = Security::varSql($pic);
		$sqlSmallPic = Security::varSql($smallPic);
		$sqlUserId = (int)$this->user->getUserId();
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoginType = 3;
		Config::$db->query("insert into $tbPic (pic, small_pic, user_id, do_time, login_type) values ($sqlPic, $sqlSmallPic, $sqlUserId, $sqlDoTime, $sqlLoginType)");
		$picId = Config::$db->getInsertId();
		Config::$db->query("update $tbUser set upload_times = upload_times+1 where id=$sqlUserId");
		return $picId;
	}
	
	public function checkLikeToday($picId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$this->user->getUserId();
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select id from $tbLike where pic_id=$sqlPicId and user_id=$sqlUserId and date_format(do_time, '%Y-%m-%d')=$sqlDate");
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
	
	public function checkLiked($picId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$this->user->getUserId();
		Config::$db->query("select id from $tbLike where pic_id=$sqlPicId and user_id=$sqlUserId");
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
	
	public function like($picId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$this->user->getUserId();
		$sqlWeek = $this->getCurrentWeek();
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoginType = 3;
		Config::$db->query("insert into $tbLike (pic_id, user_id, week, do_time, login_type) values ($sqlPicId, $sqlUserId, $sqlWeek, $sqlDoTime, $sqlLoginType)");
	}
	
	public function topTotal($page, $pagesize)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
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
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		if (!empty($res))
		{
			$rankIndex = ($page - 1) * $pagesize + 1;
			foreach ($res as $key => $value)
			{
				$res[$key]['rank'] = $rankIndex;
				$rankIndex++;
			}
		}
		return $res;
	}
	
	public function latest($page, $pagesize)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by t1.id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		return $res;
	}
	
	public function myRank()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$userId = (int)$this->user->getUserId();
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc");
		$res = Config::$db->getAllRows();
		
		$rankIndex = 1;
		$selfRank = array();
		if (!empty($res))
		{
			foreach ($res as $key => $row)
			{
				if ($userId == $row['open_id'])
				{
					$selfRank[] = array_merge($row, array('rank' => $rankIndex));
				}
				$rankIndex++;
			}
		}
		return $selfRank;
	}
	
	public function getCurrentWeek()
	{
		$day = Utils::restDays(Config::$startDate, Utils::mdate('Y-m-d'));
		$week = (int)($day / 7) + 1;
		return $week;
	}
	
	public function addComment($picId, $content)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$this->user->getUserId();
		$content = json_encode(mb_substr($content, 0, 500));
		$sqlContent = Security::varSql($content);
		$sqlLoginType = 3;
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbComment (pic_id, user_id, content, do_time, login_type) values ($sqlPicId, $sqlUserId, $sqlContent, $sqlDoTime, $sqlLoginType)");
	}
	
	public function checkCommentLock($picId)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$this->user->getUserId();
		Config::$db->query("select do_time from $tbComment where pic_id=$sqlPicId and user_id=$sqlUserId order by id desc limit 0, 1");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			$lastTime = $res['do_time'];
			$now = Utils::mdate('Y-m-d H:i:s');
			if (Utils::restSeconds($lastTime, $now) <= 60)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function getComment($picId)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$tbUser = Config::$tbUser;
		$sqlPicId = (int)$picId;
		Config::$db->query("select t1.id id, t1.pic_id pic_id, t1.user_id user_id, t1.content content, t1.do_time comment_time, t2.username username, t2.local_photo photo from $tbComment t1 join $tbUser t2 on t1.user_id=t2.id where pic_id=$sqlPicId order by id desc limit 0, 1000");
		$res = Config::$db->getAllRows();
		if (!empty($res))
		{
			foreach ($res as $key => $row)
			{
				$res[$key]['comment_time'] = Utils::mdate('Y-m-d', $row['comment_time']);
				$res[$key]['content'] = htmlspecialchars(json_decode($row['content'], true), ENT_QUOTES);
			}
		}
		return $res;
	}
	
	public function getPicCount()
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		Config::$db->query("select count(*) as num from $tbPic");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function getPicInfo($picId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$picId = (int)$picId;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc");
		$res = Config::$db->getAllRows();
		
		$rankIndex = 1;
		$picInfo = array();
		if (!empty($res))
		{
			foreach ($res as $row)
			{
				if ($picId == $row['pic_id'])
				{
					$picInfo = array_merge($row, array('rank' => $rankIndex));
					$picInfo['upload_time'] = Utils::mdate('Y-m-d', $picInfo['upload_time']);
					break;
				}
				$rankIndex++;
			}
		}
		
		return $picInfo;
	}
	
	public function getPicLikeNum($picId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		Config::$db->query("select count(*) as num from $tbLike where pic_id=$sqlPicId");
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
	
	public function getLikesKey()
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		Config::$db->query("select pic_id, user_id, do_time from $tbLike");
		$res = Config::$db->getAllRows();
		$arr = array();
		if (!empty($res))
		{
			foreach ($res as $row)
			{
				$arr[$row['pic_id'] . '_' . $row['user_id'] . '_' . Utils::mdate('Y-m-d', $row['do_time'])] = 1;
			}
		}
		return $arr;
	}
}

/**
 *	系统
 */
class System
{
	/**
	 * 获取session
	 */
	public static function getSession($sessionName)
	{
		return isset($_SESSION[Config::$systemName . '_' . $sessionName]) ? $_SESSION[Config::$systemName . '_' . $sessionName] : null;
	}
	
	/**
	 * 设置session
	 */
	public static function setSession($sessionName, $value)
	{
		$_SESSION[Config::$systemName . '_' . $sessionName] = $value;
	}
	
	/**
	 * 清除session
	 */
	public static function clearSession($sessionName)
	{
		unset($_SESSION[Config::$systemName . '_' . $sessionName]);
	}
	
	/**
	 * 上传图片
	 */
	public static function uploadImage()
	{
		$upload = new Upload(2 * 1024 * 1024, 'gif,jpg,png,bmp', array('image/gif', 'image/jpeg', 'image/png', 'image/bmp'), Config::$dirUploads, Utils::genFilename());
		if ($upload->upload())
		{
			$uploadInfo = $upload->getUploadFileInfo();
			//$url = $uploadInfo[0]['savepath'] . $uploadInfo[0]['savename'];
			$url = Config::$baseUrl . '/' . Config::$dirUploads . $uploadInfo[0]['savename'];
			return json_encode(array('error' => 0, 'url' => $url));
		}
		else
		{
			$msg = $upload->getErrorMsg();
			return json_encode(array('error' => 1, 'message' => $msg));
		}
	}
	
	/**
	 * JQ上传图片
	 */
	public static function uploadJqImage()
	{
		$error = "";
		$msg = "";
		$fileElementName = 'fileToUpload';
		if(!empty($_FILES[$fileElementName]['error']))
		{
			switch($_FILES[$fileElementName]['error'])
			{
				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;
				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
		{
			$error = 'No file was uploaded..';
		}else
		{
				$msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
				$msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
				//for security reason, we force to remove all uploaded file
				//@unlink($_FILES['fileToUpload']);
				$url = self::getImageName($_FILES['fileToUpload']['name']);
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $url);
		}
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "',\n";
		echo				"url: '" . '/' . $url . "'\n";
		echo "}";
	}
	
	public static function uploadZeroImage()
	{
		$upload = new Upload(2 * 1024 * 1024, '', '', Config::$dirUploads, Utils::genFilename());
		if ($upload->upload())
		{
			$uploadInfo = $upload->getUploadFileInfo();
			$file = Config::$dirUploads . $uploadInfo[0]['savename'];
			$url = Config::$baseUrl . '/' . $file;
			return array('error' => 0, 'url' => $url, 'file' => $file);
		}
		else
		{
			$msg = $upload->getErrorMsg();
			return array('error' => 1, 'message' => $msg);
		}
	}
	
	public static function uploadPhoto()
	{
		$upload = new Upload(2 * 1024 * 1024, '', '', Config::$dirUploads, Utils::genFilename());
		if ($upload->upload())
		{
			$uploadInfo = $upload->getUploadFileInfo();
			$file = Config::$dirUploads . $uploadInfo[0]['savename'];
			$url = Config::$baseUrl . '/' . $file;
			return array('error' => 0, 'url' => $url, 'file' => $file);
		}
		else
		{
			$msg = $upload->getErrorMsg();
			return array('error' => 1, 'message' => $msg);
		}
	}
	
	/**
	 * 生成图片文件名
	 */
	public static function getImageName($extend)
	{
		$arr = explode('.', $extend);
		return Config::$dirUploads . time() . rand(1000, 9999) . '.' . $arr[count($arr) - 1];
	}
	
	/**
	 * 设置为数据提交状态
	 */
	public static function setSubmit()
	{
		self::setSession('submitKey', 1);
	}
	
	/**
	 * 检测是否为数据提交状态
	 */
	public static function checkSubmit()
	{
		$is_set = (int)self::getSession('submitKey');
		if (1 == $is_set)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 清除数据提交状态
	 */
	public static function clearSubmit()
	{
		self::clearSession('submitKey');
	}
	
	/**
	 * 转义html代码
	 */
	public static function fixHtml($value)
	{
		$str = htmlspecialchars($value, ENT_QUOTES);
		$str = str_replace("\n", '<br>', $str);
		$str = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $str);
		$str = str_replace(' ', '&nbsp;', $str);
		
		return $str;
	}
	
	/**
	 * 转换标题内容
	 */
	public static function fixTitle($value)
	{
		$str = htmlspecialchars($value, ENT_QUOTES);
		$str = str_replace("\n", ' ', $str);
		return $str;
	}
	
	/**
	 * 获取统计代码
	 */
	public static function getCountCode()
	{
		if (Config::$isLocal)
		{
			return '';
		}
		else
		{
			return Config::$countCode;
		}
	}
	
	/**
	 * 将不带www的网址301跳转到带www的网址
	 */
	public static function fixUrl()
	{
		if (!Config::$isLocal)
		{
			$theHost = $_SERVER['HTTP_HOST'];//取得当前域名
			$theUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';//判断地址后面部分
			$theUrl = strtolower($theUrl);//将英文字母转成小写
			//判断是不是首页
			if ("/index.php" == $theUrl)
			{
				$theUrl = "";//如果是首页，赋值为空
			}
			//如果域名不是带www的网址那么进行下面的301跳转
			if ($theHost !== 'www.qumuwu.com')
			{
				header('HTTP/1.1 301 Moved Permanently');//发出301头部
				header('Location:http://www.qumuwu.com' . $theUrl);//跳转到带www的网址
			}
		}
	}
	
	/**
	 * 防重复提交，限制0.2秒内只能提交一次
	 */
	public static function fixSubmit($flag)
	{
		$lastTime = self::getSession('_systemSubmitTime' . '_' . $flag);
		if (empty($lastTime))
		{
			self::setSession('_systemSubmitTime' . '_' . $flag, microtime(true));
		}
		else
		{
			$nowTime = microtime(true);
			$interval = $nowTime - $lastTime;
			if ($interval < 0.2)
			{
				exit(0);
			}
			else
			{
				self::setSession('_systemSubmitTime' . '_' . $flag, $nowTime);
			}
		}
	}
}

/**
 *	用户
 */
class User
{
	public function __construct()
	{
	}
	
	public function existUsername($username)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select id from $tbUser where username=$sqlUsername");
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
	
	public function register($username, $password, $realname, $gender, $email, $imei, $uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		$sqlRealname = Security::varSql($realname);
		$sqlGender = Security::varSql($gender);
		$sqlEmail = Security::varSql($email);
		$sqlImei = Security::varSql($imei);
		$sqlUid = Security::varSql($uid);
		$registerTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (username, password, realname, gender, email, imei, uid, register_time, upload_times, agreement, login_type, login_status) values ($sqlUsername, $sqlPassword, $sqlRealname, $sqlGender, $sqlEmail, $sqlImei, $sqlUid, $registerTime, 0, 0, 2, 1)");
	}
	
	/**
	 * 登录
	 */
	public function login($username, $password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select * from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			$libPassword = $res['password'];
			$inputPassword = Security::multiMd5($password, Config::$key);
			if ($libPassword == $inputPassword)
			{
				$userId = (int)$res['id'];
				$username = $res['username'];
				System::setSession('userUserId', $userId);
				System::setSession('userUsername', $username);
				System::setSession('userPassword', $libPassword);
				//$this->setCookie($userId, $username, $libPassword);
				Debug::log('[user login] userId: ' . $userId . ', username: ' . $username);
				
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	/**
	 * 注销
	 */
	public function logout()
	{
		System::clearSession('userUserId');
		System::clearSession('userUsername');
		System::clearSession('userPassword');
		//$this->clearCookie();
	}
	
	/**
	 * 检测密码是否正确
	 */
	public function checkPassword($uid, $password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("select password from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			$libPassword = $res['password'];
			$inputPassword = Security::multiMd5($password, Config::$key);
			if ($libPassword == $inputPassword)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	/**
	 * 修改密码
	 */
	public function changePassword($uid, $password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		Config::$db->query("UPDATE $tbUser SET password=$sqlPassword WHERE uid=$sqlUid");
	}
	
	public function changeName($uid, $realname)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlRealname = Security::varSql($realname);
		Config::$db->query("UPDATE $tbUser SET realname=$sqlRealname WHERE uid=$sqlUid");
	}
	
	public function changeGender($uid, $gender)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlGender = Security::varSql($gender);
		Config::$db->query("UPDATE $tbUser SET gender=$sqlGender WHERE uid=$sqlUid");
	}
	
	public function changeAge($uid, $age)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlAge = (int)$age;
		Config::$db->query("UPDATE $tbUser SET age=$sqlAge WHERE uid=$sqlUid");
	}
	
	public function changeLocale($uid, $locale)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlLocale = Security::varSql($locale);
		Config::$db->query("UPDATE $tbUser SET locale=$sqlLocale WHERE uid=$sqlUid");
	}
	
	public function changeEmail($uid, $email)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlEmail = Security::varSql($email);
		Config::$db->query("UPDATE $tbUser SET email=$sqlEmail WHERE uid=$sqlUid");
	}
	
	public function uploadPhoto($uid)
	{
		$param = System::uploadPhoto();
		if (0 == $param['error'])
		{
			$url = $param['url'];
			$this->savePhoto($uid, $url);
			return array('code' => 0, 'photo' => $url, 'msg' => '');
		}
		else
		{
			$msg = $param['message'];
			return array('code' => 1, 'msg' => $msg);
		}
	}
	
	public function savePhoto($uid, $photo)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlPhoto = Security::varSql($photo);
		Config::$db->query("UPDATE $tbUser SET local_photo=$sqlPhoto WHERE uid=$sqlUid");
	}
	
	/**
	 * 用户编号
	 */
	public function getUserId($uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("select id from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return (int)$res['id'];
		}
	}
	
	/**
	 * 生成验证码
	 */
	public function getVerify()
	{
		Image::buildImageVerify('48', '22', null, Config::$systemName . '_userVerify');
	}
	
	/**
	 * 检查验证码
	 */
	public function checkVerify($code)
	{
		$verify = isset($_SESSION[Config::$systemName . '_userVerify']) ? $_SESSION[Config::$systemName . '_userVerify'] : '';
		unset($_SESSION[Config::$systemName . '_userVerify']);
		if (!empty($verify) && $code == $verify)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function setCookie($userId, $username, $password)
	{
		$cookieKey = Security::multiMd5($userId . $username . $password, Config::$key);
		setcookie(Config::$systemName . "_userCookieUserId", $userId, time() + 12 * 30 * 24 * 60 * 60);
		setcookie(Config::$systemName . "_userCookieUsername", $username, time() + 12 * 30 * 24 * 60 * 60);
		setcookie(Config::$systemName . "_userCookiePassword", $password, time() + 12 * 30 * 24 * 60 * 60);
		setcookie(Config::$systemName . "_userCookieKey", $cookieKey, time() + 12 * 30 * 24 * 60 * 60);
	}
	
	public function clearCookie()
	{
		setcookie(Config::$systemName . "_userCookieUserId", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookieUsername", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookiePassword", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookieKey", '', time() - 3600);
	}
	
	public function loginCookie()
	{
		$cookieUserId = isset($_COOKIE[Config::$systemName . "_userCookieUserId"]) ? (int)$_COOKIE[Config::$systemName . "_userCookieUserId"] : 0;
		$cookieUsername = isset($_COOKIE[Config::$systemName . "_userCookieUsername"]) ? $_COOKIE[Config::$systemName . "_userCookieUsername"] : '';
		$cookiePassword = isset($_COOKIE[Config::$systemName . "_userCookiePassword"]) ? $_COOKIE[Config::$systemName . "_userCookiePassword"] : '';
		$cookieKey = isset($_COOKIE[Config::$systemName . "_userCookieKey"]) ? $_COOKIE[Config::$systemName . "_userCookieKey"] : '';
		$safeKey = Security::multiMd5($cookieUserId . $cookieUsername . $cookiePassword, Config::$key);
		
		if (!empty($cookieUserId) && !empty($cookieUsername) && !empty($cookiePassword) && $cookieKey == $safeKey)
		{
			System::setSession('userUserId', $cookieUserId);
			System::setSession('userUsername', $cookieUsername);
			System::setSession('userPassword', $cookiePassword);
			Debug::log('[user cookieLogin] userId: ' . $cookieUserId . ', username: ' . $cookieUsername);
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getBaseInfo($uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("select uid, realname, gender, age, locale, email, upload_times, agreement, local_photo from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		
		if (empty($res))
		{
			$res = array('uid' => '', 'realname' => '', 'gender' => '', 'age' => 0, 'locale' => '', 'email' => '', 'upload_times' => 0, 'agreement' => 0, 'local_photo' => '');
		}
		
		return $res;
	}
	
	public function existImei($imei)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlImei = Security::varSql($imei);
		Config::$db->query("select id from $tbUser where imei=$sqlImei");
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
	
	public function existUid($uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("select id from $tbUser where uid=$sqlUid");
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
	
	public function genUid()
	{
		$count = 1;
		$maxCount = 10;
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		while (true)
		{
			$uid = rand(10000000, 99999999);
			$sqlUid = Security::varSql($uid);
			Config::$db->query("select id from $tbUser where uid=$sqlUid");
			$res = Config::$db->getRow();
			if (empty($res))
			{
				return $uid;
			}
			if ($count >= $maxCount)
			{
				return '';
			}
			$count++;
		}
	}
	
	public function checkLoginImei($uid)
	{
		if (empty($uid))
		{
			return false;
		}
		
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("select login_status from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			$loginStatus = (int)$res['login_status'];
			if ($loginStatus > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function loginImei($username, $password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select * from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('state' => false, 'uid' => '');
		}
		else
		{
			$libPassword = $res['password'];
			$inputPassword = Security::multiMd5($password, Config::$key);
			if ($libPassword == $inputPassword)
			{
				$uid = $res['uid'];
				$sqlUid = Security::varSql($uid);
				Config::$db->query("update $tbUser set login_status=1 where uid=$sqlUid");
				Debug::log('[loginImei] username: ' . $username);
				
				return array('state' => true, 'uid' => $uid);
			}
			else
			{
				return array('state' => false, 'uid' => '');
			}
		}
	}
	
	public function logoutImei($uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("update $tbUser set login_status=0 where uid=$sqlUid");
	}
	
	public function getUserInfo($id)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlId = (int)$id;
		Config::$db->query("select realname, gender, age, locale, email, upload_times, local_photo from $tbUser where id=$sqlId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			$res = array('realname' => '', 'gender' => '', 'age' => 0, 'locale' => '', 'email' => '', 'upload_times' => 0, 'local_photo' => '');
		}
		return $res;
	}
	
	public function getIdByName($username)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select id from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return (int)$res['id'];
		}
	}
	
	public function getUidByFbid($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select uid from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return '';
		}
		else
		{
			return $res['uid'];
		}
	}
	
	public function addFbid($fbid, $imei, $uid, $realname, $photo)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		$sqlImei = Security::varSql($imei);
		$sqlUid = Security::varSql($uid);
		$sqlRealname = Security::varSql($realname);
		$sqlPhoto = Security::varSql($photo);
		$registerTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (fbid, imei, uid, username, realname, photo, local_photo, register_time, upload_times, agreement, login_type, login_status) values ($sqlFbid, $sqlImei, $sqlUid, $sqlRealname, $sqlRealname, $sqlPhoto, $sqlPhoto, $registerTime, 0, 0, 2, 1)");
	}
	
	public function loginUid($uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("update $tbUser set login_status=1 where uid=$sqlUid");
		Debug::log('[loginUid] uid: ' . $uid);
	}
}

/**
 *	Zero
 */
class Zero
{
	public function __construct()
	{
	}
	
	public function agreement($userId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$userId;
		Config::$db->query("UPDATE $tbUser SET agreement=1 WHERE id=$sqlUserId");
	}
	
	public function checkAgreement($userId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$userId;
		Config::$db->query("select agreement from $tbUser WHERE id=$sqlUserId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			if (1 == $res['agreement'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function upload($userId, $loginType)
	{
		$baseName = Config::$dirUploads . time() . rand(100000, 999999);
		$tempPic = $baseName . '_temp.jpg';
		$pic = $baseName . '2.jpg';
		$smallPic = $baseName . '_small.jpg';
		
		$param = System::uploadZeroImage();
		if (0 == $param['error'])
		{
			$url = $param['url'];
			$tempPic = $param['file'];
			
			//Image::thumb($tempPic, $pic, "", 960, 640);
			//Image::thumb($tempPic, $smallPic, "", 248, 165);
			Image::thumb($tempPic, $pic, "", 764, 616);
			Image::thumb($tempPic, $smallPic, "", 248, 200);
			@unlink($tempPic);
			
			$picUrl = Config::$baseUrl . '/' . $pic;
			$smallPicUrl = Config::$baseUrl . '/' . $smallPic;
			$picId = $this->savePic($picUrl, $smallPicUrl, $userId, $loginType);
			return array('code' => 0, 'pic' => $picUrl, 'smallPic' => $smallPicUrl, 'msg' => '', 'picId' => $picId);
		}
		else
		{
			$msg = $param['message'];
			return array('code' => 1, 'pic' => '', 'smallPic' => '', 'msg' => $msg, 'picId' => 0);
		}
	}
	
	public function savePic($pic, $smallPic, $userId, $loginType)
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		$tbUser = Config::$tbUser;
		$sqlPic = Security::varSql($pic);
		$sqlSmallPic = Security::varSql($smallPic);
		$sqlUserId = (int)$userId;
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoginType = (int)$loginType;
		Config::$db->query("insert into $tbPic (pic, small_pic, user_id, do_time, login_type) values ($sqlPic, $sqlSmallPic, $sqlUserId, $sqlDoTime, $sqlLoginType)");
		$picId = Config::$db->getInsertId();
		Config::$db->query("update $tbUser set upload_times = upload_times+1 where id=$sqlUserId");
		return $picId;
	}
	
	public function checkLikeToday($picId, $userId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select id from $tbLike where pic_id=$sqlPicId and user_id=$sqlUserId and date_format(do_time, '%Y-%m-%d')=$sqlDate");
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
	
	public function checkLiked($picId, $userId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		Config::$db->query("select id from $tbLike where pic_id=$sqlPicId and user_id=$sqlUserId");
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
	
	public function like($picId, $userId, $loginType)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		$sqlWeek = $this->getCurrentWeek();
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoginType = (int)$loginType;
		Config::$db->query("insert into $tbLike (pic_id, user_id, week, do_time, login_type) values ($sqlPicId, $sqlUserId, $sqlWeek, $sqlDoTime, $sqlLoginType)");
	}
	
	public function topTotal($count)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$sqlCount = (int)$count;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc limit 0, $sqlCount");
		$res = Config::$db->getAllRows();
		if (!empty($res))
		{
			$rankIndex = 1;
			foreach ($res as $key => $value)
			{
				$res[$key]['rank'] = $rankIndex;
				$res[$key]['upload_time'] = date('Y-m-d H:i:s', strtotime($res[$key]['upload_time']) - 60 * 60 * 8);
				$rankIndex++;
			}
		}
		return $res;
	}
	
	public function latest($page, $pagesize)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by t1.id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		if (!empty($res))
		{
			foreach ($res as $key => $value)
			{
				$res[$key]['upload_time'] = date('Y-m-d H:i:s', strtotime($res[$key]['upload_time']) - 60 * 60 * 8);
			}
		}
		return $res;
	}
	
	public function myRank($userId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc");
		$res = Config::$db->getAllRows();
		
		$rankIndex = 1;
		$selfRank = array();
		if (!empty($res))
		{
			foreach ($res as $key => $value)
			{
				if ($userId == $res[$key]['open_id'])
				{
					$res[$key]['upload_time'] = date('Y-m-d H:i:s', strtotime($res[$key]['upload_time']) - 60 * 60 * 8);
					$selfRank[] = array_merge($res[$key], array('rank' => $rankIndex));
				}
				$rankIndex++;
			}
		}
		
		return $selfRank;
	}
	
	public function getCurrentWeek()
	{
		$day = Utils::restDays(Config::$startDate, Utils::mdate('Y-m-d'));
		$week = (int)($day / 7) + 1;
		return $week;
	}
	
	public function getPicLikeNum($picId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		Config::$db->query("select count(*) as num from $tbLike where pic_id=$sqlPicId");
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
	
	public function addComment($picId, $userId, $content, $loginType)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		$content = json_encode(mb_substr($content, 0, 500));
		$sqlContent = Security::varSql($content);
		$sqlLoginType = (int)$loginType;
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbComment (pic_id, user_id, content, do_time, login_type) values ($sqlPicId, $sqlUserId, $sqlContent, $sqlDoTime, $sqlLoginType)");
	}
	
	public function checkCommentLock($picId, $userId)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		Config::$db->query("select do_time from $tbComment where pic_id=$sqlPicId and user_id=$sqlUserId order by id desc limit 0, 1");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			$lastTime = $res['do_time'];
			$now = Utils::mdate('Y-m-d H:i:s');
			if (Utils::restSeconds($lastTime, $now) <= 60)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function getComment($picId)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$tbUser = Config::$tbUser;
		$sqlPicId = (int)$picId;
		Config::$db->query("select t1.id id, t1.pic_id pic_id, t1.user_id open_id, t1.content content, t1.do_time comment_time, t2.username username, t2.local_photo photo from $tbComment t1 join $tbUser t2 on t1.user_id=t2.id where pic_id=$sqlPicId order by id desc limit 0, 1000");
		$res = Config::$db->getAllRows();
		if (!empty($res))
		{
			foreach ($res as $key => $value)
			{
				$res[$key]['comment_time'] = date('Y-m-d H:i:s', strtotime($res[$key]['comment_time']) - 60 * 60 * 8);
				$res[$key]['content'] = json_decode($res[$key]['content'], true);
				
				//$res[$key]['comment_time'] = Utils::mdate('Y-m-d', $res[$key]['comment_time']);
				//$res[$key]['content'] = htmlspecialchars($res[$key]['content'], ENT_QUOTES);
			}
		}
		return $res;
	}
	
	public function getPicCount()
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		Config::$db->query("select count(*) as num from $tbPic");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function getLikesKey()
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		Config::$db->query("select pic_id, user_id, do_time from $tbLike");
		$res = Config::$db->getAllRows();
		$arr = array();
		if (!empty($res))
		{
			foreach ($res as $row)
			{
				$arr[$row['pic_id'] . '_' . $row['user_id'] . '_' . Utils::mdate('Y-m-d', $row['do_time'])] = 1;
			}
		}
		return $arr;
	}
}
new MainController();
?>
