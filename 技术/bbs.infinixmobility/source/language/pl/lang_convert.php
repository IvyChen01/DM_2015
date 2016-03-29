<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *      Convert Language File
 *      $ID: utility/convert/language/lang.php by Valery Votintsev at 
 *      polish language pack by kaaleth ( kaaleth-discuzpl@windowslive.com )
 */
$lang = array(

	'config_dbhost'		=> 'Host',//'数据库服务器',
	'config_dbuser'		=> 'Użytkownik bazy danych',//'数据库用户名',
	'config_dbpw'		=> 'Hasło bazy danych',//'数据库密码',
	'config_dbname'		=> 'Nazwa bazy danych',//'数据库',
	'config_tablepre'	=> 'Prefiks',//'数据表前缀',
	'config_dbcharset'	=> 'Kodowanie znaków (opcjonalne)',//'数据表字符集 (可选)',
	'config_pconnect'	=> 'Połączenie trwałe',//'持久连接',

	'config_type_source'	=> 'Źródło ustawień bazy danych (oryginalna wersja bazy danych)',//'数据源服务器设置 (原始版本的数据库)',
	'config_type_target'	=> 'Cel ustawień bazy danych (prawidłowo zainstalowana baza danych Discuz! X)',//'目标服务器设置 (已正确安装 Discuz! X 的数据库)',
	'config_type_ucenter'	=> 'Ustawienia serwera UCenter (prawidłowo zainstalowana baza danych UCenter)',//'UCenter 服务器设置 (已正确安装 UCenter 的数据库)',

	'config_type_target_comment'	=> 'Uwaga: Cel bazy danych zostanie zmieniony lub zaktualizowany. Zaleca się wykonanie kopii zapasowej.',//'注意：目标数据库的数据将会被替换或者更新,如当中含有重要内容,请先备份',
	'config_write_error'	=> 'Katalog data/ nie posiada praw do zapisu. Prosimy upewnić się, że atrybuty praw do zapisu tego katalogu ustawiono na 777.',//'转换程序的 data/ 目录不可写,请确保此目录的可写权限,设置 777 属性',

	'config_save'		=> 'Zapisz ustawienia',//'保存服务器设置',
	'config_usergroup'	=> 'Konfiguracja grupy użytkownika',//'用户组配置',
	'config_from_usergroup'	=> 'Źródło grupy użytkownika',//'来源用户组',
	'config_target_usergroup'	=> 'Cel grupy użytkownika',//'目标用户组',
	'config_extcredits'	=> 'Konfiguracja rozszerzonych punktacji',//'积分配置',
	'config_credit'		=> 'kredytów',//'积分',
	'config_from_credit'	=> 'Źrodło kredytów',//'来源积分',
	'config_target_credit'	=> 'Cel kredytów',//'目标积分',
	'config_experience'	=> 'Wartość',//'经验值',
	'config_convert_forum'	=> 'Konfugiracja danych forum',//'数据转换配置',
	'config_from_data'	=> 'Źródło danych data',//'源数据',
	'config_target_forum'	=> 'Cel forum',//'目标版块',
	'config_poll'		=> 'Ankiety',//'投票',
	'config_event'		=> 'Wydarzenia',//'活动',
	'config_auto_create'	=> 'Utwórz automatycznie',//'自动创建',
	'config_convert'	=> 'Zapisz konfiguracje konwersji',//'保存转换配置',

	'submit'		=> 'Wyślij',//'提  交',

	'message_return'	=> 'Powrót',//'返回上一步',
	'message_stop'		=> 'Zatrzymaj',//'停止运行',
	'message_not_enabled_extcredit'	=> 'W nowym systemie powinien zostać otwarty moduł kredyty. W przeciwnym wypadku następny krok nie zostanie przekonwertowany.',//'新系统中至少应开启一个积分,否则无法进行下一步转换',

	'ok'			=> '&nbsp;&nbsp;Potwierdź&nbsp;&nbsp;',//'&nbsp;确&nbsp;&nbsp;定&nbsp;',
	'cancel'		=> '&nbsp;Anuluj&nbsp;',//'&nbsp;取&nbsp;消&nbsp;',
	'return'		=> 'Powrót',//'请返回',
	'tips'			=> 'Wskazówki',//'技巧提示',
	'tips_pconnect'		=> 'Uwaga: Jeśli źródło i cel bazy danych mieszczą się w tym samym miejscu na serwerze, prosimy wpisać liczbę 0. W przeciwnym wypadku ustawić na 1',//'注意：如果源数据库与目标数据库在同一服务器，该项必须设置为0，否则设置为1',

	'mysql_config_error'	=> 'Konfiguracja MySQL nie może być pusta',//'配置不能为空',
	'mysql_connect_error'	=> 'Nie można połączyć się z bazą danych MySQL',//'连接失败',

	'config_success'	=> 'Uzyskano połączenie z serwerem. Teraz nastąpi przejście do następnego kroku.',//'服务器配置成功,现在进行下一步',

	'setting_tips'		=> 'Modyfikowanie ustawień konwersji może obniżyć jej wydajność lub nie dokonać konwersji.',//'修改转换程序设置可能导致您的转换效率降低或者无法正常完成转换,所以请您务必小心修改',

	'mysql_connect_error_1'	=> 'Nie można połączyć się z bazą danych. Proszę sprawdzić, czy nazwa użytkownika i hasło są poprawne.',//'数据库连接错误,请检查数据库密码和帐号是否正确',
	'mysql_connect_error_2'	=> 'Wystąpił błąd podczas sprawdzania tabel. Najprawdopodobnie wprowadzono błędny prefiks bazy danych.',//'数据表检查错误,您可能没有正确填写 “数据表前缀”或者您尚未安装该版本的程序',

//---------------------------
	'invalid_request'	=> 'Nieprawidłowe żądanie',//'非法请求',

//---------------------------
//convert/include/do_config.inc.php

	'config_delete'			=> 'Jeśli nie możesz wyświetlić ustawień programu, usuń plik data/config.inc.php',//'如果无法显示设置项目,请删除文件 data/config.inc.php',

//---------------------------
//convert/include/do_convert.inc.php

	'select_convert_process'	=> 'Please first select the conversion process',//'请首先选择转换程序',
	'update_start_time'	=> 'Czas rozpoczęcia aktualizacji:',//'升级开始时间：',
	'elapsed_time'		=> 'Aktualizacja została zakończona',//'升级程序已经执行了',
	'days'			=> 'dni',//'天',
	'hours'			=> 'godzin',//'小时',
	'minutes'		=> 'minut',//'分',
	'seconds'		=> 'sekund',//'秒',
	'progress'		=> 'Postęp konwersji',//'目前正在执行转换程序',
	'progress_intro1'	=> 'Proces konwersji wymaga kilkukrotnych przekierowań. Proszę nie zamykać okna przeglądarki!',//'转换过程中需要多次跳转,请勿关闭浏览器.',
	'progress_intro2'	=> 'Jeśli proces zostanie przerwany lub zajdzie potrzeba ponownego uruchomienia, kliknij na przycisk',//'如果程序中断或者需要重新开始当前程序,请点击',
	'restart'		=> 'Restart',//'重新开始',
	'process_finished'	=> 'Proces konwersji został zakończony. Proszę przejść do następnego kroku.',//'转换程序 执行完毕, 现在跳转到下一个程序',
	'process_not_found'	=> 'Transfer danych został przerwany! Nie można odnaleźć: ',//'数据转换中断! 无法找到转换程序 ',
	'process_all_finished'	=> 'Wszystkie procesy konwersji zostały zakończone.',//'转换程序全部运行完毕',

//---------------------------
//convert/include/do_finish.inc.php

	'conversion_completed'	=> 'Wszystkie procesy konwersji zostały ukończone prawidłowo!',//'您已经顺利的完成了数据转换!',
	'start_time'		=> 'Czas rozpoczęcia',//'本次升级开始时间',
	'end_time'		=> 'Czas zakończenia',//'本次升级结束时间',
	'execution_time'	=> 'Łączny czas aktualizacji',//'升级累计执行时间',
	'update_more'		=> 'W normalnych okolicznościach, może być konieczne, aby postępować zgodne z wyświetlonymi instrukcjami na ekranie.',//'通常情况下,您可能还需要按照以下提示继续进行升级,从而使您的新程序正常运行',
	'read_me'		=> 'W końcu! Zapraszamy do przejrzenia dodatkowych instrukcji (readme)',//'最后的说明(readme)',

//---------------------------
//convert/include/do_select.inc.php

	'you_selected'		=> 'Wybranych',//'您选择了',
	'process_number'	=> 'procesów do rozpoczęcia konwersji.',//'个转换程序,下面开始转换',
	'process_intro'		=> 'Usually, all the data you need to perform the following conversion table, unless you are in the course of an unexpected disruption or have special needs, choose only if necessary',//'通常情况下,您需要执行下面所有数据表的转换,除非您在执行过程中出现了意外的中断或者有特殊需求,才进行必要的选择',
	'process_configure'	=> 'Konfiguracja procesu aktualizacji',//'配置转换过程',
	'select_all'		=> 'Wszystko',//'全选',
	'run_before_convert'	=> 'Uruchom przed konwersją',//'转换之前运行的程序',
	'table_convert'		=> 'Proces konwersji tabel',//'数据表转换程序',
	'other_convert'		=> 'Wsparcie dla pozostałych konwersji',//'其他辅助转换程序',
	'start_conversion'	=> 'Rozpocznij konwersję',//'开始转换',

//---------------------------
//convert/include/do_setting.inc.php

	'edit_file'		=> 'Edytuj plik',//'编辑配置文件',
	'r/o'			=> ' Tylko do odczytu ',//' 只读 ',
	'settings_saved_ok'	=> 'Ustawienia zostały zaktualizowane i zapisane prawidłowo.',//'设置已经更新完毕并成功保存',
	'file_is_ro'		=> 'Ustawienia nie mogły zostać zapisane. Plik tylko do odczytu. Proszę powrócić.',//'该设置文件为只读文件,无法保存,请返回',
	'settings_not_changed'	=> 'Nie zmieniono żadnych ustawień',//'您没有改变任何设置',

//---------------------------
//convert/include/do_source.inc.php

	'update_permissions'	=> 'Przed rozpoczęciem konwersji, proszę upewnić się, że katalog data oraz wszystkie znajdujące się w nim pliki posiadają prawa do zapisu. W przeciwnym wypadku program nie będzie mógł zapisać ustawień konwersji.',//'在开始转换之前,请确保本程序目录下的 data 目录为可写权限,否则无法存储转换设置',
	'update_forum_too'	=> 'Przed aktualizacją UChome upewnij się, że posiadasz aktualną wersję forum Discuz!',//'如果有Discuz!和UChome同时需要升级,请务必先升级Discuz!论坛',
	'update_choose_process'	=> 'Proszę odpowiednio skonfigurować proces konwersji. W przeciwnym wypadku, proces nie zostanie zakończony prawidłowo.',//'请正确选择转换程序,否则可能造成无法转换成功',
	'update_more_space'	=> 'Proces konwersji nie ingeruje w aktualne dane, dlatego też kreator wymaga dwukrotnie więcej miejsca zgromadzonych danych na serwerze.',//'本转换程序不会破坏原始数据,所以转换需要2倍于原始数据空间',
	'source_version'	=> 'Twoja wersja',//'原始版本',
	'target_version'	=> 'Aktualizacja do wersji',//'目标版本',
	'introduction'		=> 'Wprowadzenie',//'简介',
	'description'		=> 'Opis',//'说明',
	'settings'		=> 'Ustawienia',//'设置',
	'view_readme'		=> 'Pokaż readme',//'查看',
	'change'		=> 'Zmień',//'修改',
	'start'			=> 'Start',//'开始',

//---------------------------
//convert/include/global.func.php

	'jan'	=> ' Styczeń ',//'一月',
	'feb'	=> ' Luty ',//'二月',
	'mar'	=> ' Marzec ',//'三月',
	'apr'	=> ' Kwiecień ',//'四月',
	'may'	=> ' Maj ',//'五月',
	'jun'	=> ' Czerwiec ',//'六月',
	'jul'	=> ' Lipiec ',//'七月',
	'aug'	=> ' Sierpień ',//'八月',
	'sep'	=> ' Wrzesień ',//'九月',
	'oct'	=> ' Październik ',//'十月',
	'nov'	=> ' Listopad ',//'十一月',
	'dec'	=> ' Grudzień ',//'十二月',
	'am'	=> ' AM ',//'上午',
	'pm'	=> ' PM ',//'下午',

	'prompt'		=> 'Komunikat',//'系统提示',
	'dzx_update'		=> 'Aktualizacja/Konwersja produktu Discuz! X',//'Discuz! X 系列产品升级转换',
	'dzx_update_wizard'	=> 'Kreator aktualizacji/konwersji produktu Discuz! X',//'Discuz! X 系列产品升级/转换 向导',
	'step1'		=> '1. Wybór rodzaju konwersji',//'1.选择产品转换程序',
	'step2'		=> '2. Konfiguracja serwera',//'2.设置服务器信息',
	'step3'		=> '3. Konfiguracja konwersji',//'3.配置转换过程',
	'step4'		=> '4. Proces konwersji',//'4.执行数据转换',
	'step5'		=> '5. Zakończenie konwersji',//'5.转换完成',

//---------------------------
//convert/source/d7.2_x1.0/pollvoter.php++

	'continue_convert_table '	=> 'Kontynuuj, aby przekonwertować tabele ',//'继续转换数据表 ',
	'was_converted'			=> '. Łącznie przekonwertowano: ',//', 已转换 ',
	'records'			=> 'rekordów',//'条记录',


//---------------------------
//convert/source/d7.2_x1.0/table/access.php

	'from'	=> ' z ',//' 从 ',
	'to'	=> ' do ',//' 至 ',
	'lines'	=> ' linii.',//' 行',

//---------------------------
//convert/source/d7.2_x1.0/threadtype.php++

	'convert_thread_type'	=> 'Konwersja tabeli typ tematu',//'继续转换主题分类数据表',

//---------------------------
//convert/source/d7.2_x1.5/table/activityapplies.php

	'contacts'	=> ' Kontakty: ',//' 联系方式:',

//---------------------------
//convert/source/d7.2_x2.0/table/moderators.php

	'converted'	=> ', przekonwertowano ',//'，已转换',
	'records'	=> ' rekordów.',//'条记录。',

//---------------------------
//convert/source/uch2.0_x1.0/table/home_event.php++

	'uchome_data'	=> 'Dane UCHome',//'UCHome数据',
	'uchome_events'	=> 'Wydarzenia UCHome',//'UCHome活动',
	'uchome_events_convert'	=> 'Konwertuj zawartość wydarzeń z UCenter Home',//'从 UCenter Home 转移过来的活动内容',

//---------------------------
//convert/source/uch2.0_x1.0/table/home_group.php++

	'group_home'	=> 'Grupy domowe',//'空间群组',

//---------------------------
//convert/source/uch2.0_x1.0/table/home_magic.php++

	'user_magic'	=> ' User Magic',//'用户道具',
	'magic_records'	=> 'Magic get records',//'道具收入记录',
	'magic_use_records'	=> 'Using magic records',//'道具使用记录',

//---------------------------
//convert/source/uch2.0_x1.0/table/home_poll.php++

	'uchome_polls'	=> 'Dane ankiet z UCHome',//'UCHome投票数据',
	'uchome_polls_convert'	=> 'Konwersja danych ankiet UCenter Home',//'从 UCenter Home 转移过来的投票内容',

//---------------------------
//convert/source/uch2.0_x1.0/table/home_space.php++

	'space_home_error'	=> 'Błąd: Brak punktów.',//'发生错误,请配置积分对应关系信息',
);