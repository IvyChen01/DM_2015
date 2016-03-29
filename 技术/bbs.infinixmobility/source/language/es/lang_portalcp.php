<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_portalcp.php by Valery Votintsev, codersclub.org
 *      $Id: Translated to Spanish by jhoxi, discuzhispano.com
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array(
	'block_diy_nopreview'		=> '<p>Este bloque contiene js, no se puede obtener una vista previa, por favor salve a la vista.</p>',//'<p>此模块内容包含js代码，不能立即预览，请点击保存后查看</p>',
	'block_diy_summary_html_tag'	=> 'Errores de contenido personalizado, etiquetas HTML:',//'自定义内容错误，HTML标签：',
	'block_diy_summary_not_closed'	=> 'no coincide con',//' 不匹配',
	'block_all_category'		=> 'Todas las categorias',//'全部分类',
	'block_first_category'		=> 'Top de Categorías ',//'顶级分类',
	'block_all_forum'		=> 'Todos los foros',//'全部版块',
	'block_all_group'		=> 'Todos los grupos',//'全部用户组',
	'block_all_type'		=> 'Todos los tipos',//'全部分类',
	'file_size_limit'		=> 'El archivo exede el limita que es {size} kb, porfavor vuelve.',//'文件不能大于 {size} kb，请返回．',
	'set_to_conver'			=> 'Establecer como la cubierta',//'设为封面',
	'small_image'			=> 'Small image',//'小图',
	'insert_small_image'		=> 'Inserte la imagen pequeña',//'插入小图',
	'insert_large_image'		=> 'Inserte la imagen grande',//'插入大图',
	'insert_file'			=> 'Insertar archivo',//'插入文件',
	'delete'			=> 'Borrar',//'删除',
	'upload_error'			=> 'La subida fallo',//'上传失败',
	'upload_remote_failed'		=> 'La subida remota fallo',//'远程上传失败',
	'article_noexist'		=> 'Artículo específico no existe',//'指定的文章不存在，请检查',
	'article_noallowed'		=> 'No tiene permisos para operar este artículo',//'你没有权限对指定的文章进行操作',
	'article_publish_noallowed'	=> 'No tiene permisos para publicar el artículo',//'你没有权限进行文章发布操作',
	'article_category_empty'	=> 'Sorry, the category can not be empty',//'抱歉，栏目不能为空',
	'article_edit_nopermission'	=> 'Sorry, you do not have permission to edit current article',//'抱歉，您没有权限进行当前文章操作',
	'article_publish'		=> 'Publicar el artículo',//'发布文章',
	'article_manage'		=> 'Gestionar el articulo',//'管理文章',
	'article_tag'			=> 'Etiquetas',//'标签',
	'select_category'		=> 'Selecionar categoria',//'选择分类',
	'blockstyle_diy'		=> 'Plantilla por defecto',//'自定义模板',

	'article_pushplus_info'		=> '<p><center><i><a href="{url}" class="xg1 xs1">Este artículo proporcionado por el {author}</a></i><center></p>',

	'diytemplate_name_null'		=> '[no se ha completado]',//'[未填写]',
	'portal_view_name'		=> ' Article view page',//' 文章查看页',
	'forum_viewthread_name'		=> ' Posts View Page',//' 帖子查看页',
	'portal/index'			=> 'Inicio de los artículos ',//'文章首页',
	'portal/list'			=> 'Lista de artículos(públicos)',//'文章列表页(公共)',
	'portal/view'			=> 'Artículo, mire la página(público)',//'文章查看页(公共)',
	'portal/comment'		=> 'Página de comentarios sobre el artículo',//'文章评论页',
	'forum/discuz'			=> 'Inicio del foro',//'论坛首页',
	'forum/viewthread'		=> 'Ver Tema Principal(público)',//'帖子查看首页(公共)',
	'forum/forumdisplay'		=> 'Lista de paginas del foro(público)',//'版块列表页(公共)',
	'group/index'			=> 'Grupo del inicio',//'群组首页',
	'group/group_my'		=> 'Mi grupo de inicio',//'我的群组首页',
	'group/group'			=> 'Grupo del inicio',//'群组内容页',
	'home/space_home'		=> 'Inicio del espacio',//'空间首页',
	'home/space_trade'		=> 'Espacio de los productos  en la página',//'空间商品页',
	'home/space_top'		=> 'Lista de espacio superior',//'空间排行榜',
	'home/space_thread'		=> 'Espacio al último tema',//'空间帖子页',
	'home/space_reward'		=> 'El espacio que ofrece una página de recompensa',//'空间悬赏页',
	'home/space_share_list'		=> 'Espacio que comparten la lista de páginas',//'空间分享列表页',
	'home/space_share_view'		=> '	Espacio de compartir la vista pagina',//'空间分享查看页',
	'space_share_view'		=> 'Eespacio de  compartir la vista de la pagina',//'空间分享查看页',
	'home/space_poll'		=> 'Espacio para las encuentas',//'空间投票页',
	'home/space_pm'			=> 'Espacio para los mensajes cortos',//'空间短消息页',
	'home/space_notice'		=> 'Espacio para los recordatorios',//'空间提醒页',
	'home/space_group'		=> 'Espacio para el grupo',//'空间群组页',
	'home/space_friend'		=> 'Espacio para amigos',//'空间好友页',
	'home/space_favorite'		=> 'Página espacio favorito',//'空间收藏页',
	'home/space_doing'		=> 'Espacio para los tweets ',//'空间记录页',
	'home/space_debate'		=> 'Espacio de los debates',//'空间辩论页',
	'home/space_blog_view'		=> 'Espacio del blog  de la vista de la página',//'空间日志查看页',
	'home/space_blog_list'		=> 'Espacio del blog de la lista de páginas',//'空间日志列表页',
	'home/space_album_view'		=> 'Espacio del Álbum de imágenes ',//'空间相册查看页',
	'home/space_album_pic'		=> 'Espacio de la imagen del álbum',//'空间图片查看页',
	'home/space_album_list'		=> 'Espacio del álbum',//'空间相册列表页',
	'home/space_activity'		=> 'Espacio de Eventos',//'空间活动页',
	'ranklist/ranklist'		=> 'Todos los Ranks',//'全部排行榜页',
	'ranklist/blog'			=> 'Top Blogs',//'日志排行榜页',
	'ranklist/poll'			=> 'Top Encuestas',//'投票排行榜页',
	'ranklist/activity'		=> 'Top Eventos',//'活动排行榜页',
	'ranklist/forum'		=> 'Top Foros',//'版块排行榜页',
	'ranklist/picture'		=> 'Top Imagenes',//'图片排行榜页',
	'ranklist/group'		=> 'Top Grupos',//'群组排行榜页',
	'ranklist/thread'		=> 'Top Temas',//'帖子排行榜页',
	'ranklist/member'		=> 'Top Miembros',//'用户排行榜页',
	'other_page'			=> 'Los módulos no DYD',//'非DIY模块',
	'upload'			=> 'Subir',//'上传',
	'remote'			=> 'Remoto',//'远程',
	'portal_index'			=> 'Portal',//'门户首页',
	'portal_topic_blue'		=> 'Tema azul',//'蓝色调专题',
	'portal_topic_green'		=> 'Tema verde',//'绿色调专题',
	'portal_topic_grey'		=> 'Tema gris',//'灰色调专题',
	'portal_topic_red'		=> 'Tema rojo',//'红色调专题',

	'itemtypename0'			=> 'Auto',//'自动',
	'itemtypename1'			=> '<span style="color: #FF0000">Fixed</span>',//'<span style="color: #FF0000">固定</span>',
	'itemtypename2'			=> '<span style="color: #00BFFF">Edit</span>',//'<span style="color: #00BFFF">编辑</span>',
	'itemtypename3'			=> '<span style="color: #0000FF">Push</span>',//'<span style="color: #0000FF">推送</span>',

);