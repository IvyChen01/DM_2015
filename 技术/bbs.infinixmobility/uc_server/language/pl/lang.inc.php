<?php
//------------------------------------------------------
// INTERNATIONAL UCenter v.1.6.0 (Multilingual)
// by Valery Votintsev, codersclub.org
//------------------------------------------------------
// Based on UCenter 1.6.0, (c) Comsenz.inc, discuz.net
//------------------------------------------------------
// Polish Language Pack
// by kaaleth, codersclub.org
//------------------------------------------------------

define('UC_VERNAME', 'International Version');

$lang = array(

	'SC_GBK'		=> 'Simplified Chinese GBK',
	'TC_BIG5'		=> 'Traditional Chinese BIG5',
	'SC_UTF8'		=> 'Simplified Chinese  UTF8',
	'TC_UTF8'		=> 'Traditional Chinese UTF8',
	'EN_ISO'		=> 'ENGLISH ISO8859',
	'EN_UTF8'		=> 'ENGLISH UTF-8',

	'title_install'		=> SOFT_NAME.' proces instalacyjny',
	'agreement_yes'		=> 'Zgadzam się',
	'agreement_no'		=> 'Nie zgadzam się',
	'notset'		=> 'Bez limitów',

	'message_title'		=> 'Wskazówka',
	'error_message'		=> 'Błąd',
	'message_return'	=> 'Powrót',
	'return'		=> 'Powrót',
	'install_wizard'	=> 'Proces instalacyjny',
	'config_nonexistence'	=> 'Plik konfiguracyjny nie istnieje',
	'nodir'			=> 'Folder nie istnieje',
	'short_open_tag_invalid'	=> 'Proszę włączyć funkcję "short_open_tag" w pliku php.ini.',
	'redirect'			=> 'Proces instalacyjny uruchomi się automatycznie.<br>Jeśli tak się nie stało, kliknij tutaj.',

	'database_errno_2003'	=> 'Błąd połączenia z bazą danych, proszę upewnić się, czy baza danych została skonfigurowana poprawnie.',
	'database_errno_1044'	=> 'Wystąpił błąd podczas tworzenia nowej bazy danych, proszę sprawdzić jej nazwę.',
	'database_errno_1045'	=> 'Błąd połączenia z bazą danych, proszę sprawdzić nazwę użytkownika oraz hasło.',
	'database_errno_1064'	=> 'BŁĄD SQL',

	'dbpriv_createtable'	=> 'Brak zezwoleń "CREATE TABLE"',
	'dbpriv_insert'		=> 'Brak zezwoleń "INSERT"',
	'dbpriv_select'		=> 'Brak zezwoleń "SELECT"',
	'dbpriv_update'		=> 'Brak zezwoleń "UPDATE"',
	'dbpriv_delete'		=> 'Brak zezwoleń "DELETE"',
	'dbpriv_droptable'	=> 'Brak zezwoleń "DROP TABLE"',

	'db_not_null'		=> 'Wygląda na to, że UCenter został zainstalowany już wcześniej. Kontynuacja instalacji wyczyści stare dane.',
	'db_drop_table_confirm'	=> 'Zainstalować i usunąć stare dane?',

	'writeable'		=> 'Możliwy zapis',
	'unwriteable'		=> 'Niemożliwy zapis',
	'old_step'		=> 'Następny krok',
	'new_step'		=> 'Poprzedni krok',

	'database_errno_2003'	=> 'Nie można połączyć się z bazą danych. Upewnij się, czy jest baza danych została już utworzona z poprawną konfiguracją.',
	'database_errno_1044'	=> 'Nie można połączyć się z bazą danych, proszę sprawdzić nazwę bazy.',
	'database_errno_1045'	=> 'Nie można połączyć się z bazą danych, proszę sprawdzić nazwę użytkownika oraz hasło.',

	'step_env_check_title'	=> 'Rozpocznij instalację',
	'step_env_check_desc'	=> 'Sprawdzanie środowiska oraz uprawnień.',
	'step_db_init_title'	=> 'Instalacja danych',
	'step_db_init_desc'	=> 'Instalacja danych...',
	
	'step1_file'		=> 'Nazwa pliku',
	'step1_need_status'	=> 'Wymagane',
	'step1_status'		=> 'Aktualne',
	'not_continue'		=> 'Proszę rozwiązać problemy oznaczone czerwoną czcionką i spróbować ponownie.',

	'tips_dbinfo'			=> 'Informacje wejściowe',
	'tips_dbinfo_comment'		=> '',
	'tips_admininfo'		=> 'Informacje dotyczące konta Administratora',
	'tips_admininfo_comment'	=> 'Proszę zapamiętać hasło założyciela, gdyż może być potrzebne do logowania się w UCenter.',
	'step_ext_info_title'		=> 'Instalacja przebiegła poprawnie.',
	'step_ext_info_desc'		=> 'Kliknij tutaj aby zalogować się.',

	'ext_info_succ'			=> 'Instalacja została zakończona',
	'install_locked'		=> 'Installation is Locked due to previous installation, if you want to install again, please delete <br /> '.str_replace(ROOT_PATH, '', $lockfile),
	'error_quit_msg'		=> 'Proszę rozwiązać następujące błędy.',

	'step_app_reg_title'		=> 'Konfiguracja środowiska',
	'step_app_reg_desc'		=> 'Check Server and Set UCenter',
	'tips_ucenter'			=> 'Please fill in related info of UCenter',
	'tips_ucenter_comment'		=> 'UCenter to główny rdzeń oprogramowania Comsenz. Discuz! Instalacja forum wymaga tejże aplikacji. Jeśli UCenter został zainstalowany wcześniej, proszę wypełnić informację o jego dostępie lub przejść do <a href="http://www.discuz.com/" target="blank">centrum produktów Comsenz</a> aby pobrać i zainstalować to oprogramowanie.',

	'advice_mysql_connect'		=> 'Proszę się upewnić, czy moduł MySQL został załadowany poprawnie.',
	'advice_fsockopen'		=> 'Proszę włączyć funkcję "allow_url_fopen" w pliku "php.ini". Jeśli nie masz o tym zielonego pojęcia, skontaktuj się z dostawcą usługi.',
	'advice_gethostbyname'		=> '"gethostbyname" function is needed. Please contact space provider to make sure it is enabled',
	'advice_file_get_contents'	=> 'Proszę włączyć funkcję "allow_url_fopen" w pliku "php.ini". Jeśli nie masz o tym zielonego pojęcia, skontaktuj się z dostawcą usługi.d',
	'advice_xml_parser_create'	=> 'Funkcja XML wymaga wsparcia w PHP. Jeśli nie masz o tym zielonego pojęcia, skontaktuj się z dostawcą usługi.',

	'ucurl'				=> 'Adres URL do UCenter',
	'ucpw'				=> 'Hasło założyciela UCenter',

	'tips_siteinfo'			=> 'Uzupełnij informacje na temat strony.',
	'sitename'			=> 'Nazwa strony',
	'siteurl'			=> 'Adres URL strony',

	'forceinstall'			=> 'Force Install',
	'dbinfo_forceinstall_invalid'	=> 'You may modify table prefix to prevent data loss if current database contains data with the same table prefix; force install will erase all the previous data!',

	'click_to_back'			=> 'Kliknij tutaj, aby powrócić',
	'adminemail'			=> 'System Emaili',
	'adminemail_comment'		=> 'Służy do wysyłania raportów o błędach skryptów',
	'dbhost_comment'		=> 'Host, najczęściej: localhost',
	'tablepre_comment'		=> 'Proszę zmień prefiks, jeśli jedna baza zawierać będzie kilka forów.',
	'forceinstall_check_label'	=> 'Chcę wymazać poprzednie dane!!!',

	'uc_url_empty'			=> 'Adres URL UCenter jest pusty, proszę wypełnić to pole.',
	'uc_url_invalid'		=> 'Format URL nie jest poprawny.',
	'uc_url_unreachable'		=> 'Adres URL UCenter nie jest poprawny.',
	'uc_ip_invalid'			=> 'Cannot resolve domain, please fill in website IP</font>',
	'uc_admin_invalid'		=> 'Wprowadzono błędne hasło założyciela, spróbuj ponownie.',
	'uc_data_invalid'		=> 'Połączenie nie powiodło się, sprawdź adres URL do UCenter',
	'ucenter_ucurl_invalid'		=> 'Adres URL do UCenter jest pusty lub niepoprawny',
	'ucenter_ucpw_invalid'		=> 'Hasło założyciela UCenter jest puste lub niepoprawne',
	'siteinfo_siteurl_invalid'	=> 'Adres URL strony jest pusty lub niepoprawny',
	'siteinfo_sitename_invalid'	=> 'Nazwa strony jest pusta lub niepoprawna',
	'dbinfo_dbhost_invalid'		=> 'Nazwa hosta bazy danych jest pusta lub niepoprawna',
	'dbinfo_dbname_invalid'		=> 'Nazwa bazy danych jest pusta lub niepoprawna',
	'dbinfo_dbuser_invalid'		=> 'Nazwa użytkownika bazy danych jest pusta lub niepoprawna',
	'dbinfo_dbpw_invalid'		=> 'Hasło jest puste lub niepoprawne',
	'dbinfo_adminemail_invalid'	=> 'Adres Email jest pusty lub niepoprawny',
	'dbinfo_tablepre_invalid'	=> 'Wprowadzono błędny prefiks, nie może zaczynać się od cyfr lub format jest niepoprawny "."',
	'admininfo_username_invalid'	=> 'Nazwa Administratora jest pusta lub niepoprawna',
	'admininfo_email_invalid'	=> 'Adres Administratora Email jest pusty lub niepoprawny',
	'admininfo_ucfounderpw_invalid'	=> 'Hasło Administratora jest puste, proszę uzupełnić to pole',
	'admininfo_ucfounderpw2_invalid'	=> 'Wprowadzone hasła nie pasują do siebie',

	'username'			=> 'Nazwa Administratora',
	'email'				=> 'Email Administratora',
	'password'			=> 'Hasło Administratora',
	'password_comment'		=> 'Hasło Administratora nie może być puste.',
	'password2'			=> 'Proszę powtórzyć hasło.',

	'admininfo_invalid'		=> 'Dane Administratora są niekompletne. Proszę uzupełnić pominięte pola.',
	'dbname_invalid'		=> 'Nazwa bazy danych jest pusta. Proszę uzupełnić to pole.',
	'admin_username_invalid'	=> 'Wprowadzono błędną nazwę użytkownika. Rozmiar nie może przekroczyć 15 znaków. Nie używaj znaków specjalnych.',
	'admin_password_invalid'	=> 'Wprowadzone hasła nie pasują do siebie.',
	'admin_email_invalid'		=> 'Wprowadzono błędny adres Email. Być może został już użyty lub zawiera niepoprawne znaki.',
	'admin_invalid'			=> 'Dane Administratora są niekompletne. Wszystkie pola są wymagane.',
	'admin_exist_password_error'	=> 'Username exists, if you want to set it as forum admin, please fill in correct password, or change another username',

	'tagtemplates_subject'	=> 'Temat',
	'tagtemplates_uid'	=> 'UID',
	'tagtemplates_username'	=> 'Autor',
	'tagtemplates_dateline'	=> 'Data',
	'tagtemplates_url'	=> 'URL',

	'uc_version_incorrect'	=> 'Twoja wersja UCenter jest już nieaktualna. Proszę zaktualizować do najnowszej wersji. Wydane angielskie: http://www.distown.net/forum-12-1.html, wersja oficjalna: http://www.comsenz.com/ .',
	'config_unwriteable'	=> 'Nie można nadpisać pliku konfiguracyjnego. Proszę ustalić prawa do zapisu (777) dla "config.inc.php".',

	'install_in_processed'	=> 'Instalacja...',
	'install_succeed'	=> 'Zainstalowano poprawnie, kliknij tutaj, aby przejść do kolejnego kroku.',
	'license'		=> '<div class="license"><h1>Licencja</h1>

<p> Copyright (c) 2001-2010, Hong Sing Imagination (Beijing) Co., Ltd. Wszystkie prawa zastrzeżone.</p>

<p> Dzięki za wybór produktu UCenter. Mamy nadzieję, że nasz wysiłek zapewni Państwu szybkie, wydajne i efektywne zarządzanie witryną.</p>

<p> Sing Imagination (Beijing) Technology Co., Ltd. dla deweloperów produktu UCenter, and they shall have UCenter products copyright. Sing Imagination (Beijing) Technology Co., Ltd. strona internetowa http://www.comsenz.com, UCenter oficjalnie dostępny jest pod adresem http://www.discuz.com, wspiarcie otrzymasz na oficjalnym forum http://www.discuz . net.</p>

<p> Prawa dotyczące UCenter zostały zarejestrowane w administracji praw autorskich, w Chińskiej Republice Narodowej i obejmują zasięg międzynarodowy. Użytkownicy: osoby lub organizacje, profit bądź non-profil, muszą dokładnie zapoznać się z umową, zgodzić się i przestrzegać wszystkich jej warunków od momentu rozpoczęcia pracy z oprogramowaniem UCenter.</p>

<p> Niniejsza licencja odnośi się tylko i wyłącznie do aplikacji UCenter w wersji 1.x. Tylko Hong Sing Imagination (Beijing) Technology Co., Ltd. posiada możliwość jej interpretacji.</p>

<h3> I. license agreement right </h3>
<ol>
<li> you can fully comply with the end user license agreement, based on the software used in this non-commercial use, without having to pay for software copyright licensing fees.</li>
<li> agreement you can within the constraints and limitations UCenter modify the source code (if provided) or interface styles to suit your site requirements.</li>
<li> you have to use this software to build the site all the members of the information, articles and related information of ownership, and is independent of commitment and legal obligations related to the article content.</li>
<li> a commercial license, you can use this software for commercial applications, while according to the type of license purchased to determine the period of technical support, technical support, technical support form and content, from the moment of purchase, within the period of technical support have a way to get through the specified designated areas of technical support services. Business authorized users have the power to reflect and comment, relevant comments will be a primary consideration, but not necessarily be accepted promise or guarantee.</li>
</ol>

<h3> II. agreement constraints and limitations </h3>
<ol>
<li> business license has not been before, may not use this software for commercial purposes (including but not limited to business sites, business operations, for commercial purpose or profit web site). Purchase of commercial license, please visit http://www.discuz.com reference instructions, call 8610-51657885 for more details.</li>
<li> may not associated with the software or business license for rental, sale, mortgage or grant sub-licenses.</li>
<li> In any case, that no matter how used, whether modified or landscaping, changes to what extent, just use UCenter whole or any part, without the written permission of the page footer Department UCenter name and Sing Imagination (Beijing) Technology Co., Ltd. affiliated website (http://www.comsenz.com, http://www.discuz.com or http://www.discuz.net) the link must be retained, not removed or modified.</li>
<li> prohibited UCenter whole or any part of the basis for the development of any derivative version, modified version or third-party version for redistribution.</li>
<li> If you failed to comply with the terms of this Agreement, your authorization will be terminated by the license rights will be recovered, and bear the corresponding legal responsibility.</li>
</ol>

<h3> III. Limited Warranty and Disclaimer </h3>
<ol>
<li> the software and the accompanying documents as not to provide any express or implied, or guarantee in the form of compensation provided.</li>
<li> user voluntary use of this software, you must understand the risks of using this software, technical services in the not to buy products, we do not promise to provide any form of technical support, use the warrant or assume any use of this software issues related to liability arising.</li>
<li> Sing Imagination (Beijing) Technology Co., Ltd. does not use the software to build the site responsible for articles or information.</li>
</ol>

<p> the UCenter end user license agreement, business license and technical services to the details provided by UCenter exclusive official website. Sing Imagination (Beijing) Technology Co., Ltd. has, without prior notice, modify the license agreement and the power of service price list, the revised agreement or change list from the date of the new authorized user effect.</p>

<p> electronic text form of license agreement as the two sides signed an agreement in writing as a complete and equivalent legal effect. Once you start the installation UCenter, shall be deemed to fully understand and accept the terms of this Agreement, in the enjoyment of the powers conferred by these provisions, while subject to restrictions and limitations related. Acts outside the scope of protocol licensing will be a direct violation of the licensing agreement and constitutes infringement, we have the right to terminate the authorization, shall be ordered to stop the damage, and reserves the power to investigate ?? responsibility.</p></div>',

	'uc_installed'		=> 'UCenter został już zainstalowany. Jeśli chcesz przeinstalować program, proszę usunąć plik "data/install.lock"',
	'i_agree'		=> 'Zgadzam się',
	'supportted'		=> 'Wspierane',
	'unsupportted'		=> 'Nie wspierane',
	'max_size'		=> 'Wspiera/Maks. rozmiar',
	'project'		=> 'Projekt',
	'ucenter_required'	=> 'Wymagania UCenter',
	'ucenter_best'		=> 'UCenter rządzi!',
	'curr_server'		=> 'Aktualnie',
	'env_check'		=> 'Sprawdź środowisko',
	'os'			=> 'System operacyjny',
	'php'			=> 'Wersja PHP',
	'attachmentupload'	=> 'Upload załączników',
	'unlimit'		=> 'Bez limitów',
	'version'		=> 'Wersja',
	'gdversion'		=> 'Wersja GD',
	'allow'			=> 'Zezwala',
	'unix'			=> 'Unix',
	'diskspace'		=> 'Przestrzeń dysku',
	'priv_check'		=> 'Sprawdź katalog & Uprawnienia plików',
	'func_depend'		=> 'Check Depended Functions',
	'func_name'		=> 'Funkcja',
	'check_result'		=> 'Rezultat',
	'suggestion'		=> 'Sugestia',
	'advice_mysql'		=> 'Proszę sprawdzić, czy moduł MySQL został załadowany.',
	'advice_fopen'		=> 'Proszę włączyć funkcję "allow_url_fopen" w pliku "php.ini". Jeśli nie masz o tym zielonego pojęcia, skontaktuj się z dostawcą usługi.',
	'advice_file_get_contents'	=> 'Proszę włączyć funkcję "allow_url_fopen" w pliku "php.ini". Jeśli nie masz o tym zielonego pojęcia, skontaktuj się z dostawcą usługi.',
	'advice_xml'		=> 'Funkcja XML wymaga wsparcia w PHP. Jeśli nie masz o tym zielonego pojęcia, skontaktuj się z dostawcą usługi.',
	'none'			=> 'Brak',

	'dbhost'	=> 'Host BD',
	'dbuser'	=> 'Użytkownik BD',
	'dbpw'		=> 'Hasło BD',
	'dbname'	=> 'Nazwa BD',
	'tablepre'	=> 'Prefiks tabel',

	'ucfounderpw'	=> 'Hasło założyciela',
	'ucfounderpw2'	=> 'Potwierdzenie hasła',

	'create_table'	=> 'Tworzenie tabeli',
	'succeed'	=> 'Sukces!',
);