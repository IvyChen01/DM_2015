<?php
/**
 * 数据库操作
 */
class Database
{
	private $db_driver = '';//数据库驱动类型
	private $db = null;//指定驱动的数据库对象
	
	/**
	 * 创建指定驱动的数据库对象
	 * $db_config	配置数据
	 */
	public function __construct($db_config)
	{
		$this->db_driver = $db_config['db_driver'];
		switch ($this->db_driver)
		{
			case 'mysql':
				$this->db = new Mysql($db_config);
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
	public function get_row($acctype = MYSQL_ASSOC)
	{
		return $this->db->get_row($acctype);
	}
	
	/**
	 * 返回当前的所有记录并把游标移向表尾
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function get_all_rows($acctype = MYSQL_ASSOC)
	{
		return $this->db->get_all_rows($acctype);
	}
	
	/**
	 * 获取查询的记录个数
	 */
	public function get_num_rows()
	{
		return $this->db->get_num_rows();
	}
	
	/**
	 * 获取指定表的所有字段名
	 * $tb_name	表名
	 */
	public function get_all_fields($tb_name)
	{
		return $this->db->get_all_fields($tb_name);
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
	public function get_link_id()
	{
		return $this->db->link_id;
	}
	
	/**
	 * 获取查询结果
	 */
	public function get_result()
	{
		return $this->db->result;
	}
	
	/**
	 * 获取新插入记录的id
	 */
	public function get_insert_id()
	{
		return $this->db->get_insert_id();
	}
	
	/**
	 * 获取当前数据库的所有表名
	 */
	public function get_all_tables()
	{
		return $this->db->get_all_tables();
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
		mysql_select_db($this->dbname) or $this->error('选择数据库失败');
		mysql_query("set names $charset");
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
		$result=mysql_query("SHOW TABLES FROM `$database`") or die(mysql_error());
	//	$result = mysql_list_tables($database);//mysql_list_tables函数不建议使用
		while($tmpArry = mysql_fetch_row($result)){
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
			if(!mysql_query(trim($sql))) 
			{
				$this->error('恢复失败：'.mysql_error());
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
		$createtable = mysql_query("SHOW CREATE TABLE $table");
		$create = mysql_fetch_row($createtable);
		$create[1] = str_replace("\n","",$create[1]);
		$create[1] = str_replace("\t","",$create[1]);

		$tableDom  .= $create[1].";\n";

		$rows = mysql_query("SELECT * FROM $table");
		$numfields = mysql_num_fields($rows);
		$numrows = mysql_num_rows($rows);
		$n = 1;
		$sqlArry = array();
		while ($row = mysql_fetch_row($rows))
		{
		   $comma = "";
		   $tableDom  .= "INSERT INTO $table VALUES(";
		   for($i = 0; $i < $numfields; $i++)
		   {
				$tableDom  .= $comma."'".mysql_real_escape_string($row[$i])."'";
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
	public $link_id = 0;//连接id
	public $result = 0;//查询结果
	
	//数据库配置信息	
	private $hostname = '';//数据库主机
	private $username = '';//用户名
	private $password = '';//密码
	private $db_name = '';//数据库名
	private $db_charset = '';//数据库字符集
	private $db_collat = '';
	private $db_pconnect = false;//是否长连接
	private $is_connected = false;//是否已连接
	
	/**
	 * 存储配置信息并连接数据库
	 * $db_config	配置信息
	 */
	public function __construct($db_config)
	{
		$this->hostname = $db_config['hostname'];
		$this->username = $db_config['username'];
		$this->password = $db_config['password'];
		$this->db_name = $db_config['db_name'];
		$this->db_charset = $db_config['db_charset'];
		$this->db_collat = $db_config['db_collat'];
		$this->db_pconnect = $db_config['db_pconnect'];
	}
	
	/**
	 * 连接数据库
	 */
	public function connect()
	{
		if ( ! $this->is_connected)
		{
			if ($this->db_pconnect)
			{
				$this->link_id = @mysql_pconnect($this->hostname, $this->username, $this->password);
			}
			else
			{
				$this->link_id = @mysql_connect($this->hostname, $this->username, $this->password);
			}
			
			//成功连接则选择数据库，否则处理错误
			if ($this->link_id)
			{
				mysql_select_db($this->db_name);
				mysql_query("SET NAMES '{$this->db_charset}', character_set_client=binary, sql_mode='', interactive_timeout=3600 ;", $this->link_id);
				//标记已连接
				$this->is_connected = true;
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
		if ($this->is_connected)
		{
			$this->result = mysql_query($sql, $this->link_id);
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
	public function get_row($acctype = MYSQL_ASSOC)
	{
		if ($this->result)
		{
			return mysql_fetch_array($this->result, $acctype);
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
	public function get_all_rows($acctype = MYSQL_ASSOC)
	{
		if ($this->result)
		{
			$res = array();
			while ($row = mysql_fetch_array($this->result, $acctype))
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
	public function get_num_rows()
	{
		if ($this->result)
		{
			return mysql_num_rows($this->result);
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 获取指定表的所有字段名
	 * $tb_name	表名
	 */
	public function get_all_fields($tb_name)
	{
		if ($this->is_connected)
		{
			$res = array();
			$fields = mysql_list_fields($this->db_name, $tb_name, $this->link_id);
			if ( ! $fields)
			{
				exit('Database error!');
			}
			$columns = mysql_num_fields($fields);
			for ($i = 0; $i < $columns; $i++)
			{
				$res[$i] = mysql_field_name($fields, $i);
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
		if ($this->link_id)
		{
			mysql_close($this->link_id);
		}
		$this->result = 0;
		$this->link_id = 0;
		$this->is_connected = false;
	}
	
	/**
	 * 获取新插入记录的id
	 */
	public function get_insert_id()
	{
		if ($this->link_id)
		{
			return mysql_insert_id($this->link_id);
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 获取当前数据库的所有表名
	 */
	public function get_all_tables()
	{
		if ($this->is_connected)
		{
			$res = array();
			$this->query("SHOW TABLES");
			$rows = $this->get_all_rows(MYSQL_NUM);
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
			return true;
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
	public static $log_file = 'log.php';//日志文件
	public static $src_time = 0;//开始时间
	
	/**
	 * 程序执行时间
	 */
	public static function runtime()
	{
		$time = microtime(true) - self::$src_time;
		if ($time < 0.001)
		{
			return 0;
		}
		
		return $time;
	}
	
	/**
	 * 添加日志记录
	 * $str	记录内容
	 */
	public static function log($str)
	{
		$file_exists = file_exists(self::$log_file);
		$file = fopen(self::$log_file, 'a+');
		if (!$file_exists)
		{
			fwrite($file, '<?php if(!defined(\'VIEW\')) exit(\'Request Error!\'); ?>' . "\r\n");
			fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n");
		}
		fwrite($file, '[' . Utils::mdate('H:i:s') . ' ' . Utils::get_client_ip() . ']	' . $str . "<br />\r\n");
		fclose($file);
	}
	
	/**
	 * 清空当天日志
	 */
	public static function clear_log()
	{
		$file_exists = file_exists(self::$log_file);
		$file = fopen(self::$log_file, 'w');
		fwrite($file, '<?php if(!defined(\'VIEW\')) exit(\'Request Error!\'); ?>' . "\r\n");
		fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n");
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
		if(isset(self::$way)&&in_array(self::$way,array(1,2,3)))
			return self::$way;
			
		//自动获取最佳访问方式	
		if(function_exists('curl_init'))//curl方式
		{
			return 1;
		}
		else if(function_exists('fsockopen'))//socket
		{
			return 2;
		}
		else if(function_exists('file_get_contents'))//php系统函数file_get_contents
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
	static public function phpPost($url, $post_data=array(), $timeout=5,$header="") 
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
		$head = substr($out, 0, $pos);    //http head
		$status = substr($head, 0, strpos($head, "\r\n"));    //http status line
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
获取ip地址的地理位置信息
需要ip数据库的支持，ip数据库请自行到cp官网http://www.canphp.com下载
 */
class IpArea
{
    /**
     * QQWry.Dat文件指针
     *
     * @var resource
     */
    private $fp;

    /**
     * 第一条IP记录的偏移地址
     *
     * @var int
     */
    private $firstip;

    /**
     * 最后一条IP记录的偏移地址
     *
     * @var int
     */
    private $lastip;

    /**
     * IP记录的总条数（不包含版本信息记录）
     *
     * @var int
     */
    private $totalip;

    /**
     * 构造函数，打开 QQWry.Dat 文件并初始化类中的信息
     *
     * @param string $filename
     * @return IpLocation
     */
    public function __construct($filename = "qqwry.dat") {
        $this->fp = 0;
        if (($this->fp = fopen(dirname(__FILE__).'/'.$filename, 'rb')) !== false) {
            $this->firstip = $this->getlong();
            $this->lastip = $this->getlong();
            $this->totalip = ($this->lastip - $this->firstip) / 7;
        }
    }
	    /**
     * 根据所给 IP 地址或域名返回所在地区信息
     *
     * @access public
     * @param string $ip
     * @return array
     */
    public function get($ip='',$all=false, $charset='utf-8') {
        if (!$this->fp) return null;            // 如果数据文件没有被正确打开，则直接返回空
		if(empty($ip)) $ip = $this->getIp();
        $location['ip'] = gethostbyname($ip);   // 将输入的域名转化为IP地址
        $ip = $this->packip($location['ip']);   // 将输入的IP地址转化为可比较的IP地址
                                                // 不合法的IP地址会被转化为255.255.255.255
        // 对分搜索
        $l = 0;                         // 搜索的下边界
        $u = $this->totalip;            // 搜索的上边界
        $findip = $this->lastip;        // 如果没有找到就返回最后一条IP记录（QQWry.Dat的版本信息）
        while ($l <= $u) {              // 当上边界小于下边界时，查找失败
            $i = floor(($l + $u) / 2);  // 计算近似中间记录
            fseek($this->fp, $this->firstip + $i * 7);
            $beginip = strrev(fread($this->fp, 4));     // 获取中间记录的开始IP地址
            // strrev函数在这里的作用是将little-endian的压缩IP地址转化为big-endian的格式
            // 以便用于比较，后面相同。
            if ($ip < $beginip) {       // 用户的IP小于中间记录的开始IP地址时
                $u = $i - 1;            // 将搜索的上边界修改为中间记录减一
            }
            else {
                fseek($this->fp, $this->getlong3());
                $endip = strrev(fread($this->fp, 4));   // 获取中间记录的结束IP地址
                if ($ip > $endip) {     // 用户的IP大于中间记录的结束IP地址时
                    $l = $i + 1;        // 将搜索的下边界修改为中间记录加一
                }
                else {                  // 用户的IP在中间记录的IP范围内时
                    $findip = $this->firstip + $i * 7;
                    break;              // 则表示找到结果，退出循环
                }
            }
        }

        //获取查找到的IP地理位置信息
        fseek($this->fp, $findip);
        $location['beginip'] = long2ip($this->getlong());   // 用户IP所在范围的开始地址
        $offset = $this->getlong3();
        fseek($this->fp, $offset);
        $location['endip'] = long2ip($this->getlong());     // 用户IP所在范围的结束地址
        $byte = fread($this->fp, 1);    // 标志字节
        switch (ord($byte)) {
            case 1:                     // 标志字节为1，表示国家和区域信息都被同时重定向
                $countryOffset = $this->getlong3();         // 重定向地址
                fseek($this->fp, $countryOffset);
                $byte = fread($this->fp, 1);    // 标志字节
                switch (ord($byte)) {
                    case 2:             // 标志字节为2，表示国家信息又被重定向
                        fseek($this->fp, $this->getlong3());
                        $location['country'] = $this->getstring();
                        fseek($this->fp, $countryOffset + 4);
                        $location['area'] = $this->getarea();
                        break;
                    default:            // 否则，表示国家信息没有被重定向
                        $location['country'] = $this->getstring($byte);
                        $location['area'] = $this->getarea();
                        break;
                }
                break;
            case 2:                     // 标志字节为2，表示国家信息被重定向
                fseek($this->fp, $this->getlong3());
                $location['country'] = $this->getstring();
                fseek($this->fp, $offset + 8);
                $location['area'] = $this->getarea();
                break;
            default:                    // 否则，表示国家信息没有被重定向
                $location['country'] = $this->getstring($byte);
                $location['area'] = $this->getarea();
                break;
        }
        if ($location['country'] == " CZ88.NET") {  // CZ88.NET表示没有有效信息
            $location['country'] = "未知";
        }
        if ($location['area'] == " CZ88.NET") {
            $location['area'] = "";
        }
		//编码转换
		$location=auto_charset($location,'gbk',$charset);
		
		if($all)
			return $location;
		else
			return $location['country'].$location['area'];       
    }
	
    /**
     * 返回读取的长整型数
     *
     * @access private
     * @return int
     */
    private function getlong() {
        //将读取的little-endian编码的4个字节转化为长整型数
        $result = unpack('Vlong', fread($this->fp, 4));
        return $result['long'];
    }

    /**
     * 返回读取的3个字节的长整型数
     *
     * @access private
     * @return int
     */
    private function getlong3() {
        //将读取的little-endian编码的3个字节转化为长整型数
        $result = unpack('Vlong', fread($this->fp, 3).chr(0));
        return $result['long'];
    }

    /**
     * 返回压缩后可进行比较的IP地址
     *
     * @access private
     * @param string $ip
     * @return string
     */
    private function packip($ip) {
        // 将IP地址转化为长整型数，如果在PHP5中，IP地址错误，则返回False，
        // 这时intval将Flase转化为整数-1，之后压缩成big-endian编码的字符串
        return pack('N', intval(ip2long($ip)));
    }

    /**
     * 返回读取的字符串
     *
     * @access private
     * @param string $data
     * @return string
     */
    private function getstring($data = "") {
        $char = fread($this->fp, 1);
        while (ord($char) > 0) {        // 字符串按照C格式保存，以\0结束
            $data .= $char;             // 将读取的字符连接到给定字符串之后
            $char = fread($this->fp, 1);
        }
        return $data;
    }

    /**
     * 返回地区信息
     *
     * @access private
     * @return string
     */
    private function getarea() {
        $byte = fread($this->fp, 1);    // 标志字节
        switch (ord($byte)) {
            case 0:                     // 没有区域信息
                $area = "";
                break;
            case 1:
            case 2:                     // 标志字节为1或2，表示区域信息被重定向
                fseek($this->fp, $this->getlong3());
                $area = $this->getstring();
                break;
            default:                    // 否则，表示区域信息没有被重定向
                $area = $this->getstring($byte);
                break;
        }
        return $area;
    }
	//获取ip地址
	public function getIp()
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
	   return($ip);
	}
	 /**
     * 析构函数，用于在页面执行结束后自动关闭打开的文件。
     *
     */
    public function __destruct() {
        if ($this->fp) {
            fclose($this->fp);
        }
        $this->fp = 0;
    }
}

if (!function_exists('auto_charset')) 
{
	// 自动转换字符集 支持数组转换
	function auto_charset($fContents,$from='gbk',$to='utf-8'){
		$from   =  strtoupper($from)=='UTF8'? 'utf-8':$from;
		$to       =  strtoupper($to)=='UTF8'? 'utf-8':$to;
		if( strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents)) ){
			//如果编码相同或者非字符串标量则不转换
			return $fContents;
		}
		if(is_string($fContents) ) {
			if(function_exists('mb_convert_encoding')){
				return mb_convert_encoding ($fContents, $to, $from);
			}elseif(function_exists('iconv')){
				return iconv($from,$to,$fContents);
			}else{
				return $fContents;
			}
		}
		elseif(is_array($fContents)){
			foreach ( $fContents as $key => $val ) {
				$_key =     auto_charset($key,$from,$to);
				$fContents[$_key] = auto_charset($val,$from,$to);
				if($key != $_key )
					unset($fContents[$key]);
			}
			return $fContents;
		}
		else{
			return $fContents;
		}
	}
}

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
	public static function var_get($value)
	{
		$res = isset($_GET[$value]) ? $_GET[$value] : '';
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
	public static function var_post($value)
	{
		$res = isset($_POST[$value]) ? $_POST[$value] : '';
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
	public static function var_sql($value)
	{
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$value = stripslashes($value);
		}
		$value = "'" . mysql_real_escape_string($value) . "'";
		
		return $value;
	}
	
	/**
	 * 多次md5加密
	 * $id: 原文
	 * $key: 密钥
	 */
	public static function md5_multi($id, $key)
	{
		$id_key = $key . $id;
		$str1 = md5(substr(md5($id_key), 3, 16) . substr(md5($key), 5, 11) . $id_key);
		$str2 = md5($id_key);
		$code = '';
		for ($i = 0; $i < 32; $i++)
		{
			$t = substr($str2, $i, 1);
			$t_code = ord($t);
			if ($t_code >= 48 && $t_code <= 57)
			{
				$t = chr(97 + $t_code - 48);
			}
			$code .= $t;
		}
		
		return substr($code, 0, 13) . $str1 . substr($code, 13, 19);
	}
	
	//加密函数，可用decrypt()函数解密，$data：待加密的字符串或数组；$key：密钥；$expire 过期时间
	public static function encrypt($data, $key = '', $expire = 0)
	{
		$string=serialize($data);
		$ckey_length = 4;
		$key = md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = substr(md5(microtime()), -$ckey_length);
	
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
		
		$string =  sprintf('%010d', $expire ? $expire + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) 
		{
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for($j = $i = 0; $i < 256; $i++) 
		{
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i++) 
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
		$ckey_length = 4;
		$key = md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = substr($string, 0, $ckey_length);
		
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
		
		$string =  base64_decode(substr($string, $ckey_length));
		$string_length = strlen($string);
		
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) 
		{
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for($j = $i = 0; $i < 256; $i++) 
		{
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i++) 
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
	public static function in($data,$force=false)
	{
		if(is_string($data))
		{
			$data=trim(htmlspecialchars($data));//防止被挂马，跨站攻击
			if(($force==true)||(!get_magic_quotes_gpc())) 
			{
			   $data = addslashes($data);//防止sql注入
			}
			return  $data;
		}
		else if(is_array($data))//如果是数组采用递归过滤
		{
			foreach($data as $key=>$value)
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
		if(is_string($data))
		{
			return $data = stripslashes($data);
		}
		else if(is_array($data))//如果是数组采用递归过滤
		{
			foreach($data as $key=>$value)
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
	public static function text_in($str)
	{
		$str=strip_tags($str,'<br>');
		$str = str_replace(" ", "&nbsp;", $str);
		$str = str_replace("\n", "<br>", $str);	
		if(!get_magic_quotes_gpc()) 
		{
		  $str = addslashes($str);
		}
		return $str;
	}
	
	//文本输出
	public static function text_out($str)
	{
		$str = str_replace("&nbsp;", " ", $str);
		$str = str_replace("<br>", "\n", $str);	
		$str = stripslashes($str);
		return $str;
	}
	
	//html代码输出
	public static function html_out($str)
	{
		if(function_exists('htmlspecialchars_decode'))
			$str=htmlspecialchars_decode($str);
		else
			$str=html_entity_decode($str);
	
		$str = stripslashes($str);
		return $str;
	}
	
	/**
	 * html转换输出
	 */
	public static function htmlspecialchars_array($arr)
	{
		if (is_array($arr))
		{
			$res = array();
			foreach ($arr as $key => $value)
			{
				$res[$key] = self::htmlspecialchars_array($value);
			}
			
			return $res;
		}
		else
		{
			return htmlspecialchars($arr, ENT_QUOTES);
		}
	}
	
	//html代码输入
	public static function html_in($str)
	{
		$search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
						 "'<iframe[^>]*?>.*?</iframe>'si", // 去掉iframe
						);
		$replace = array ("",
						  "",
						);			  
	   $str=@preg_replace ($search, $replace, $str);
	   $str=htmlspecialchars($str);
		if(!get_magic_quotes_gpc()) 
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
	public static function mdate($format, $date_str = '')
	{
		if (empty($date_str))
		{
			$date = new DateTime();
		}
		else
		{
			try
			{
				$date = new DateTime($date_str);
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
	public static function get_client_ip()
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
	 * 递归创建文件夹	Utils::create_dir('2012/02/10")
	 * $path	路径
	 */
	public static function create_dir($path)
	{
		if (!file_exists($path))
		{
			self::create_dir(dirname($path));
			mkdir($path, 0777);
		}
	}
	
	/**
	 * 遍历删除目录和目录下所有文件
	 */
	public static function del_dir($dir)
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
				is_dir("$dir/$file") ? self::del_dir("$dir/$file") : @unlink("$dir/$file");
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
	public static function mbsubstr($str, $start, $length, $auto_extend = true, $charset='utf-8')
	{
		$src_len = mb_strlen($str, $charset);
		$new_str = mb_substr($str, $start, $length, $charset);
		$new_len = mb_strlen($new_str, $charset);
		if ($auto_extend && $src_len > $new_len)
		{
			$new_str .= '...';
		}
		
		return $new_str;
	}
	
	/**
	 * 检查字符串是否是UTF8编码,是返回true,否则返回false
	 */
	public static function is_utf8($string)
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
	 * 自动转换字符集 支持数组转换
	 */
	public static function auto_charset($fContents,$from='gbk',$to='utf-8'){
		$from   =  strtoupper($from)=='UTF8'? 'utf-8':$from;
		$to       =  strtoupper($to)=='UTF8'? 'utf-8':$to;
		if( strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents)) ){
			//如果编码相同或者非字符串标量则不转换
			return $fContents;
		}
		if(is_string($fContents) ) {
			if(function_exists('mb_convert_encoding')){
				return mb_convert_encoding ($fContents, $to, $from);
			}elseif(function_exists('iconv')){
				return iconv($from,$to,$fContents);
			}else{
				return $fContents;
			}
		}
		elseif(is_array($fContents)){
			foreach ( $fContents as $key => $val ) {
				$_key =     auto_charset($key,$from,$to);
				$fContents[$_key] = auto_charset($val,$from,$to);
				if($key != $_key )
					unset($fContents[$key]);
			}
			return $fContents;
		}
		else{
			return $fContents;
		}
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
	public static function gen_uniqid()
	{
		return md5(uniqid(rand(), true));
	}
	
	/**
	 * 获取两个日期相隔的天数
	 * return $day2 - $day1
	 */
	public static function rest_days($day1, $day2)
	{
		return ceil((strtotime($day2) - strtotime($day1)) / (3600 * 24));
	}
	
	/**
	 * 获取两个日期相隔的秒数
	 * return $day2 - $day1
	 */
	public static function rest_seconds($day1, $day2)
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
	public static function format_date($date)
	{
		$month_en = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$month = (int)self::mdate('m', $date);
		
		return $month_en[$month - 1] . self::mdate(' j, Y', $date);
	}
	
	/**
	 * 返回数据到客户端
	 */
	public static function echo_data($code = 0, $info = 'ok', $param = null)
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
	public static function check_mobile()
	{
		$touchbrowser_list = array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
					'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
					'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
					'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource',
					'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
					'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
					'benq', 'haier', '^lct', '320x320', '240x320', '176x220', 'windows phone');
		$wmlbrowser_list = array('cect', 'compal', 'ctl', 'lg', 'nec', 'tcl', 'alcatel', 'ericsson', 'bird', 'daxian', 'dbtel', 'eastcom',
				'pantech', 'dopod', 'philips', 'haier', 'konka', 'kejian', 'lenovo', 'benq', 'mot', 'soutec', 'nokia', 'sagem', 'sgh',
				'sed', 'capitel', 'panasonic', 'sonyericsson', 'sharp', 'amoi', 'panda', 'zte', 'linux');
		$pad_list = array('ipad');
		$brower = array('mozilla', 'chrome', 'safari', 'opera', 'm3gate', 'winwap', 'openwave', 'myop');
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		
		if(self::dstrpos($useragent, $pad_list)) {
			return false;
		}
		
		$v = self::dstrpos($useragent, $touchbrowser_list, true);
		if($v) {
			return $v;
		}
		
		if(self::dstrpos($useragent, $wmlbrowser_list)) {
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
		if(empty($string)) return false;
		foreach((array)$arr as $v) {
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
	public static function gen_filename($extend = '')
	{
		return time() . rand(100000, 999999) . $extend;
	}
	
	/**
	 * [x]
	 * 生成静态页
	 * $file_name	生成文件名
	 * $url	所要生成HTML的页面的URL
	 */
	public static function x_make_html($file_name, $url)
	{
		self::create_dir(dirname($file_name));
		ob_start();
		echo file_get_contents($url);
		file_put_contents($file_name, ob_get_clean(), LOCK_EX);
	}
	
	/**
	 * 编译PHP文件
	 * $files	待编译的PHP文件
	 * $file_make	编译生成的PHP文件
	 */
	public static function make_php($files, $file_make, $extends_code = '')
	{
		$file_write = fopen($file_make, 'w');
		fwrite($file_write, "<?php");
		foreach ($files as $value)
		{
			$str = file_get_contents($value);
			$str = preg_replace('/^<\?php/', '', $str, 1);
			$str = preg_replace("/\?>\r\n$/", '', $str, 1);
			fwrite($file_write, $str);
		}
		if (!empty($extends_code))
		{
			fwrite($file_write, $extends_code . "\r\n");
		}
		fwrite($file_write, "?>\r\n");
		fclose($file_write);
	}
}

//xml解析成数组
//静态类
class Xml
{
	public static function decode($xml)
	{
		$values = array();
		$index  = array();
		$array  = array();
		$parser = xml_parser_create('utf-8');
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parse_into_struct($parser, $xml, $values, $index);
		xml_parser_free($parser);
		$i = 0;
		$name = $values[$i]['tag'];
		$array[$name] = isset($values[$i]['attributes']) ? $values[$i]['attributes'] : '';
		$array[$name] = self::_struct_to_array($values, $i);
		return $array;
	}
	
	private static function _struct_to_array($values, &$i)
	{
		$child = array();
		if (isset($values[$i]['value'])) 
		array_push($child, $values[$i]['value']);
		
		while ($i++ < count($values))
		 {
			switch ($values[$i]['type']) 
			{
				case 'cdata':
					array_push($child, $values[$i]['value']);
					break;
				
				case 'complete':
					$name = $values[$i]['tag'];
					if(!empty($name))
					{
						$child[$name]= ($values[$i]['value'])?($values[$i]['value']):'';
						if(isset($values[$i]['attributes'])) 
						{                   
							$child[$name] = $values[$i]['attributes'];
						}
					}   
				break;
				
				case 'open':
					$name = $values[$i]['tag'];
					$size = isset($child[$name]) ? sizeof($child[$name]) : 0;
					$child[$name][$size] = self::_struct_to_array($values, $i);
					break;
				
				case 'close':
					return $child;
					break;
			}
		}
		return $child;
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
		$action = Security::var_get('a');//操作标识
		switch ($action)
		{
			case 'verify':
				$this->verify();
				return;
			case 'do_login':
				$this->do_login();
				return;
			default:
		}
		
		if ($this->admin->check_login())
		{
			switch ($action)
			{
				case 'change_password':
					$this->change_password();
					return;
				case 'do_change_password':
					$this->do_change_password();
					return;
				case 'logout':
					$this->logout();
					return;
				case 'log':
					$this->log();
					return;
				case 'clear_log':
					$this->clear_log();
					return;
				case 'db':
					$this->db();
					return;
				case 'db2':
					$this->db2();
					return;
				case 'db_daily':
					$this->db_daily();
					return;
				case 'db_zhong_jiang':
					$this->db_zhong_jiang();
					return;
				case 'db_jiang_chi':
					$this->db_jiang_chi();
					return;
				case 'backup':
					$this->backup();
					return;
				case 'recover':
					$this->recover();
					return;
				case 'upgrade':
					$this->upgrade();
					return;
				case 'install':
					return;
					$this->install();
					return;
				case 'upload_image':
					$this->upload_image();
					return;
				case 'upload_jq_image':
					$this->upload_jq_image();
					return;
				case 'sum_prize':
					$this->sum_prize();
					return;
				case 'init_prize':
					$this->init_prize();
					return;
				case 'winlist':
					$this->winlist();
					return;
				case 'lucky_count':
					$this->lucky_count();
					return;
				case 'install_hong_bao':
					return;
					$this->install_hong_bao();
					return;
				case 'db3':
					$this->db3();
					return;
				case 'hong_bao_count':
					$this->hong_bao_count();
					return;
				case 'hong_bao_winlist':
					$this->hong_bao_winlist();
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
		$this->admin->get_verify();
	}
	
	/**
	 * 登录
	 */
	private function do_login()
	{
		$username = Security::var_post('username');
		$password = Security::var_post('password');
		$verify = Security::var_post('verify');
		
		if ($this->admin->check_verify($verify))
		{
			if (!empty($username) && !empty($password))
			{
				if ($this->admin->login($username, $password))
				{
					Utils::echo_data(0, '登录成功！');
				}
				else
				{
					Utils::echo_data(1, '用户名或密码不正确！');
				}
			}
			else
			{
				Utils::echo_data(2, '用户名和密码不能为空！');
			}
		}
		else
		{
			Utils::echo_data(3, '验证码不正确！');
		}
	}
	
	/**
	 * 显示修改密码页
	 */
	private function change_password()
	{
		include('view/admin/change_password.php');
	}
	
	/**
	 * 修改密码
	 */
	private function do_change_password()
	{
		$src_password = Security::var_post('src_password');
		$new_password = Security::var_post('new_password');
		if (!empty($src_password) && !empty($new_password))
		{
			if ($this->admin->check_password($src_password))
			{
				$this->admin->change_password($new_password);
				$this->admin->logout();
				Utils::echo_data(0, '修改成功！');
			}
			else
			{
				Utils::echo_data(1, '原密码错误！');
			}
		}
		else
		{
			Utils::echo_data(2, '原密码和新密码不能为空！');
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
		$date = Security::var_get('date');
		if (empty($date))
		{
			if (file_exists(Debug::$log_file))
			{
				include(Debug::$log_file);
			}
			else
			{
				echo 'No log!';
			}
		}
		else
		{
			$log_file = Config::$dir_log . Utils::mdate('Y-m-d', $date) . '.php';
			if (file_exists($log_file))
			{
				include($log_file);
			}
			else
			{
				echo 'No log!';
			}
		}
	}
	
	/**
	 * 清空当天日志
	 */
	private function clear_log()
	{
		Debug::clear_log();
		echo 'ok';
	}
	
	/**
	 * 查看数据库数据
	 */
	private function db()
	{
		$install = new Install();
		$all_tables = $install->get_all_tables();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	private function db2()
	{
		$install = new Install();
		$all_tables = array(Config::$tb_admin, Config::$tb_user, Config::$tb_jiang_chi, Config::$tb_zhong_jiang, Config::$tb_lucky_daily);
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	private function db_daily()
	{
		$install = new Install();
		$all_tables = array(Config::$tb_lucky_daily);
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	private function db_zhong_jiang()
	{
		$install = new Install();
		$all_tables = array(Config::$tb_zhong_jiang);
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	private function db_jiang_chi()
	{
		$install = new Install();
		$all_tables = array(Config::$tb_jiang_chi);
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	/**
	 * 备份数据库
	 */
	private function backup()
	{
		$install = new Install();
		$install->backup();
		echo 'ok';
	}
	
	/**
	 * 恢复数据库
	 */
	private function recover()
	{
		$install = new Install();
		$install->recover();
		echo 'ok';
	}
	
	/**
	 * 升级系统
	 */
	private function upgrade()
	{
		$install = new Install();
		$install->upgrade();
		echo 'ok';
	}
	
	/**
	 * 安装系统
	 */
	private function install()
	{
		$install = new Install();
		$install->install();
		echo 'ok';
	}
	
	/**
	 * 上传图片
	 */
	private function upload_image()
	{
		echo System::upload_image();
	}
	
	/**
	 * 上传JQ图片
	 */
	private function upload_jq_image()
	{
		System::upload_jq_image();
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
	
	private function sum_prize()
	{
		$install = new Install();
		$install->sum_prize();
	}
	
	private function init_prize()
	{
		$install = new Install();
		$install->init_prize();
		echo 'ok';
	}
	
	private function winlist()
	{
		$lucky = new Lucky();
		$zhong_jiang = $lucky->get_zhong_jiang();
		$_jiang_list = array();
		
		foreach ($zhong_jiang as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_time']);
			if (!isset($_jiang_list[$date]))
			{
				$_jiang_list[$date] = array();
				$_jiang_list[$date]['date'] = $date;
				$_jiang_list[$date]['winner'] = array();
			}
			$_jiang_list[$date]['winner'][] = array('department' => $value['department'], 'username' => $value['username'], 'prizename' => $value['prizename']);
		}
		
		include('view/admin/winlist.php');
	}
	
	private function lucky_count()
	{
		$lucky = new Lucky();
		$daily = $lucky->get_daily();
		$zhong_jiang = $lucky->get_zhong_jiang();
		
		$_day_list = array();
		$_total_lucky = 0;
		$_total_winner = 0;
		$_total_lucky_rate = 0;
		
		foreach ($daily as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_time']);
			if (!isset($_day_list[$date]))
			{
				$_day_list[$date] = array();
				$_day_list[$date]['date'] = $date;
				$_day_list[$date]['lucky'] = 0;
				$_day_list[$date]['winner'] = 0;
				$_day_list[$date]['lucky_rate'] = 0;
			}
			$_day_list[$date]['lucky']++;
			$_total_lucky++;
		}
		
		foreach ($zhong_jiang as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_time']);
			if (!isset($_day_list[$date]))
			{
				$_day_list[$date] = array();
				$_day_list[$date]['date'] = $date;
				$_day_list[$date]['lucky'] = 0;
				$_day_list[$date]['winner'] = 0;
				$_day_list[$date]['lucky_rate'] = 0;
			}
			$_day_list[$date]['winner']++;
			$_total_winner++;
		}
		
		foreach ($_day_list as $value)
		{
			$date = $value['date'];
			$numWinner = $_day_list[$date]['winner'];
			$numLucky = $_day_list[$date]['lucky'];
			if ($numLucky != 0)
			{
				$_day_list[$date]['lucky_rate'] = round($numWinner / $numLucky * 100, 1);
			}
		}
		
		if ($_total_lucky != 0)
		{
			$_total_lucky_rate = round($_total_winner / $_total_lucky * 100, 1);
		}
		
		include('view/admin/lucky_count.php');
	}
	
	private function install_hong_bao()
	{
		$install = new Install();
		$install->install_hong_bao();
		echo 'ok';
	}
	
	private function db3()
	{
		$install = new Install();
		$all_tables = array(Config::$tb_hb_jiang_chi, Config::$tb_hb_zhong_jiang, Config::$tb_hb_lucky_daily, Config::$tb_hb_bind_user, Config::$tb_hb_base_user);
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1100);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	private function hong_bao_count()
	{
		$hong_bao = new HongBao();
		$daily = $hong_bao->get_daily();
		$_day_list = array();
		$_total_lucky = 0;
		
		foreach ($daily as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_time']);
			if (!isset($_day_list[$date]))
			{
				$_day_list[$date] = array();
				$_day_list[$date]['date'] = $date;
				$_day_list[$date]['lucky'] = 0;
			}
			$_day_list[$date]['lucky']++;
			$_total_lucky++;
		}
		
		include('view/admin/hong_bao_count.php');
	}
	
	private function hong_bao_winlist()
	{
		$hong_bao = new HongBao();
		$zhong_jiang = $hong_bao->get_zhong_jiang();
		$_jiang_list = array();
		
		foreach ($zhong_jiang as $value)
		{
			$_jiang_list[] = array('jobnum' => $value['jobnum'], 'username' => $value['username'], 'department' => $value['department'], 'prizename' => $value['prizename']);
		}
		
		include('view/admin/hong_bao_winlist.php');
	}
}

/**
 * 红包控制器
 */
class HongBaoController
{
	private $hong_bao = null;//红包模型
	
	public function __construct()
	{
		$this->hong_bao = new HongBao();
		$action = Security::var_get('a');//操作标识
		switch ($action)
		{
			case 'hong_bao':
				$this->hong_bao();
				return;
			case 'bind_jobnum':
				$this->bind_jobnum();
				return;
			case 'click_hong_bao':
				$this->click_hong_bao();
				return;
			case 'hong_bao_test':
				$this->hong_bao_test();
				return;
			default:
		}
	}
	
	private function hong_bao()
	{
		$openid = trim(Security::var_get('openid'));
		$key = trim(Security::var_get('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		
		/*
		///// debug
		$openid = rand(1, 1000000000);
		$openid = 'a001';
		$key = Security::md5_multi($openid, Config::$key);
		$srcKey = Security::md5_multi($openid, Config::$key);
		*/
		
		$_is_bind_jobnum = false;
		$_click_flag = 0;
		$_money = 0;
		$_max_money = 0;
		$_records = null;
		$_jobnum = '';
		$_username = '';
		$_openid = $openid;
		$_key = $srcKey;
		
		if ($key == $srcKey && !empty($openid))
		{
			$userinfo = $this->hong_bao->get_bind_user_info($openid);
			if (empty($userinfo))
			{
				//没绑定工号
				$_is_bind_jobnum = false;
				$_records = json_encode(array());
			}
			else
			{
				//已绑定工号
				$jobnum = $userinfo['jobnum'];
				$username = $userinfo['username'];
				$department = $userinfo['department'];
				$lucky_info = $this->hong_bao->get_lucky_today($jobnum);
				$is_lucky = $lucky_info['is_lucky'];
				
				if ($is_lucky)
				{
					$click_flag = $lucky_info['click_flag'];
					$money = $lucky_info['money'];
				}
				else
				{
					$click_flag = 0;
					//$money = $this->hong_bao->lucky($jobnum, $username, $department, $openid);
					$money = 0;
				}
				
				$_is_bind_jobnum = true;
				$_click_flag = $click_flag;
				$_money = $money;
				$_max_money = $this->hong_bao->get_max_money($jobnum);
				$_records = json_encode($this->hong_bao->get_records($jobnum));
				$_jobnum = $jobnum;
				$_username = $username;
			}
			
			//include('view/hong_bao.php');
			include('view/hong_bao_end.php');
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	private function bind_jobnum()
	{
		Utils::echo_data(5, '非法请求！');
		return;
		
		$openid = trim(Security::var_post('openid'));
		$key = trim(Security::var_post('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		$jobnum = trim(Security::var_post('jobnum'));
		$username = trim(Security::var_post('username'));
		
		if ($key == $srcKey && !empty($openid))
		{
			if (empty($jobnum) || empty($username))
			{
				Utils::echo_data(1, '工号和姓名不能为空！');
			}
			else
			{
				$userinfo = $this->hong_bao->get_base_user_info($jobnum);
				if (empty($userinfo))
				{
					Utils::echo_data(2, '工号或姓名不正确！');
				}
				else
				{
					$base_username = $userinfo['username'];
					if ($username != $base_username)
					{
						Utils::echo_data(2, '工号或姓名不正确！');
					}
					else
					{
						if ($this->hong_bao->check_bind_jobnum($jobnum))
						{
							Utils::echo_data(3, '该工号已被绑定过了！');
						}
						else
						{
							if ($this->hong_bao->check_bind_openid($openid))
							{
								Utils::echo_data(4, '该微信号已经绑定过工号了！');
							}
							else
							{
								$department = $userinfo['department'];
								$this->hong_bao->bind_jobnum($jobnum, $username, $department, $openid);
								$money = $this->hong_bao->lucky($jobnum, $username, $department, $openid);
								$max_money = $this->hong_bao->get_max_money($jobnum);
								$records = $this->hong_bao->get_records($jobnum);
								Utils::echo_data(0, '绑定成功！', array('money' => $money, 'maxMoney' => $max_money, 'records' => json_encode($records), 'jobnum' => $jobnum, 'username' => $username));
							}
						}
					}
				}
			}
		}
		else
		{
			Utils::echo_data(5, '非法请求！');
		}
	}
	
	private function click_hong_bao()
	{
		Utils::echo_data(1, '非法请求！');
		return;
		
		$openid = trim(Security::var_post('openid'));
		$key = trim(Security::var_post('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		$jobnum = trim(Security::var_post('jobnum'));
		
		if ($key == $srcKey && !empty($openid))
		{
			$this->hong_bao->set_pan_click($jobnum);
			Utils::echo_data(0, 'ok');
		}
		else
		{
			Utils::echo_data(1, '非法请求！');
		}
	}
	
	private function hong_bao_test()
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo '<p style="font-size: 60px;">抢红包测试通道已经关闭了~</p>';
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
		if (file_exists(Config::$install_lock))
		{
			exit('Locked!');
		}
		else
		{
			$this->install = new Install();
			$action = Security::var_get('a');//操作标识
			switch ($action)
			{
				case 'create_database':
					$this->create_database();
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
	private function create_database()
	{
		$this->install->create_database();
		echo 'Succeed!';
	}
	
	/**
	 * 安装数据库
	 */
	private function install()
	{
		$this->install->install();
		$this->create_lock_file();
		echo 'Succeed!';
	}
	
	/**
	 * 生成锁定文件
	 */
	private function create_lock_file()
	{
		$file = fopen(Config::$install_lock, 'a');
		fwrite($file, '<?php //重要，请勿删除！需重新安装数据库或升级数据库时才可删除。?>');
		fclose($file);
	}
}

/**
 * 抽奖控制器
 */
class LuckyController
{
	private $lucky = null;//抽奖模型
	
	public function __construct()
	{
		$this->lucky = new Lucky();
		$action = Security::var_get('a');//操作标识
		switch ($action)
		{
			case 'lucky':
				$this->lucky();
				return;
			case 'fill_lucky_info':
				$this->fill_lucky_info();
				return;
			case 'click_pan':
				$this->click_pan();
				return;
			default:
		}
	}
	
	private function lucky()
	{
		include('view/lucky_end.php');
		return;
		
		$openid = trim(Security::var_get('openid'));
		$key = trim(Security::var_get('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		
		/*
		///// debug
		$openid = rand(1, 1000000000);
		$openid = 'a0012';
		$key = Security::md5_multi($openid, Config::$key);
		$srcKey = Security::md5_multi($openid, Config::$key);
		*/
		
		$_is_lucky_today = false;
		$_pan_flag = 0;
		$_is_win_today = false;
		$_is_saved_info = false;
		$_department = '';
		$_username = '';
		$_lucky_code = 0;
		$_openid = $openid;
		$_key = $srcKey;
		
		if ($key == $srcKey && !empty($openid))
		{
			$lucky_today = $this->lucky->check_lucky_today($openid);
			$_is_lucky_today = $lucky_today[0];
			$_pan_flag = $lucky_today[1];
			if ($_is_lucky_today)
			{
				if ($this->lucky->check_is_win_today($openid))
				{
					$_is_win_today = true;
					$userinfo = $this->lucky->get_userinfo_today($openid);
					$is_save = $userinfo[0];
					$_department = $userinfo[1];
					$_username = $userinfo[2];
					$_lucky_code = $userinfo[3];
					if ($is_save)
					{
						$_is_saved_info = true;
					}
					else
					{
						$_is_saved_info = false;
					}
				}
				else
				{
					$_is_win_today = false;
				}
			}
			else
			{
				$_lucky_code = $this->lucky->lucky($openid);
			}
			include('view/lucky.php');
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	private function fill_lucky_info()
	{
		Utils::echo_data(2, '非法请求！');
		return;
		
		$openid = trim(Security::var_post('openid'));
		$key = trim(Security::var_post('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		$department = trim(Security::var_post('department'));
		$username = trim(Security::var_post('username'));
		
		if ($key == $srcKey && !empty($openid))
		{
			if (empty($department) || empty($username))
			{
				Utils::echo_data(3, '部门和姓名不能为空！');
			}
			else
			{
				$userinfo = $this->lucky->get_userinfo_today($openid);
				$is_save = $userinfo[0];
				if ($is_save)
				{
					Utils::echo_data(1, '请勿重复提交！');
				}
				else
				{
					$this->lucky->save_win_userinfo($openid, $department, $username);
					Utils::echo_data(0, 'ok', array('department' => $department, 'username' => $username));
				}
			}
		}
		else
		{
			Utils::echo_data(2, '非法请求！');
		}
	}
	
	private function click_pan()
	{
		Utils::echo_data(2, '非法请求！');
		return;
		
		$openid = trim(Security::var_post('openid'));
		$key = trim(Security::var_post('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		
		if ($key == $srcKey && !empty($openid))
		{
			if (!$this->lucky->check_pan_today($openid))
			{
				$this->lucky->set_pan_click($openid);
				Utils::echo_data(0, 'ok');
			}
			else
			{
				Utils::echo_data(1, '已经点击过了！');
			}
		}
		else
		{
			Utils::echo_data(2, '非法请求！');
		}
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
		$module = Security::var_get('m');//模块标识
		switch ($module)
		{
			case 'admin':
				new AdminController();
				break;
			case 'hong_bao':
				new HongBaoController();
				break;
			case 'install':
				new InstallController();
				break;
			case 'lucky':
				new LuckyController();
				break;
			case 'weixin':
				new WeixinController();
				break;
			default:
				new WeixinController();
				
				//echo Security::md5_multi('admin', Config::$key);
		}
		
		$action = Security::var_get('a');//操作标识
		if (!('admin' == $module && 'log' == $action))
		{
			Debug::log("[$module][$action] time: " . Debug::runtime());
		}
	}
}

/**
 * 微信控制器
 */
class WeixinController
{
	private $weixin = null;//微信模型
	
	public function __construct()
	{
		$this->weixin = new Weixin();
		$action = Security::var_get('a');//操作标识
		switch ($action)
		{
			case 'lucky':
				$this->lucky();
				return;
			case 'fill_lucky_info':
				$this->fill_lucky_info();
				return;
			case 'click_pan':
				$this->click_pan();
				return;
			default:
				$this->index();
		}
	}
	
	/**
	 * 首页
	 */
	private function index()
	{
		//$this->weixin->valid();
		//return;
		
		if ($this->weixin->checkSignature())
		{
			$this->response();
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	private function response()
	{
		//get post data, May be due to the different environments
		$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
		
		//extract post data
		if (!empty($postStr))
		{
			/* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection, the best way is to check the validity of xml by yourself */
			libxml_disable_entity_loader(true);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			
			$toUserName = $postObj->ToUserName;
			$fromUserName = $postObj->FromUserName;
			$createTime = $postObj->CreateTime;
			$msgType = $postObj->MsgType;
			$content = trim($postObj->Content);
			$msgid = $postObj->MsgId;
			$event = $postObj->Event;
			
			/*
			Debug::log('$toUserName: ' . $toUserName);
			Debug::log('$fromUserName: ' . $fromUserName);
			Debug::log('$createTime: ' . $createTime);
			Debug::log('$msgType: ' . $msgType);
			Debug::log('$content: ' . $content);
			Debug::log('$msgid: ' . $msgid);
			Debug::log('$event: ' . $event);
			*/
			
			$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";
			$time = time();
			
			switch ($msgType)
			{
				case 'text':
					switch ($content)
					{
						case '我要抽奖':
							$key = Security::md5_multi($fromUserName, Config::$key);
							//$contentStr = '猛戳这里进入抽奖：' . "\n" . '<a href="www.geyaa.com/transsion_weixin/?m=lucky&a=lucky&openid=' . $fromUserName . '&key=' . $key . '">年会抽奖第一弹</a>';
							$contentStr = '转盘抽奖结束了哦~';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						case '我要抢红包':
							$key = Security::md5_multi($fromUserName, Config::$key);
							//$contentStr = '抢红包活动2月3日10:00开始，敬请期待~';
							//$contentStr = '猛戳这里抢红包：' . "\n" . '<a href="http://temp.qumuwu.com/?m=hong_bao&a=hong_bao&openid=' . $fromUserName . '&key=' . $key . '">传音年会抢红包</a>';
							$contentStr = '抢红包活动已经结束了哦~';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						case '抢红包测试':
							$key = Security::md5_multi($fromUserName, Config::$key);
							//$contentStr = '猛戳这里抢红包：' . "\n" . '<a href="http://temp.qumuwu.com/?m=hong_bao&a=hong_bao_test&openid=' . $fromUserName . '&key=' . $key . '">抢红包测试</a>';
							$contentStr = '抢红包测试通道已经关闭了~';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						default:
							echo '';
					}
					break;
				case 'event':
					switch ($event)
					{
						case 'subscribe':
							$contentStr = "欢迎来到传音\n查看历史纪录，点击右上角人像";
							//$contentStr = '终于等到你！还好你没放弃。来这儿就对了！这儿，美女如云。这儿，呈现一手花絮。这儿，更多礼物送！送！送！';
							//$contentStr = '这儿，美女如云。这儿，更多一手花絮，深情表白，匿名点歌。天青色等烟雨，长腿欧巴就在这等着你！！';
							//$contentStr = '非常感谢你的关注！小编将为您爆料2015传音年会最劲爆动态，最逗B的花絮敬请期待。';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						case 'unsubscribe':
							echo '';
							break;
						default:
							echo '';
					}
					break;
				default:
					echo '';
			}
		}
		else
		{
			echo '';
		}
	}
	
	private function lucky()
	{
		include('view/lucky_end.php');
		return;
	}
	
	private function fill_lucky_info()
	{
		Utils::echo_data(2, '非法请求！');
		return;
	}
	
	private function click_pan()
	{
		Utils::echo_data(2, '非法请求！');
		return;
	}
}

/**
 *	管理员
 */
class Admin
{
	private $db = null;//数据库
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
	}
	
	/**
	 * 登录
	 */
	public function login($username, $password)
	{
		$this->db->connect();
		$tb_admin = Config::$tb_admin;
		$password = Security::md5_multi($password, Config::$key);
		$sql_username = Security::var_sql($username);
		$this->db->query("SELECT * FROM $tb_admin WHERE username=$sql_username");
		$res = $this->db->get_row();
		
		if (!empty($res))
		{
			if ($password == $res['password'])
			{
				System::set_session('admin_userid', (int)$res['id']);
				System::set_session('admin_username', $res['username']);
				System::set_session('admin_password', $res['password']);
				Debug::log('[admin login] userid: ' . $res['id'] . ', username: ' . $res['username']);
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
	public function check_login()
	{
		if ($this->get_userid() > 0)
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
		System::clear_session('admin_userid');
		System::clear_session('admin_username');
		System::clear_session('admin_password');
	}
	
	/**
	 * 检测密码是否正确
	 */
	public function check_password($password)
	{
		$session_password = $this->get_password();
		$in_password = Security::md5_multi($password, Config::$key);
		if ($session_password == $in_password)
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
	public function change_password($new_password)
	{
		$this->db->connect();
		$tb_admin = Config::$tb_admin;
		$sql_id = (int)$this->get_userid();
		$new_password = Security::md5_multi($new_password, Config::$key);
		$sql_new_password = Security::var_sql($new_password);
		$this->db->query("UPDATE $tb_admin SET password=$sql_new_password WHERE id=$sql_id");
	}
	
	/**
	 * 获取用户编号
	 */
	public function get_userid()
	{
		return (int)System::get_session('admin_userid');
	}
	
	/**
	 * 获取用户名
	 */
	public function get_username()
	{
		return System::get_session('admin_username');
	}
	
	/**
	 * 获取密码
	 */
	public function get_password()
	{
		return System::get_session('admin_password');
	}
	
	/**
	 * 生成验证码
	 */
	public function get_verify()
	{
		Image::buildImageVerify('48', '22', null, Config::$system_name . '_admin_verify');
	}
	
	/**
	 * 检查验证码
	 */
	public function check_verify($code)
	{
		$verify = isset($_SESSION[Config::$system_name . '_admin_verify']) ? $_SESSION[Config::$system_name . '_admin_verify'] : '';
		unset($_SESSION[Config::$system_name . '_admin_verify']);
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
	public static $debug_enabled = false;//调试开关
	public static $system_name = 'transsion_weixin';//系统名称
	public static $key = '13232,g[][3.ba.f,c..fa3[]23a34';//密钥
	public static $base_url = 'http://www.geyaa.com/transsion_weixin/';//当前网址，线上或本地
	public static $dir_backup = 'extends/db_backup/';//数据库备份目录
	public static $dir_recover = 'extends/db_recover/';//数据库恢复目录
	public static $dir_log = 'extends/log/';//日志目录
	public static $dir_uploads = 'extends/uploads/';//上传目录
	public static $dir_cache = 'extends/cache/';//缓存主目录
	public static $install_lock = 'extends/lock/install.php';//数据库安装锁定文件
	public static $view_check = '<?php if(!defined(\'VIEW\')) exit(\'Request Error!\'); ?>';//VIEW入口检测代码
	
	public static $max_prize = 10;//最大奖品数
	public static $prize_name = array('88元', '18元', '8元', '', '', '', '', '', '', '');//奖品名称
	public static $prize_money = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	
	public static $wx_appid = 'wxc4c3e3d41130ff68';
	public static $wx_appsecret = '2bac8f0460f6ee411a404f565675649c';
	
	public static $tb_admin = 'transsion_weixin_admin';//管理员表
	public static $tb_user = 'transsion_weixin_user';//会员表
	public static $tb_jiang_chi = 'transsion_weixin_jiang_chi';//奖池表
	public static $tb_zhong_jiang = 'transsion_weixin_zhong_jiang';//中奖表
	public static $tb_lucky_daily = 'transsion_weixin_lucky_daily';//每日抽奖表
	
	public static $tb_hb_jiang_chi = 'transsion_weixin_hb_jiang_chi';//红包奖池表
	public static $tb_hb_zhong_jiang = 'transsion_weixin_hb_zhong_jiang';//红包中奖表
	public static $tb_hb_lucky_daily = 'transsion_weixin_hb_lucky_daily';//红包每日记录表
	public static $tb_hb_bind_user = 'transsion_weixin_hb_bind_user';//红包绑定工号表
	public static $tb_hb_base_user = 'transsion_weixin_hb_base_user';//红包工号库，绑定工号时从工号库判断工号数据是否正确
	
	public static $db_config = null;//数据库配置信息，线上或本地
	
	//线上数据库配置信息
	private static $db_online = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'db_name' => '',//数据库名
		'db_driver' => '',//数据库驱动
		'db_charset' => '',//数据库字符集
		'db_collat' => '',
		'db_pconnect' => false//是否永久连接
	);
	
	//本地数据库配置信息
	private static $db_local = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'db_name' => '',//数据库名 geyaa
		'db_driver' => '',//数据库驱动
		'db_charset' => '',//数据库字符集
		'db_collat' => '',
		'db_pconnect' => false//是否永久连接
	);
	
	/**
	 * 初始化状态
	 */
	public static function init()
	{
		//记录执行程序的当前时间，配置log文件位置
		//限制视图文件须由控制器调用才可执行
		Debug::$src_time = microtime(true);
		Debug::$log_file = self::$dir_log . Utils::mdate('Y-m-d') . '.php';
		define('VIEW', true);
		define('TOKEN', 'feijcljsoihr');
		
		//设置中国时区，开启session
		if (self::$debug_enabled)
		{
			@error_reporting(E_ALL);
			self::$db_config = self::$db_local;
		}
		else
		{
			@error_reporting(0);
			self::$db_config = self::$db_online;
		}
		@date_default_timezone_set('PRC');
		@session_start();
	}
}

/**
 *	抢红包
 */
class HongBao
{
	private $db = null;//数据库
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
	}
	
	/**
	 * 抽奖
	 */
	public function lucky($jobnum, $username, $department, $openid)
	{
		$this->db->connect();
		$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_hb_jiang_chi WHERE prize_date=$sql_date");
		$res = $this->db->get_row();
		$new_prize = 0;
		
		$max_prize = $this->get_max_prize($jobnum);
		$new_prize = $max_prize;
		
		if (!empty($res))
		{
			//根据设定的概率判断是否中奖
			$rand = rand(1, 100);
			if ($rand <= (int)$res['rate'])
			{
				//组合奖品id
				$prize_arr = array_merge(
					$this->join_prize(1, $res['prize1']),
					$this->join_prize(2, $res['prize2']),
					$this->join_prize(3, $res['prize3']),
					$this->join_prize(4, $res['prize4']),
					$this->join_prize(5, $res['prize5']),
					$this->join_prize(6, $res['prize6']),
					$this->join_prize(7, $res['prize7']),
					$this->join_prize(8, $res['prize8']),
					$this->join_prize(9, $res['prize9']),
					$this->join_prize(10, $res['prize10'])
				);
				
				//判断当天奖池中是否还有奖品
				$prize_arr_count = count($prize_arr);
				if ($prize_arr_count > 0)
				{
					$prize_index = rand(0, $prize_arr_count - 1);
					$prize_id = $prize_arr[$prize_index];
					
					if (0 == $max_prize)
					{
						//减少奖池中对应的奖品，保存中奖数据
						$this->reduce_jiang_chi($res['id'], $prize_id);
						$this->save_lucky($jobnum, $username, $department, $openid, $prize_id);
						$new_prize = $prize_id;
						$this->set_lucky_today($jobnum, Config::$prize_money[$prize_id - 1]);
						
						return Config::$prize_money[$prize_id - 1];
					}
					else
					{
						if ($prize_id < $max_prize)
						{
							$this->reduce_jiang_chi($res['id'], $prize_id);
							$this->add_jiang_chi($res['id'], $max_prize);
							$this->change_lucky($jobnum, $prize_id);
							$new_prize = $prize_id;
							$this->set_lucky_today($jobnum, Config::$prize_money[$prize_id - 1]);
							
							return Config::$prize_money[$prize_id - 1];
						}
					}
				}
			}
		}
		
		if (0 == $new_prize)
		{
			$this->set_lucky_today($jobnum, 0);
			return 0;
		}
		else
		{
			$money = Config::$prize_money[$new_prize - 1];
			$low_money = rand(0, $money);
			$this->set_lucky_today($jobnum, $low_money);
			return $low_money;
		}
	}
	
	/**
	 * 记录今天抽过奖
	 */
	private function set_lucky_today($jobnum, $money)
	{
		$this->db->connect();
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$sql_jobnum = Security::var_sql($jobnum);
		$sql_money = (int)$money;
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
		$this->db->query("insert into $tb_hb_lucky_daily (jobnum, money, lucky_time, click_flag) values ($sql_jobnum, $sql_money, $sql_date, 0)");
	}
	
	// ok
	/**
	 * 组合奖品
	 */
	private function join_prize($prize, $num)
	{
		$res = array();
		for ($i = 0; $i < $num; $i++)
		{
			$res[] = $prize;
		}
		
		return $res;
	}
	
	// ok
	/**
	 * 减少奖池里指定的奖品数量
	 */
	private function reduce_jiang_chi($jiang_chi_id, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
			$sql_id = (int)$jiang_chi_id;
			$field_name = 'prize' . $prize_id;
			$this->db->query("UPDATE $tb_hb_jiang_chi SET $field_name=$field_name-1 WHERE id=$sql_id");
		}
	}
	
	// ok
	/**
	 * 增加奖池里指定的奖品数量
	 */
	private function add_jiang_chi($jiang_chi_id, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
			$sql_id = (int)$jiang_chi_id;
			$field_name = 'prize' . $prize_id;
			$this->db->query("UPDATE $tb_hb_jiang_chi SET $field_name=$field_name+1 WHERE id=$sql_id");
		}
	}
	
	private function get_max_prize($jobnum)
	{
		$this->db->connect();
		$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
		$sql_jobnum = Security::var_sql($jobnum);
		$this->db->query("select * from $tb_hb_zhong_jiang where jobnum=$sql_jobnum");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return $res['prizeid'];
		}
		else
		{
			return 0;
		}
	}
	
	public function get_max_money($jobnum)
	{
		$this->db->connect();
		$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
		$sql_jobnum = Security::var_sql($jobnum);
		$this->db->query("select * from $tb_hb_zhong_jiang where jobnum=$sql_jobnum");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			if ($res['prizeid'] >= 1 && $res['prizeid'] <= Config::$max_prize)
			{
				return Config::$prize_money[$res['prizeid'] - 1];
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 保存中奖数据
	 */
	private function save_lucky($jobnum, $username, $department, $openid, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
			$sql_jobnum = Security::var_sql($jobnum);
			$sql_username = Security::var_sql($username);
			$sql_department = Security::var_sql($department);
			$sql_openid = Security::var_sql($openid);
			$sql_prize_id = (int)$prize_id;
			$sql_prize_name = Security::var_sql(Config::$prize_name[$prize_id - 1]);
			$sql_time = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
			$this->db->query("INSERT INTO $tb_hb_zhong_jiang (jobnum, username, department, openid, prizeid, prizename, lucky_time) VALUES ($sql_jobnum, $sql_username, $sql_department, $sql_openid, $sql_prize_id, $sql_prize_name, $sql_time)");
		}
	}
	
	/**
	 * 修改中奖数据
	 */
	private function change_lucky($jobnum, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
			$sql_jobnum = Security::var_sql($jobnum);
			$sql_prize_id = (int)$prize_id;
			$sql_prize_name = Security::var_sql(Config::$prize_name[$prize_id - 1]);
			$sql_time = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
			$this->db->query("update $tb_hb_zhong_jiang set prizeid=$sql_prize_id, prizename=$sql_prize_name, lucky_time=$sql_time where jobnum=$sql_jobnum");
		}
	}
	
	// ok
	public function set_pan_click($jobnum)
	{
		$this->db->connect();
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$sql_jobnum = Security::var_sql($jobnum);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("update $tb_hb_lucky_daily set click_flag=1 WHERE jobnum=$sql_jobnum AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
	}
	
	// ok
	public function get_bind_user_info($openid)
	{
		$this->db->connect();
		$sql_openid = Security::var_sql($openid);
		$tb_hb_bind_user = Config::$tb_hb_bind_user;
		$this->db->query("select * from $tb_hb_bind_user where openid=$sql_openid");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return array('jobnum' => $res['jobnum'], 'username' => $res['username'], 'department' => $res['department']);
		}
		else
		{
			return null;
		}
	}
	
	// ok
	public function get_base_user_info($jobnum)
	{
		$this->db->connect();
		$sql_jobnum = Security::var_sql($jobnum);
		$tb_hb_base_user = Config::$tb_hb_base_user;
		$this->db->query("select * from $tb_hb_base_user where jobnum=$sql_jobnum");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return array('jobnum' => $res['jobnum'], 'username' => $res['username'], 'department' => $res['department']);
		}
		else
		{
			return null;
		}
	}
	
	// ok
	public function check_bind_jobnum($jobnum)
	{
		$this->db->connect();
		$sql_jobnum = Security::var_sql($jobnum);
		$tb_hb_bind_user = Config::$tb_hb_bind_user;
		$this->db->query("select * from $tb_hb_bind_user where jobnum=$sql_jobnum");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// ok
	public function check_bind_openid($openid)
	{
		$this->db->connect();
		$sql_openid = Security::var_sql($openid);
		$tb_hb_bind_user = Config::$tb_hb_bind_user;
		$this->db->query("select * from $tb_hb_bind_user where openid=$sql_openid");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// ok
	public function bind_jobnum($jobnum, $username, $department, $openid)
	{
		$this->db->connect();
		$sql_jobnum = Security::var_sql($jobnum);
		$sql_username = Security::var_sql($username);
		$sql_department = Security::var_sql($department);
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
		$tb_hb_bind_user = Config::$tb_hb_bind_user;
		$this->db->query("insert into $tb_hb_bind_user (jobnum, username, department, openid, register_time) values ($sql_jobnum, $sql_username, $sql_department, $sql_openid, $sql_date)");
	}
	
	// ok
	/**
	 * 获取今天的抽奖数据
	 */
	public function get_lucky_today($jobnum)
	{
		$this->db->connect();
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$sql_jobnum = Security::var_sql($jobnum);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_hb_lucky_daily WHERE jobnum=$sql_jobnum AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return array('is_lucky' => true, 'click_flag' => $res['click_flag'], 'money' => $res['money']);
		}
		else
		{
			return array('is_lucky' => false, 'click_flag' => 0, 'money' => 0);
		}
	}
	
	public function get_records($jobnum)
	{
		$this->db->connect();
		$sql_jobnum = Security::var_sql($jobnum);
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$this->db->query("SELECT * FROM $tb_hb_lucky_daily where jobnum=$sql_jobnum order by id");
		$res = $this->db->get_all_rows();
		$records = array('d1' => -1, 'd2' => -1, 'd3' => -1, 'd4' => -1, 'd5' => -1, 'd6' => -1);
		
		if (!empty($res))
		{
			foreach ($res as $row)
			{
				$date = Utils::mdate('Y-m-d', $row['lucky_time']);
				switch ($date)
				{
					case '2015-02-03':
						$records['d1'] = $row['money'];
						break;
					case '2015-02-04':
						$records['d2'] = $row['money'];
						break;
					case '2015-02-05':
						$records['d3'] = $row['money'];
						break;
					case '2015-02-06':
						$records['d4'] = $row['money'];
						break;
					case '2015-02-07':
						$records['d5'] = $row['money'];
						break;
					case '2015-02-08':
						$records['d6'] = $row['money'];
						break;
					default:
				}
			}
		}
		
		return $records;
	}
	
	public function get_daily()
	{
		$this->db->connect();
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$this->db->query("SELECT * FROM $tb_hb_lucky_daily order by id");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	public function get_zhong_jiang()
	{
		$this->db->connect();
		$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
		$this->db->query("SELECT * FROM $tb_hb_zhong_jiang order by department, prizeid desc");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
}

/**
 * 安装系统
 */
class Install
{
	private $db = null;//数据库
	private $db_name = '';//数据库名
	private $db_charset = '';//数据库字符集
	private $db_collat = '';
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->db_name = Config::$db_config['db_name'];
		$this->db_charset = Config::$db_config['db_charset'];
		$this->db_collat = Config::$db_config['db_collat'];
	}
	
	/**
	 * 创建数据库
	 */
	public function create_database()
	{
		$this->db->connect();
		$this->db->query("CREATE DATABASE IF NOT EXISTS $this->db_name DEFAULT CHARACTER SET $this->db_charset COLLATE $this->db_collat");
	}
	
	/**
	 * 安装系统
	 */
	public function install()
	{
		$this->create_table();
		$this->insert();
	}
	
	/**
	 * 创建表
	 */
	private function create_table()
	{
		$this->db->connect();
		$tb_admin = Config::$tb_admin;
		$tb_user = Config::$tb_user;
		$tb_jiang_chi = Config::$tb_jiang_chi;
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$tb_lucky_daily = Config::$tb_lucky_daily;
		
		$this->db->query("DROP TABLE IF EXISTS $tb_admin");
		$this->db->query("CREATE TABLE $tb_admin (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			username VARCHAR( 50 ) NOT NULL ,
			password VARCHAR( 200 ) NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_user");
		$this->db->query("CREATE TABLE $tb_user (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			username VARCHAR( 50 ) NOT NULL ,
			password VARCHAR( 200 ) NOT NULL ,
			phone VARCHAR( 50 ) NOT NULL ,
			register_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_jiang_chi");
		$this->db->query("CREATE TABLE $tb_jiang_chi (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			prize_date DATE NOT NULL ,
			rate INT NOT NULL ,
			prize1 INT NOT NULL ,
			prize2 INT NOT NULL ,
			prize3 INT NOT NULL ,
			prize4 INT NOT NULL ,
			prize5 INT NOT NULL ,
			prize6 INT NOT NULL ,
			prize7 INT NOT NULL ,
			prize8 INT NOT NULL ,
			prize9 INT NOT NULL ,
			prize10 INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_zhong_jiang");
		$this->db->query("CREATE TABLE $tb_zhong_jiang (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			openid VARCHAR( 50 ) NOT NULL ,
			department VARCHAR( 50 ) NOT NULL ,
			username VARCHAR( 50 ) NOT NULL ,
			prizeid INT NOT NULL ,
			prizename VARCHAR( 50 ) NOT NULL ,
			lucky_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_lucky_daily");
		$this->db->query("CREATE TABLE $tb_lucky_daily (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			openid VARCHAR( 50 ) NOT NULL ,
			lucky_time DATETIME NOT NULL ,
			pan_flag INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		$this->db->connect();
		$tb_admin = Config::$tb_admin;
		$password = 'hjiccaabifhfdca71803f25aee0cd220c273baf0c0d70chcaiafajcgbfeeiccd';
		$this->db->query("INSERT INTO $tb_admin (username, password) VALUES ('admin', '$password')");
	}
	
	/**
	 * 获取所有的表名
	 */
	public function get_all_tables()
	{
		$this->db->connect();
		return $this->db->get_all_tables();
	}
	
	/**
	 * 获取指定表的所有字段名
	 */
	public function get_all_fields($tb_name)
	{
		$this->db->connect();
		return $this->db->get_all_fields($tb_name);
	}
	
	/**
	 * 获取指定表的所有记录
	 */
	public function get_records($tb_name, $start = 0, $record_count = 10)
	{
		$this->db->connect();
		$res = array();
		$res_index = 0;
		$sql_start = (int)$start;
		$sql_record_count = (int)$record_count;
		$this->db->query("SELECT * FROM $tb_name LIMIT $sql_start, $sql_record_count");
		while ($row = $this->db->get_row(MYSQL_NUM))
		{
			$fields_count = count($row);
			for ($i = 0; $i < $fields_count; $i++)
			{
				$res[$res_index][$i] = htmlspecialchars($row[$i], ENT_QUOTES);
			}
			$res_index++;
		}
		
		return $res;
	}
	
	/**
	 * 备份数据库
	 */
	public function backup()
	{
		$path = Config::$dir_backup . Utils::mdate('Y-m-d') . '/';
		Utils::create_dir($path);
		$db = new Dbbak(Config::$db_config['hostname'], Config::$db_config['username'], Config::$db_config['password'], Config::$db_config['db_name'], Config::$db_config['db_charset'], $path);
		$tableArray = $db->getTables();
		$db->exportSql($tableArray);
	}
	
	/**
	 * 恢复数据库
	 */
	public function recover()
	{
		$db = new Dbbak(Config::$db_config['hostname'], Config::$db_config['username'], Config::$db_config['password'], Config::$db_config['db_name'], Config::$db_config['db_charset'], Config::$dir_recover);
		$db->importSql();
	}
	
	/**
	 * 升级系统
	 */
	public function sum_prize()
	{
		$this->db->connect();
		$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
		$this->db->query("select sum(prize1), sum(prize2), sum(prize3), sum(prize4), sum(prize5), sum(prize6) from $tb_hb_jiang_chi");
		$res = $this->db->get_row();
		print_r($res);
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		$this->db->connect();
		
		$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
		$this->db->query("update $tb_hb_zhong_jiang set openid='oSS56s4XHfcWo94svaTNdNMiZVR0' where id=243");
		
		//$tb_hb_bind_user = Config::$tb_hb_bind_user;
		//$this->db->query("update $tb_hb_bind_user set openid='oSS56s4XHfcWo94svaTNdNMiZVR0' where id=630");
		
		/*
		$tb_hb_base_user = Config::$tb_hb_base_user;
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01244', '占志诚', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01245', '黄齐欢', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01246', '刘国利', '产品规划部')");
		*/
		
		//$tb_hb_base_user = Config::$tb_hb_base_user;
		//$this->db->query("update $tb_hb_base_user set jobnum='A01121' where id=991");
		
		//$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		//$this->db->query("delete from $tb_hb_lucky_daily where id=392");
		
		//$tb_hb_bind_user = Config::$tb_hb_bind_user;
		//$this->db->query("delete from $tb_hb_bind_user where jobnum='01173'");
		
		/*
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$this->db->query("update $tb_zhong_jiang set department='商务物流部', username='唐丹丹' where id=145");
		*/
		
		/*
		$tb_jiang_chi = Config::$tb_jiang_chi;
		$this->db->query("update $tb_jiang_chi set prize4=4, prize5=8, prize6=57 where prize_date='2015-1-17'");
		*/
		
		/*
		$tb_jiang_chi = Config::$tb_jiang_chi;
		$this->db->query("update $tb_jiang_chi set rate=15, prize3=1, prize4=4, prize5=6, prize6=33 where prize_date='2015-1-10'");
		$this->db->query("update $tb_jiang_chi set rate=40, prize4=4, prize5=6, prize6=32 where prize_date='2015-1-11'");
		$this->db->query("update $tb_jiang_chi set rate=20, prize4=5, prize5=6, prize6=32 where prize_date='2015-1-12'");
		$this->db->query("update $tb_jiang_chi set rate=30, prize4=4, prize5=7, prize6=32 where prize_date='2015-1-13'");
		$this->db->query("update $tb_jiang_chi set rate=40, prize4=5, prize5=6, prize6=32 where prize_date='2015-1-14'");
		$this->db->query("update $tb_jiang_chi set rate=50, prize4=4, prize5=7, prize6=32 where prize_date='2015-1-15'");
		$this->db->query("update $tb_jiang_chi set rate=60, prize4=4, prize5=7, prize6=32 where prize_date='2015-1-16'");
		$this->db->query("update $tb_jiang_chi set rate=100, prize4=4, prize5=6, prize6=32 where prize_date='2015-1-17'");
		*/
	}
	
	public function init_prize()
	{
		$this->db->connect();
		$tb_jiang_chi = Config::$tb_jiang_chi;
		$this->db->query("delete from $tb_jiang_chi");
		
		//Infinix平板2个，TECNO Phantom Z 2个，itel手机2个，蓝牙耳机26个，充电宝39个，彩票195张
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-5', '20', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-6', '20', '1', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-7', '30', '0', '1', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-8', '40', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-9', '50', '0', '0', '1', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-10', '50', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-11', '100', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-12', '60', '1', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-13', '60', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-14', '70', '0', '1', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-15', '80', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-16', '90', '0', '0', '1', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-17', '100', '0', '0', '0', '2', '3', '15')");
	}
	
	public function install_hong_bao()
	{
		$this->create_hb_table();
		$this->init_hb_base_user();
		$this->init_hb_jiang_chi();
	}
	
	/**
	 * 创建红包表
	 */
	private function create_hb_table()
	{
		$this->db->connect();
		$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
		$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$tb_hb_bind_user = Config::$tb_hb_bind_user;
		$tb_hb_base_user = Config::$tb_hb_base_user;
		
		$this->db->query("DROP TABLE IF EXISTS $tb_hb_jiang_chi");
		$this->db->query("CREATE TABLE $tb_hb_jiang_chi (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			prize_date DATE NOT NULL ,
			rate INT NOT NULL ,
			prize1 INT NOT NULL ,
			prize2 INT NOT NULL ,
			prize3 INT NOT NULL ,
			prize4 INT NOT NULL ,
			prize5 INT NOT NULL ,
			prize6 INT NOT NULL ,
			prize7 INT NOT NULL ,
			prize8 INT NOT NULL ,
			prize9 INT NOT NULL ,
			prize10 INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_hb_zhong_jiang");
		$this->db->query("CREATE TABLE $tb_hb_zhong_jiang (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			jobnum VARCHAR( 10 ) NOT NULL ,
			username VARCHAR( 50 ) NOT NULL ,
			department VARCHAR( 50 ) NOT NULL ,
			openid VARCHAR( 50 ) NOT NULL ,
			prizeid INT NOT NULL ,
			prizename VARCHAR( 50 ) NOT NULL ,
			lucky_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_hb_lucky_daily");
		$this->db->query("CREATE TABLE $tb_hb_lucky_daily (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			jobnum VARCHAR( 10 ) NOT NULL ,
			money INT NOT NULL ,
			lucky_time DATETIME NOT NULL ,
			click_flag INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_hb_bind_user");
		$this->db->query("CREATE TABLE $tb_hb_bind_user (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			jobnum VARCHAR( 10 ) NOT NULL ,
			username VARCHAR( 50 ) NOT NULL ,
			department VARCHAR( 50 ) NOT NULL ,
			openid VARCHAR( 50 ) NOT NULL ,
			register_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_hb_base_user");
		$this->db->query("CREATE TABLE $tb_hb_base_user (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			jobnum VARCHAR( 10 ) NOT NULL ,
			username VARCHAR( 50 ) NOT NULL ,
			department VARCHAR( 50 ) NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
	}
	
	private function init_hb_base_user()
	{
		$this->db->connect();
		$tb_hb_base_user = Config::$tb_hb_base_user;
		
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60442', '赵军辉', '软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60443', '彭建森', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60444', '詹海波', 'ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60445', '李韩', '软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60446', '王轶超', '软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60447', '柳佰华', '硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60448', '马帅', '结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60449', '沈丽君', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60450', '董坤伟', 'ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60451', '洪亚婷', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60452', '杨婉岑', '人事行政部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80159', '眭志伟', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80161', '杨玲', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80162', '林闽琦', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80163', '雷志强', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00001', '竺兆江', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00002', '张祺', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00004', '叶伟强', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00005', '胡盛龙', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00006', '严孟', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00007', '秦霖', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00008', '胡飞侠', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00009', 'Shyamol', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00010', '王翀', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00013', '欧阳葵', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00017', '胡蒋科', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00018', '刘井泉', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00022', '邓翔', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00023', '代芳', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00025', '邓国彬', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00026', '邱能凯', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00027', '谭波', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00028', '涂才荣', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00029', '周劲', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00031', '苏磊', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00032', '梁卉卉', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00038', '何建波', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00041', '黄健', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00042', '郭磊', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00043', '何紫辉', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00044', '雷伟国', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00053', '韩靖羽', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00060', '姜柏宇', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00064', '夏春雷', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00065', '胡伟平', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00066', '刘仰宏', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00068', '张建', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00069', '龚金银', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00070', '戴娥英', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00075', '姚海珍', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00079', '阿里夫', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00080', '周宗政', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00082', '王齐', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00086', '俞卫国', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00087', '王成军', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00088', '刘俊杰', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00099', '刘红玲', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00111', '宋英男', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00115', '岳翠忠', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00116', '鲁荣豪', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00120', '陈方', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00129', '申瑞刚', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00131', '王海滨', '上海研发中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00132', '潘志浪', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00134', '杨晨', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00135', '许昭', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00136', '黄永源', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00141', '金卫星', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00148', '吴连军', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00150', '张艳', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00151', '崔文君', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00153', '李平', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00154', '代书燕', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00155', '余玟龙', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00156', '郭必亮', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00157', '宁建梅', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00163', '乐苏华', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00165', 'MOHAMMAD MAHFUZUL HUQ', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00168', '蔡海山', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00169', '彭利平', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00171', '代祥', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00173', '卢文科', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00176', '兰云贵', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00179', '刘宏', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00186', '欧阳振瑞', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00195', '董丹萍', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00198', '涂才福', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00200', '高斌斌', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00201', '田孟芬', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00202', '黎广胜', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00203', '王振宇', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00207', '陈燕芬', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00208', '郑显彪', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00210', '王志杰', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00228', '李戈', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00229', '刘凯', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00238', '乔世英', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00240', '吴文', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00241', '黄石娟', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00244', '严翠娥', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00251', '唐波', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00252', '闵晓兰', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00254', '史静', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00259', '方芳', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00262', '金燕', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00269', '杨宏', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00274', '吴海霞', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00280', '邹亮', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00286', '张金花', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00289', '孙英超', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00290', '张甄楠', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00293', '李静', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00295', '石伟', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00296', '王先波', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00300', '吴胜祖', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00303', '段盛晓', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00305', '卢惠端', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00306', '党进', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00307', '陈双双', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00310', '焦永刚', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00311', '周晓玲', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00313', '谢乐斌', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00314', '谭将', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00322', '冯世君', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00323', '黄宏辉', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00324', '蔡孙荣', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00328', '邓可爽', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00342', '丁鼎', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00345', '肖辉', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00347', '李庆春', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00355', '张义', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00357', '郭耕耘', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00359', '陈慧子', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00369', '王槐碧', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00373', '李俭彬', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00377', '董海忠', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00379', '汪鹏', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00381', '张群', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00382', '古裕彬', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00386', '伍玲华', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00387', '贺晓秋', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00391', '王辉', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00393', '段涵琳', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00396', '张继海', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00397', '孟志赟', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00399', '陶威', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00405', '李明', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00407', '石文彬', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00419', '孙良锋', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00420', '赵仰强', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00422', '伍亮', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00427', '黄宇航', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00433', '黄仕帅', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00436', '曹跃峰', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00437', '易发云', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00439', '艾余胜', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00440', '吴松', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00447', '赵文良', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00451', '余勇', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00453', '赵航', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00455', '姜曙明', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00460', '左涛', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00461', '黎镇', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00463', '劳明强', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00464', '李景哲', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00468', '柯尊焱', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00469', '鲁守彬', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00477', '骆伊婷', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00480', '王旭芬', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00489', '周金宝', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00491', '肖红', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00492', '曾忠', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00493', '王小强', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00498', '陈东东', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00499', '倪凯', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00501', '宋玮', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00502', '谭春玲', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00503', '徐烨', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00504', '刘洋', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00508', '刘杰', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00509', '唐丹丹', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00510', '李小琳', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00512', '陈文臻', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00513', '鲁岚', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00514', '陈梓博', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00517', '吴赛', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00518', '肖志高', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00519', '王小龙', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00520', '陈艳霞', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00521', '周然鸣', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00522', '陆海雷', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00526', '张旭东', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00527', '黄东', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00529', '唐俊飞', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00530', '张文斌', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00531', '朱文卿', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00532', '张操', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00534', '袁丽清', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00535', '魏世兵', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00537', '张亚智', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00540', '何秀水', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00541', '廖浏平', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00543', '张欣', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00549', '王功泽', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00553', '寇士洋', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00554', '陈廷波', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00556', '李魁', '上海研发中心-INFINIX项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00557', '鲍彬彬', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00558', '刘小龙', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00560', '闵丽', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00561', '林宏强', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00562', '李春鹏', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00564', '陈钦明', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00566', '代元元', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00567', '彭继圭', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00569', '朱苗', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00571', '陈伏秀', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00573', '王静', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00575', '钟劲松', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00577', '刘会', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00582', '宋慈', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00583', '蒋小龙', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00584', '蔡茂', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00586', '吴国成', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00587', '莫艳勇', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00589', '刘林峻', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00590', '袁雪梅', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00592', '黄明松', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00594', '周鑫', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00595', '李玥', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00597', '何艳', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00598', '郭京京', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00600', '周炎福', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00602', '赵贤凯', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00604', 'Boukali Mounir', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00605', '赵震', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00606', 'Jean Sébastien COSTE', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00607', '陈肖肖', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00609', '齐战', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00610', '索超', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00611', '胡志勇', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00614', '黄彬', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00615', '徐淑珍', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00616', '管银银', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00618', '李彧', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00621', '符良宏', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00622', '张丽丽', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00624', '李灿生', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00626', '齐子铭', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00628', '唐宇鑫', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00631', '涂颢', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00632', '陈周涛', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00634', '肖永辉', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00639', '熊红涛', '上海研发中心-INFINIX项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00644', '项俊', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00650', '叶淑婷', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00652', '易恺', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00653', '陈娇', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00654', '刘治江', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00657', '冯士严', '上海研发中心-INFINIX项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00658', '雷程', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00659', '罗祖雄', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00660', '陈雨', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00662', '吕小丽', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00663', '谌思明', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00664', '肖培彪', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00665', '张仁员', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00669', '郭辉奇', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00670', '张聂', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00672', '黄友军', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00673', '胡黎', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00674', '徐斌', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00679', '吴一鸣', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00682', '王璐', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00687', '李华新', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00689', '晏鹏', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00691', '唐晓梅', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00693', '方羿', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00695', '陆翠洪', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00697', '孟凡', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00699', '李毅斌', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00700', '高亮', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00701', '周剑', '上海研发中心-INFINIX项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00702', '陈伟园', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00705', '杨道庄', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00707', '闫书红', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00708', '陈安东', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00709', '李景全', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00713', '陈慧珠', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00714', '王芳', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00715', '项赟', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00717', '李江涛', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00721', '贺利霞', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00722', '孟春东', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00723', '杨双赫', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00725', '王春生', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00727', '胡娟娟', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00728', '刘波', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00730', '关铮杰', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00731', '刘颖', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00732', '徐仁誉', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00734', '李山飞', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00736', '李广友', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00737', '李小霞', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00740', '彭星', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00741', '陈琼', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00743', '杨文龙', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00744', 'Arnaud LEFEBVRE', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00745', '张德星', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00746', '夏钊', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00747', '罗龙', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00748', '巫震宇', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00749', '柯阳', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00751', '吴少波', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00754', '李丹平', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00756', '叶镇和', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00757', '郑诗慧', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00758', '陈浩', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00759', '李秀云', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00760', '蒋佳星', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00761', '徐敏', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00764', '蔡永', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00772', '卫桂芬', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00774', '孟娟', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00776', '黄露莎', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00777', '郭立乾', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00778', '范小娟', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00781', '官爱民', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00782', '马龙', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00783', '马晓川', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00784', '龚晓伟', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00785', '张文皓', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00787', '杨帆', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00789', '胡海瑞', '投资法务部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00790', '曹振华', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00792', '陈方华', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00794', '汪虎', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00798', 'Md. Monirul Islam', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00800', 'Chidi Okonkwo', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00801', 'Joseph magloire SOFFACK -SONNA ', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00802', 'Gloria maria Anampiu', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00804', 'Ireshad Ahmed ', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00805', 'ziaur Rahman', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00806', '何自如', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00807', 'THIAM PAPA MEDOUNE', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00808', 'Talha Masharka', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00809', '李传堃', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00810', '胡伟欣', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00811', '张峰', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00812', '庄恒', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00814', '李海玉', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00815', '刘晶晶', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00816', '潘胜荣', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00818', '周静', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00819', 'NAYYAR HUSSAIN ', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00820', '胡军', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00822', '欧伟哲', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00823', '王晓明', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00825', '廖菊芳', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00827', '余雷', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00829', '刘明', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00832', '马骄', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00834', '竺家豪', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00835', '江雅琴', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00836', '王柯', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00840', '田长军', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00841', '马佐刚', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00843', '谭洁', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00845', '向东', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00846', '张喜鹏', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00847', '吕明武', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00848', '张桂秀', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00849', '刘钦', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00850', '刘若天', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00851', '邹剑锋', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00853', '冯运通', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00854', '刘团', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00855', '周茂盛', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00856', '刘根平', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00857', '梁晰瑶', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00858', '邓慧', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00859', '辛未', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00866', '叶媛媛', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00867', '高威', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00868', '曾峰晴', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00869', '冯振洲', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00870', '罗湘陵', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00871', '马秋平', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00872', '姚长征', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00873', '洪丹玲', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00875', '莫斯淇', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00876', '蔡欣城', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00877', '陈云', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00881', '叶婷', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00883', '杜恒', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00884', '徐航', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00885', '黄凌宾', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00887', '王渊博', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00889', '王利', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00891', '张艳', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00893', '左国强', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00898', '李旭啸', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00900', '方冰冰', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00901', '唐善兵', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00902', '魏瑞', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00903', '娄博', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00904', '熊爽', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00905', '黄世平', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00906', '刘天明', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00909', '吴昊', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00914', '姜楠', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00915', '张玉磊', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00916', '徐幼芳', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00917', '李霞', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00918', '周鸿武', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00922', '陈洋', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00923', '王青', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00924', '刘伟奇', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00925', '陈元海', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00926', '谭科', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00929', '阳娜', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00932', '张婧', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00934', '刘辉', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00935', '周勇', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00936', '徐显斌', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00937', '李婉婷', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00938', '江民烽', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00939', '黄强国', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00940', '张家威', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00941', '韩冬', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00942', '周蕾', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00944', '田旭生', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00945', '李文静', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00948', '潘小英', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00950', '张颖', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00951', '周瑾', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00952', '胡继伟', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00953', '吴青', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00954', '周红芳', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00957', '叶海波', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00958', '郭雪妮', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00960', '李智', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00961', '李超', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00962', '何巍', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00963', '南彬', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00964', '朱宇轩', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00969', '邓介刚', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00970', '廖京林', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00971', '肖文', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00972', '许山油', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00973', '张炳春', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00974', '孙媛媛', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00975', '陈密', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00976', '张漫', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00977', '林泽湘', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00978', '蔡思敏', '投资法务部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00979', '魏海龙', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00980', '周也', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00982', '唐慰', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00986', '洪东阳', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00987', '王礼安', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00988', '王正文', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00989', '刘建生', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00991', '覃纳', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00992', '杨琳莉', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00993', '谢先锐', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00994', '郑善华', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00995', '胡开辉', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00998', '望艳芳', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00999', '杨参军', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01000', '谢关明', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01001', '徐晓玲', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01002', '徐中一', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01004', '王勋', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01005', '袁鹏', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01008', '曲文', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01009', '程刚', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01010', '郁万萍', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01012', '沈卓敏', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01014', 'Camille Louis Leon', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01015', '汪静', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01016', '盘浩', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01018', '赵向蓝', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01019', '李汶昭', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01020', '肖国庆', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01022', '沈燕', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01023', '杜灿', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01024', '马殿元', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01025', '马永刚', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01027', '周瑾妤', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01029', '林汉斌', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01030', '舒辉', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01032', '蒋飞', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01035', '冼志彪', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01036', '吴琦', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01037', '徐华盛', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01038', '周惠娟', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01040', '左飞', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01041', '熊雪莹', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01042', '黄伟国', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01044', '吴长国', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01045', 'Kenome', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01046', '郝明雄', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01047', '曹豪磊', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01048', '徐超', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01050', '黄思乐', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01051', '曾续琴', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01054', '陈润东', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01056', '杨倩', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01057', '李扬', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01058', '余亚鹏', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01059', '陈婷婷', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01061', '彭珺', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01062', '黄维维', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01063', '付美云', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01064', '张敏', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01065', '李姣', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01066', '崔天福', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01068', '耿丽', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01069', '赵耀', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01070', '王军蓉', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01071', '蒋慧芳', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01072', '刘康', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01073', '刘光华', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01074', '廖小丽', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01075', '薛丽', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01076', '康燕', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01077', '张维', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01078', '楚聪', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01079', '金阳', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01081', '彭参', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01082', '刘正', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01085', '崔志鹏', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01086', '曹美女', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01087', '武韬', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01089', '招燕玲', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01090', '韦燕羽', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01092', '徐明明', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01093', '刘望可', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01095', '金鼎', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01096', '余永利', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01097', '苏弦贤', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01098', '陈海飞', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01099', '慕灵宇', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01100', '陈剑鸣', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01101', '朱丽璇', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01102', '朱巧林', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01103', 'Jean-alexis', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01104', '崔效升', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01105', '涂茂婷', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01107', '莫艳莹', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01108', '梁文雅', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01109', '徐峰', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01110', '钱停秋', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01111', 'joan waithera muiyuro', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01112', '黃奕龙', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01113', 'Adamou', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01114', '方锐城', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01115', '唐华', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01118', '毛艳', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01119', '郑渝', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01120', '曾立城', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01121', '任文', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01122', '李艳杰', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01123', '姚少飞', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01124', '曾乐兴', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01125', '杨柠铭', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01126', '翁振楠', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01127', '卢丽萍', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01128', '谢碧芳', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01129', '张文浩', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01130', '游起发', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01133', '马志成', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01136', '李巧飞', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01137', '潘殿好', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01138', '黄晓雪', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01139', '杨勇', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01140', '李泽喜', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01141', '刘鑫', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01142', '肖俊婷', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01143', '孙纪兰', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01144', '刘基福', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01145', '苟桂花', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01146', '蔡宇超', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01147', 'Nourhan Mahmoud', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01148', '鲁林海', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01149', '孙海知', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01150', '袁杰', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01152', '蒋庆华', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01153', '张野', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01154', '黄婉如', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01155', '涂齐鹏', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01156', '邹春芳', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01157', '罗刚', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01158', '陶红珍', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01165', '陈桂君', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01166', '何志', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01167', '周永成', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01168', '刘磊', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01169', '李坤', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01170', '吴志祥', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01172', '夏鹏', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01173', '邹振良', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01174', '周佳', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01175', '罗春迎', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01176', '丛曰娜', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01177', '陈博', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01178', '吴金妹', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01179', '黄善婷', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01181', '王满', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01182', '李贵品', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01183', '罗闪', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01184', '徐跃华', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01185', '黄婉婷', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01186', '冯程', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01187', '孔秀敏', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01188', '彭丽', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01189', '王欣', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01191', '胡伟杰', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01192', '朱洪君', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01193', '刘敏', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01195', '万正位', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01196', '柳思琦', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01198', '唐永甜', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01199', '刘凯', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01201', '肖春霞', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01202', '何三山', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01203', '胡珍', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01204', '郭迪理', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01205', '雷富金', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01206', '李春秀', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01207', '刘福宏', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01208', '李义', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01209', '莫细明', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01210', '林朝升', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01212', '蒲明海', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01213', '庞星星', 'itel事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01214', '周志晨', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01215', '邹凯', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01217', '蒲思安', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01218', '洪仲坤', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01219', '刘晨昱', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01220', '李双红', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01221', '赖让锦', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01222', '薛涵予', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01224', '林锦坤', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01225', '张镇群', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01226', '李小娇', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01227', '牛红威', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01228', '尹阳平', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01229', '陈瑾卿', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01230', '陈宇', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01231', '程红俊', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01232', '汪波', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01233', '陈辉', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01234', '汪盛希', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01235', '易晓菲', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01236', '伊丽', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01237', '梅勇彬', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01238', '朱观林', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01239', '刘仔勤', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01240', '曹珍珍', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01241', '王国材', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01242', '黄伟铭', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01243', '宋立洲', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('03778', '黄丰南', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('04716', '李青明', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('04909', '娄华云', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('05612', '朱雄', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('05743', '张超叶', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('06559', '宋小伟', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('07712', '李扬帆', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('09299', '杨双', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('12051', '喻培福', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60001', '肖明', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60002', '陆伟峰', '上海研发中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60003', '张永乐', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60004', '孟跃龙', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60006', '曹娟', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60007', '秦进', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60008', '张兰华', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60009', '姜飞', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60010', '吉晓伟', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60011', '汪丽', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60013', '王栋', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60015', '金凤麟', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60017', '武长坤', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60018', '李永贤', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60020', '朱勇', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60022', '聂维祺', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60023', '张维娟', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60027', '刘芳', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60033', '王忠明', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60036', '邱红', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60037', '王海军', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60040', '陈宇', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60041', '常义兵', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60045', '徐永涛', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60046', '黄宇杰', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60051', '熊辉', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60053', '刘彦忠', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60056', '李鸿', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60058', '占雄伟', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60064', '周飞', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60065', '任新泉', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60071', '林湘琦', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60072', '周凡贻', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60075', '张合乾', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60077', '李杨', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60085', '曾海荣', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60086', '崔娜娜', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60090', '刘豪杰', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60095', '赵帛羽', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60096', '李凯', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60099', '崔晓玲', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60100', '任帅帅', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60105', '韦灵春', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60108', '陈睿', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60109', '亓凯旋', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60118', '彭少朋', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60119', '罗方丽', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60121', '叶彩梨', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60130', '胡家旋', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60131', '周灿', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60134', '张德祥', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60144', '夏相声', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60145', '夏霄月', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60146', '董军', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60147', '龚岐', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60150', '赵江伟', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60151', '张涛', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60155', '张颖瑞', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60157', '陈敏', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60161', '丁瑜', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60163', '张蕊', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60170', '林广', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60171', '徐秦煜', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60173', '李仁志', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60174', '陶丽君', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60178', '吕帅', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60179', '顾少平', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60182', '罗丽', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60195', '王甲亮', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60196', '张锐', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60197', '龚乾坤', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60199', '王伟槐', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60200', '皇甫娜', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60203', '周庆怡', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60208', '刘毅', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60217', '闫秋雨', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60218', '任伟', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60222', '戴林春', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60223', '汪琳', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60224', '王陵', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60226', '黄鑫', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60227', '程慧君', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60228', '李凌志', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60235', '章天璐', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60238', '周为英', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60241', '牛建伟', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60247', '杨亮', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60249', '王彬', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60250', '朱建刚', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60253', '朱伟', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60256', '谢肖', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60259', '束陈林', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60260', '苏静', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60264', '李秀明', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60265', '章平', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60266', '陆德锁', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60268', '张丽清', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60270', '芦海龙', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60271', '所迪', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60273', '江涛', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60274', '唐圣杰', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60278', '张释引', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60279', '庄欢欢', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60280', '顾仁波', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60281', '张在梁', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60283', '洪宗胜', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60284', '滕帅', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60288', '张闽泉', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60292', '李琪', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60297', '姚伟', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60298', '王坤', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60299', '毛海霞', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60300', '张阿昌', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60302', '李名龙', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60303', '吴承东', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60304', '何小刚', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60309', '王福龙', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60311', '陈敏', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60313', '张浩斌', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60315', '刘波', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60316', '王政', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60317', '彭灿', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60319', '周嘉伦', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60321', '李守辉', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60322', '胡伟', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60323', '张少华', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60324', '毛育滔', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60325', '熊根根', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60326', '马强强', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60327', '苗春田', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60332', '舒凯', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60334', '潘文生', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60335', '周磊', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60336', '李肇光', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60342', '蒋贻峰', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60344', '储昭阳', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60345', '林明锟', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60346', '高启杰', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60350', '陈冲', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60353', '马丹丹', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60358', '林星', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60359', '剡飞龙', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60360', '梁朋朋', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60362', '钟祥超', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60364', '刘世权', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60365', '朱宁波', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60366', '田超群', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60367', '邵广庆', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60368', '王春生', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60369', '彭志强', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60370', '王莎莎', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60371', '陆志民', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60372', '李庆', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60374', '王栋森', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60376', '姚黄鑫', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60378', '汪晗', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60379', '屈阳', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60380', '马文涛', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60383', '刘龙振', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60386', '黄猷', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60387', '蒋博', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60388', '朱诗宇', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60389', '陈二辉', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60390', '林兵', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60391', '代其全', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60392', '刘家福', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60393', '杨善雨', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60394', '王奇林', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60395', '尹固滨', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60397', '朱华敏', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60399', '顾加成', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60400', '吴昊', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60402', '李晓刚', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60403', '张巍', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60405', '王鹏', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60406', '王俊', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60407', '郑占飞', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60408', '李柳青', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60409', '蒋松萌', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60410', '谢志超', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60411', '宋晓彬', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60413', '庞婉晶', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60414', '朱飞', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60415', '沈海河', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60416', '卞仕功', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60417', '张开元', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60418', '丁智伟', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60420', '张金虎', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60422', '秦彬', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60423', '赵若楠', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60425', '周如磊', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60426', '李文灿', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60427', '吴永胜', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60428', '仇培旋', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60429', '刘娜', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60430', '陈君', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60431', '沈倍佩', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60432', '陈云库', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60433', '刘希', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60434', '顾志成', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60435', '张文海', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60436', '章富洪', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60437', '刘志强', '软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60438', '吴灿', '硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60439', '鄢明智', '系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60440', '周乃涛', '软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60441', '安子', '系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80001', '王济纬', '移动互联-总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80004', '余来志', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80005', '徐伟松', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80006', '梁发源', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80007', '邓浩', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80008', '石莹', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80009', '刘茜茜', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80011', '陈家乐', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80013', '卢健', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80015', '梁铂琚', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80016', '陈加凯', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80020', '李妮丽', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80021', '张茂军', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80024', '李靖', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80028', '刘文杰', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80029', '黄恩海', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80031', '刘志', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80034', '罗远辉', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80036', '程屹东', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80039', '周仕冬', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80041', '李航', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80043', '史坤', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80044', '彭义臻', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80045', '王凡', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80047', '谭云', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80051', '韩巍', '移动互联-总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80052', '卓优', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80053', '陈忆佳', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80054', '王晓龙', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80056', '高健伦', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80058', '杨华强', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80061', '王贺', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80062', '陈小双', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80063', '吴倍苍', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80067', '王兴平', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80068', '曾婷', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80070', '雷玲玲', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80071', '刘靓', '移动互联-人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80074', '赵清华', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80075', '唐裕', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80076', '刘建军', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80078', '龙海', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80079', '韦康', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80080', '程刚', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80081', '米萌', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80083', '赵琳', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80086', '高菲云', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80087', '张伟', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80089', '李旻婧', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80092', 'Okano Gillies', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80093', 'Lawal Surajudeen Olaitan', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80094', 'Blessing Joe Ime', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80095', 'Arowolo Rachael R', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80096', 'Kpono-Abasi Ndisa Akpabio', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80097', '陈丽芬', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80098', '黄琦', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80099', '曾志英', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80100', '马丽婵', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80101', '程玉强', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80102', '谢梦晨', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80103', '成宇', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80104', '谢锦', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80106', '黄杰', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80109', '黎伟强', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80111', '杨林', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80112', '姚必财', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80115', '栗小粟', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80116', '隋军强', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80118', '马庆毅', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80120', '孙浩桓', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80121', '黄帆', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80122', '毛健羽', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80124', '陈柳', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80125', '黎晓文', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80126', '陶凯林', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80128', '潘蒙', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80129', '孙盼', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80130', '袁庆伟', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80131', '姜薇', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80132', '李成艳', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80134', '王益', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80135', '廖阳杰', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80136', '龚腾峰', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80137', '邓如桔', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80139', '陈志萍', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80140', '官焕静', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80141', '陈继才', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80143', '成传友', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80144', '祝琼', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80145', '冯志坚', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80147', '王成君', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80148', '马昭烈', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80149', '陈风斌', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80150', '李国优', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80151', '王储玺', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80152', '金路', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80153', '陈竞雄', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80154', '李俊', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80155', '李冠霖', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80156', '尹金亮', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80157', '刘巧', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80158', '邹志伟', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A00556', '王朝辉', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('07068', '戴芳', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A02766', '简繁', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('Z12697', '林丽琴', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('03237', '周毅', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('07313', '甘泉', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01132', '杨少华', '后勤部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01121', '何爱平', '关务部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('Z13497', '张玲', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('Z12706', '庞建勇', '质控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('4011', '唐小芳', '质检部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('08395', '杨汉林', '工程部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00022', '胡金', '物控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('Z13782', '彭辉', '物控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00423', '李鹏', '生产部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('04111', '董登峰', '物控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A03521', '熊秉毅', '测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A02787', '刘霞', '质量部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A03518', '黄东海', '质量部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A01095', '李超', '物控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A02680', '唐政', '生产部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A00949', '王智聪', '工程部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('H00103', '王中琦', '质量部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('H00825', '利波', '物控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('H00894', '陈春利', '质量部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('H00105', '陈进', '工程部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('07933', '李桂胜', '生产部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('04573', '殷永祥', '生产部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('05601', '陈才', '集装箱')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('02379', '周建军', '生产部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01244', '占志诚', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01245', '黄齐欢', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01246', '刘国利', '产品规划部')");
	}
	
	private function init_hb_jiang_chi()
	{
		$this->db->connect();
		$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
		$this->db->query("delete from $tb_hb_jiang_chi");
		
		//2月3-8号
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-3', 80, 2, 29, 150)");
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-4', 80, 2, 15, 100)");
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-5', 80, 2, 15, 50)");
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-6', 80, 2, 15, 0)");
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-7', 80, 2, 15, 0)");
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-8', 100, 2, 15, 0)");
	}
}

/**
 *	抽奖
 */
class Lucky
{
	private $db = null;//数据库
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
	}
	
	/**
	 * 检测今天是否抽过奖
	 */
	public function check_lucky_today($openid)
	{
		$this->db->connect();
		$tb_lucky_daily = Config::$tb_lucky_daily;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_lucky_daily WHERE openid=$sql_openid AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return array(true, $res['pan_flag']);
		}
		else
		{
			return array(false, 0);
		}
	}
	
	/**
	 * 记录今天抽过奖
	 */
	public function set_lucky_today($openid)
	{
		$this->db->connect();
		$tb_lucky_daily = Config::$tb_lucky_daily;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
		$this->db->query("insert into $tb_lucky_daily (openid, lucky_time, pan_flag) values ($sql_openid, $sql_date, 0)");
	}
	
	/**
	 * 抽奖
	 */
	public function lucky($openid)
	{
		$this->set_lucky_today($openid);
		if ($this->check_is_win($openid))
		{
			return 0;
		}
		
		$this->db->connect();
		$tb_jiang_chi = Config::$tb_jiang_chi;
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_jiang_chi WHERE prize_date=$sql_date");
		$res = $this->db->get_row();
		
		if (!empty($res))
		{
			//根据设定的概率判断是否中奖
			$rand = rand(1, 100);
			if ($rand <= (int)$res['rate'])
			{
				//组合奖品id
				$prize_arr = array_merge(
					$this->join_prize(1, $res['prize1']),
					$this->join_prize(2, $res['prize2']),
					$this->join_prize(3, $res['prize3']),
					$this->join_prize(4, $res['prize4']),
					$this->join_prize(5, $res['prize5']),
					$this->join_prize(6, $res['prize6']),
					$this->join_prize(7, $res['prize7']),
					$this->join_prize(8, $res['prize8']),
					$this->join_prize(9, $res['prize9']),
					$this->join_prize(10, $res['prize10'])
				);
				
				//判断当天奖池中是否还有奖品
				$prize_arr_count = count($prize_arr);
				if ($prize_arr_count > 0)
				{
					$prize_index = rand(0, $prize_arr_count - 1);
					$prize_id = $prize_arr[$prize_index];
					//减少奖池中对应的奖品，保存中奖数据
					$this->reduce_jiang_chi($res['id'], $prize_id);
					$this->save_lucky($openid, $prize_id);
					
					return $prize_id;
				}
			}
		}
		
		return 0;
	}
	
	/**
	 * 组合奖品
	 */
	private function join_prize($prize, $num)
	{
		$res = array();
		for ($i = 0; $i < $num; $i++)
		{
			$res[] = $prize;
		}
		
		return $res;
	}
	
	/**
	 * 减少奖池里指定的奖品数量
	 */
	private function reduce_jiang_chi($jiang_chi_id, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_jiang_chi = Config::$tb_jiang_chi;
			$sql_id = (int)$jiang_chi_id;
			$field_name = 'prize' . $prize_id;
			$this->db->query("UPDATE $tb_jiang_chi SET $field_name=$field_name-1 WHERE id=$sql_id");
		}
	}
	
	/**
	 * 保存中奖数据
	 */
	private function save_lucky($openid, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_zhong_jiang = Config::$tb_zhong_jiang;
			$sql_openid = Security::var_sql($openid);
			$sql_prize_id = (int)$prize_id;
			$sql_prize_name = Security::var_sql(Config::$prize_name[$prize_id - 1]);
			$sql_time = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
			$this->db->query("INSERT INTO $tb_zhong_jiang (openid, prizeid, prizename, lucky_time) VALUES ($sql_openid, $sql_prize_id, $sql_prize_name, $sql_time)");
		}
	}
	
	/**
	 * 保存中奖用户信息
	 */
	public function save_win_userinfo($openid, $department, $username)
	{
		$this->db->connect();
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$sql_openid = Security::var_sql($openid);
		$sql_department = Security::var_sql($department);
		$sql_username = Security::var_sql($username);
		$this->db->query("update $tb_zhong_jiang set department=$sql_department, username=$sql_username where openid=$sql_openid");
	}
	
	public function check_is_win($openid)
	{
		$this->db->connect();
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$sql_openid = Security::var_sql($openid);
		$this->db->query("SELECT * FROM $tb_zhong_jiang WHERE openid=$sql_openid");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function check_is_win_today($openid)
	{
		$this->db->connect();
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_zhong_jiang WHERE openid=$sql_openid AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function get_userinfo_today($openid)
	{
		$this->db->connect();
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_zhong_jiang WHERE openid=$sql_openid AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			if (!empty($res['department']) && !empty($res['username']))
			{
				return array(true, $res['department'], $res['username'], (int)$res['prizeid']);
			}
			else
			{
				return array(false, '', '', (int)$res['prizeid']);
			}
		}
		else
		{
			return array(false, '', '', 0);
		}
	}
	
	public function get_daily()
	{
		$this->db->connect();
		$tb_lucky_daily = Config::$tb_lucky_daily;
		$this->db->query("SELECT * FROM $tb_lucky_daily order by id");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	public function get_zhong_jiang()
	{
		$this->db->connect();
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$this->db->query("SELECT * FROM $tb_zhong_jiang order by id");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	public function check_pan_today($openid)
	{
		$this->db->connect();
		$tb_lucky_daily = Config::$tb_lucky_daily;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_lucky_daily WHERE openid=$sql_openid AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			if (1 == $res['pan_flag'])
			{
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
	
	public function set_pan_click($openid)
	{
		$this->db->connect();
		$tb_lucky_daily = Config::$tb_lucky_daily;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("update $tb_lucky_daily set pan_flag=1 WHERE openid=$sql_openid AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
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
	public static function get_session($session_name)
	{
		return isset($_SESSION[Config::$system_name . '_' . $session_name]) ? $_SESSION[Config::$system_name . '_' . $session_name] : null;
	}
	
	/**
	 * 设置session
	 */
	public static function set_session($session_name, $value)
	{
		$_SESSION[Config::$system_name . '_' . $session_name] = $value;
	}
	
	/**
	 * 清除session
	 */
	public static function clear_session($session_name)
	{
		unset($_SESSION[Config::$system_name . '_' . $session_name]);
	}
	
	/**
	 * 上传图片
	 */
	public static function upload_image()
	{
		$upload = new Upload(2 * 1024 * 1024, 'gif,jpg,png,bmp', array('image/gif', 'image/jpeg', 'image/png', 'image/bmp'), Config::$dir_uploads, Utils::gen_filename());
		if ($upload->upload())
		{
			$upload_info = $upload->getUploadFileInfo();
			//$url = $upload_info[0]['savepath'] . $upload_info[0]['savename'];
			$url = Config::$base_url . '/' . Config::$dir_uploads . $upload_info[0]['savename'];
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
	public static function upload_jq_image()
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
				$url = self::get_image_name($_FILES['fileToUpload']['name']);
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $url);
		}
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "',\n";
		echo				"url: '" . '/' . $url . "'\n";
		echo "}";
	}
	
	/**
	 * 生成图片文件名
	 */
	public static function get_image_name($extend)
	{
		$arr = explode('.', $extend);
		return Config::$dir_uploads . time() . rand(1000, 9999) . '.' . $arr[count($arr) - 1];
	}
	
	/**
	 * 设置为数据提交状态
	 */
	public static function set_submit()
	{
		self::set_session('submit_key', 1);
	}
	
	/**
	 * 检测是否为数据提交状态
	 */
	public static function check_submit()
	{
		$is_set = (int)self::get_session('submit_key');
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
	public static function clear_submit()
	{
		self::clear_session('submit_key');
	}
	
	/**
	 * 转义html代码
	 */
	public function fix_html($value)
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
	public function fix_title($value)
	{
		$str = htmlspecialchars($value, ENT_QUOTES);
		$str = str_replace("\n", ' ', $str);
		return $str;
	}
}

/**
 *	微信
 */
class Weixin
{
	private $db = null;//数据库
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
	}
	
	public function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = Security::var_get('signature');
        $timestamp = Security::var_get('timestamp');
        $nonce = Security::var_get('nonce');
        
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
		
      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to wechat world!";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }
        }else {
        	echo "";
        	exit;
        }
    }
	
	public function valid()
    {
        $echoStr = Security::var_get('echostr');
		
        //valid signature , option
        if ($this->checkSignature())
		{
        	echo $echoStr;
        }
    }
}
new MainController();
?>
