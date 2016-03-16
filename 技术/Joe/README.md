####易网时代CMS系统

####关于本系统

 - 本系统可作为公司网站或个人博客性质的内容管理系统使用
 - 后台使用[BJUI](http://www.b-jui.com)+[ThinkPHP](http://www.thinkphp.cn)整合开发，供初学BJUI前端框架的PHPer参考
 - 前台采用BootStrap开发，界面自适应手机、平板及电脑显示
 - 主要功能模块：栏目管理、文章管理、用户管理、权限管理、数据管理、系统设置
 - 系统说明：[http://www.topstack.cn/page-33-34.html](http://www.topstack.cn/page-33-34.html).
 - 项目地址：[http://git.oschina.net/xvpindex/BJUI_TP_CMS](http://git.oschina.net/xvpindex/BJUI_TP_CMS).
 - 系统演示：[http://www.topstack.cn](http://www.topstack.cn).

####使用说明

 - 导入数据库文件到MySQL数据库中
 - 修改 /App/Common/Conf/config.php 文件中的数据库配置
 - 在浏览器地址栏中输入 localhost 运行即可(建议使用chrome内核的浏览器)
 - 后台登陆地址：http://localhost/Admin，用户名：admin，密码：123456

####注意事项

 - 本系统需开启rewrite服务，Apache服务器下为.htaccess文件，Nginx服务器下需引入rewrite.conf文件
 - 本系统启用了文件缓存技术，请确保 /App/Runtime 目录有可写权限

####目录结构

	根目录
	|
	|--ThinkPHP                             ：ThinkPHP 核心框架包
	|
	|----App                                ：应用目录
	|     |--Admin                          ：后台应用目录
    |     |
	|     |--Common                         ：公用函数及类库文件存放目录
    |     |     |--Common                   ：公用函数目录 
	|     |     |--Conf                     ：配置文件目录
	|     |     |     |--config.php         ：公用配置文件
	|     |     |     |--siteConfig.php     ：用于存放网站配置信息等公用信息
    |     |     |--Controller               ：公用控制器目录 
    |     |     |--Model                    ：公用模型目录 
	|     |
	|     |--Databases                      ：数据库备份目录
	|     |--Home                           ：前台应用目录
	|     |--Runtime                        ：缓存文件存放目录
	|
	|--Public                               ：公用前台文件目录
	|     |--Css                            ：公用的CSS样式存放目录
	|     |--Img                            ：公用图片存放目录
	|     |--Js                             ：公用JS存放目录
	|
	|--Static                               ：静态文件存放目录
	|     |--Plugins                        ：插件目录
	|           |--BJUI                     ：BJUI框架
	|           |--jquery-plugins           ：jQuery插件
	|           |--kindeditor               ：kindEditor编辑器
	|
	|--Uploads                              ：附件上传目录
	|     |--file                           ：文件目录
	|     |--flash                          ：flash目录
	|     |--image         			        ：图片目录
	|     |--media                          ：媒体目录
	|
	|--index.php                            ：前台入口文件
	|--.htaccess                            ：Windows服务器下URL重写规则
	|--rewrite.conf                         ：Linux服务器下URL重写规则