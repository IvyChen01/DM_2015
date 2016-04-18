<?php
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
				@mysql_select_db($this->db_name);
				@mysql_query("SET NAMES '{$this->db_charset}', character_set_client=binary, sql_mode='', interactive_timeout=3600 ;", $this->link_id);
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
			$this->result = @mysql_query($sql, $this->link_id);
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
	public function get_all_rows($acctype = MYSQL_ASSOC)
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
	public function get_num_rows()
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
	 * $tb_name	表名
	 */
	public function get_all_fields($tb_name)
	{
		if ($this->is_connected)
		{
			$res = array();
			$fields = @mysql_list_fields($this->db_name, $tb_name, $this->link_id);
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
		if ($this->link_id)
		{
			@mysql_close($this->link_id);
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
			return @mysql_insert_id($this->link_id);
		}
		else
		{
			return 0;
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
}

 /**
  * 内置MYSQL连接，只需要简单配置数据连接
 使用方法如下
 
<?php

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
?>
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
	//	$result = mysql_list_tables($database);//mysql_list_tables函数不建议使用
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
 * 调试
 * 静态类
 */
class Debug
{
	public static $log_enabled = false;//日志开关，true:打开，false:关闭
	public static $log_file = 'log.php';//日志文件
	
	/**
	 * 添加日志记录
	 * $str	记录内容
	 */
	public static function log($str)
	{
		if (self::$log_enabled)
		{
			if (file_exists(self::$log_file))
			{
				$file = fopen(self::$log_file, 'a+');
				fwrite($file, '[' . date('H:i:s') . ' ' . Utils::get_client_ip() . '] ' . $str . "<br />\r\n");
			}
			else
			{
				$file = fopen(self::$log_file, 'a+');
				fwrite($file, '<?php if(!defined(\'VIEW\')) exit(\'Request Error!\'); ?>' . "\r\n" . '[' . date('H:i:s') . ' ' . Utils::get_client_ip() . '] ' . $str . "<br />\r\n");
			}
			fclose($file);
		}
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
		self::$config['SMTP_USERNAME']=isset($config['SMTP_USERNAME'])?$config['SMTP_USERNAME']:'';//smtp服务器帐号，如：你的qq邮箱
		self::$config['SMTP_PASSWORD']=isset($config['SMTP_PASSWORD'])?$config['SMTP_PASSWORD']:'';//smtp服务器帐号密码，如你的qq邮箱密码
		self::$config['SMTP_AUTH']=isset($config['SMTP_AUTH'])?$config['SMTP_AUTH']:true;//启用SMTP验证功能，一般需要开启
		self::$config['SMTP_CHARSET']=isset($config['SMTP_CHARSET'])?$config['SMTP_CHARSET']:'utf-8';//发送的邮件内容编码	
		self::$config['SMTP_FROM_TO']=isset($config['SMTP_FROM_TO'])?$config['SMTP_FROM_TO']:'';//发件人邮件地址
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
					$pages_str .= '<span class="cur">' . $current_page . '</span>' . $this->spacing_str;
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
		
		return substr($code, 0, 11) . $str1 . substr($code, 11, 19);
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
	 * SQL安全变量
	 */
	public static function sql_var($value)
	{
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$value = stripslashes($value);
		}
		// 如果不是数字则加引号
		if (!is_numeric($value))
		{
			$value = "'" . mysql_real_escape_string($value) . "'";
		}
		
		return $value;
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
            if(function_exists($rule)) {
                //使用函数生成一个唯一文件标识号
                $saveName = $rule().".".$filename['extension'];
            }else {
                //使用给定的文件名作为标识号
                $saveName = $rule.".".$filename['extension'];
            }
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
	 * 生成静态页
	 * $file_name	生成文件名
	 * $url	所要生成HTML的页面的URL
	 */
	public static function make_html($file_name, $url)
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
	public static function make_php($files, $file_make)
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
		fwrite($file_write, "?>\r\n");
		fclose($file_write);
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
	
	//遍历删除目录和目录下所有文件
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
	
	// 获取客户端IP地址
	public static function get_client_ip(){
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
	
	//中文字符串截取
	public static function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
	{
		switch($charset)
		{
			case 'utf-8':$char_len=3;break;
			case 'UTF8':$char_len=3;break;
			default:$char_len=2;
		}
		//小于指定长度，直接返回
		if(strlen($str)<=($length*$char_len))
		{	
			return $str;
		}
		if(function_exists("mb_substr"))
		{   
			$slice= mb_substr($str, $start, $length, $charset);
		}
		else if(function_exists('iconv_substr'))
		{
			$slice=iconv_substr($str,$start,$length,$charset);
		}
		else
		{ 
		   $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
			$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
			$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
			$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
			preg_match_all($re[$charset], $str, $match);
			$slice = join("",array_slice($match[0], $start, $length));
		}
		if($suffix) 
			return $slice."…";
		return $slice;
	}
	
	// 检查字符串是否是UTF8编码,是返回true,否则返回false
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
	
	// 自动转换字符集 支持数组转换
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
	
	// 浏览器友好的变量输出
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
	
	//生成唯一的值
	public static function gen_uniqid()
	{
		return md5(uniqid(rand(), true));
	}
	
	//显示弹框消息
	public static function show_message($value)
	{
		echo '<script type="text/javascript" language="javascript"> alert("' . $value . '"); </script>';
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
		$month = (int)date('m', strtotime($date));
		
		return $month_en[$month - 1] . date(' j, Y', strtotime($date));
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
	private $install = null;//安装模型
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->install = new Install();
		$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
		switch ($action)
		{
			case 'login':
				$this->login();
				return;
			case 'verify':
				$this->verify();
				return;
			case 'change_user_language':
				$this->change_user_language();
				return;
			default:
		}
		
		if ($this->admin->check_login())
		{
			switch ($action)
			{
				case 'show_admin':
					$this->show_admin();
					return;
				case 'logout':
					$this->logout();
					return;
				case 'show_change_password':
					$this->show_change_password();
					return;
				case 'change_password':
					$this->change_password();
					return;
				case 'backup':
					$this->backup();
					return;
				case 'recover':
					$this->recover();
					return;
				case 'view_database':
					$this->view_database();
					return;
				case 'db_job':
					$this->db_job();
					return;
				case 'db_info':
					$this->db_info();
					return;
				case 'make_index_html':
					$this->make_index_html();
					return;
				case 'view_log':
					$this->view_log();
					return;
				case 'upload_image':
					$this->upload_image();
					return;
				case 'show_language':
					$this->show_language();
					return;
				case 'change_language':
					$this->change_language();
					return;
				case 'upload_jq_image':
					$this->upload_jq_image();
					return;
				case 'db_select':
					$this->db_select();
					return;
				case 'upgrade':
					$this->install->upgrade();
					echo 'ok';
					return;
				default:
					$this->show_admin();
			}
		}
		else
		{
			$this->show_login();
		}
	}
	
	/**
	 * 登录
	 */
	private function login()
	{
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		if (empty($username) || empty($password))
		{
			System::echo_data(2, '用户名和密码不能为空！');
		}
		else
		{
			$is_succeed = $this->admin->login($username, $password);
			if ($is_succeed)
			{
				System::echo_data(0, '登录成功！');
			}
			else
			{
				System::echo_data(1, '用户名或密码错误！');
			}
		}
	}
	
	private function verify()
	{
		Image::buildImageVerify();
	}
	
	private function change_user_language()
	{
		$language = isset($_GET['language']) ? $_GET['language'] : Config::$language_en;
		System::set_user_language($language);
		$_back_url = System::get_user_back_url();
		include('view/admin_language_back.php');
	}
	
	/**
	 * 显示管理页
	 */
	private function show_admin()
	{
		$_back_url = '?m=info&a=show_modify_index';
		include('view/admin_language_back.php');
	}
	
	/**
	 * 退出登录
	 */
	private function logout()
	{
		$this->admin->logout();
		$this->show_login();
	}
	
	/**
	 * 显示修改密码页
	 */
	private function show_change_password()
	{
		$_language_user = System::get_user_language();
		include('view/admin_change_password.php');
	}
	
	/**
	 * 修改密码
	 */
	private function change_password()
	{
		$src_password = isset($_POST['src_password']) ? $_POST['src_password'] : '';
		$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
		if (empty($src_password))
		{
			System::echo_data(2, '原密码不能为空！');
			return;
		}
		if (empty($new_password))
		{
			System::echo_data(3, '新密码不能为空！');
			return;
		}
		if ($this->admin->check_password($src_password))
		{
			$this->admin->change_password($new_password);
			$this->admin->logout();
			System::echo_data(0, '修改成功！');
		}
		else
		{
			System::echo_data(1, '原密码错误！');
		}
	}
	
	/**
	 * 备份数据库
	 */
	private function backup()
	{
		$this->install->backup();
		//$this->show_admin();
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
';
		Utils::show_message('备份完成！');
	}
	
	/**
	 * 恢复数据库
	 */
	private function recover()
	{
		$this->install->recover();
		//$this->show_admin();
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
';
		Utils::show_message('恢复完成！');
	}
	
	/**
	 * 查看数据库数据
	 */
	private function view_database()
	{
		$all_tables = $this->install->get_all_tables();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name, 0, 10);
			$_table_list[] = $table_info;
		}
		include('view/admin_view_database.php');
	}
	
	/**
	 * 查看招聘表数据
	 */
	private function db_job()
	{
		$all_tables = $this->install->get_job_table();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name, 0, 100);
			$_table_list[] = $table_info;
		}
		include('view/admin_view_database.php');
	}
	
	/**
	 * 查看招聘表数据
	 */
	private function db_info()
	{
		$all_tables = $this->install->get_info_table();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name, 0, 100);
			$_table_list[] = $table_info;
		}
		include('view/admin_view_database.php');
	}
	
	/**
	 * 生成首页静态页
	 */
	private function make_index_html()
	{
		//System::make_index_html();
		$this->show_admin();
		Utils::show_message('更新完成！');
	}
	
	/**
	 * 查看日志文件
	 */
	private function view_log()
	{
		$log_date = isset($_GET['b']) ? $_GET['b'] : '';
		if (!empty($log_date))
		{
			$_log_file = Config::$dir_log . $log_date . '.php';
		}
		else
		{
			$_log_file = Config::$dir_log . date('Y-m-d') . '.php';
		}
		include('view/admin_log.php');
	}
	
	/**
	 * 上传图片
	 */
	private function upload_image()
	{
		echo System::upload_image();
	}
	
	private function show_language()
	{
		$_back_url = System::get_back_url();
		include('view/admin_language.php');
	}
	
	private function change_language()
	{
		$language = isset($_GET['language']) ? $_GET['language'] : Config::$language_en;
		System::set_user_language($language);
		$_back_url = System::get_back_url();
		include('view/admin_language_back.php');
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function show_login()
	{
		include('view/admin_login.php');
	}
	
	private function upload_jq_image()
	{
		System::upload_jq_image();
	}
	
	private function db_select()
	{
		$this->install->db_select();
	}
}

/**
 * 信息控制器
 */
class InfoController
{
	private $admin = null;//管理员模型
	private $info = null;//信息模型
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->info = new Info();
		$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
		$tag = isset($_GET['tag']) ? (int)$_GET['tag'] : 0;
		
		if ($this->admin->check_login())
		{
			switch ($action)
			{
				case 'show_modify_index':
					$this->show_modify_index();
					return;
				case 'modify_index':
					$this->modify_index();
					return;
				case 'show_modify_info':
					$this->show_modify_info();
					return;
				case 'modify_info':
					$this->modify_info();
					return;
				case 'add_history':
					$this->add_history();
					return;
				case 'modify_history':
					$this->modify_history();
					return;
				case 'delete_history':
					$this->delete_history();
					return;
				default:
			}
		}
		
		$this->show_info($tag);
	}
	
	private function show_modify_index()
	{
		System::set_back_url('?m=info&a=show_modify_index');
		$_language_user = System::get_user_language();
		
		$res = $this->info->get_index_setting();
		$_language = System::get_language_name();
		$_title = $res['title'];
		$_keywords = $res['keywords'];
		$_description = $res['description'];
		$_about_image = $res['about_image'];
		$_about_text = $res['about_text'];
		$_brands_image = $res['brands_image'];
		$_brands_text = $res['brands_text'];
		$_operating_image = $res['operating_image'];
		$_operating_text = $res['operating_text'];
		$_careers_image = $res['careers_image'];
		$_careers_text = $res['careers_text'];
		$_responsibility_image = $res['responsibility_image'];
		$_responsibility_text = $res['responsibility_text'];
		$_banner_image1 = $res['banner_image1'];
		$_banner_link1 = $res['banner_link1'];
		$_banner_image2 = $res['banner_image2'];
		$_banner_link2 = $res['banner_link2'];
		$_banner_image3 = $res['banner_image3'];
		$_banner_link3 = $res['banner_link3'];
		$_banner_image4 = $res['banner_image4'];
		$_banner_link4 = $res['banner_link4'];
		$_supplier_icon = '';
		$_supplier_title = '';
		$_supplier_image = $res['supplier_image'];
		$_supplier_text = $res['supplier_text'];
		$_supplier_link = $res['supplier_link'];
		$_join_icon = '';
		$_join_title = '';
		$_join_image = $res['join_image'];
		$_join_text = $res['join_text'];
		$_join_link = $res['join_link'];
		$_tag1 = 0;
		$_tag2 = 0;
		
		include('view/admin_index_modify.php');
	}
	
	private function modify_index()
	{
		$title = isset($_POST['title']) ? $_POST['title'] : 'a';
		$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : 'c';
		$about_image = isset($_POST['about_image']) ? $_POST['about_image'] : '';
		$about_text = isset($_POST['about_text']) ? $_POST['about_text'] : '';
		$brands_image = isset($_POST['brands_image']) ? $_POST['brands_image'] : '';
		$brands_text = isset($_POST['brands_text']) ? $_POST['brands_text'] : '';
		$operating_image = isset($_POST['operating_image']) ? $_POST['operating_image'] : '';
		$operating_text = isset($_POST['operating_text']) ? $_POST['operating_text'] : '';
		$careers_image = isset($_POST['careers_image']) ? $_POST['careers_image'] : '';
		$careers_text = isset($_POST['careers_text']) ? $_POST['careers_text'] : '';
		$responsibility_image = isset($_POST['responsibility_image']) ? $_POST['responsibility_image'] : '';
		$responsibility_text = isset($_POST['responsibility_text']) ? $_POST['responsibility_text'] : '';
		$banner_image1 = isset($_POST['banner_image1']) ? $_POST['banner_image1'] : '';
		$banner_link1 = isset($_POST['banner_link1']) ? $_POST['banner_link1'] : '';
		$banner_image2 = isset($_POST['banner_image2']) ? $_POST['banner_image2'] : '';
		$banner_link2 = isset($_POST['banner_link2']) ? $_POST['banner_link2'] : '';
		$banner_image3 = isset($_POST['banner_image3']) ? $_POST['banner_image3'] : '';
		$banner_link3 = isset($_POST['banner_link3']) ? $_POST['banner_link3'] : '';
		$banner_image4 = isset($_POST['banner_image4']) ? $_POST['banner_image4'] : '';
		$banner_link4 = isset($_POST['banner_link4']) ? $_POST['banner_link4'] : '';
		$supplier_image = isset($_POST['supplier_image']) ? $_POST['supplier_image'] : '';
		$supplier_text = isset($_POST['supplier_text']) ? $_POST['supplier_text'] : '';
		$supplier_link = isset($_POST['supplier_link']) ? $_POST['supplier_link'] : '';
		$join_image = isset($_POST['join_image']) ? $_POST['join_image'] : '';
		$join_text = isset($_POST['join_text']) ? $_POST['join_text'] : '';
		$join_link = isset($_POST['join_link']) ? $_POST['join_link'] : '';
		
		$this->info->modify_index_setting($title, $keywords, $description, $about_image, $about_text, $brands_image, $brands_text, $operating_image, $operating_text, $careers_image, $careers_text, $responsibility_image, $responsibility_text, $banner_image1, $banner_link1, $banner_image2, $banner_link2, $banner_image3, $banner_link3, $banner_image4, $banner_link4, $supplier_image, $supplier_text, $supplier_link, $join_image, $join_text, $join_link);
		System::echo_data(0, '修改成功！');
	}
	
	private function show_modify_info()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		if (!empty(Config::$info_detail[$id]))
		{
			System::set_back_url('?m=info&a=show_modify_info&id=' . $id);
			$_language_user = System::get_user_language();
			
			$this->info->set_modify_info_id($id);
			$_title = Config::$info_detail[$id]['cn'];
			$_info = $this->info->get_info($id);
			$_language = System::get_language_name();
			$no_images = array('11', '21', '31', '41', '51');
			if (in_array($id, $no_images))
			{
				$_image_tag = false;
			}
			else
			{
				$_image_tag = true;
			}
			$_tag1 = (int)((int)$id / 10);
			$_tag2 = (int)$id % 10;
			
			if (4 == $_tag1)
			{
				if ($_tag2 >= 6 && $_tag2 <= 8)
				{
					$_tag2--;
				}
			}
			
			switch ($id)
			{
				/*
				case '12':
				case '21':
				case '22':
				case '23':
				case '24':
				case '25':
				case '26':
				case '31':
				case '32':
				case '33':
				case '34':
				case '35':
				case '36':
				case '37':
				case '38':
				case '42':
				case '46':
				case '52':
					//两栏
					include('view/admin_info_modify2.php');
					break;
				*/
				case '13':
					//发展历程
					$res = $this->info->get_history();
					$new_res = array();
					foreach ($res as $key => $value)
					{
						$row = array();
						foreach ($value as $row_key => $row_value)
						{
							$row[$row_key] = htmlspecialchars($row_value);
						}
						$new_res[] = $row;
					}
					$_history = $new_res;
					include('view/admin_history.php');
					break;
				default:
					include('view/admin_info_modify.php');
			}
		}
	}
	
	private function modify_info()
	{
		$id = $this->info->get_modify_info_id();
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$banner_image = isset($_POST['banner_image']) ? $_POST['banner_image'] : '';
		$menu_name = isset($_POST['menu_name']) ? $_POST['menu_name'] : '';
		$menu_image = isset($_POST['menu_image']) ? $_POST['menu_image'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		switch ($id)
		{
			/*
			case '12':
			case '21':
			case '22':
			case '23':
			case '24':
			case '25':
			case '26':
			case '31':
			case '32':
			case '33':
			case '34':
			case '35':
			case '36':
			case '37':
			case '38':
			case '42':
			case '46':
			case '52':
				//两栏
				$content2 = isset($_POST['content2']) ? $_POST['content2'] : '';
				$this->info->modify_info2($id, $title, $keywords, $description, $banner_image, $menu_name, $menu_image, $content, $content2);
				break;
			*/
			default:
				$this->info->modify_info($id, $title, $keywords, $description, $banner_image, $menu_name, $menu_image, $content);
		}
		
		System::echo_data(0, '修改成功！');
	}
	
	private function show_info($tag)
	{
		$_language_user = System::get_user_language();
		
		if (empty(Config::$info_detail[$tag]))
		{
			//首页
			System::set_user_back_url('/');
			$res = $this->info->get_index_setting();
			$_title = $res['title'];
			$_keywords = $res['keywords'];
			$_description = $res['description'];
			$_about_image = $res['about_image'];
			$_about_text = $res['about_text'];
			$_brands_image = $res['brands_image'];
			$_brands_text = $res['brands_text'];
			$_operating_image = $res['operating_image'];
			$_operating_text = $res['operating_text'];
			$_careers_image = $res['careers_image'];
			$_careers_text = $res['careers_text'];
			$_responsibility_image = $res['responsibility_image'];
			$_responsibility_text = $res['responsibility_text'];
			$_banner_image1 = $res['banner_image1'];
			$_banner_link1 = $res['banner_link1'];
			$_banner_image2 = $res['banner_image2'];
			$_banner_link2 = $res['banner_link2'];
			$_banner_image3 = $res['banner_image3'];
			$_banner_link3 = $res['banner_link3'];
			$_banner_image4 = $res['banner_image4'];
			$_banner_link4 = $res['banner_link4'];
			$_supplier_image = $res['supplier_image'];
			$_supplier_text = $res['supplier_text'];
			$_supplier_link = $res['supplier_link'];
			$_join_image = $res['join_image'];
			$_join_text = $res['join_text'];
			$_join_link = $res['join_link'];
			
			$news = new News();
			$_news = $news->get_cn_news(1);
			$_nav_index = 0;
			
			include('templates/index.php');
		}
		else
		{
			System::set_user_back_url('?tag=' . $tag);
			$res = $this->info->get_index_setting();
			$_about_image = $res['about_image'];
			$_about_text = $res['about_text'];
			$_brands_image = $res['brands_image'];
			$_brands_text = $res['brands_text'];
			$_operating_image = $res['operating_image'];
			$_operating_text = $res['operating_text'];
			$_careers_image = $res['careers_image'];
			$_careers_text = $res['careers_text'];
			$_responsibility_image = $res['responsibility_image'];
			$_responsibility_text = $res['responsibility_text'];
			
			$_info = $this->info->get_info($tag);
			$_menu_images = $this->info->get_menu_images($tag);
			$_menu_info = $this->info->get_menu_info($tag, 'cn');
			$_nav_index = (int)((int)$tag / 10);
			$_brand_link = $this->info->get_brand_link($tag);
			
			$_info_detail = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$info_detail as $key => $value)
				{
					$_info_detail[$key] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$info_detail as $key => $value)
				{
					$_info_detail[$key] = $value['en'];
				}
			}
			
			switch ($tag)
			{
				case '11':
					//关于我们
					if ($_language_user == 'cn')
					{
						include('templates/about-us/index_cn.php');
					}
					else
					{
						include('templates/about-us/index.php');
					}
					break;
				case '21':
				case '31':
					//主栏目页，两栏
					//include('templates/main_menu_page2.php');
					//break;
				case '41':
				case '51':
					//主栏目页
					include('templates/main_menu_page.php');
					break;
				case '13':
					//发展历程
					$_history = $this->info->get_history();
					include('templates/about-us/history/index.php');
					break;
				case '25':
					include('templates/business.php');
					break;
				default:
					//通用
					include('templates/info_page.php');
			}
		}
	}
	
	private function add_history()
	{
		$year = isset($_POST['year']) ? $_POST['year'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$insert_id = $this->info->add_history($year, $description, $content);
		System::echo_data(0, 'ok', array('insert_id' => $insert_id));
	}
	
	private function modify_history()
	{
		$id = isset($_POST['id']) ? (int)$_POST['id'] : '';
		$year = isset($_POST['year']) ? $_POST['year'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$insert_id = $this->info->modify_history($id, $year, $description, $content);
		System::echo_data(0, 'ok');
	}
	
	private function delete_history()
	{
		$id = isset($_POST['id']) ? (int)$_POST['id'] : '';
		$this->info->delete_history($id);
		System::echo_data(0, 'ok');
	}
}

/**
 * 系统安装控制器
 */
class InstallController
{
	private $install = null;//安装模型
	private $lock_file = '';//锁定文件
	
	public function __construct()
	{
		$this->lock_file = Config::$dir_lock . 'install.php';
		if (file_exists($this->lock_file))
		{
			exit('Locked!');
		}
		else
		{
			$this->install = new Install();
			$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
			switch ($action)
			{
				case 'create_database':
					$this->create_database();
					break;
				case 'install':
					$this->install();
					break;
				case 'upgrade':
					$this->upgrade();
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
		$file = fopen($this->lock_file, 'a');
		fwrite($file, '<?php //重要，请勿删除！需重新安装数据库或升级数据库时才可删除。?>');
		fclose($file);
	}
	
	/**
	 * 升级数据库
	 */
	private function upgrade()
	{
		$this->install->upgrade();
		$this->create_lock_file();
		echo 'Succeed!';
	}
}

/**
 * 招聘控制器
 */
class JobController
{
	private $admin = null;//管理员模型
	private $job = null;
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->job = new Job();
		$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
		
		switch ($action)
		{
			case 'show_job':
				$this->show_job();
				return;
			default:
		}
		
		if ($this->admin->check_login())
		{
			switch ($action)
			{
				case 'manage':
					$this->manage();
					return;
				case 'show_add_job':
					$this->show_add_job();
					return;
				case 'add_job':
					$this->add_job();
					return;
				case 'show_modify_job':
					$this->show_modify_job();
					return;
				case 'modify_job':
					$this->modify_job();
					return;
				case 'delete_job':
					$this->delete_job();
					return;
				case 'campus_homepage':
					$this->campus_homepage();
					return;
				case 'do_campus_homepage':
					$this->do_campus_homepage();
					return;
				default:
			}
		}
		else
		{
			$this->show_login();
		}
	}
	
	private function show_job()
	{
		$jobtype = isset($_GET['type']) ? $_GET['type'] : '';
		if ($jobtype != 'social' && $jobtype != 'campus' && $jobtype != 'overseas')
		{
			$jobtype = 'social';
		}
		
		System::set_user_back_url('?m=job&a=show_job' . '&type=' . $jobtype);
		$_language_user = System::get_user_language();
		
		$info = new Info();
		$res = $info->get_index_setting();
		$_about_image = $res['about_image'];
		$_about_text = $res['about_text'];
		$_brands_image = $res['brands_image'];
		$_brands_text = $res['brands_text'];
		$_operating_image = $res['operating_image'];
		$_operating_text = $res['operating_text'];
		$_careers_image = $res['careers_image'];
		$_careers_text = $res['careers_text'];
		$_responsibility_image = $res['responsibility_image'];
		$_responsibility_text = $res['responsibility_text'];
		
		if ('social' == $jobtype)
		{
			$_info = $info->get_info('45');
			$_menu_images = $info->get_menu_images('45');
			$_menu_info = $info->get_menu_info('45', 'cn');
		}
		else if ('campus' == $jobtype)
		{
			$_info = $info->get_info('49');
			$_menu_images = $info->get_menu_images('49');
			$_menu_info = $info->get_menu_info('49', 'cn');
		}
		else
		{
			$_info = $info->get_info('141');
			$_menu_images = $info->get_menu_images('141');
			$_menu_info = $info->get_menu_info('141', 'cn');
		}
		$_nav_index = 4;
		
		if ('social' == $jobtype)
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$job_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$job_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
		}
		else if ('campus' == $jobtype)
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$campus_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$campus_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
		}
		else
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$overseas_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$overseas_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
		}
		
		$_job = $this->job->get_job_by_type($jobtype);
		
		$_info_detail = array();
		if ($_language_user == 'cn')
		{
			foreach (Config::$info_detail as $key => $value)
			{
				$_info_detail[$key] = $value['cn'];
			}
		}
		else
		{
			foreach (Config::$info_detail as $key => $value)
			{
				$_info_detail[$key] = $value['en'];
			}
		}
		
		if ('social' == $jobtype)
		{
			include('templates/careers/social.php');
		}
		else if ('campus' == $jobtype)
		{
			$_campus_homepage = $this->job->get_campus_homepage();
			include('templates/careers/campus.php');
		}
		else
		{
			include('templates/careers/overseas.php');
		}
	}
	
	private function manage()
	{
		$jobtype = isset($_GET['type']) ? $_GET['type'] : '';
		if ('' == $jobtype)
		{
			$jobtype = System::get_session_jobtype();
		}
		if ($jobtype != 'social' && $jobtype != 'campus' && $jobtype != 'overseas')
		{
			$jobtype = 'social';
		}
		$_jobtype2 = $jobtype;
		System::set_session_jobtype($jobtype);
		
		if ('social' == $jobtype)
		{
			$_jobtype = '社会招聘';
			$_tag1 = 4;
			$_tag2 = 8;
		}
		else if ('campus' == $jobtype)
		{
			$_jobtype = '校园招聘';
			$_tag1 = 4;
			$_tag2 = 9;
		}
		else
		{
			$_jobtype = '海外招聘';
			$_tag1 = 4;
			$_tag2 = 10;
		}
		
		System::set_back_url('?m=job&a=manage' . '&type=' . $jobtype);
		$_language_user = System::get_user_language();
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		if ($page < 1)
		{
			$page = 1;
		}
		$_job = $this->job->get_job_page(($page - 1) * Config::$admin_job_pagesize, Config::$admin_job_pagesize, $jobtype);
		$_language = System::get_language_name();
		
		$pagelist = new Page();
		$page_count = ceil($this->job->get_job_count($jobtype) / Config::$admin_job_pagesize);
		$pagelist->url_base = '/?m=job&a=manage' . '&type=' . $jobtype . '&page=';
		//$pagelist->url_extend = '.php';
		$pagelist->format = '{preve}{pages}{next}';
		$pagelist->left_delimiter = '';
		$pagelist->right_delimiter = '';
		$pagelist->total_page = $page_count;
		$_pagelist = $pagelist->get_pages($page);
		$_num_from = ($page - 1) * Config::$admin_job_pagesize + 1;
		
		include('view/admin_job_manage.php');
	}
	
	private function show_add_job()
	{
		System::set_back_url('?m=job&a=manage');
		$_language_user = System::get_user_language();
		$_language = System::get_language_name();
		
		$jobtype = System::get_session_jobtype();
		if ($jobtype != 'social' && $jobtype != 'campus' && $jobtype != 'overseas')
		{
			$jobtype = 'social';
		}
		
		if ('social' == $jobtype)
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$job_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$job_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
			$_tag1 = 4;
			$_tag2 = 8;
		}
		else if ('campus' == $jobtype)
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$campus_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$campus_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
			$_tag1 = 4;
			$_tag2 = 9;
		}
		else
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$overseas_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$overseas_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
			$_tag1 = 4;
			$_tag2 = 10;
		}
		
		include('view/admin_job_add.php');
	}
	
	private function add_job()
	{
		$jobtype = System::get_session_jobtype();
		if ($jobtype != 'social' && $jobtype != 'campus' && $jobtype != 'overseas')
		{
			$jobtype = 'social';
		}
		
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$typename = isset($_POST['jobtype']) ? $_POST['jobtype'] : '';
		$pubtime = isset($_POST['pubtime']) ? $_POST['pubtime'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$this->job->add_job($title, $typename, $pubtime, $content, $jobtype);
		System::echo_data(0, '添加成功！');
	}
	
	private function show_modify_job()
	{
		$job_id = isset($_GET['id']) ? $_GET['id'] : 0;
		System::set_back_url('?m=job&a=manage');
		$_language_user = System::get_user_language();
		$this->job->set_modify_job_id($job_id);
		$_job = $this->job->get_job_by_id($job_id);
		$_language = System::get_language_name();
		
		$jobtype = System::get_session_jobtype();
		if ($jobtype != 'social' && $jobtype != 'campus' && $jobtype != 'overseas')
		{
			$jobtype = 'social';
		}
		
		if ('social' == $jobtype)
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$job_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$job_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
			
			$_tag1 = 4;
			$_tag2 = 8;
		}
		else if ('campus' == $jobtype)
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$campus_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$campus_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
			
			$_tag1 = 4;
			$_tag2 = 9;
		}
		else
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$overseas_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$overseas_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
			
			$_tag1 = 4;
			$_tag2 = 10;
		}
		
		include('view/admin_job_modify.php');
	}
	
	private function modify_job()
	{
		$id = (int)$this->job->get_modify_job_id();
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$typename = isset($_POST['jobtype']) ? $_POST['jobtype'] : '';
		$pubtime = isset($_POST['pubtime']) ? $_POST['pubtime'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$this->job->modify_job($id, $title, $typename, $pubtime, $content);
		System::echo_data(0, '修改成功！');
	}
	
	private function delete_job()
	{
		$job_id = isset($_GET['id']) ? $_GET['id'] : 0;
		$this->job->delete_job($job_id);
		$this->manage();
		Utils::show_message('删除成功！');
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function show_login()
	{
		include('view/admin_login.php');
	}
	
	private function campus_homepage()
	{
		//System::set_back_url('?m=job&a=manage');
		System::set_back_url('?m=job&a=campus_homepage');
		$_language_user = System::get_user_language();
		$_campus_homepage = $this->job->get_campus_homepage();
		$_language = System::get_language_name();
		
		$jobtype = System::get_session_jobtype();
		if ($jobtype != 'social' && $jobtype != 'campus' && $jobtype != 'overseas')
		{
			$jobtype = 'social';
		}
		
		if ('social' == $jobtype)
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$job_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$job_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
		}
		else if ('campus' == $jobtype)
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$campus_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$campus_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
		}
		else
		{
			$_jobtype = array();
			if ($_language_user == 'cn')
			{
				foreach (Config::$overseas_type as $key => $value)
				{
					$_jobtype[] = $value['cn'];
				}
			}
			else
			{
				foreach (Config::$overseas_type as $key => $value)
				{
					$_jobtype[] = $value['en'];
				}
			}
		}
		
		$_tag1 = 4;
		$_tag2 = 10;
		
		include('view/admin_campus_homepage.php');
		//echo 'ok';
	}
	
	private function do_campus_homepage()
	{
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$this->job->set_campus_homepage($content);
		System::echo_data(0, '保存成功！');
	}
}

/**
 * 主入口
 */
$src_time = microtime(true);
new Main();
$module = isset($_GET['m']) ? $_GET['m'] : '';//模块标识
$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
$time = microtime(true) - $src_time;
//Debug::log('time: [' . $time . '][' . $module . '][' . $action . ']');

class Main
{
	public function __construct()
	{
		Config::init();
		$module = isset($_GET['m']) ? $_GET['m'] : '';//模块标识
		switch ($module)
		{
			case 'admin':
				new AdminController();
				break;
			case 'info':
				new InfoController();
				break;
			case 'install':
				new InstallController();
				break;
			case 'job':
				new JobController();
				break;
			case 'news':
				new NewsController();
				break;
			default:
				new InfoController();
		}
	}
}

/**
 * 新闻控制器
 */
class NewsController
{
	private $admin = null;//管理员模型
	private $news = null;
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->news = new News();
		$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
		switch ($action)
		{
			case 'show_news_list':
				$this->show_news_list();
				return;
			case 'show_news':
				$this->show_news();
				return;
			case 'get_cn_news':
				$this->get_cn_news();
				return;
			case 'get_recommend_news_cn':
				$this->get_recommend_news_cn();
				return;
			default:
		}
		
		if ($this->admin->check_login())
		{
			switch ($action)
			{
				case 'manage':
					$this->manage();
					return;
				case 'show_add_news':
					$this->show_add_news();
					return;
				case 'add_news':
					$this->add_news();
					return;
				case 'show_modify_news':
					$this->show_modify_news();
					return;
				case 'modify_news':
					$this->modify_news();
					return;
				case 'delete_news':
					$this->delete_news();
					return;
				default:
			}
		}
		else
		{
			$this->show_login();
		}
	}
	
	private function show_news_list()
	{
		System::set_user_back_url('?m=news&a=show_news_list');
		$_language_user = System::get_user_language();
		
		$info = new Info();
		$res = $info->get_index_setting();
		$_about_image = $res['about_image'];
		$_about_text = $res['about_text'];
		$_brands_image = $res['brands_image'];
		$_brands_text = $res['brands_text'];
		$_operating_image = $res['operating_image'];
		$_operating_text = $res['operating_text'];
		$_careers_image = $res['careers_image'];
		$_careers_text = $res['careers_text'];
		$_responsibility_image = $res['responsibility_image'];
		$_responsibility_text = $res['responsibility_text'];
		
		$_info = $info->get_info('16');
		$_menu_images = $info->get_menu_images('16');
		$_menu_info = $info->get_menu_info('16', 'cn');
		$_news = $this->news->get_cn_news(1);
		$_nav_index = 1;
		
		$_info_detail = array();
		if ($_language_user == 'cn')
		{
			foreach (Config::$info_detail as $key => $value)
			{
				$_info_detail[$key] = $value['cn'];
			}
		}
		else
		{
			foreach (Config::$info_detail as $key => $value)
			{
				$_info_detail[$key] = $value['en'];
			}
		}
		
		include('templates/about-us/news/index.php');
	}
	
	private function show_news()
	{
		System::set_user_back_url('?m=news&a=show_news_list');
		$_language_user = System::get_user_language();
		
		$info = new Info();
		$res = $info->get_index_setting();
		$_about_image = $res['about_image'];
		$_about_text = $res['about_text'];
		$_brands_image = $res['brands_image'];
		$_brands_text = $res['brands_text'];
		$_operating_image = $res['operating_image'];
		$_operating_text = $res['operating_text'];
		$_careers_image = $res['careers_image'];
		$_careers_text = $res['careers_text'];
		$_responsibility_image = $res['responsibility_image'];
		$_responsibility_text = $res['responsibility_text'];
		
		$_menu_info = $info->get_menu_info('16', 'cn');
		$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
		$_news = $this->news->get_news_by_id($id);
		$_nav_index = 1;
		
		$_info_detail = array();
		if ($_language_user == 'cn')
		{
			foreach (Config::$info_detail as $key => $value)
			{
				$_info_detail[$key] = $value['cn'];
			}
		}
		else
		{
			foreach (Config::$info_detail as $key => $value)
			{
				$_info_detail[$key] = $value['en'];
			}
		}
		
		include('templates/about-us/news/detials.php');
	}
	
	private function get_cn_news()
	{
		$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
		$res = $this->news->get_cn_news($page);
		$total_page = ceil($this->news->get_news_count_cn() / Config::$reload_news_count);
		System::echo_data(0, 'ok', array('data' => $res, 'total_page' => $total_page));
	}
	
	private function get_recommend_news_cn()
	{
		$current_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
		$res = $this->news->get_recommend_news_cn($current_id);
		System::echo_data(0, 'ok', array('data' => $res));
	}
	
	private function manage()
	{
		System::set_back_url('?m=news&a=manage');
		$_language_user = System::get_user_language();
		
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		if ($page < 1)
		{
			$page = 1;
		}
		$_news = $this->news->get_news_page(($page - 1) * Config::$admin_news_pagesize, Config::$admin_news_pagesize);
		$_language = System::get_language_name();
		
		$pagelist = new Page();
		$page_count = ceil($this->news->get_news_count() / Config::$admin_news_pagesize);
		$pagelist->url_base = '/?m=news&a=manage&page=';
		//$pagelist->url_extend = '.php';
		$pagelist->format = '{preve}{pages}{next}';
		$pagelist->left_delimiter = '';
		$pagelist->right_delimiter = '';
		$pagelist->total_page = $page_count;
		$_pagelist = $pagelist->get_pages($page);
		$_num_from = ($page - 1) * Config::$admin_news_pagesize + 1;
		$_tag1 = 1;
		$_tag2 = 6;
		
		include('view/admin_news_manage.php');
	}
	
	private function show_add_news()
	{
		System::set_back_url('?m=news&a=manage');
		$_language_user = System::get_user_language();
		$_language = System::get_language_name();
		$_tag1 = 1;
		$_tag2 = 6;
		include('view/admin_news_add.php');
	}
	
	private function add_news()
	{
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$pubtime = isset($_POST['pubtime']) ? $_POST['pubtime'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$image = isset($_POST['list_image']) ? $_POST['list_image'] : '';
		$recommend_image = isset($_POST['recommend_image']) ? $_POST['recommend_image'] : '';
		$news_from = isset($_POST['news_from']) ? $_POST['news_from'] : '';
		$profile = isset($_POST['profile']) ? $_POST['profile'] : '';
		$this->news->add_news($title, $keywords, $description, $content, $pubtime, $image, $recommend_image, $news_from, $profile);
		System::echo_data(0, '发布成功！');
	}
	
	private function show_modify_news()
	{
		$news_id = isset($_GET['id']) ? $_GET['id'] : 0;
		System::set_back_url('?m=news&a=manage');
		$_language_user = System::get_user_language();
		$this->news->set_modify_news_id($news_id);
		$_news = $this->news->get_admin_news_by_id($news_id);
		$_language = System::get_language_name();
		$_tag1 = 1;
		$_tag2 = 6;
		include('view/admin_news_modify.php');
	}
	
	private function modify_news()
	{
		$id = (int)$this->news->get_modify_news_id();
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$pubtime = isset($_POST['pubtime']) ? $_POST['pubtime'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$image = isset($_POST['list_image']) ? $_POST['list_image'] : '';
		$recommend_image = isset($_POST['recommend_image']) ? $_POST['recommend_image'] : '';
		$news_from = isset($_POST['news_from']) ? $_POST['news_from'] : '';
		$profile = isset($_POST['profile']) ? $_POST['profile'] : '';
		$this->news->modify_news($id, $title, $keywords, $description, $content, $pubtime, $image, $recommend_image, $news_from, $profile);
		System::echo_data(0, '修改成功！');
	}
	
	private function delete_news()
	{
		$news_id = isset($_GET['id']) ? $_GET['id'] : 0;
		$this->news->delete_news($news_id);
		$this->manage();
		Utils::show_message('删除成功！');
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function show_login()
	{
		include('view/admin_login.php');
	}
}

/**
 *	管理员
 */
class Admin
{
	private $db = null;//数据库
	private $tb_admin = '';//管理员表
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_admin = Config::$tb_admin;
	}
	
	/**
	 * 登录
	 */
	public function login($username, $password)
	{
		$this->db->connect();
		$password = Security::md5_multi($password, Config::$key);
		$sql_username = Security::sql_var($username);
		$this->db->query("SELECT * FROM $this->tb_admin WHERE username=$sql_username");
		$res = $this->db->get_row();
		
		if (null == $res)
		{
			return false;
		}
		else
		{
			if ($password == $res['password'])
			{
				$_SESSION[Config::$system_name . '_admin_userid'] = (int)$res['id'];
				$_SESSION[Config::$system_name . '_admin_username'] = $res['username'];
				$_SESSION[Config::$system_name . '_admin_password'] = $res['password'];
				$sql_id = Security::sql_var($this->get_userid());
				$sql_login_time = Security::sql_var(date('Y-m-d H:i:s'));
				$this->db->query("UPDATE $this->tb_admin SET login_time=$sql_login_time WHERE id=$sql_id");
				
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
	 * 检测密码是否正确
	 */
	public function check_password($password)
	{
		$src_password = $this->get_password();
		$password = Security::md5_multi($password, Config::$key);
		if ($password == $src_password)
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
		unset($_SESSION[Config::$system_name . '_admin_userid']);
		unset($_SESSION[Config::$system_name . '_admin_username']);
		unset($_SESSION[Config::$system_name . '_admin_password']);
	}
	
	/**
	 * 修改密码
	 */
	public function change_password($new_password)
	{
		$this->db->connect();
		$sql_id = Security::sql_var($this->get_userid());
		$new_password = Security::md5_multi($new_password, Config::$key);
		$sql_new_password = Security::sql_var($new_password);
		$this->db->query("UPDATE $this->tb_admin SET password=$sql_new_password WHERE id=$sql_id");
	}
	
	/**
	 * 获取用户编号
	 */
	public function get_userid()
	{
		return isset($_SESSION[Config::$system_name . '_admin_userid']) ? (int)$_SESSION[Config::$system_name . '_admin_userid'] : 0;
	}
	
	/**
	 * 获取用户名
	 */
	public function get_username()
	{
		return isset($_SESSION[Config::$system_name . '_admin_username']) ? $_SESSION[Config::$system_name . '_admin_username'] : '';
	}
	
	/**
	 * 获取密码
	 */
	public function get_password()
	{
		return isset($_SESSION[Config::$system_name . '_admin_password']) ? $_SESSION[Config::$system_name . '_admin_password'] : '';
	}
}

/**
 * 配置信息
 */
class Config
{
	public static $debug_enabled = true;//调试开关
	public static $is_cn = true;//是否国内版
	public static $log_enabled = true;//日志记录开关
	
	public static $system_name = 'p5_transsion';//系统名称
	public static $key = '3sadff.,.,.,j.x3sd,f343ffff..,.,fff.,bc';//密钥
	public static $version = '2014.3.19_17.24';//版本号
	
	public static $url = '';//当前网址，线上或本地
	public static $url_online = 'http://www.transsion.com';//线上网址
	public static $url_local = 'http://';//本地网址
	
	public static $url_tecno = 'http://www.tecno-mobile.com';//tecno官网
	public static $url_itel = 'http://www.itel-mobile.com';//itel官网
	public static $url_infinix = 'http://www.infinixmobility.com';//infinix官网
	public static $url_carlcare = 'http://www.carlcare.com';//carlcare官网
	public static $url_iflux = 'http://www.ifluxlighting.com';//iflux官网
	
	public static $dir_log = 'log/';//日志目录
	public static $dir_lock = 'lock/';//锁定文件目录
	public static $dir_dbbackup = 'dbbackup/';//数据库备份目录
	
	public static $tb_admin = 'transsion_admin';//管理员表
	
	public static $tb_index = 'transsion_index';//首页表
	public static $tb_news = 'transsion_news';//新闻表
	public static $tb_job = 'transsion_job';//招聘表
	public static $tb_info = 'transsion_info';//基本信息表
	public static $tb_type = 'transsion_type';//栏目表
	public static $tb_history = 'transsion_history';//发展历程表
	
	public static $tb_index_en = 'transsion_index_en';//首页表
	public static $tb_news_en = 'transsion_news_en';//新闻表
	public static $tb_job_en = 'transsion_job_en';//招聘表
	public static $tb_info_en = 'transsion_info_en';//基本信息表
	public static $tb_type_en = 'transsion_type_en';//栏目表
	public static $tb_history_en = 'transsion_history_en';//发展历程表
	
	public static $admin_news_pagesize = 30;//管理员每页显示新闻条数
	public static $admin_job_pagesize = 30;//管理员每页显示招聘条数
	public static $reload_news_count = 6;//每次加载的新闻条数
	
	public static $language_cn = 'cn';
	public static $language_en = 'en';
	
	public static $info_detail = array
	(
		'11' => array('cn' => '关于我们', 'en' => 'About Us', 'link' => 'about-us'),
		'12' => array('cn' => '企业简介', 'en' => 'Company Profile', 'link' => 'company-profile'),
		'13' => array('cn' => '发展历程', 'en' => 'History', 'link' => 'history'),
		'14' => array('cn' => '公司使命', 'en' => 'Mission', 'link' => 'mission'),
		'15' => array('cn' => '发展愿景', 'en' => 'Vision', 'link' => 'vision'),
		'16' => array('cn' => '最新消息', 'en' => 'Latest News', 'link' => 'latest-news'),
		
		'21' => array('cn' => '品牌管理', 'en' => 'Brands', 'link' => 'brands'),
		'22' => array('cn' => 'TECNO', 'en' => 'TECNO', 'link' => 'tecno'),
		'23' => array('cn' => 'itel', 'en' => 'itel', 'link' => 'itel'),
		'24' => array('cn' => 'Carlcare', 'en' => 'Carlcare', 'link' => 'carlcare'),
		'25' => array('cn' => '业务区域', 'en' => 'Business Segments', 'link' => 'business-segments'),
		'26' => array('cn' => '品牌保护', 'en' => 'Brand Protection', 'link' => 'brand-protection'),
		'27' => array('cn' => 'Infinix', 'en' => 'Infinix', 'link' => 'infinix'),
		'28' => array('cn' => 'iFLUX', 'en' => 'iFLUX', 'link' => 'iflux'),
		
		'31' => array('cn' => '运营体系', 'en' => 'Operating System', 'link' => 'operating-system'),
		'32' => array('cn' => '研究开发', 'en' => 'Research & Development', 'link' => 'research-development'),
		'33' => array('cn' => '供应链管理', 'en' => 'Supply Chain Management', 'link' => 'supply-chain'),
		'34' => array('cn' => '成为供应商', 'en' => 'Apply to Be a Supplier', 'link' => 'apply-supplier'),
		'35' => array('cn' => '生产制造', 'en' => 'Production', 'link' => 'production'),
		'36' => array('cn' => '质量体系', 'en' => 'Quality System', 'link' => 'quality-system'),
		'37' => array('cn' => '市场营销', 'en' => 'Marketing', 'link' => 'marketing'),
		'38' => array('cn' => '客户服务', 'en' => 'Customer Service', 'link' => 'customer-service'),
		
		'41' => array('cn' => '加入传音', 'en' => 'Careers', 'link' => 'careers'),
		'42' => array('cn' => '核心价值观', 'en' => 'Core Value', 'link' => 'core-value'),
		'43' => array('cn' => '经营理念', 'en' => 'Business Philosophy', 'link' => 'business-philosophy'),
		'44' => array('cn' => '海外生活', 'en' => 'Life Abroad', 'link' => 'gallery'),
		'46' => array('cn' => '职业发展', 'en' => 'Career Development', 'link' => 'career-development'),
		'47' => array('cn' => '员工风采', 'en' => 'Our People', 'link' => 'brain-gain'),
		'48' => array('cn' => '薪资福利', 'en' => 'Pay and Benefits', 'link' => 'pay-benefits'),
		//'49' => array('cn' => '职位申请', 'en' => 'Job Offers', 'link' => 'job-offers'),
		'45' => array('cn' => '社会招聘', 'en' => 'Social Recruitment', 'link' => 'social-recruitment'),
		'49' => array('cn' => '校园招聘', 'en' => 'Campus Recruitment', 'link' => 'campus-recruitment'),
		'141' => array('cn' => '海外招聘', 'en' => 'Overseas recruitment', 'link' => 'overseas-recruitment'),
		
		'51' => array('cn' => '社会责任', 'en' => 'Responsibility', 'link' => 'responsibility'),
		'52' => array('cn' => '本地支持', 'en' => 'Local Support', 'link' => 'local-support'),
		'53' => array('cn' => '慈善公益', 'en' => 'Charity & Public Welfare', 'link' => 'charity'),
		'54' => array('cn' => '人才培养', 'en' => 'Professional Training', 'link' => 'professional-training')
	);
	
	public static $job_type = array
	(
		array('id' => '1', 'cn' => '销售类', 'en' => 'Sales'),
		array('id' => '2', 'cn' => '市场类', 'en' => 'Marketing'),
		array('id' => '3', 'cn' => '文职类', 'en' => 'Secretarial'),
		array('id' => '4', 'cn' => 'IT类', 'en' => 'IT'),
		array('id' => '5', 'cn' => '物流类', 'en' => 'Logistics'),
		array('id' => '6', 'cn' => '质量类', 'en' => 'Quality'),
		array('id' => '7', 'cn' => '设计类', 'en' => 'Design'),
		array('id' => '8', 'cn' => '研发类', 'en' => 'Development')
	);
	
	public static $campus_type_x = array
	(
		array('id' => '31', 'cn' => 'Infinix办事处', 'en' => 'temp1'),
		array('id' => '32', 'cn' => 'Infinix事业部', 'en' => 'temp2'),
		array('id' => '33', 'cn' => 'itel办事处', 'en' => 'temp3'),
		array('id' => '34', 'cn' => 'TECNO办事处', 'en' => 'temp4'),
		array('id' => '35', 'cn' => 'TECNO事业部', 'en' => 'temp5'),
		array('id' => '36', 'cn' => '研发中心', 'en' => 'temp6'),
		array('id' => '37', 'cn' => '制造管理部', 'en' => 'temp7'),
		array('id' => '38', 'cn' => '数字营销部', 'en' => 'temp8'),
		array('id' => '39', 'cn' => '账务管理部', 'en' => 'temp9'),
		array('id' => '40', 'cn' => '人力资源部', 'en' => 'temp10'),
		array('id' => '41', 'cn' => '3C-HUB', 'en' => 'temp11'),
		array('id' => '42', 'cn' => '客服中心', 'en' => 'temp12'),
		array('id' => '43', 'cn' => '商务物流部', 'en' => 'temp13'),
		array('id' => '44', 'cn' => '移动互联', 'en' => 'temp14'),
		array('id' => '45', 'cn' => '信息管理部', 'en' => 'temp15'),
		
		array('id' => '17', 'cn' => '海外事业部', 'en' => 'Overseas'),
		array('id' => '8', 'cn' => '产品研发', 'en' => 'Products'),
		array('id' => '9', 'cn' => '质量管理', 'en' => 'Quality'),
		array('id' => '10', 'cn' => '制造管理', 'en' => 'Manufacturing'),
		array('id' => '11', 'cn' => '采购物控', 'en' => 'Purchase'),
		array('id' => '12', 'cn' => '市场与品牌', 'en' => 'Marketing'),
		array('id' => '13', 'cn' => '销售', 'en' => 'Sales'),
		array('id' => '14', 'cn' => '财务审计', 'en' => 'Financial'),
		array('id' => '15', 'cn' => '综合管理', 'en' => 'Comprehensive'),
		array('id' => '16', 'cn' => 'IT', 'en' => 'IT')
	);
	
	public static $campus_type = array
	(
		array('id' => '51', 'cn' => '海外', 'en' => 'Overseas'),
		array('id' => '52', 'cn' => '深圳', 'en' => 'Shen Zhen'),
		array('id' => '53', 'cn' => '上海', 'en' => 'Shang Hai')
	);
	
	public static $overseas_type = array
	(
		array('id' => '21', 'cn' => 'TECNO/Infinix/itel事业部', 'en' => 'Business'),
		array('id' => '22', 'cn' => '运营商事业部', 'en' => 'Operator'),
		array('id' => '23', 'cn' => '客户服务中心', 'en' => 'Carlcare Service Centre'),
		array('id' => '24', 'cn' => 'Infinix事业部', 'en' => 'Infinix Business'),
		array('id' => '25', 'cn' => '质量管理部', 'en' => 'Quality Management'),
		array('id' => '26', 'cn' => '3C-HUB', 'en' => '3C Hub Business'),
		array('id' => '27', 'cn' => '品牌管理部', 'en' => 'Brand Management'),
		array('id' => '28', 'cn' => '平台管理部', 'en' => 'Platform Management')
	);
	
	public static $db_config = null;//数据库配置信息，线上或本地
	
	//本地数据库配置信息
	private static $db_local = array
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
	
	//国内服务器
	//线上数据库配置信息
	private static $db_cn = array
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
	
	//爱尔兰服务器2
	//线上数据库配置信息
	private static $db_ireland = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => ',//密码
		'db_name' => '',//数据库名
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
		//设置中国时区，开启session
		if (self::$debug_enabled)
		{
			@error_reporting(E_ALL);
			self::$url = self::$url_local;
			self::$db_config = self::$db_local;
		}
		else
		{
			@error_reporting(0);
			self::$url = self::$url_online;
			if (self::$is_cn)
			{
				self::$db_config = self::$db_cn;
			}
			else
			{
				self::$db_config = self::$db_ireland;
			}
		}
		@date_default_timezone_set('PRC');
		@session_start();
		
		//限制视图文件须由控制器调用才可执行
		//初始化调试状态
		define('VIEW', true);
		Debug::$log_enabled = self::$log_enabled;
		Debug::$log_file = self::$dir_log . date('Y-m-d') . '.php';
	}
}

/**
 *	信息
 */
class Info
{
	private $db = null;//数据库
	private $tb_index = '';
	private $tb_index_en = '';
	private $tb_info = '';
	private $tb_info_en = '';
	private $tb_history = '';//发展历程表
	private $tb_history_en = '';//发展历程表
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_index = Config::$tb_index;
		$this->tb_index_en = Config::$tb_index_en;
		$this->tb_info = Config::$tb_info;
		$this->tb_info_en = Config::$tb_info_en;
		$this->tb_history = Config::$tb_history;
		$this->tb_history_en = Config::$tb_history_en;
	}
	
	public function get_index_setting()
	{
		$this->db->connect();
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_index");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_index_en");
				break;
			default:
		}
		$res = $this->db->get_row();
		
		return $res;
	}
	
	public function modify_index_setting($title, $keywords, $description, $about_image, $about_text, $brands_image, $brands_text, $operating_image, $operating_text, $careers_image, $careers_text, $responsibility_image, $responsibility_text, $banner_image1, $banner_link1, $banner_image2, $banner_link2, $banner_image3, $banner_link3, $banner_image4, $banner_link4, $supplier_image, $supplier_text, $supplier_link, $join_image, $join_text, $join_link)
	{
		$this->db->connect();
		$sql_title = Security::sql_var($title);
		$sql_keywords = Security::sql_var($keywords);
		$sql_description = Security::sql_var($description);
		$sql_about_image = Security::sql_var($about_image);
		$sql_about_text = Security::sql_var($about_text);
		$sql_brands_image = Security::sql_var($brands_image);
		$sql_brands_text = Security::sql_var($brands_text);
		$sql_operating_image = Security::sql_var($operating_image);
		$sql_operating_text = Security::sql_var($operating_text);
		$sql_careers_image = Security::sql_var($careers_image);
		$sql_careers_text = Security::sql_var($careers_text);
		$sql_responsibility_image = Security::sql_var($responsibility_image);
		$sql_responsibility_text = Security::sql_var($responsibility_text);
		$sql_banner_image1 = Security::sql_var($banner_image1);
		$sql_banner_link1 = Security::sql_var($banner_link1);
		$sql_banner_image2 = Security::sql_var($banner_image2);
		$sql_banner_link2 = Security::sql_var($banner_link2);
		$sql_banner_image3 = Security::sql_var($banner_image3);
		$sql_banner_link3 = Security::sql_var($banner_link3);
		$sql_banner_image4 = Security::sql_var($banner_image4);
		$sql_banner_link4 = Security::sql_var($banner_link4);
		$sql_supplier_image = Security::sql_var($supplier_image);
		$sql_supplier_text = Security::sql_var($supplier_text);
		$sql_supplier_link = Security::sql_var($supplier_link);
		$sql_join_image = Security::sql_var($join_image);
		$sql_join_text = Security::sql_var($join_text);
		$sql_join_link = Security::sql_var($join_link);
		
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("UPDATE $this->tb_index SET
					title=$sql_title, 
					keywords=$sql_keywords, 
					description=$sql_description, 
					about_image=$sql_about_image, 
					about_text=$sql_about_text, 
					brands_image=$sql_brands_image, 
					brands_text=$sql_brands_text, 
					operating_image=$sql_operating_image, 
					operating_text=$sql_operating_text, 
					careers_image=$sql_careers_image, 
					careers_text=$sql_careers_text, 
					responsibility_image=$sql_responsibility_image, 
					responsibility_text=$sql_responsibility_text, 
					banner_image1=$sql_banner_image1, 
					banner_link1=$sql_banner_link1, 
					banner_image2=$sql_banner_image2, 
					banner_link2=$sql_banner_link2, 
					banner_image3=$sql_banner_image3, 
					banner_link3=$sql_banner_link3, 
					banner_image4=$sql_banner_image4, 
					banner_link4=$sql_banner_link4,
					supplier_image=$sql_supplier_image, 
					supplier_text=$sql_supplier_text, 
					supplier_link=$sql_supplier_link,
					join_image=$sql_join_image, 
					join_text=$sql_join_text, 
					join_link=$sql_join_link");
				break;
			case Config::$language_en:
				$this->db->query("UPDATE $this->tb_index_en SET
					title=$sql_title, 
					keywords=$sql_keywords, 
					description=$sql_description, 
					about_image=$sql_about_image, 
					about_text=$sql_about_text, 
					brands_image=$sql_brands_image, 
					brands_text=$sql_brands_text, 
					operating_image=$sql_operating_image, 
					operating_text=$sql_operating_text, 
					careers_image=$sql_careers_image, 
					careers_text=$sql_careers_text, 
					responsibility_image=$sql_responsibility_image, 
					responsibility_text=$sql_responsibility_text, 
					banner_image1=$sql_banner_image1, 
					banner_link1=$sql_banner_link1, 
					banner_image2=$sql_banner_image2, 
					banner_link2=$sql_banner_link2, 
					banner_image3=$sql_banner_image3, 
					banner_link3=$sql_banner_link3, 
					banner_image4=$sql_banner_image4, 
					banner_link4=$sql_banner_link4,
					supplier_image=$sql_supplier_image, 
					supplier_text=$sql_supplier_text, 
					supplier_link=$sql_supplier_link,
					join_image=$sql_join_image, 
					join_text=$sql_join_text, 
					join_link=$sql_join_link");
				break;
			default:
		}
	}
	
	public function get_info($id)
	{
		$this->db->connect();
		$sql_id = (int)$id;
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_info WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_info_en WHERE id=$sql_id");
				break;
			default:
		}
		$res = $this->db->get_row();
		
		return $res;
	}
	
	public function modify_info($id, $title, $keywords, $description, $banner_image, $menu_name, $menu_image, $content)
	{
		$this->db->connect();
		$sql_id =(int)$id;
		$sql_title = Security::sql_var($title);
		$sql_keywords = Security::sql_var($keywords);
		$sql_description = Security::sql_var($description);
		$sql_banner_image = Security::sql_var($banner_image);
		$sql_menu_name = Security::sql_var($menu_name);
		$sql_menu_image = Security::sql_var($menu_image);
		$sql_content = Security::sql_var($content);
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("UPDATE $this->tb_info SET title=$sql_title, keywords=$sql_keywords, description=$sql_description, banner_image=$sql_banner_image, menu_name=$sql_menu_name, menu_image=$sql_menu_image, content=$sql_content WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("UPDATE $this->tb_info_en SET title=$sql_title, keywords=$sql_keywords, description=$sql_description, banner_image=$sql_banner_image, menu_name=$sql_menu_name, menu_image=$sql_menu_image, content=$sql_content WHERE id=$sql_id");
				break;
			default:
		}
	}
	
	public function modify_info2($id, $title, $keywords, $description, $banner_image, $menu_name, $menu_image, $content, $content2)
	{
		$this->db->connect();
		$sql_id =(int)$id;
		$sql_title = Security::sql_var($title);
		$sql_keywords = Security::sql_var($keywords);
		$sql_description = Security::sql_var($description);
		$sql_banner_image = Security::sql_var($banner_image);
		$sql_menu_name = Security::sql_var($menu_name);
		$sql_menu_image = Security::sql_var($menu_image);
		$sql_content = Security::sql_var($content);
		$sql_content2 = Security::sql_var($content2);
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("UPDATE $this->tb_info SET title=$sql_title, keywords=$sql_keywords, description=$sql_description, banner_image=$sql_banner_image, menu_name=$sql_menu_name, menu_image=$sql_menu_image, content=$sql_content, content2=$sql_content2 WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("UPDATE $this->tb_info_en SET title=$sql_title, keywords=$sql_keywords, description=$sql_description, banner_image=$sql_banner_image, menu_name=$sql_menu_name, menu_image=$sql_menu_image, content=$sql_content, content2=$sql_content2 WHERE id=$sql_id");
				break;
			default:
		}
	}
	
	/**
	 * 记录待修改的新闻id
	 */
	public function set_modify_info_id($id)
	{
		$_SESSION[Config::$system_name . '_admin_modify_info_id'] = $id;
	}
	
	/**
	 * 获取待修改的新闻id
	 */
	public function get_modify_info_id()
	{
		$id = isset($_SESSION[Config::$system_name . '_admin_modify_info_id']) ? $_SESSION[Config::$system_name . '_admin_modify_info_id'] : '';
		
		return $id;
	}
	
	public function get_menu_images($id)
	{
		$this->db->connect();
		$sql_id = (int)$id;
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT typeid FROM $this->tb_info WHERE id = $sql_id");
				$res = $this->db->get_row();
				if (!empty($res))
				{
					$sql_typeid = (int)$res['typeid'];
				}
				else
				{
					return null;
				}
				//$this->db->query("SELECT * FROM $this->tb_info WHERE typeid = $sql_typeid AND id != $sql_id AND menu_image != ''");
				$this->db->query("SELECT * FROM $this->tb_info WHERE typeid = $sql_typeid AND menu_image != ''");
				break;
			case Config::$language_en:
				$this->db->query("SELECT typeid FROM $this->tb_info_en WHERE id = $sql_id");
				$res = $this->db->get_row();
				if (!empty($res))
				{
					$sql_typeid = (int)$res['typeid'];
				}
				else
				{
					return null;
				}
				//$this->db->query("SELECT * FROM $this->tb_info_en WHERE typeid = $sql_typeid AND id != $sql_id AND menu_image != ''");
				$this->db->query("SELECT * FROM $this->tb_info_en WHERE typeid = $sql_typeid AND menu_image != ''");
				break;
			default:
		}
		$res = $this->db->get_all_rows();
		return $res;
	}
	
	public function get_menu_info($id, $language = 'cn')
	{
		$language = System::get_user_language();
		
		$main_name = '';
		$main_link = '';
		$sub_name = '';
		$sub_link = '';
		if (!empty(Config::$info_detail[$id]))
		{
			//$main_num = (int)((int)$id / 10) % 10;
			switch ($language)
			{
				case Config::$language_cn:
					$sql_id = (int)$id;
					$this->db->query("SELECT typeid FROM $this->tb_info WHERE id = $sql_id");
					$res = $this->db->get_row();
					if (!empty($res))
					{
						$main_num = (int)$res['typeid'];
					}
					else
					{
						return array('main_name' => '', 'main_link' => '', 'sub_name' => '', 'sub_link' => '');
					}
					
					$main_name = Config::$info_detail[$main_num . '1']['cn'];
					$main_link = '?tag=' . $main_num . '1';
					$sub_name = Config::$info_detail[$id]['cn'];
					$sub_link = '?tag=' . $id;
					if ((int)$id == 16)
					{
						$sub_link = '?m=news&a=show_news_list';
					}
					break;
				case Config::$language_en:
					$sql_id = (int)$id;
					$this->db->query("SELECT typeid FROM $this->tb_info_en WHERE id = $sql_id");
					$res = $this->db->get_row();
					if (!empty($res))
					{
						$main_num = (int)$res['typeid'];
					}
					else
					{
						return array('main_name' => '', 'main_link' => '', 'sub_name' => '', 'sub_link' => '');
					}
					
					$main_name = Config::$info_detail[$main_num . '1']['en'];
					$main_link = '?tag=' . $main_num . '1';
					$sub_name = Config::$info_detail[$id]['en'];
					$sub_link = '?tag=' . $id;
					if ((int)$id == 16)
					{
						$sub_link = '?m=news&a=show_news_list';
					}
					break;
				default:
			}
		}
		
		return array('main_name' => $main_name, 'main_link' => $main_link, 'sub_name' => $sub_name, 'sub_link' => $sub_link);
	}
	
	public function get_parent_menu($id, $language = 'cn')
	{
		$main_menu = array('11', '21', '31', '41', '51');
		if (in_array($id, $no_images))
		{
			$_image_tag = false;
		}
		else
		{
			$_image_tag = true;
		}
	}
	
	public function get_history()
	{
		$this->db->connect();
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_history ORDER BY year DESC");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_history_en ORDER BY year DESC");
				break;
			default:
		}
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	public function add_history($year, $description, $content)
	{
		$this->db->connect();
		$sql_year = Security::sql_var($year);
		$sql_description = Security::sql_var($description);
		$sql_content = Security::sql_var($content);
		
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("INSERT INTO $this->tb_history (year, description, content) VALUES ($sql_year, $sql_description, $sql_content)");
				$insert_id = $this->db->get_insert_id();
				break;
			case Config::$language_en:
				$this->db->query("INSERT INTO $this->tb_history_en (year, description, content) VALUES ($sql_year, $sql_description, $sql_content)");
				$insert_id = $this->db->get_insert_id();
				break;
			default:
		}
		
		return $insert_id;
	}
	
	public function modify_history($id, $year, $description, $content)
	{
		$this->db->connect();
		$sql_id =(int)$id;
		$sql_year = Security::sql_var($year);
		$sql_description = Security::sql_var($description);
		$sql_content = Security::sql_var($content);
		
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("UPDATE $this->tb_history SET year=$sql_year, description=$sql_description, content=$sql_content WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("UPDATE $this->tb_history_en SET year=$sql_year, description=$sql_description, content=$sql_content WHERE id=$sql_id");
				break;
			default:
		}
	}
	
	public function delete_history($id)
	{
		$this->db->connect();
		$sql_id =(int)$id;
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("DELETE FROM $this->tb_history WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("DELETE FROM $this->tb_history_en WHERE id=$sql_id");
				break;
			default:
		}
	}
	
	public function get_brand_link($tag)
	{
		switch ($tag)
		{
			case '22':
				return Config::$url_tecno;
				break;
			case '23':
				return Config::$url_itel;
				break;
			case '24':
				return Config::$url_carlcare;
				break;
			case '27':
				return Config::$url_infinix;
				break;
			case '28':
				return Config::$url_iflux;
				break;
			default:
				return '';
		}
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
	
	private $tb_admin = '';//管理员表
	
	private $tb_index = '';//首页表
	private $tb_news = '';//新闻表
	private $tb_job = '';//招聘表
	private $tb_info = '';//基本信息表
	private $tb_type = '';//栏目表
	private $tb_history = '';//发展历程表
	
	private $tb_index_en = '';//首页表
	private $tb_news_en = '';//新闻表
	private $tb_job_en = '';//招聘表
	private $tb_info_en = '';//基本信息表
	private $tb_type_en = '';//栏目表
	private $tb_history_en = '';//发展历程表
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->db_name = Config::$db_config['db_name'];
		$this->db_charset = Config::$db_config['db_charset'];
		$this->db_collat = Config::$db_config['db_collat'];
		
		$this->tb_admin = Config::$tb_admin;
		
		$this->tb_index = Config::$tb_index;
		$this->tb_news = Config::$tb_news;
		$this->tb_job = Config::$tb_job;
		$this->tb_info = Config::$tb_info;
		$this->tb_type = Config::$tb_type;
		$this->tb_history = Config::$tb_history;
		
		$this->tb_index_en = Config::$tb_index_en;
		$this->tb_news_en = Config::$tb_news_en;
		$this->tb_job_en = Config::$tb_job_en;
		$this->tb_info_en = Config::$tb_info_en;
		$this->tb_type_en = Config::$tb_type_en;
		$this->tb_history_en = Config::$tb_history_en;
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
		$this->db->query("DROP TABLE IF EXISTS $this->tb_admin");
		$this->db->query("CREATE TABLE $this->tb_admin (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			username VARCHAR( 50 ) NOT NULL ,
			password VARCHAR( 200 ) NOT NULL ,
			login_time DATETIME NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_index");
		$this->db->query("CREATE TABLE $this->tb_index (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			title VARCHAR( 200 ) NOT NULL ,
			keywords VARCHAR( 200 ) NOT NULL ,
			description VARCHAR( 200 ) NOT NULL ,
			about_image VARCHAR( 255 ) NOT NULL ,
			about_text VARCHAR( 200 ) NOT NULL ,
			brands_image VARCHAR( 255 ) NOT NULL ,
			brands_text VARCHAR( 200 ) NOT NULL ,
			operating_image VARCHAR( 255 ) NOT NULL ,
			operating_text VARCHAR( 200 ) NOT NULL ,
			careers_image VARCHAR( 255 ) NOT NULL ,
			careers_text VARCHAR( 200 ) NOT NULL ,
			responsibility_image VARCHAR( 255 ) NOT NULL ,
			responsibility_text VARCHAR( 200 ) NOT NULL ,
			banner_image1 VARCHAR( 255 ) NOT NULL ,
			banner_link1 VARCHAR( 255 ) NOT NULL ,
			banner_image2 VARCHAR( 255 ) NOT NULL ,
			banner_link2 VARCHAR( 255 ) NOT NULL ,
			banner_image3 VARCHAR( 255 ) NOT NULL ,
			banner_link3 VARCHAR( 255 ) NOT NULL ,
			banner_image4 VARCHAR( 255 ) NOT NULL ,
			banner_link4 VARCHAR( 255 ) NOT NULL ,
			supplier_image VARCHAR( 255 ) NOT NULL ,
			supplier_text VARCHAR( 200 ) NOT NULL ,
			supplier_link VARCHAR( 255 ) NOT NULL ,
			join_image VARCHAR( 255 ) NOT NULL ,
			join_text VARCHAR( 200 ) NOT NULL ,
			join_link VARCHAR( 255 ) NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_news");
		$this->db->query("CREATE TABLE $this->tb_news (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			title VARCHAR( 200 ) NOT NULL ,
			keywords VARCHAR( 200 ) NOT NULL ,
			description VARCHAR( 200 ) NOT NULL ,
			content TEXT NOT NULL ,
			typeid INT NOT NULL ,
			pubdate DATETIME NOT NULL ,
			link VARCHAR( 255 ) NOT NULL ,
			image VARCHAR( 255 ) NOT NULL ,
			recommend_image VARCHAR( 255 ) NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_job");
		$this->db->query("CREATE TABLE $this->tb_job (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			title VARCHAR( 200 ) NOT NULL ,
			keywords VARCHAR( 200 ) NOT NULL ,
			description VARCHAR( 200 ) NOT NULL ,
			content TEXT NOT NULL ,
			typeid INT NOT NULL ,
			pubdate DATETIME NOT NULL ,
			link VARCHAR( 255 ) NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_info");
		$this->db->query("CREATE TABLE $this->tb_info (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			title VARCHAR( 200 ) NOT NULL ,
			keywords VARCHAR( 200 ) NOT NULL ,
			description VARCHAR( 200 ) NOT NULL ,
			content TEXT NOT NULL ,
			typeid INT NOT NULL ,
			link VARCHAR( 255 ) NOT NULL ,
			menu_image VARCHAR( 255 ) NOT NULL ,
			menu_name VARCHAR( 255 ) NOT NULL ,
			banner_image VARCHAR( 255 ) NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_type");
		$this->db->query("CREATE TABLE $this->tb_type (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			typename VARCHAR( 200 ) NOT NULL ,
			fid INT NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_index_en");
		$this->db->query("CREATE TABLE $this->tb_index_en (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			title VARCHAR( 200 ) NOT NULL ,
			keywords VARCHAR( 200 ) NOT NULL ,
			description VARCHAR( 200 ) NOT NULL ,
			about_image VARCHAR( 255 ) NOT NULL ,
			about_text VARCHAR( 200 ) NOT NULL ,
			brands_image VARCHAR( 255 ) NOT NULL ,
			brands_text VARCHAR( 200 ) NOT NULL ,
			operating_image VARCHAR( 255 ) NOT NULL ,
			operating_text VARCHAR( 200 ) NOT NULL ,
			careers_image VARCHAR( 255 ) NOT NULL ,
			careers_text VARCHAR( 200 ) NOT NULL ,
			responsibility_image VARCHAR( 255 ) NOT NULL ,
			responsibility_text VARCHAR( 200 ) NOT NULL ,
			banner_image1 VARCHAR( 255 ) NOT NULL ,
			banner_link1 VARCHAR( 255 ) NOT NULL ,
			banner_image2 VARCHAR( 255 ) NOT NULL ,
			banner_link2 VARCHAR( 255 ) NOT NULL ,
			banner_image3 VARCHAR( 255 ) NOT NULL ,
			banner_link3 VARCHAR( 255 ) NOT NULL ,
			banner_image4 VARCHAR( 255 ) NOT NULL ,
			banner_link4 VARCHAR( 255 ) NOT NULL ,
			supplier_icon VARCHAR( 255 ) NOT NULL ,
			supplier_title VARCHAR( 200 ) NOT NULL ,
			supplier_image VARCHAR( 255 ) NOT NULL ,
			supplier_text VARCHAR( 200 ) NOT NULL ,
			supplier_link VARCHAR( 255 ) NOT NULL ,
			join_icon VARCHAR( 255 ) NOT NULL ,
			join_title VARCHAR( 200 ) NOT NULL ,
			join_image VARCHAR( 255 ) NOT NULL ,
			join_text VARCHAR( 200 ) NOT NULL ,
			join_link VARCHAR( 255 ) NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_news_en");
		$this->db->query("CREATE TABLE $this->tb_news_en (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			title VARCHAR( 200 ) NOT NULL ,
			keywords VARCHAR( 200 ) NOT NULL ,
			description VARCHAR( 200 ) NOT NULL ,
			content TEXT NOT NULL ,
			typeid INT NOT NULL ,
			pubdate DATETIME NOT NULL ,
			link VARCHAR( 255 ) NOT NULL ,
			image VARCHAR( 255 ) NOT NULL ,
			recommend_image VARCHAR( 255 ) NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_job_en");
		$this->db->query("CREATE TABLE $this->tb_job_en (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			title VARCHAR( 200 ) NOT NULL ,
			keywords VARCHAR( 200 ) NOT NULL ,
			description VARCHAR( 200 ) NOT NULL ,
			content TEXT NOT NULL ,
			typeid INT NOT NULL ,
			pubdate DATETIME NOT NULL ,
			link VARCHAR( 255 ) NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_info_en");
		$this->db->query("CREATE TABLE $this->tb_info_en (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			title VARCHAR( 200 ) NOT NULL ,
			keywords VARCHAR( 200 ) NOT NULL ,
			description VARCHAR( 200 ) NOT NULL ,
			content TEXT NOT NULL ,
			typeid INT NOT NULL ,
			link VARCHAR( 255 ) NOT NULL ,
			menu_image VARCHAR( 255 ) NOT NULL ,
			menu_name VARCHAR( 255 ) NOT NULL ,
			banner_image VARCHAR( 255 ) NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_type_en");
		$this->db->query("CREATE TABLE $this->tb_type_en (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			typename VARCHAR( 200 ) NOT NULL ,
			fid INT NOT NULL
		) ENGINE = InnoDB CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		$this->db->connect();
		$password = 'fbffbgdcbhc0035da846225ca132f3f193d77edde8aebbeddabddfbhgfahfd';
		$sql_login_time = Security::sql_var(date('Y-m-d H:i:s'));
		$this->db->query("INSERT INTO $this->tb_admin (username, password, login_time) VALUES ('admin', '$password', $sql_login_time)");
		
		for ($i = 11; $i <= 16; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['cn']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image) VALUES ($i, '', '', '', '', 1, $link, '/images/contact_3.jpg', $menu_name, '/images/aboutUs_banner.jpg')");
		}
		for ($i = 21; $i <= 26; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['cn']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image) VALUES ($i, '', '', '', '', 2, $link, '/images/contact_3.jpg', $menu_name, '/images/aboutUs_banner.jpg')");
		}
		for ($i = 31; $i <= 38; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['cn']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image) VALUES ($i, '', '', '', '', 3, $link, '/images/contact_3.jpg', $menu_name, '/images/aboutUs_banner.jpg')");
		}
		for ($i = 41; $i <= 49; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['cn']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image) VALUES ($i, '', '', '', '', 4, $link, '/images/contact_3.jpg', $menu_name, '/images/aboutUs_banner.jpg')");
		}
		for ($i = 51; $i <= 54; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['cn']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image) VALUES ($i, '', '', '', '', 5, $link, '/images/contact_3.jpg', $menu_name, '/images/aboutUs_banner.jpg')");
		}
		$this->db->query("UPDATE $this->tb_info SET menu_image='', menu_name='' WHERE id='11' OR id='21' OR id='31' OR id='41' OR id='51'");
		$this->db->query("UPDATE $this->tb_info SET link='?m=news&a=show_news_list' WHERE id='16'");
		
		for ($i = 11; $i <= 16; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['en']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info_en (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image) VALUES ($i, '', '', '', '', 1, $link, '/images/contact_3.jpg', $menu_name, '/images/aboutUs_banner.jpg')");
		}
		for ($i = 21; $i <= 26; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['en']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info_en (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image) VALUES ($i, '', '', '', '', 2, $link, '/images/contact_3.jpg', $menu_name, '/images/aboutUs_banner.jpg')");
		}
		for ($i = 31; $i <= 38; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['en']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info_en (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image) VALUES ($i, '', '', '', '', 3, $link, '/images/contact_3.jpg', $menu_name, '/images/aboutUs_banner.jpg')");
		}
		for ($i = 41; $i <= 49; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['en']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info_en (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image) VALUES ($i, '', '', '', '', 4, $link, '/images/contact_3.jpg', $menu_name, '/images/aboutUs_banner.jpg')");
		}
		for ($i = 51; $i <= 54; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['en']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info_en (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image) VALUES ($i, '', '', '', '', 5, $link, '/images/contact_3.jpg', $menu_name, '/images/aboutUs_banner.jpg')");
		}
		$this->db->query("UPDATE $this->tb_info_en SET menu_image='', menu_name='' WHERE id='11' OR id='21' OR id='31' OR id='41' OR id='51'");
		$this->db->query("UPDATE $this->tb_info_en SET link='?m=news&a=show_news_list' WHERE id='16'");
		
		$this->db->query("INSERT INTO $this->tb_index (title, keywords, description, about_image, about_text, brands_image, brands_text, operating_image, operating_text, careers_image, careers_text, responsibility_image, responsibility_text, banner_image1, banner_link1, banner_image2, banner_link2, banner_image3, banner_link3, banner_image4, banner_link4, supplier_image, supplier_text, supplier_link, join_image, join_text, join_link) VALUES ('传音科技', '传音科技, Tecno手机', '传音很牛逼！', '/images/aboutus_voice.jpg', 'TECNO GROUP LIMITED,<br>established in July 2006,', '/images/4.png', 'About GROUP LIMITED,<br>established in July 2006,', '/images/2.png', 'About GROUP LIMITED,<br>established in July 2006,', '/images/5.png', 'About GROUP LIMITED,<br>established in July 2006,', '/images/6.png', 'About GROUP LIMITED,<br>established in July 2006,', '/images/home_banner_1.jpg', '#', '/images/home_banner_2.jpg', '#', '/images/home_banner_3.jpg', '#', '/images/home_banner_4.jpg', '#', '/images/to_be_sup.jpg', 'SOMETHING GOOD WE HAVE DONE.', '#', '/images/join_us.jpg', 'SOMETHING GOOD WE HAVE DONE.', '#')");
		$this->db->query("INSERT INTO $this->tb_index_en (title, keywords, description, about_image, about_text, brands_image, brands_text, operating_image, operating_text, careers_image, careers_text, responsibility_image, responsibility_text, banner_image1, banner_link1, banner_image2, banner_link2, banner_image3, banner_link3, banner_image4, banner_link4, supplier_image, supplier_text, supplier_link, join_image, join_text, join_link) VALUES ('传音科技', '传音科技, Tecno手机', '传音很牛逼！', '/images/aboutus_voice.jpg', 'TECNO GROUP LIMITED,<br>established in July 2006,', '/images/4.png', 'About GROUP LIMITED,<br>established in July 2006,', '/images/2.png', 'About GROUP LIMITED,<br>established in July 2006,', '/images/5.png', 'About GROUP LIMITED,<br>established in July 2006,', '/images/6.png', 'About GROUP LIMITED,<br>established in July 2006,', '/images/home_banner_1.jpg', '#', '/images/home_banner_2.jpg', '#', '/images/home_banner_3.jpg', '#', '/images/home_banner_4.jpg', '#', '/images/to_be_sup.jpg', 'SOMETHING GOOD WE HAVE DONE.', '#', '/images/join_us.jpg', 'SOMETHING GOOD WE HAVE DONE.', '#')");
		
		for ($i = 0; $i < 15; $i++)
		{
			$this->db->query("INSERT INTO $this->tb_news (title, keywords, description, content, typeid, pubdate, link, image, recommend_image) VALUES ('IF YOU WANT TO BUY A TECNO SMART-PHONE.', '', '', 'After observing the trends with TECNO smartphones in the market, I gained a fairly good grasp of their life cycles. I remember a few weeks after the launch of the TECNO Phantom A...', 0, '2014-3-18', '13981304599949.php', '/images/news_1.jpg', '/uploads/images/news_03.jpg')");
			
			$this->db->query("INSERT INTO $this->tb_news_en (title, keywords, description, content, typeid, pubdate, link, image, recommend_image) VALUES ('IF YOU WANT TO BUY A TECNO SMART-PHONE.', '', '', 'After observing the trends with TECNO smartphones in the market, I gained a fairly good grasp of their life cycles. I remember a few weeks after the launch of the TECNO Phantom A...', 0, '2014-3-18', '13981304599949.php', '/images/news_1.jpg', '/uploads/images/news_03.jpg')");
		}
	}
	
	/**
	 * 获取所有的表名
	 */
	public function get_all_tables()
	{
		$res = array();
		$res[] = $this->tb_admin;
		$res[] = $this->tb_index;
		$res[] = $this->tb_news;
		$res[] = $this->tb_job;
		$res[] = $this->tb_info;
		$res[] = $this->tb_type;
		$res[] = $this->tb_history;
		
		$res[] = $this->tb_index_en;
		$res[] = $this->tb_news_en;
		$res[] = $this->tb_job_en;
		$res[] = $this->tb_info_en;
		$res[] = $this->tb_type_en;
		$res[] = $this->tb_history_en;
		
		return $res;
	}
	
	/**
	 * 获取所有的表名
	 */
	public function get_job_table()
	{
		$res = array();
		$res[] = $this->tb_job;
		$res[] = $this->tb_job_en;
		
		return $res;
	}
	
	/**
	 * 获取所有的表名
	 */
	public function get_info_table()
	{
		$res = array();
		$res[] = $this->tb_info;
		$res[] = $this->tb_info_en;
		
		return $res;
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
		$db = new Dbbak(Config::$db_config['hostname'], Config::$db_config['username'], Config::$db_config['password'], Config::$db_config['db_name'], Config::$db_config['db_charset'], Config::$dir_dbbackup);
		$tableArray = $db->getTables();
		$db->exportSql($tableArray);
	}
	
	/**
	 * 恢复数据库
	 */
	public function recover()
	{
		$db = new Dbbak(Config::$db_config['hostname'], Config::$db_config['username'], Config::$db_config['password'], Config::$db_config['db_name'], Config::$db_config['db_charset'], Config::$dir_dbbackup);
		$db->importSql();
	}
	
	public function db_select()
	{
		echo '<meta charset="utf-8"/>';
		$this->db->connect();
		$this->db->query("SELECT * FROM $this->tb_info where id=45");
		$res = $this->db->get_all_rows();
		print_r($res);
		
		echo '<br /><br />';
		
		$this->db->query("SELECT * FROM $this->tb_info_en where id=45");
		$res = $this->db->get_all_rows();
		print_r($res);
		
		echo '<br /><br />';
		
		$this->db->query("SELECT * FROM $this->tb_info where id=49");
		$res = $this->db->get_all_rows();
		print_r($res);
		
		echo '<br /><br />';
		
		$this->db->query("SELECT * FROM $this->tb_info_en where id=49");
		$res = $this->db->get_all_rows();
		print_r($res);
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		$this->db->connect();
		for ($i = 28; $i <= 28; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['cn']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image, content2) VALUES ($i, '', '', '', '', 2, $link, '/images/t1.jpg', $menu_name, '/images/t2.jpg', '')");
		}
		for ($i = 28; $i <= 28; $i++)
		{
			$menu_name = Security::sql_var(Config::$info_detail['' . $i]['en']);
			$link = Security::sql_var('?tag=' . $i);
			$this->db->query("INSERT INTO $this->tb_info_en (id, title, keywords, description, content, typeid, link, menu_image, menu_name, banner_image, content2) VALUES ($i, '', '', '', '', 2, $link, '/images/e1.jpg', $menu_name, '/images/e2.jpg', '')");
		}
	}
}

/**
 *	招聘
 */
class Job
{
	private $db = null;//数据库
	private $tb_job = '';//新闻表名
	private $tb_job_en = '';//新闻表名
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_job = Config::$tb_job;
		$this->tb_job_en = Config::$tb_job_en;
	}
	
	public function get_job_count($jobtype = 'social')
	{
		$this->db->connect();
		$sql_jobtype = Security::sql_var($jobtype);
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_job WHERE jobtype=$sql_jobtype");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_job_en WHERE jobtype=$sql_jobtype");
				break;
			default:
		}
		$count = $this->db->get_num_rows();
		
		return $count;
	}
	
	public function get_job()
	{
		$this->db->connect();
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_job ORDER BY typename, pubdate DESC");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_job_en ORDER BY typename, pubdate DESC");
				break;
			default:
		}
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	/**
	 * 获取新闻
	 */
	public function get_job_page($from, $n = 10, $jobtype = 'social')
	{
		$this->db->connect();
		$sql_jobtype = Security::sql_var($jobtype);
		$from = (int)$from;
		if ($from < 0)
		{
			$from = 0;
		}
		$n = (int)$n;
		if ($n < 0)
		{
			$n = 0;
		}
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_job WHERE jobtype=$sql_jobtype ORDER BY typename, pubdate DESC LIMIT $from, $n");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_job_en WHERE jobtype=$sql_jobtype ORDER BY typename, pubdate DESC LIMIT $from, $n");
				break;
			default:
		}
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	public function get_job_by_type($jobtype = 'social')
	{
		$this->db->connect();
		$sql_jobtype = Security::sql_var($jobtype);
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_job WHERE jobtype=$sql_jobtype ORDER BY typename, pubdate DESC");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_job_en WHERE jobtype=$sql_jobtype ORDER BY typename, pubdate DESC");
				break;
			default:
		}
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	/**
	 * 获取新闻
	 */
	public function get_job_by_id($id)
	{
		$this->db->connect();
		$sql_id = (int)$id;
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_job WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_job_en WHERE id=$sql_id");
				break;
			default:
		}
		$res = $this->db->get_row();
		
		return $res;
	}
	
	/**
	 * 添加新闻
	 */
	public function add_job($title, $typename, $pubtime, $content, $jobtype = 'social')
	{
		$this->db->connect();
		$sql_jobtype = Security::sql_var($jobtype);
		$sql_title = Security::sql_var($title);
		$sql_typename = Security::sql_var($typename);
		$sql_content = Security::sql_var($content);
		if (empty($pubtime))
		{
			$sql_publish_time = Security::sql_var(date('Y-m-d H:i:s'));
		}
		else
		{
			$sql_publish_time = Security::sql_var(date('Y-m-d H:i:s', strtotime($pubtime)));
		}
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("INSERT INTO $this->tb_job (title, typename, pubdate, content, jobtype) VALUES ($sql_title, $sql_typename, $sql_publish_time, $sql_content, $sql_jobtype)");
				break;
			case Config::$language_en:
				$this->db->query("INSERT INTO $this->tb_job_en (title, typename, pubdate, content, jobtype) VALUES ($sql_title, $sql_typename, $sql_publish_time, $sql_content, $sql_jobtype)");
				break;
			default:
		}
	}
	
	/**
	 * 修改新闻
	 */
	public function modify_job($id, $title, $typename, $pubtime, $content)
	{
		$this->db->connect();
		$sql_id =(int)$id;
		$sql_title = Security::sql_var($title);
		$sql_typename = Security::sql_var($typename);
		$sql_content = Security::sql_var($content);
		if (empty($pubtime))
		{
			$sql_publish_time = Security::sql_var(date('Y-m-d H:i:s'));
		}
		else
		{
			$sql_publish_time = Security::sql_var(date('Y-m-d H:i:s', strtotime($pubtime)));
		}
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("UPDATE $this->tb_job SET title=$sql_title, typename=$sql_typename, content=$sql_content, pubdate=$sql_publish_time WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("UPDATE $this->tb_job_en SET title=$sql_title, typename=$sql_typename, content=$sql_content, pubdate=$sql_publish_time WHERE id=$sql_id");
				break;
			default:
		}
	}
	
	/**
	 * 记录待修改的新闻id
	 */
	public function set_modify_job_id($id)
	{
		$_SESSION[Config::$system_name . '_admin_modify_job_id'] = (int)$id;
	}
	
	/**
	 * 获取待修改的新闻id
	 */
	public function get_modify_job_id()
	{
		$id = isset($_SESSION[Config::$system_name . '_admin_modify_job_id']) ? $_SESSION[Config::$system_name . '_admin_modify_job_id'] : 0;
		
		return $id;
	}
	
	/**
	 * 删除新闻
	 */
	public function delete_job($id)
	{
		$this->db->connect();
		$sql_id =(int)$id;
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("DELETE FROM $this->tb_job WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("DELETE FROM $this->tb_job_en WHERE id=$sql_id");
				break;
			default:
		}
	}
	
	/**
	 * 生成惟一文件名
	 */
	public function get_html_file()
	{
		return time() . rand(1000, 9999) . '.php';
	}
	
	public function get_campus_homepage()
	{
		$this->db->connect();
		$tb_index = Config::$tb_index;
		$tb_index_en = Config::$tb_index_en;
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $tb_index");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $tb_index_en");
				break;
			default:
		}
		$res = $this->db->get_row();
		
		if (!empty($res))
		{
			return $res['job_campus_homepage'];
		}
		else
		{
			return '';
		}
	}
	
	public function set_campus_homepage($value)
	{
		$this->db->connect();
		$tb_index = Config::$tb_index;
		$tb_index_en = Config::$tb_index_en;
		$sql_value = Security::sql_var($value);
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("update $tb_index set job_campus_homepage=$sql_value");
				break;
			case Config::$language_en:
				$this->db->query("update $tb_index_en set job_campus_homepage=$sql_value");
				break;
			default:
		}
	}
}

/**
 *	新闻
 */
class News
{
	private $db = null;//数据库
	private $tb_news = '';//新闻表名
	private $tb_news_en = '';//新闻表名
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_news = Config::$tb_news;
		$this->tb_news_en = Config::$tb_news_en;
	}
	
	public function get_news_count()
	{
		$this->db->connect();
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_news");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_news_en");
				break;
			default:
		}
		$count = $this->db->get_num_rows();
		
		return $count;
	}
	
	public function get_news_count_cn()
	{
		$this->db->connect();
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_news");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_news_en");
				break;
			default:
		}
		$count = $this->db->get_num_rows();
		
		return $count;
	}
	
	/**
	 * 获取新闻
	 */
	public function get_news()
	{
		$this->db->connect();
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_news ORDER BY pubdate DESC");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_news_en ORDER BY pubdate DESC");
				break;
			default:
		}
		$res = $this->db->get_all_rows();
		
		return $this->parse_news($res);
	}
	
	private function parse_news($res)
	{
		$new_res = array();
		if (!empty($res))
		{
			foreach ($res as $key => $value)
			{
				$row = array();
				$row['id'] = $value['id'];
				$row['title'] = $value['title'];
				$row['keywords'] = $value['keywords'];
				$row['description'] = $value['description'];
				$row['content'] = $value['content'];
				$row['typeid'] = $value['typeid'];
				$row['pubdate'] = $this->format_date($value['pubdate']);
				//$row['link'] = $value['link'];
				$row['link'] = '?m=news&a=show_news&id=' . $value['id'];
				$row['image'] = $value['image'];
				$row['recommend_image'] = $value['recommend_image'];
				$row['news_from'] = $value['news_from'];
				$row['profile'] = $value['profile'];
				$new_res[] = $row;
			}
		}
		
		return $new_res;
	}
	
	/**
	 * 获取新闻
	 */
	public function get_news_page($from, $n = 10)
	{
		$this->db->connect();
		$from = (int)$from;
		if ($from < 0)
		{
			$from = 0;
		}
		$n = (int)$n;
		if ($n < 0)
		{
			$n = 0;
		}
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_news ORDER BY pubdate DESC LIMIT $from, $n");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_news_en ORDER BY pubdate DESC LIMIT $from, $n");
				break;
			default:
		}
		$res = $this->db->get_all_rows();
		
		return $this->parse_news($res);
	}
	
	/**
	 * 获取新闻
	 */
	public function get_news_by_id($id)
	{
		$this->db->connect();
		$sql_id = (int)$id;
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_news WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_news_en WHERE id=$sql_id");
				break;
			default:
		}
		$res = $this->db->get_row();
		
		return $this->parse_id_news($res);
	}
	
	private function parse_id_news($res)
	{
		$row = array();
		if (!empty($res))
		{
			$value = $res;
			$row['id'] = $value['id'];
			$row['title'] = $value['title'];
			$row['keywords'] = $value['keywords'];
			$row['description'] = $value['description'];
			$row['content'] = $value['content'];
			$row['typeid'] = $value['typeid'];
			$row['pubdate'] = $this->format_date($value['pubdate']);
			//$row['link'] = $value['link'];
			$row['link'] = '?m=news&a=show_news&id=' . $value['id'];
			$row['image'] = $value['image'];
			$row['recommend_image'] = $value['recommend_image'];
			$row['news_from'] = $value['news_from'];
			$row['profile'] = $value['profile'];
		}
		
		return $row;
	}
	
	/**
	 * 获取新闻
	 */
	public function get_admin_news_by_id($id)
	{
		$this->db->connect();
		$sql_id = (int)$id;
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_news WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_news_en WHERE id=$sql_id");
				break;
			default:
		}
		$res = $this->db->get_row();
		
		return $this->parse_admin_id_news($res);
	}
	
	private function parse_admin_id_news($res)
	{
		$row = array();
		if (!empty($res))
		{
			$value = $res;
			$row['id'] = $value['id'];
			$row['title'] = $value['title'];
			$row['keywords'] = $value['keywords'];
			$row['description'] = $value['description'];
			$row['content'] = $value['content'];
			$row['typeid'] = $value['typeid'];
			$row['pubdate'] = date('Y-m-d H:i:s', strtotime($value['pubdate']));
			//$row['link'] = $value['link'];
			$row['link'] = '?m=news&a=show_news&id=' . $value['id'];
			$row['image'] = $value['image'];
			$row['recommend_image'] = $value['recommend_image'];
			$row['news_from'] = $value['news_from'];
			$row['profile'] = $value['profile'];
		}
		
		return $row;
	}
	
	/**
	 * 添加新闻
	 */
	public function add_news($title, $keywords, $description, $content, $pubtime, $image, $recommend_image, $news_from, $profile)
	{
		$this->db->connect();
		$sql_title = Security::sql_var($title);
		$sql_keywords = Security::sql_var($keywords);
		$sql_description = Security::sql_var($description);
		$sql_content = Security::sql_var($content);
		if (empty($pubtime))
		{
			$sql_publish_time = Security::sql_var(date('Y-m-d H:i:s'));
		}
		else
		{
			$sql_publish_time = Security::sql_var(date('Y-m-d H:i:s', strtotime($pubtime)));
		}
		$sql_image = Security::sql_var($image);
		$sql_recommend_image = Security::sql_var($recommend_image);
		$sql_news_from = Security::sql_var($news_from);
		$sql_profile = Security::sql_var($profile);
		//$sql_typeid = Config::$id_latest_news;
		$link = $this->get_html_file();
		$sql_link = Security::sql_var($link);
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("INSERT INTO $this->tb_news (title, keywords, description, content, typeid, pubdate, link, image, recommend_image, news_from, profile) VALUES ($sql_title, $sql_keywords, $sql_description, $sql_content, 0, $sql_publish_time, $sql_link, $sql_image, $sql_recommend_image, $sql_news_from, $sql_profile)");
				break;
			case Config::$language_en:
				$this->db->query("INSERT INTO $this->tb_news_en (title, keywords, description, content, typeid, pubdate, link, image, recommend_image, news_from, profile) VALUES ($sql_title, $sql_keywords, $sql_description, $sql_content, 0, $sql_publish_time, $sql_link, $sql_image, $sql_recommend_image, $sql_news_from, $sql_profile)");
				break;
			default:
		}
	}
	
	/**
	 * 修改新闻
	 */
	public function modify_news($id, $title, $keywords, $description, $content, $pubtime, $image, $recommend_image, $news_from, $profile)
	{
		$this->db->connect();
		$sql_id =(int)$id;
		$sql_title = Security::sql_var($title);
		$sql_keywords = Security::sql_var($keywords);
		$sql_description = Security::sql_var($description);
		$sql_content = Security::sql_var($content);
		if (empty($pubtime))
		{
			$sql_publish_time = Security::sql_var(date('Y-m-d H:i:s'));
		}
		else
		{
			$sql_publish_time = Security::sql_var(date('Y-m-d H:i:s', strtotime($pubtime)));
		}
		$sql_image = Security::sql_var($image);
		$sql_recommend_image = Security::sql_var($recommend_image);
		$sql_news_from = Security::sql_var($news_from);
		$sql_profile = Security::sql_var($profile);
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("UPDATE $this->tb_news SET title=$sql_title, keywords=$sql_keywords, description=$sql_description, content=$sql_content, pubdate=$sql_publish_time, image=$sql_image, recommend_image=$sql_recommend_image, news_from=$sql_news_from, profile=$sql_profile WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("UPDATE $this->tb_news_en SET title=$sql_title, keywords=$sql_keywords, description=$sql_description, content=$sql_content, pubdate=$sql_publish_time, image=$sql_image, recommend_image=$sql_recommend_image, news_from=$sql_news_from, profile=$sql_profile WHERE id=$sql_id");
				break;
			default:
		}
	}
	
	/**
	 * 记录待修改的新闻id
	 */
	public function set_modify_news_id($id)
	{
		$_SESSION[Config::$system_name . '_admin_modify_news_id'] = (int)$id;
	}
	
	/**
	 * 获取待修改的新闻id
	 */
	public function get_modify_news_id()
	{
		$id = isset($_SESSION[Config::$system_name . '_admin_modify_news_id']) ? $_SESSION[Config::$system_name . '_admin_modify_news_id'] : 0;
		
		return $id;
	}
	
	/**
	 * 删除新闻
	 */
	public function delete_news($id)
	{
		$this->db->connect();
		$sql_id =(int)$id;
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("DELETE FROM $this->tb_news WHERE id=$sql_id");
				break;
			case Config::$language_en:
				$this->db->query("DELETE FROM $this->tb_news_en WHERE id=$sql_id");
				break;
			default:
		}
	}
	
	/**
	 * 生成惟一文件名
	 */
	public function get_html_file()
	{
		return time() . rand(1000, 9999) . '.php';
	}
	
	public function get_cn_news($page)
	{
		$this->db->connect();
		$page = (int)$page;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * Config::$reload_news_count;
		$n = Config::$reload_news_count;
		
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_news ORDER BY pubdate DESC LIMIT $from, $n");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_news_en ORDER BY pubdate DESC LIMIT $from, $n");
				break;
			default:
		}
		
		$res = $this->db->get_all_rows();
		
		return $this->parse_reload_news($res);
	}
	
	private function parse_reload_news($res)
	{
		$new_res = array();
		if (!empty($res))
		{
			foreach ($res as $key => $value)
			{
				$row = array();
				$row['id'] = $value['id'];
				$row['title'] = $value['title'];
				$row['content'] = $value['profile'];
				$row['pubdate'] = $this->format_date($value['pubdate']);
				$row['image'] = $value['image'];
				//$row['link'] = $value['link'];
				$row['link'] = '?m=news&a=show_news&id=' . $value['id'];
				$new_res[] = $row;
			}
		}
		
		return $new_res;
	}
	
	public function get_recommend_news_cn($current_id)
	{
		$this->db->connect();
		$sql_current_id = (int)$current_id;
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				$this->db->query("SELECT * FROM $this->tb_news WHERE id != $sql_current_id ORDER BY pubdate DESC LIMIT 0, 3");
				break;
			case Config::$language_en:
				$this->db->query("SELECT * FROM $this->tb_news_en WHERE id != $sql_current_id ORDER BY pubdate DESC LIMIT 0, 3");
				break;
			default:
		}
		
		$res = $this->db->get_all_rows();
		
		return $this->parse_recommend_news($res);
	}
	
	private function parse_recommend_news($res)
	{
		$new_res = array();
		if (!empty($res))
		{
			foreach ($res as $key => $value)
			{
				$row = array();
				$row['id'] = $value['id'];
				$row['title'] = $value['title'];
				//$row['content'] = $value['profile'];
				$row['pubdate'] = $this->format_date($value['pubdate']);
				$row['image'] = $value['recommend_image'];
				//$row['link'] = $value['link'];
				$row['link'] = '?m=news&a=show_news&id=' . $value['id'];
				$new_res[] = $row;
			}
		}
		
		return $new_res;
	}
	
	public static function format_date($date)
	{
		switch (System::get_user_language())
		{
			case Config::$language_cn:
				return date('Y年n月j日', strtotime($date));
				break;
			case Config::$language_en:
				return Utils::format_date($date);
				break;
			default:
		}
	}
}

/**
 *	系统
 */
class System
{
	public function __construct()
	{
		//
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
	 * 上传图片
	 */
	public static function upload_image()
	{
		$upload = new Upload(2 * 1024 * 1024, 'jpg,gif,png,bmp', '', 'uploads/', 'time');
		if ($upload->upload())
		{
			$upload_info = $upload->getUploadFileInfo();
			//$url = $upload_info[0]['savepath'] . $upload_info[0]['savename'];
			//$url = Config::$url . '/uploads/' . $upload_info[0]['savename'];
			$url = '/uploads/' . $upload_info[0]['savename'];
			
			return json_encode(array('error' => 0, 'url' => $url));
		}
		else
		{
			$msg = $upload->getErrorMsg();
			
			return json_encode(array('error' => 1, 'message' => $msg));
		}
	}
	
	/**
	 * 设置提交key
	 */
	public static function set_submit_key()
	{
		$_SESSION[Config::$system_name . '_submit_key'] = 1;
	}
	
	/**
	 * 检测是否设置提交key
	 */
	public static function check_submit_key()
	{
		$is_set = isset($_SESSION[Config::$system_name . '_submit_key']) ? (int)$_SESSION[Config::$system_name . '_submit_key'] : 0;
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
	 * 清除提交key
	 */
	public static function clear_submit_key()
	{
		unset($_SESSION[Config::$system_name . '_submit_key']);
	}
	
	/**
	 * 生成首页html
	 */
	public static function make_index_html()
	{
		Utils::make_html('index.html', Config::$url . '/?m=system&a=show_index');
	}
	
	public static function get_language_name()
	{
		$language = self::get_user_language();
		switch ($language)
		{
			case Config::$language_cn:
				$language = '中文';
				break;
			case Config::$language_en:
				$language = '英语';
				break;
			default:
				$language = '';
		}
		
		return $language;
	}
	
	public static function set_back_url($back_url)
	{
		$_SESSION[Config::$system_name . '_admin_back_url'] = $back_url;
	}
	
	public static function get_back_url()
	{
		return isset($_SESSION[Config::$system_name . '_admin_back_url']) ? $_SESSION[Config::$system_name . '_admin_back_url'] : '?m=admin&a=show_admin';
	}
	
	public static function get_user_language_cookie()
	{
		return isset($_COOKIE[Config::$system_name . "_user_cookie_language"]) ? $_COOKIE[Config::$system_name . "_user_cookie_language"] : '';
	}
	
	public static function set_user_language_cookie($language)
	{
		 setcookie(Config::$system_name . "_user_cookie_language", '' . $language, time() + 12 * 30 * 24 * 60 * 60);
	}
	
	public static function get_user_language_session()
	{
		return isset($_SESSION[Config::$system_name . "_user_session_language"]) ? $_SESSION[Config::$system_name . "_user_session_language"] : '';
	}
	
	public static function set_user_language_session($language)
	{
		$_SESSION[Config::$system_name . "_user_session_language"] = '' . $language;
	}
	
	public static function get_user_language()
	{
		$language = self::get_user_language_session();
		if (empty($language))
		{
			$language = self::get_user_language_cookie();
			self::set_user_language_session($language);
		}
		
		if (empty($language))
		{
			if (Config::$is_cn)
			{
				$language = Config::$language_cn;
			}
			else
			{
				$language = Config::$language_en;
			}
		}
		
		return $language;
	}
	
	public static function set_user_language($language)
	{
		self::set_user_language_session($language);
		self::set_user_language_cookie($language);
	}
	
	public static function set_user_back_url($back_url)
	{
		$_SESSION[Config::$system_name . '_user_back_url'] = $back_url;
	}
	
	public static function get_user_back_url()
	{
		return isset($_SESSION[Config::$system_name . '_user_back_url']) ? $_SESSION[Config::$system_name . '_user_back_url'] : '/';
	}
	
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
	
	public static function get_image_name($extend)
	{
		$arr = explode('.', $extend);
		return 'uploads/' . time() . rand(1000, 9999) . '.' . $arr[count($arr) - 1];
	}
	
	public static function get_session_jobtype()
	{
		return isset($_SESSION[Config::$system_name . "_session_jobtype"]) ? $_SESSION[Config::$system_name . "_session_jobtype"] : 'social';
	}
	
	public static function set_session_jobtype($jobtype)
	{
		$_SESSION[Config::$system_name . "_session_jobtype"] = '' . $jobtype;
	}
}
?>
