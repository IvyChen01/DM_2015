<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $ID: lang_email.php by Valery Votintsev at 
 *      polish language pack by kaaleth ( kaaleth-discuzpl@windowslive.com )
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$lang = array
(
	'hello'				=> 'Cześć',//'你好',
	'moderate_member_invalidate'	=> 'Odrzuć',//'否决',
	'moderate_member_delete'	=> 'Usuń',//'删除',
	'moderate_member_validate'	=> 'Akceptuj',//'通过',


	'get_passwd_subject'	=> 'Odzyskiwanie hasła',//'取回密码说明',
	'get_passwd_message'	=> '
<p>{username},
Ta wiadomość została wysłana ze strony {bbname}.</p>

<p>Otrzymałeś tą wiadomość, ponieważ ten adres email został zarejestrowany
 na konto użytkownika naszego forum, który wysłał prośbę o odzyskanie hasła.</p>
<p>
----------------------------------------------------------------------<br />
<strong>Ważne!</strong><br />
----------------------------------------------------------------------</p>

<p>Jeśli to nie Ty odwiedzasz nasze forum lub nie przeprowadziłeś żadnej zmiany,
proszę zignorować tą wiadomość.</p>
<p>
----------------------------------------------------------------------<br />
<strong>Instrukcja odzyskiwania hasła</strong><br />
----------------------------------------------------------------------</p>
</p>
Link z prośbą o odzyskanie hasła jest ważny tylko i wyłącznie przez 3 dni od momentu dostarczenia tej wiadomośc:<br />

<a href="{siteurl}member.php?mod=getpasswd&amp;uid={uid}&amp;id={idstring}" target="_blank">{siteurl}member.php?mod=getpasswd&amp;uid={uid}&amp;id={idstring}</a>
<br />
(Jeśli nie działa, proszę skopiować link do pola adresu w przeglądarce internetowej.)</p>

<p>Po otwarciu strony, proszę wprowadzić nowe hasło i potwierdzić formularz. Dopiero wtedy będziesz
mógł uzyskać dostęp do konta wpisując swoje nowe hasło.
Pamiętaj, że hasło możesz zmienić kiedykolwiek podczas edycji własnego konta.</p>

<p>Żądanie zostało wysłane z adresu IP: {clientip}</p>


<p>
Z poważaniem,<br />
</p>
<p>Ekipa {bbname} .
{siteurl}</p>',


	'email_verify_subject'	=> 'Weryfikacja adresu email',//'email 地址验证',
	'email_verify_message'	=> '
<p>{username},<br />
Ta wiadomość została wysłana ze strony {bbname}.</p>

<p>Otrzymałeś tą wiadomość, ponieważ Twój adres email został zarejestrowany na naszym forum lub
ktoś z użytkowników przez pomyłkę wprowadził błędny podczas edycji konta.
Jeśli to nie Ty odwiedzasz nasze forum lub nie przeprowadziłeś żadnej zmiany,
proszę zignorować tą wiadomość.</p>
<br />
----------------------------------------------------------------------<br />
<strong>Instrucje aktywacji konta</strong><br />
----------------------------------------------------------------------<br />
<br />
<p>Jeśli jesteś nowy na forum lub dokonałeś zmian w swoim profilu, proszę zastosować się do poniższych instrukcji.
Wymagamy weryfikacji Twojego adres email. Operacja zapobiega niechcianym wiadomościom SPAM oraz innym operacjom.</p>

<p>Aby aktywować konto, kliknij na poniższy odnośnik:<br />

<a href="{url}" target="_blank">{url}</a>
<br />
(Jeśli nie działa, proszę skopiować link do pola adresu w przeglądarce internetowej.)</p>

<p>Dziękujemy za wizytę. Mamy nadzieję, że będziesz z nami szczęśliwy!</p>


<p>
Z poważaniem,<br />

Ekipa {bbname} .<br />
{siteurl}</p>',

	'email_register_subject' =>	'Rejestracja na forum',//'论坛注册地址',
'email_register_message' =>	'<br />
<p>Ta wiadomość została wysłana ze strony {bbname}.</p>

<p>Otrzymałeś tą wiadomość, ponieważ Twój adres email został zarejestrowany w serwisie {bbname}.
Jeśli nie chcesz odwiedzać naszego forum lub wycofać się z rejestracji,
proszę zignorować tą wiadomość.</p>
<br />
----------------------------------------------------------------------<br />
<strong>Instrukcje rejestracji nowego konta</strong><br />
----------------------------------------------------------------------<br />
<br />
<p>Wygląda na to, że zostałeś nowym użytkownikiem serwisu {bbname} lub dokonałeś zmian w swoim aktualnym koncie.
Każda operacja mająca na celu zmianę danych chroniących Twoje konto, będzie wymagać wcześniejszego potwierdzenia.</p>

<p>Link ważny jest przez kolejne 3 dni od momentu jego wysłania. Po upływie tego czasu, możesz poprosić o nowy link aktywacyjny. Aby dokończyć proces rejestracji, proszę kliknąć w poniższy odnośnik. <br />

<a href="{url}" target="_blank">{url}</a>
<br />
(Jeśli nie działa, proszę skopiować link do pola adresu w przeglądarce internetowej.)</p>

<p>Dziękujemy za wizytę.Thank you for your visit. Do zobaczenia!</p>


<p>
Z poważaniem,<br />

Ekipa {bbname} .<br />
{siteurl}</p>',


	'add_member_subject'	=> 'Zostałeś dodany jako nowy użytkownik',//'您被添加成为会员',
	'add_member_message'	=> '
{newusername},
<p>Ta wiadomość została wysłana ze strony {bbname}.</p><br />
<br />
Witaj,
Przedstawiam się jako {adminusername} i jestem jednym z administratorów w serwisie {bbname}.<br />
Otrzymałeś tą wiadomość, ponieważ specjalnie dla Ciebie zostało utworzone nowe konto<br />
na naszym forum, do którego przypisaliśmy właśnie ten adres email.<br />
<br />
----------------------------------------------------------------------<br />
Ważne!<br />
----------------------------------------------------------------------<br />
<br />
Jeśli nie jesteś zainteresowany członkostwem na naszym forum, proszę zignorować tą wiadomość.<br />
<br />
----------------------------------------------------------------------<br />
Informacje dotyczące konta<br />
----------------------------------------------------------------------<br />
<br />
Nazwa forum: {bbname}<br />
Adres forum: {siteurl}<br />
<br />
Użytkownik: {newusername}<br />
Hasło: {newpassword}<br />
<br />
Od teraz możesz użyć swojego konta by zalogować się na naszym forum, życzę przyjemności podczas Twoich odwiedzin!<br />
<br />
<br />
<br />
Z poważaniem,<br />
<br />
Ekipa {bbname} .<br />
{siteurl}',


	'birthday_subject'	=> 'Wszystkiego najlepszego!',//'祝您生日快乐',
	'birthday_message'	=> '<br />
{username},<br />
Ta wiadomość została wysłana ze strony {bbname}.<br />
<br />
Otrzymałeś tą wiadomość, ponieważ Twój adres email został zarejestrowany na naszym forum {bbname}.<br />
Według danych zawartch w Twoim profilu, dziś są Twoje urodziny.<br />
W związku z powyższym, ekipa forum życzy Tobie wszystkiego, co najlepsze,
a także spełnienia najskrytszych marzeń!<br />
<br />
Jeśli to nie Ty jesteś członkiem naszego forum, być może nastąpiła pomyłka.<br />
Sprawdź adres email oraz datę urodzenia w profilu.<br />
Proszę nie odpowiadać na tą wiadomość.<br />
<br />
<br />
<p>
Z poważaniem,<br />

Ekipa {bbname} .<br />
{siteurl}</p>',

	'email_to_friend_subject'	=> '{$_G[member][username]} polecił Tobie temat: $thread[subject]',//'{$_G[member][username]} 推荐给您: $thread[subject]',
	'email_to_friend_message'	=> '<br />
Ta wiadomość została wysłana przez {$_G[member][username]} ze strony {$_G[setting][bbname]}.<br />
<br />
Otrzymałeś tą wiadomość, ponieważ użytkownik {$_G[member][username]}<br />
ze strony {$_G[setting][bbname]} polecił Ci tę zawartość używając przycisku "poleć znajomym".<br />
Polecamy przejrzenie wiadomości.<br />
Jeśli nie jesteś zainteresowany, proszę zignorować tą wiadomość.<br />
Ta wiadomość została wysłana dobrowolnie.<br />
<br />
----------------------------------------------------------------------<br />
Treść wiadomości<br />
----------------------------------------------------------------------<br />
<br />
$message<br />
<br />
----------------------------------------------------------------------<br />
Koniec wiadomości<br />
----------------------------------------------------------------------<br />
<br />
Proszę pamiętać, że wiadomość została wysłana przez użytkownika naszego forum, który skorzystał z przycisku "poleć znajomym".<br />
Ekipa forum nie odpowiada za treść umieszczoną w tej zawartości.<br />
<br />
<br />
Witaj na {$_G[setting][bbname]}<br />
$_G[siteurl]',

	'email_to_invite_subject'	=> 'Twój znajomy {$_G[member][username]} zaprasza Cię do rejestracji na {$_G[setting][bbname]}',//'您的朋友 {$_G[member][username]} 发送 {$_G[setting][bbname]} 论坛注册邀请码给您',
	'email_to_invite_message'	=> '<br />
$sendtoname,<br />
Ta wiadomość została wysłana od {$_G[member][username]} z forum {$_G[setting][bbname]}.<br />
<br />
Otrzymałeś tą wiadomość, ponieważ została ona wysłana przez {$_G[member][username]} z {bbname} .<br />
Ta wiadomość zawiera kod zaproszenia, który upoważnia Cię do rejestracji na naszym forum,<br />
a także przekazuje następującą treść.<br />
<br />
!!! Jeśli nie jesteś zainteresowany, proszę zignorować tę wiadomość.<br />
Nie musisz usuwać subskrypcji lub korzystać z podobnych funkcji.<br />
<br />
----------------------------------------------------------------------<br />
Treść wiadomości<br />
----------------------------------------------------------------------<br />
<br />
$message<br />
<br />
----------------------------------------------------------------------<br />
Koniec wiadomości<br />
----------------------------------------------------------------------<br />
<br />
Proszę pamiętać, że wiadomość została wysłana przez użytkownika naszego forum.<br />
Ekipa forum nie odpowiada za treść umieszczoną w tej zawartości.<br />
<br />
Witaj na {$_G[setting][bbname]}
$_G[siteurl]',


	'moderate_member_subject'	=> 'Weryfikacja tożsamości',//'用户审核结果通知',
	'moderate_member_message'	=> '<br />
<p>{username},
Ta wiadomość została wysłana z forum {bbname}.</p>

<p>Otrzymałeś tę wiadomość, ponieważ każdy nowo zarejestrowany użytkownik
musi zostać zweryfikowany przez administratora forum.
Po zakończeniu aktywacji, zostaniesz poinformowany.</p>
<br />
----------------------------------------------------------------------<br />
<strongInformacje dotyczące rejestracji</strong><br />
----------------------------------------------------------------------<br />
<br />
Użytkownik: {username}<br />
Data rejestracji: {regdate}<br />
Czas nadesłania: {submitdate}<br />
Numer zgłoszenia: {submittimes}<br />
Powód rejestracji: {message}<br />
<br />
Rezultat weryfikacji: {modresult}<br />
Czas weryfikacji: {moddate}<br />
Weryfikator: {adminusername}<br />
Wiadomość od Administratora: {remark}<br />
<br />
----------------------------------------------------------------------<br />
<strong>Wynik</strong><br />
----------------------------------------------------------------------<br />

<p>Zatwierdzony: Twoja rejestracja została przyjęta. Zostałeś użytkownikiem forum {bbname}.</p>

<p>Odrzucony: Twoje informacje nie są kompletne lub nie spełniają narzuconych wymagań.
Możesz odwołać się ponownie, <a href="home.php?mod=spacecp&ac=profile" target="_blank">uzupełniając szczegóły konta</a> i zatwierdzić raz jeszcze.</p>

<p>Usunięty: Twoje żądanie zostało odrzucone, ponieważ nie spełnia narzuconych wymagań lub
liczba rejestracji osiągneła już limit.
Twoje informacje zostały kompletnie usunięte z naszej bazy danych.
Szczegóły logowania nie mogą zostać użyte na forum.</p>
<br />
<br />
Z poważaniem,<br />
<br />
Ekipa {bbname} .<br />
{siteurl}',

	'adv_expiration_subject' => 'Twoja reklama wygaśnie za {day} dni.',//'您站点的广告将于 {day} 天后到期，请及时处理',
	'adv_expiration_message' => 'Następujące reklamy wygasną w przeciągu {day} dni, proszę sprawdzić:<br /><br />{advs}',//'您站点的以下广告将于 {day} 天后到期，请及时处理：<br /><br />{advs}',
	'invite_payment_email_message'	=> '
Dziękujemy za skorzystanie z {bbname}, ({siteurl}). Twoje zamówienie {orderid} zostało skompletowane i zweryfikowane.<br />
<br />----------------------------------------------------------------------<br />
Poniżej znajdziesz kod zaproszenia
<br />----------------------------------------------------------------------<br />

{codetext}

<br />----------------------------------------------------------------------<br />
Ważne!
<br />----------------------------------------------------------------------<br />',
);

