<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_misc.php by Valery Votintsev, codersclub.org
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'discuz_lang'		=> 'Divers',  //  'misc'
	'contact'		=> 'Contact:',  //  'Contact:'
	'anonymous'		=> 'Anonyme',  //   'Anoymous'
	'anonymoususer'		=> 'Anonyme',  //   'Anonymous'
	'guestuser'		=> 'Invit&#233;s',  //  'Guest'
	'has_expired'		=> 'Cette information a expir&#233;',  //  'This information has expired'
	'click_view'		=> 'Cliquez pour voir',  //  'Click to view'
	'never_expired'		=> 'Illimit&#233;',  // 'Unlimited' 
	'sort_update'		=> 'Mise &#224; jour',  //  'Update'
	'sort_upload'		=> 'T&#233;l&#233;chargez',  //  'Upload'
	'view_noperm'		=> 'Contenu cach&#233;',  //  'Hidden content'
	'post_hidden'		=> '**** Caché par Auteur ****',  //  '**** Hidden by author ****'
	'post_banned'		=> '**** Auteur est interdit ou supprimé ****',  //   '**** Author has been banned or deleted ****'
	'post_single_banned'	=> '**** Ce post est interdit ou bannit ****',  //  '**** This post has been banned ****'
	'message_ishidden_hiddenreplies'	=> 'Ce post ne s\'affiche qu\'&#224; l\'Auteur du sujet',  // 'This post is only shown to author of the thread' 
	'post_reply_quote'	=> '{author} a post&#233; en {time}',  //  '{author} posted on {time}'
	'post_edit'		=> "[i=s] Derni&#232;re &#233;dition par {editor} sur {edittime} [/i]\n\n",  //  '[i=s] Last edited by {editor} on {edittime} [/i]\n\n'
	'post_edit_regexp'	=> '/^\[i=s\] Derni&#232;re &#233;dition par .*? sur .*? \[\/i\]\n\n/s',  //  '/^\[i=s\] Last edited by .*? on .*? \[\/i\]\n\n/s'
	'post_edithtml'		=> '[i=s] Ce post a &#233;t&#233; &#233;dit&#233; par {editor} sur {edittime} [/i]<br /><br />',  //  '[i=s] This post was edited by {editor} on {edittime} [/i]<br /><br />'
	'post_edithtml_regexp'	=> '/^\[i=s\] Ce post a &#233;t&#233; &#233;dit&#233; par .*? sur .*? \[\/i\]&lt;br \/&gt;&lt;br \/&gt;/s',  //  '/^\[i=s\] This post was edited by .*? on .*? \[\/i\]&lt;br \/&gt;&lt;br \/&gt;/s'
	'post_editnobbcode'	=> '[Derni&#232;re &#233;dition par {editor} sur {edittime}]\n\n',  //  '[Last edited by {editor} on {edittime}]\n\n'
	'post_editnobbcode_regexp'	=> '/^\[Derni&#232;re &#233;dition par .*? sur .*?\]\n\n/s',  // '/^\[Last edited by .*? on .*?\]\n\n/s' 
	'post_reply'		=> 'R&#233;ponse',  //  'Reply'
	'post_thread'		=> '\'s sujet', // "'s thread"

	'price'			=> 'Prix',  //  'Price'
	'pay_view'		=> 'Enregistrement',  //  'Record'  //销售记录
	'attachment_buy'	=> 'Acheter',  //  'Buy'

	'post_trade_yuan'	=> '$',  //  '$'
	'post_trade_seller'	=> 'Vendeur',  //  'Seller'
	'post_trade_name'	=> 'Nom Article',  //  'Item Name'
	'post_trade_price'	=> 'Prix',  //  'Price'
	'post_trade_quality'	=> '&#201;tat de l\'article',  //  'Item condition'
	'post_trade_locus'	=> 'Emplacement Article',  //  'Item location'
	'post_trade_transport_type'	=> 'Frais de port pay&#233;s par',  // 'Shipping fee paid by' //Modify
	'post_trade_transport_seller'	=> 'Vendeur',  //  'Seller'
	'post_trade_transport_buyer'	=> 'Acheteur',  //  'Buyer'
	'post_trade_transport_mail'	=> 'Mail',  //  'Mail'
	'post_trade_transport_express'	=> 'Express',  //  'Express'
	'post_trade_transport_virtual'	=> 'Virtuel',  // 'Virtual' 
	'post_trade_transport_physical'	=> 'comptant sur la livraison',  // 'C.O.D.' //cash on delivery
//vot	'post_trade_locus'		=> 'Emplacement Article',  //  'Item location'
	'post_trade_description'	=> 'Description',  //  'Description'
	'post_trade_pm_subject'		=> '[N&#233;gociation]',  //  '[Bargain]'
	'post_trade_pm_buynum'		=> 'Quantit&#233;',  //  'Quantity'
	'post_trade_pm_wishprice'	=> 'Prix d&#233;sirez',  //  'Wish Price'
	'post_trade_pm_reason'		=> 'Raison',  //  'Reason'
	'postappend_content'		=> 'Contenu suppl&#233;mentaire',  //  'Additional Content'
	'payment_unit'			=> '€',  //  '€'

	'attach'		=> 'Pi&#232;ce jointe',  //  'Attachment'
	'attach_pay'		=> 'Pi&#232;ce Jointe Ventes',  //  'Sales Attachment' //Modify
	'attach_credits_policy'	=> 'Points de vue Politique',  //  'View points policy'
	'attach_img'		=> 'Image Pi&#232;ce Jointe',  // 'Image Attachment' 
	'attach_readperm'	=> 'Permission de lecture',  //  'Read Permission'
	'attach_img_zoom'	=> 'Cliquez et ouvrir de nouvelles fen&#234;tres\\nCTRL+Utilisez la molette de la souris pour zoomer/d&#233;zoomer',  //  'Click and open in new windows\\nCTRL+Use mouse wheel to zoom in/out'
	'attach_img_thumb'	=> 'Cliquez pour voir en taille r&#233;elle l\'image dans une nouvelle fen&#234;tre',  //  'Click to view full size of image in new window'
	'attach_downloads'	=> 'T&#233;l&#233;chargements',  //  'Downloads'

	'post_trade_transport'		=> 'Frais d\'exp&#233;dition',  //   'Shipping fee'
//vot	'post_trade_transport_mail'	=> 'Mail',  //  'Mail'
	'post_trade_quality'		=> '&#201;tat de l\'article',  // 'Item condition'  //Modify
	'post_trade_quality_new'	=> 'Nouveau',  //  'New'
	'post_trade_quality_secondhand'	=> 'Seconde main',  //  'Secondhand'

	'trade_unstart'			=> '<font color="gray">En attente pour le processus</font>',  //  '<font color="gray">Waiting for process</font>'
	'trade_waitbuyerpay'		=> 'En attente de l\'acheteur pour payer',  //  'Waitting buyer to pay'
	'trade_waitsellerconfirm'	=> 'Vendeur En attente de confirmation',  //  'Waiting seller to confirm'
	'trade_sysconfirmpay'		=> 'Syst&#232;me attente de confirmation, Svp. ne pas envoyer de marchandises maintenant',  //  'Waitting system to confirm, please do not send goods now'
	'trade_waitsellersend'		=> 'Vendeur en attente d\'envoyer des marchandises',  //  'waiting seller to send goods'
	'trade_waitbuyerconfirm'	=> 'Vendeur en attente de confirmation',  // 'Waiting seller to confirm' 
	'trade_syspayseller'		=> 'En attente Alipay pour payer le vendeur',  // 'Waitting alipay to pay the seller' 
	'trade_finished'		=> '<font color="green">Commerce termin&#233; avec Succ&#232;s</font>',  //  '<font color="green">Trade successfully completed</font>'
	'trade_closed'			=> '<font color="gray">Commerce ferm&#233; (inachev&#233;)</font>',  // '<font color="gray">Trade closed(uncompleted)</font>' 
	'trade_waitselleragree'		=> 'En attente pour le vendeur d\'approuver la restitution',  //  'Waitting for seller to approve refund'
	'trade_sellerrefusebuyer'	=> 'Le vendeur refuse, l\'acheteur attend de modifier les conditions',  //  'Seller refused, waitting buyer to change the conditions'
	'trade_waitbuyerreturn'		=> 'Le vendeur a approuv&#233; la restitution d\'attente pour l\'acheteur de retourner les marchandises',  //  'Seller approved refund, waitting for buyer to return goods' 
	'trade_waitsellerconfirmgoods'	=> 'En attente l\'acheteur pour confirmer',  //  'Waitting buyer to confirm'
	'trade_waitalipayrefund'	=> 'En attente au remboursement alipay',  // 'Waitting alipay to refund' 
	'trade_alipaycheck'		=> 'Processus d\'Alipay En attente',  //  'Waitting alipay process'
	'trade_overedrefund'		=> 'plus de restitution ',  //  'Overed refund '
	'trade_refundsuccess'		=> '<font color="green">Remboursement avec Succ&#232;s </font>',  //  '<font color="green">Successfully refunded</font>'
	'trade_refundclosed'		=> '<font color="green">Remboursement ferm&#233;</font>',  //  '<font color="green">Refund closed</font>'

	'trade_offline_1'	=> 'Effectif de la transaction.',  //  'Effective transaction.'
	'trade_offline_4'	=> 'Pay&#233; et en attente de livraison de la marchandise',  //  'Paid and waiting goods delivery'
	'trade_offline_5'	=> 'A livr&#233;',  //  'Delivered'
	'trade_offline_7'	=> 'A recu, l\'&#233;change est compl&#233;t&#233;.',  //  'Received, trade completed.'
	'trade_offline_8'	=> 'Annuler ces &#233;changes',  //  'Cancel this trade'
	'trade_offline_10'	=> 'Je veux retourner, en attendant que le vendeur s\'engage &#224; rembourser.',  //  'I want to return, waiting for the sellers agreed to refund.'
	'trade_offline_11'	=> 'Le vendeur a refus&#233; de rembourser',  //  'Seller refused to refund'
	'trade_offline_12'	=> 'Le vendeur a accept&#233; de rembourser',  //  'Seller agreed to refund'
	'trade_offline_13'	=> 'A retourn&#233;, le vendeur en attente pour recevoir des marchandises',  //  'Returned, waiting seller to receive goods'
	'trade_offline_17'	=> 'Vendeurs ont recu les retours, rembours&#233;s.',  //  'Sellers received returns, refunded.'

	'trade_message_4'	=> 'Vous pouvez entrer les paiements et les informations de compte bancaire',  // 'You can enter payments and bank account information' 
	'trade_message_5'	=> 'Vous pouvez entrer les livraisons, les factures et autres informations',  // 'You can enter shipments, invoices, and other information'  
	'trade_message_13'	=> 'Vous pouvez entrer les livraisons, les factures et autres informations',  //  'You can enter shipments, invoices, and other information'

	'credit_payment'	=> 'Approvisionner',  // 'Add Funds' 
	'credit_forum_payment'	=> 'Approvisionner',  //  'Add Funds'
	'credit_forum_royalty'	=> 'Taxes TTC',  //  'Tax fee'
	
	'credit_total'			=> 'Total Points',//'总积分',

	'invite_payment'	=> 'Acheter un code d\'invitation',  //  'Buy an invitation code'
	'invite_forum_payment'	=> 'Acheter un code d\'invitation',  // 'Buy an invitation code' 
	'invite_forum_payment_unit'	=> '$',  //  '$'
	'invite_forum_royalty'		=> 'Frais de Transaction',  //  'Transaction fees'

	'formulaperm_regdate'		=> 'Inscrit',  //  'Joined'
	'formulaperm_regday'		=> 'Inscrit en jours',  //  'Joined days'
	'formulaperm_regip'		=> 'Reg IP',  //  'Reg IP'
	'formulaperm_lastip'		=> 'Dernier IP',  //  'Last IP'
	'formulaperm_buyercredit'	=> 'Cr&#233;dit Acheteur',  //  'Buyer credit'
	'formulaperm_sellercredit'	=> 'Cr&#233;dit du Vendeur',  // 'Seller credit' 
	'formulaperm_digestposts'	=> 'R&#233;sum&#233;s',  //  'Digests'
	'formulaperm_posts'		=> 'Posts',  // 'Posts' 
	'formulaperm_threads'		=> 'Sujets',  //  'Threads'
	'formulaperm_oltime'		=> 'temps en ligne (heure)',  //  'Online time(hour)'
	'formulaperm_pageviews'		=> 'Page vues',  // 'Page views' 
	'formulaperm_and'		=> 'et',  //  'and'
	'formulaperm_or'		=> 'ou',  //  'or'
	'formulaperm_extcredits'	=> 'Personnalisation points',  //  'Customize points'

	'login_normal_mode'		=> 'En-Ligne',  // 'Online' 
	'login_switch_invisible_mode'	=> 'Statut Changer',  //  'Switch status'
	'login_switch_normal_mode'	=> 'Statut Changer',  //  'Switch status'
	'login_invisible_mode'		=> 'Invisible',  //  'Hidden'

	'eccredit_explain'	=> 'Expliquez',  //  'Explain'

	'google_site_0'		=> 'Rechercher web',  // 'Search web' 
	'google_site_1'		=> 'Rechercher site',  //  'Search site'
	'google_sa'		=> 'Rechercher',  //  'Search'

	'modcp_logs_action_home'	=> 'Message Interne',  //  'Inner Message'
	'modcp_logs_action_moderate'	=> 'Mod&#233;r&#233;',  //  'Moderate'
	'modcp_logs_action_member'	=> 'Gestion Utilisateurs',  //  'Manage users'
	'modcp_logs_action_forumaccess'	=> 'Utilisateur permission',  //  'User permission'
	'modcp_logs_action_thread'	=> 'Gestion sujets',  //  'Manage threads'
	'modcp_logs_action_forum'	=> 'Gestion forums',  // 'Manage forums' 
	'modcp_logs_action_announcement'	=> 'Annonce',  //  'Announcement'
	'modcp_logs_action_log'		=> 'Gestion Logs',  //  'Manage logs' // Gestions des journaux
	'modcp_logs_action_stat'	=> 'Gestion statistiques',  //  'Manag statistics'

	'modcp_logs_action_login'	=> 'Connexion',  //  'Login'

	'uch_selectalbum'	=> 'Svp.Veuillez choisir un album',  //  'Please select an album'
	'uch_noalbum'		=> 'Vous n\'avez pas eu tout l\'album, ', // "You didn't have any album, "
	'click_here'		=> 'cliquez ici',  //  'click here'
	'uch_createalbum'	=> ' afin d\'en cr&#233;er un!',  //  ' to create one!'

	'pm_from'	=> 'Vers',  //  'From'
	'pm_to'		=> 'De',  // 'To' 
	'pm_date'	=> 'Date',  // 'Date' 

	'share_message'	=> 'Salut!J\'ai vu ce sujet dans le {$_G[setting][bbname]},Je pense qu\'il est utile, alors je le recommande &#224; votre disposition. \\n\\n$thread[subject]\\nAdresse: [url={$threadurl}]{$threadurl}[/url]\\n\\nEsp&#233;rons qu\'il vous plaira.',  // 'Hello!I saw this thread in {$_G[setting][bbname]},I think it is valuable,so I recommend it to you. \\n\\n$thread[subject]\\nAddress: [url={$threadurl}]{$threadurl}[/url]\\n\\nHope you like it.' 

	'week_0'	=> 'Dim',  //  'Sun' 
	'week_1'	=> 'Lun',  //  'Mon'
	'week_2'	=> 'Mar',  //  'Tue'
	'week_3'	=> 'Mer',  //  'Wed' 
	'week_4'	=> 'Jeu',  //  'Thu'
	'week_5'	=> 'Ven',  //  'Fri'
	'week_6'	=> 'Sam',  //  'Sat'

	'y_m_d'		=> 'Y-m-d',//'Y年m月d日',

	'notice_actor'		=> ', et ainsi de suite. totale $actorcount personne(s)',  //  'and so on. Total $actorcount person(s)'

	'perms_allowvisit'	=> 'Acc&#232;s Forum',  //  'Access forum'
	'perms_readaccess'	=> 'R.P.',  //  'R.P.'
	'perms_allowviewpro'	=> 'Voir utilisateur\'s profil',  // "View user\'s profile",
	'perms_allowinvisible'	=> 'Cach&#233;',  // 'Hidden' 
	'perms_allowsearch'	=> 'Recherche',  //  'Search'
	'perms_allownickname'	=> 'Pseudo',  //  'Nick name'
	'perms_allowcstatus'	=> 'Personnalisez statut',  // 'Customize status' 
	'perms_allowpost'	=> 'Sujets',  // 'Threads' 
	'perms_allowreply'	=> 'Poster r&#233;ponses',  // 'Post replies' 
	'perms_allowpostpoll'	=> 'Sondage',  //  'Poll'
	'perms_allowvote'	=> 'Vote',  //  'Vote'
	'perms_allowpostreward'	=> 'R&#233;compense',  // 'Reward' 
	'perms_allowpostactivity'	=> 'Activit&#233;',  //  'Activity'
	'perms_allowpostdebate'		=> 'D&#233;bat',  //  'Debate'
	'perms_allowposttrade'		=> 'Commerce',  //  'Trade'
	'perms_maxsigsize'		=> 'Max longueur de la signature',  //  'Max length of signature'
	'perms_allowsigbbcode'		=> 'Utiliser BBCode dans la signature',  //  'Use BBCode in signature'
	'perms_allowsigimgcode'		=> 'Utiliser [img] dans la signature',  //  'Use [img] in signature'
	'perms_maxbiosize'		=> 'Longueur maximale des auto-pr&#233;sentation',  //  'Max length of self-introduction'
	'perms_allowrecommend'		=> 'Th&#232;mes recommand&#233;s',  // 'Recommended Topics' //Modify
	'perms_allowbiobbcode'		=> 'Utiliser BBCode',  //  'Use BBCode'
	'perms_allowbioimgcode'		=> 'Utiliser [img] code',  //  'Use [img] code'
	'perms_allowgetattach'		=> 'Bas/Voir pi&#232;ces jointe',  //  'Down/View attachs'
	'perms_allowgetimage'		=> 'Voir image',  //  'View image'
	'perms_allowpostattach'		=> 'T&#233;l&#233;chargez des pi&#232;ces jointes',  //  'Upload attachments'
	'perms_allowpostimage'		=> 'T&#233;l&#233;chargez image post',  // 'Upload post image' 
	'perms_allowsetattachperm'	=> 'Autorisations Pi&#232;ce jointe',  //  'Attachment permissions'
	'perms_maxspacesize'		=> 'Taille Espace',  //  'Space size'
	'perms_maxattachsize'		=> 'Taille max. de chacun',  //  'Max size each one'
	'perms_maxsizeperday'		=> 'Taille totale par jour',  //  'Total size per day'
	'perms_maxattachnum'		=> 'Montant total par jour',  //  'Total amount per day'
//vot	'perms_allowbioimgcode'		=> 'Utiliser [img] dans l\'auto-pr&#233;sentation',  //  'Use [img] in self-introduction'
	'perms_attachextensions'	=> 'Types de pi&#232;ces jointes',  //  'Attachment types'
	'perms_allowstickthread'	=> 'Scotch&#233;',  //  'Stick'
	'perms_allowdigestthread'	=> 'R&#233;sum&#233;',  //  'Digest'
	'perms_allowstickthread_value'	=> 'Scotch&#233;',  //  'Stick'
	'perms_allowdigestthread_value'	=> 'R&#233;sum&#233;',  // 'Digest' 
	'perms_allowbumpthread'		=> 'Choc',  // 'Bump' 
	'perms_allowhighlightthread'	=> 'Souligner',  // 'Hightlight' 
	'perms_allowrecommendthread'	=> 'Recommander',  // 'Recommend' 
	'perms_allowstampthread'	=> '&#201;valuer',  //  'Evaluate'
	'perms_allowclosethread'	=> 'Fermer',  //  'Close'
	'perms_allowmovethread'		=> 'D&#233;placez',  // 'Move' 
	'perms_allowedittypethread'	=> 'Modifier type de sujet',  //  'Edit thread type'
	'perms_allowcopythread'		=> 'Copier',  //  'Copy'
	'perms_allowmergethread'	=> 'Fusionner',  //  'Merge'
	'perms_allowsplitthread'	=> 'Couper',  // 'Split' 
	'perms_allowrepairthread'	=> 'R&#233;paration',  // 'Repair' 
	'perms_allowrefund'		=> 'Remboursement en vigueur',  //  'Force refund' //Modify
	'perms_alloweditpoll'		=> 'Modifier sondages',  // 'Edit polls' 
	'perms_allowremovereward'	=> 'Retirer r&#233;compense',  //  'Remove reward'
	'perms_alloweditactivity'	=> 'Gestion activit&#233;s',  //  'Manage activities'
	'perms_allowedittrade'		=> 'Gestion Commerces',  //  'Manage trades'
	'perms_alloweditpost'		=> 'Modifier posts',  //  'Edit posts'
	'perms_allowwarnpost'		=> 'Alertes posts',  // 'Warn posts' 
	'perms_allowbanpost'		=> 'Ban posts',  //  'Ban posts'
	'perms_allowdelpost'		=> 'Supprimer posts',  //  'Delete posts'
	'perms_allowviewreport'		=> 'Voir les Rapports Utilisateurs',  //  'View user reports'
	'perms_allowmodpost'		=> 'Mod&#233;rer sujets',  // 'Moderate threads' 
	'perms_allowmoduser'		=> 'Mod&#233;rer Utilisateurs',  //  'Moderate users'
	'perms_allowbanuser'		=> 'Ban Utilisateurs',  //  'Ban users'
	'perms_allowbanip'		=> 'Ban IP',  //  'Ban IP'
	'perms_allowedituser'		=> 'Modifier Utilisateurs',  // 'Edit users' 
	'perms_allowmassprune'		=> 'Posts suppression en vrac',  // 'Bulk delete posts' 
	'perms_allowpostannounce'	=> 'Post annonces',  //  'Post announcements'
	'perms_disablepostctrl'	=> 'D&#233;sactiver "post limiter"',  // 'Disable "Post limit"' //Modify
	'perms_allowviewip'	=> 'Voir IP',  // 'View IP' 
	'perms_viewperm'	=> 'Acc&#232;s Forum',  //   'Access forum'
	'perms_postperm'	=> 'Post sujets',  //  'Post threads'
	'perms_replyperm'	=> 'Post r&#233;ponses',  // 'Post replies' 
	'perms_getattachperm'	=> 'T&#233;l&#233;ch./Voir pi&#232;ces jointe',  //  'Download/View attachments'
	'perms_postattachperm'	=> 'Charger pi&#232;ces jointe',  //  'Upload attachments'
	'perms_postimageperm'	=> 'Charger images',  //  'Upload images'
	'perms_allowblog'	=> 'Post blogs',  //  'Post blogs'
	'perms_allowdoing'	=> 'Post Actes',  // 'Post doings' 
	'perms_allowupload'	=> 'Charger images',  //  'Upload images' 
	'perms_allowshare'	=> 'Partages de Post ',  // 'Post shares' 
	'perms_allowpoke'	=> 'Salut',  //  'Poke'
	'perms_allowfriend'	=> 'Ajouter ami',  // 'Add friend' 
	'perms_allowclick'	=> 'Autoriser la position',  // 'Allow the position' //Modify
	'perms_allowmyop'	=> 'Utiliser applications',  //  'Use applications'
	'perms_allowcomment'	=> 'Commentaires du Post',  //  'Post comments'
	'perms_allowstatdata'	=> 'Voir statistique',  //  'View statistic'
	'perms_allowstat'	=> 'Voir Stats. &#233;volution',  //  'View stats trend'
	'perms_allowpostarticle'	=> 'Post articles',  //  'Post articles'
	'perms_raterange'	=> 'Autoriser notations',  //  'Allow to ratings'
	'perms_allowcommentpost'	=> 'Permet de commenter',//'允许参与点评',  //  'Allow to comment',
	'perms_allowat'			=> 'Autoriser le nombre de @name',//'允许 @ 的人数',  //   'Allow the number of @name',
	'perms_allowreplycredit'	=> 'Autoriser &#224; d&#233;finir le prix Bonus des r&#233;ponses',//'允许设置回帖奖励', //   'Allow to set replies reward',
	'perms_allowposttag'		=> 'Autoriser l\'utilisation des  Tags',//'允许使用标签', //  'Allow to use tags',
	'perms_allowcreatecollection'	=> 'Permettre de cr&#233;er des collections',//'允许创建淘专辑的数量', //  'Allow to create collections',
	'perms_allowsendpm'	=> 'Autoriser envoie M.P',  //  'Allow Send PM'
	'perms_maximagesize'	=> 'Taille de l\'image Max.',  //  'Max size of picture'
	'perms_allowmediacode'	=> 'Code multim&#233;dia',  //  'Multimedia code'

	'join_topic'	=> 'Se joint aux sujets',  // 'Join threads' 
	'join_poll'	=> 'Se joint aux sondages',  //  'Join polls'
	'buy_trade'	=> 'Se joint aux commerces',  // 'Join trades' 
	'join_reward'	=> 'Se joint aux primes',  // 'Join rewards' 
	'join_activity'	=> 'Se joint aux activit&#233;s',  // 'Join activities' 
	'join_debate'	=> 'Se joint aux d&#233;bats',  //  'Join debates'
	'at_invite'		=> '@name pour les amis',//'@我的好友', //  '@name for friends',

	'lower'			=> ' inf&#233;rieure &#224; ',  //  ' lower than '
	'higher'		=> ' plus &#233;lev&#233; que ',  //  ' higher than '
	'report_msg_your'	=> 'Vos ',  //  'Your '
	'report_noreward'	=> 'Aucune incitation',  //  'No incentive'
	'activity_viewimg'	=> 'Cliquer pour voir',//'点击查看',  //  'Click to view',

	'crime_postreason'	=> '{reason} &nbsp; <a href="forum.php?mod=redirect&goto=findpost&pid={pid}&ptid={tid}" target="_blank" class="xi2">D&#233;tails</a>',//'{reason} &nbsp; <a href="forum.php?mod=redirect&goto=findpost&pid={pid}&ptid={tid}" target="_blank" class="xi2">查看详情</a>',
	'crime_reason'		=> '{reason}',

	'connectguest_message_search'	=> array('Pas logu&#233;', 'logu&#233;'),//array('尚未登录', '先登录'), // array('Not logged in', 'Logged'),
	'connectguest_message_replace'	=> array('Pas encore <a href="member.php?mod=connect">Am&#233;liorer compte actuel</a> or <a href="member.php?mod=connect&ac=bind">Se lier &#224; un compte existant</a>', 'Vous avez besoin de <a href="member.php?mod=connect">D\'am&#233;liorer l\'information du compte</a> ou <a href="member.php?mod=connect&ac=bind">de se Lier au compte existant</a> '),//array('尚未 <a href="member.php?mod=connect">完善帐号信息</a> 或 <a href="member.php?mod=connect&ac=bind">绑定已有帐号</a> ', '您需要先 <a href="member.php?mod=connect">完善帐号信息</a> 或 <a href="member.php?mod=connect&ac=bind">绑定已有帐号</a> '), //  array('Not yet <a href="member.php?mod=connect">Improve current account</a> or <a href="member.php?mod=connect&ac=bind">Bind existing account</a>', 'You need to <a href="member.php?mod=connect">Improve account information</a> or <a href="member.php?mod=connect&ac=bind">Bind existing account</a> '),
	'connectguest_message_mobile_search'	=> array('Pas logu&#233;', 'Logu&#233;'),//array('尚未登录', '先登录'),  //   array('Not logged in', 'Logged'),
	'connectguest_message_mobile_replace'	=> 'Fournir des informations sur votre compte ou se Lier &#224; compte existant, ',//'在电脑版完善资料或绑定已有帐号，',  //'Provide your account information or Bind existing account, ',

	'avatar'		=> 'Avatar',//'头像',
	'signature'		=> 'Signature',//'签名',
	'custom_title'		=> 'Titre Personnalis&#233;',//'自定义头衔', //  'Custom Title',

	'forum_guide'		=> 'Guide',//'导读',

	'patch_site_have'	=> 'Votre site a',//'您的网站有', //  'Your site have',
	'patch_is_fixed'	=> 'Les failles de sécurit&#233;, a &#233;t&#233; fix&#233;',//'个安全漏洞，已修复', // 'Security vulnerabilities, has been fixed', 
	'patch_need_fix'	=> 'Failles de s&#233;curit&#233;',//'个安全漏洞，请尽快修复', //  'Security vulnerabilities',
	'patch_fixed_status'	=> 'Fix&#233;',//'已修复', //  'Fixed',
	'patch_unfix_status'	=> 'PAS fix&#233;',//'未修复', // 'NOT fixed', 
	'patch_fix_failed_status'	=> 'La r&#233;paration a échou&#233;',//'修复失败', //   'Repair failed',
	'patch_fix_right_now'	=> 'Faites r&#233;parer d&#232;s maintenant',//'立即修复', //  'Repair right now', // Faites réparer dès maintenant
	'patch_view_fix_detail'	=> 'D&#233;tails',//'查看详情', //  'Details',
	'patch_name'		=> 'Vuln&#233;rabilit&#233;',//'漏洞名称', //  'Vulnerability', 
	'patch_dateline'	=> 'Date',//'发布日期',
	'patch_status'		=> 'Statut',//'当前状态', //  'Status',
	'patch_close'		=> 'Fermer',//'关闭',  //  'Close',

	'plugin_title'		=> 'M&#224;J rappel d\'application',//'应用更新提醒',  //  'Application update reminder',
	'plugin_memo'		=> 'Mises &#224; jour disponibles: <span class="xi1">{number}</span>',//'您有 <span class="xi1">{number}</span> 款应用有可用更新',  //  'Updates available: <span class="xi1">{number}</span>',
	'plugin_link'		=> 'M&#224;J maintenant',//'现在更新',  //  'Update Now', // Mise à jour dès à présent OU MAJ. dès à présent OU mise à niveau maintenant.

	'seccode'		=> 'Verification code',//'验证码',
	'seccode_update'	=> 'Renew',//'换一个',
	'seccode_player'	=> '<span style="padding:2px"><img border="0" style="vertical-align:middle" src="static/image/common/seccodeplayer.gif" /> <a href="javascript:;" onclick="window.document.seccodeplayer_{idhash}.SetVariable(\'isPlay\', 1)">Play the verification code</a></span>',//'<span style="padding:2px"><img border="0" style="vertical-align:middle" src="static/image/common/seccodeplayer.gif" /> <a href="javascript:;" onclick="window.document.seccodeplayer_{idhash}.SetVariable(\'isPlay\', 1)">播放验证码</a></span>',
	'secqaa'		=> 'Secure Answer',//'验证问答',

	'mobileoem_creditrule'	=> 'Mobile Forum Registration',//'掌上论坛签到',

// Added by Valery Votintsev, codersclub.org
	'poll_reply_no_perms'	=> 'Vous ne pouvez pas r&#233;pondre au sondage',//'您不能对自己的回帖进行投票',  //  'You can not reply the poll',
	'poll_replyed_already'	=> 'Vous avez d&#233;j&#224; r&#233;pondu &#224; ce sondage',//'您已经对此回帖投过票了',  //  'You have already replied this poll',
	'poll_voted_ok'		=> 'Vous avez d&#233;j&#224; vot&#233;',//'投票成功',  //  'You have voted successfully',
);

