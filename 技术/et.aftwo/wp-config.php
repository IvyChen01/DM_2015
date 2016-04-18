<?php
/**
 * WordPress基础配置文件。
 *
 * 本文件包含以下配置选项：MySQL设置、数据库表名前缀、密钥、
 * WordPress语言设定以及ABSPATH。如需更多信息，请访问
 * {@link http://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 * 编辑wp-config.php}Codex页面。MySQL设置具体信息请咨询您的空间提供商。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以手动复制这个文件，并重命名为“wp-config.php”，然后填入相关信息。
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define('DB_NAME', '');

/** MySQL数据库用户名 */
define('DB_USER', '');

/** MySQL数据库密码 */
define('DB_PASSWORD', '');

/** MySQL主机 */
define('DB_HOST', '');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', '');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'i-nu2@ysI(Uuo|n#qXHm~kDuT}nsM_o#n~&(C-5Hy6R1-/I}5 _$h/@5-OMbvCfr');
define('SECURE_AUTH_KEY',  'gQ{~Ln4  Q{z>=N)D}gGX,Ww_hyi|t rT{wd5fdbt254}v@1RqlVS*ttJmm$L<T+');
define('LOGGED_IN_KEY',    'xf1L^+g86&3]8?_V?)kL pJqIg;j|zjtfi[J;3u)r{UNO=vGwJA#)m2D5G0hu#lX');
define('NONCE_KEY',        'vJioe#tOtMeXSp6xlt 26kxGt{>uN%:L9n|U5JjO:e7*Ule=_$VQlIF:(e{T M-g');
define('AUTH_SALT',        '>lI/>Cj]meX&A^CS/!AZ~1vhF!{6Rl>xzir+^z-)KfRKA|(-@6OPAUQ>gqWqXSBN');
define('SECURE_AUTH_SALT', ')jI:FD0Cv7|,dIGu0g%sEO|*G%r4CqM+J~en_F2+pdHPAi|wT2[bO)ov%6^8>Qj(');
define('LOGGED_IN_SALT',   '*,%jQJ)7<~%m6L[I|+n1SzzCXCkJR/+X4s+c#s#*ig7;5&:[&&$`H4cM+0p?5Qys');
define('NONCE_SALT',       'jjINROZKZ|Ej+5WZ5KgMc4`F`_||c9(5r(jLbXVK6L7j_@PU@6;Xwn$f:++J}BdL');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 */
define('WP_DEBUG', false);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置WordPress变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');
