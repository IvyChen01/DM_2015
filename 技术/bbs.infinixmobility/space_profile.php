<?php
define('CURSCRIPT', 'test');
require './source/class/class_core.php';//引入系统核心文件
$discuz = & discuz_core::instance();//以下代码为创建及初始化对�?
$discuz->init();

include DISCUZ_ROOT.'source/language/'.DISCUZ_LANG.'/lang_template.php';
$_G['lang'] = array_merge($_G['lang'], $lang);

$without_tpl = true;
include DISCUZ_ROOT.'source/include/spacecp/spacecp_profile.php';
/*echo "<pre>";
print_r($space);
echo "</pre>";
exit();*/
$gender = array("0"=>"Secret","1"=>"Male","2"=>"Female");
$birthyear = array();
$birthmonth = array(
	"1"=>"January",
	"2"=>"February",
	"3"=>"March",
	"4"=>"April",
	"5"=>"May",
	"6"=>"June",
	"7"=>"July",
	"8"=>"August",
	"9"=>"September",
	"10"=>"October",
	"11"=>"November",
	"12"=>"December"
);
$birthday = array();
for($i=1916;$i<=2015;$i++){
	$birthyear[$i]=$i;
}
for($i=1;$i<=31;$i++){
	$birthday[$i]=$i;
}
$birthprovince = array(
"Abkhazia"=>"Abkhazia",
"Andorra"=>"Andorra",
"United Arab Emirates"=>"United Arab Emirates",
"Afghanistan"=>"Afghanistan",
"Antigua and Barbuda"=>"Antigua and Barbuda",
"Anguilla"=>"Anguilla",
"Albania"=>"Albania",
"Armenia"=>"Armenia",
"Netherlands Antilles"=>"Netherlands Antilles",
"Angola"=>"Angola",
"Argentina"=>"Argentina",
"American Samoa"=>"American Samoa",
"Austria"=>"Austria",
"Australia"=>"Australia",
"Aruba"=>"Aruba",
"Aland Islands"=>"Aland Islands",
"Azerbaijan"=>"Azerbaijan",
"Bosnia and Herzegovina"=>"Bosnia and Herzegovina",
"Barbados"=>"Barbados",
"Bangladesh"=>"Bangladesh",
"Belgium"=>"Belgium",
"Burkina Faso"=>"Burkina Faso",
"Bulgaria"=>"Bulgaria",
"Bahrain"=>"Bahrain",
"Burundi"=>"Burundi",
"Benin"=>"Benin",
"Saint Barthelemy"=>"Saint Barthelemy",
"Bermuda"=>"Bermuda",
"Brunei Darussalam"=>"Brunei Darussalam",
"Bolivia"=>"Bolivia",
"Brazil"=>"Brazil",
"Bahamas"=>"Bahamas",
"Bhutan"=>"Bhutan",
"Bouvet Island"=>"Bouvet Island",
"Botswana"=>"Botswana",
"Belarus"=>"Belarus",
"Belize"=>"Belize",
"Canada"=>"Canada",
"Cocos (Keeling) Islands"=>"Cocos (Keeling) Islands",
"Congo, The Democratic Republic of the"=>"Congo, The Democratic Republic of the",
"Central African Republic"=>"Central African Republic",
"Congo"=>"Congo",
"Switzerland"=>"Switzerland",
"Cote D'Ivoire"=>"Cote D'Ivoire",
"Cook Islands"=>"Cook Islands",
"Chile"=>"Chile",
"Cameroon"=>"Cameroon",
"China"=>"China",
"Colombia"=>"Colombia",
"Costa Rica"=>"Costa Rica",
"Cuba"=>"Cuba",
"Cape Verde"=>"Cape Verde",
"Christmas Island"=>"Christmas Island",
"Cyprus"=>"Cyprus",
"Czech Republic"=>"Czech Republic",
"Germany"=>"Germany",
"Djibouti"=>"Djibouti",
"Denmark"=>"Denmark",
"Dominica"=>"Dominica",
"Dominican Republic"=>"Dominican Republic",
"Algeria"=>"Algeria",
"Ecuador"=>"Ecuador",
"Estonia"=>"Estonia",
"Egypt"=>"Egypt",
"Western Sahara"=>"Western Sahara",
"Eritrea"=>"Eritrea",
"Spain"=>"Spain",
"Ethiopia"=>"Ethiopia",
"Europe"=>"Europe",
"Finland"=>"Finland",
"Fiji"=>"Fiji",
"Falkland Islands (Malvinas)"=>"Falkland Islands (Malvinas)",
"Micronesia, Federated States of"=>"Micronesia, Federated States of",
"Faroe Islands"=>"Faroe Islands",
"France"=>"France",
"France, Metropolitan"=>"France, Metropolitan",
"Gabon"=>"Gabon",
"Great Britain"=>"Great Britain",
"Grenada"=>"Grenada",
"Georgia"=>"Georgia",
"French Guiana"=>"French Guiana",
"Guernsey"=>"Guernsey",
"Ghana"=>"Ghana",
"Gibraltar"=>"Gibraltar",
"Greenland"=>"Greenland",
"Gambia"=>"Gambia",
"Guinea"=>"Guinea",
"Guadeloupe"=>"Guadeloupe",
"Equatorial Guinea"=>"Equatorial Guinea",
"Greece"=>"Greece",
"South Georgia and the South Sandwich Islands"=>"South Georgia and the South Sandwich Islands",
"Guatemala"=>"Guatemala",
"Guam"=>"Guam",
"Guinea-Bissau"=>"Guinea-Bissau",
"Guyana"=>"Guyana",
"Hong Kong"=>"Hong Kong",
"Heard and McDonald Islands"=>"Heard and McDonald Islands",
"Honduras"=>"Honduras",
"Croatia"=>"Croatia",
"Haiti"=>"Haiti",
"Hungary"=>"Hungary",
"Indonesia"=>"Indonesia",
"Ireland"=>"Ireland",
"Israel"=>"Israel",
"Isle of Man"=>"Isle of Man",
"India"=>"India",
"British Indian Ocean Territory"=>"British Indian Ocean Territory",
"Iraq"=>"Iraq",
"Iran, Islamic Republic of"=>"Iran, Islamic Republic of",
"Iceland"=>"Iceland",
"Italy"=>"Italy",
"Jersey"=>"Jersey",
"Jamaica"=>"Jamaica",
"Jordan"=>"Jordan",
"Japan"=>"Japan",
"Kenya"=>"Kenya",
"Kyrgyzstan"=>"Kyrgyzstan",
"Cambodia"=>"Cambodia",
"Kiribati"=>"Kiribati",
"Comoros"=>"Comoros",
"Saint Kitts and Nevis"=>"Saint Kitts and Nevis",
"Korea, Democratic People's Republic of"=>"Korea, Democratic People's Republic of",
"Korea, Republic of"=>"Korea, Republic of",
"Kuwait"=>"Kuwait",
"Cayman Islands"=>"Cayman Islands",
"Kazakhstan"=>"Kazakhstan",
"Lao People's Democratic Republic"=>"Lao People's Democratic Republic",
"Lebanon"=>"Lebanon",
"Saint Lucia"=>"Saint Lucia",
"Liechtenstein"=>"Liechtenstein",
"Sri Lanka"=>"Sri Lanka",
"Liberia"=>"Liberia",
"Lesotho"=>"Lesotho",
"Lithuania"=>"Lithuania",
"Luxembourg"=>"Luxembourg",
"Latvia"=>"Latvia",
"Libyan Arab Jamahiriya"=>"Libyan Arab Jamahiriya",
"Morocco"=>"Morocco",
"Monaco"=>"Monaco",
"Moldova, Republic of"=>"Moldova, Republic of",
"Montenegro"=>"Montenegro",
"Saint Martin"=>"Saint Martin",
"Madagascar"=>"Madagascar",
"Marshall Islands"=>"Marshall Islands",
"Macedonia"=>"Macedonia",
"Mali"=>"Mali",
"Myanmar"=>"Myanmar",
"Mongolia"=>"Mongolia",
"Macau"=>"Macau",
"Northern Mariana Islands"=>"Northern Mariana Islands",
"Martinique"=>"Martinique",
"Mauritania"=>"Mauritania",
"Montserrat"=>"Montserrat",
"Malta"=>"Malta",
"Mauritius"=>"Mauritius",
"Maldives"=>"Maldives",
"Malawi"=>"Malawi",
"Mexico"=>"Mexico",
"Malaysia"=>"Malaysia",
"Mozambique"=>"Mozambique",
"Namibia"=>"Namibia",
"New Caledonia"=>"New Caledonia",
"Niger"=>"Niger",
"Norfolk Island"=>"Norfolk Island",
"Nigeria"=>"Nigeria",
"Nicaragua"=>"Nicaragua",
"Netherlands"=>"Netherlands",
"Norway"=>"Norway",
"Nepal"=>"Nepal",
"Nauru"=>"Nauru",
"Niue"=>"Niue",
"New Zealand"=>"New Zealand",
"Oman"=>"Oman",
"South Ossetia"=>"South Ossetia",
"Panama"=>"Panama",
"Peru"=>"Peru",
"French Polynesia"=>"French Polynesia",
"Papua New Guinea"=>"Papua New Guinea",
"Philippines"=>"Philippines",
"Pakistan"=>"Pakistan",
"Poland"=>"Poland",
"Saint Pierre and Miquelon"=>"Saint Pierre and Miquelon",
"Pitcairn"=>"Pitcairn",
"Puerto Rico"=>"Puerto Rico",
"Palestine"=>"Palestine",
"Portugal"=>"Portugal",
"Palau"=>"Palau",
"Paraguay"=>"Paraguay",
"Qatar"=>"Qatar",
"Reunion"=>"Reunion",
"Romania"=>"Romania",
"Serbia"=>"Serbia",
"Russia"=>"Russia",
"Rwanda"=>"Rwanda",
"Saudi Arabia"=>"Saudi Arabia",
"Solomon Islands"=>"Solomon Islands",
"Seychelles"=>"Seychelles",
"Sudan"=>"Sudan",
"Sweden"=>"Sweden",
"Singapore"=>"Singapore",
"Saint Helena"=>"Saint Helena",
"Slovenia"=>"Slovenia",
"Svalbard and Jan Mayen"=>"Svalbard and Jan Mayen",
"Slovakia"=>"Slovakia",
"Sierra Leone"=>"Sierra Leone",
"San Marino"=>"San Marino",
"Senegal"=>"Senegal",
"Somalia"=>"Somalia",
"Suriname"=>"Suriname",
"South Sudan"=>"South Sudan",
"Sao Tome and Principe"=>"Sao Tome and Principe",
"Soviet Union"=>"Soviet Union",
"El Salvador"=>"El Salvador",
"Syrian Arab Republic"=>"Syrian Arab Republic",
"Swaziland"=>"Swaziland",
"Turks and Caicos Islands"=>"Turks and Caicos Islands",
"Chad"=>"Chad",
"French Southern Territories"=>"French Southern Territories",
"Togo"=>"Togo",
"Thailand"=>"Thailand",
"Tajikistan"=>"Tajikistan",
"Tokelau"=>"Tokelau",
"Timor-Leste"=>"Timor-Leste",
"Turkmenistan"=>"Turkmenistan",
"Tunisia"=>"Tunisia",
"Tonga"=>"Tonga",
"East (Portuguese) Timor"=>"East (Portuguese) Timor",
"Turkey"=>"Turkey",
"Trinidad and Tobago"=>"Trinidad and Tobago",
"Tuvalu"=>"Tuvalu",
"Taiwan"=>"Taiwan",
"Tanzania, United Republic of"=>"Tanzania, United Republic of",
"Ukraine"=>"Ukraine",
"Uganda"=>"Uganda",
"United Kingdom"=>"United Kingdom",
"USA"=>"USA",
"United States Minor Outlying Islands"=>"United States Minor Outlying Islands",
"Uruguay"=>"Uruguay",
"Uzbekistan"=>"Uzbekistan",
"Holy See (Vatican City State)"=>"Holy See (Vatican City State)",
"Venezuela"=>"Venezuela",
"Virgin Islands, British"=>"Virgin Islands, British",
"Virgin Islands, U.S."=>"Virgin Islands, U.S.",
"Vietnam"=>"Vietnam",
"Vanuatu"=>"Vanuatu",
"Wallis and Futuna"=>"Wallis and Futuna",
"Samoa"=>"Samoa",
"Yemen"=>"Yemen",
"Mayotte"=>"Mayotte",
"Yugoslavia"=>"Yugoslavia",
"South Africa"=>"South Africa",
"Zambia"=>"Zambia",
"Zaire"=>"Zaire",
"Zimbabwe"=>"Zimbabwe",
"Other"=>"Other"
);
$bloodtype = array(
	"A"=>"A",
	"B"=>"B",
	"AB"=>"AB",
	"O"=>"O",
	"Other"=>"Other"
);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="Page-Exit" content="RevealTrans (Duration=3, Transition=23)">
	<link rel="stylesheet" href="static/image/mobile/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="template/webshow_mtb0115/touch/img/css/base.css?eKb" type="text/css">
</head>
<body class="bg main">
	<div style="width: 100%; background: #90c31f; height: 40px; line-height:40px; box-shadow:  1px 0px 2px rgba(0,0,0,0.0); font-size: 0.9em; text-align: center;">
		<div style="position:absolute;">
			<a href="javascript:history.back();" style="display: block;width: 22px;height: 30px;margin: 0 0 0 10px;background: url(template/webshow_mtb0115/touch/img/m_left_2.png) 0 10px no-repeat;overflow: hidden;background-size: 58%;"></a>
		</div>
		<span style="font-size: 1.5em;">Edit Profile</span>
	</div>	
<form action="home.php?mod=spacecp&ac=profile&op=base&mobile=2" method="post" enctype="multipart/form-data" autocomplete="off" target="frame_profile" onsubmit="clearErrorInfo();">
<input type="hidden" value="4bf56e3f" name="formhash" />
<table cellspacing="0" cellpadding="0" class="tfm" id="profilelist">
<tr>
<th>User name</th>
<td><?=$space['username']?></td>
<td>&nbsp;</td>
</tr><tr id="tr_realname">
<th id="th_realname">Real Name</th>
<td id="td_realname">
<input type="text" name="realname" id="realname" class="px" value="<?=$space['realname']?>" tabindex="1" /><div class="rq mtn" id="showerror_realname"></div><p class="d"></p></td>
</tr>
<tr id="tr_gender">
<th id="th_gender">Gender</th>
<td id="td_gender">
<select name="gender" id="gender" value="<?=$space['gender']?>"  class="ps" tabindex="1">
<?php 
foreach ($gender as $key=>$value) {
if($space['gender']==$key){
?>
<option value="<?=$key?>" selected="selected"><?=$value?></option>
<?php }else{?>
<option value="<?=$key?>"><?=$value?></option>
<?php }}?>
</select><div class="rq mtn" id="showerror_gender"></div><p class="d"></p></td>
</tr>
<tr id="tr_birthday">
<th id="th_birthday">Day of birth</th>
<td id="td_birthday">
<select name="birthyear" id="birthyear" class="ps" onchange="showbirthday();" tabindex="1">
<?php
foreach ($birthyear as $key=>$value) {
if($space['birthyear']==$key){
?>
<option value="<?=$key?>" selected="selected"><?=$value?></option>
<?php }else{?>
<option value="<?=$key?>"><?=$value?></option>
<?php }}?>
</select>&nbsp;&nbsp;<select name="birthmonth" id="birthmonth" class="ps" onchange="showbirthday();" tabindex="1">
<?php
foreach ($birthmonth as $key=>$value) {
if($space['birthmonth']==$key){
?>
<option value="<?=$key?>" selected="selected"><?=$value?></option>
<?php }else{?>
<option value="<?=$key?>"><?=$value?></option>
<?php }}?>
</select>&nbsp;&nbsp;<select name="birthday" id="birthday" class="ps" tabindex="1">
<?php
foreach ($birthday as $key=>$value) {
if($space['birthday']==$key){
?>
<option value="<?=$key?>" selected="selected"><?=$value?></option>
<?php }else{?>
<option value="<?=$key?>"><?=$value?></option>
<?php }}?>
</select>
<div class="rq mtn" id="showerror_birthday"></div><p class="d"></p></td>
</tr>
<tr id="tr_birthcity">
<th id="th_birthcity">Birth City</th>
<td id="td_birthcity">
<p id="birthdistrictbox"><select name="birthprovince" style="width:200px;"  id="birthprovince" class="ps" onchange="showdistrict('birthdistrictbox', ['birthprovince', 'birthcity', 'birthdist', 'birthcommunity'], 1, 1, 'birth')" tabindex="1">
<option value="">- Country -</option>
<?php
foreach ($birthprovince as $key=>$value) {
if($space['birthprovince']==$key){
?>
<option value="<?=$key?>" selected="selected"><?=$value?></option>
<?php }else{?>
<option value="<?=$key?>"><?=$value?></option>
<?php }}?>
</select>&nbsp;&nbsp;</p><div class="rq mtn" id="showerror_birthcity"></div><p class="d"></p></td>
</tr>
<tr id="tr_residecity">
<th id="th_residecity">Living City</th>
<td id="td_residecity">
<p id="residedistrictbox"><select name="resideprovince" id="resideprovince" style="width:200px;"  class="ps" onchange="showdistrict('residedistrictbox', ['resideprovince', 'residecity', 'residedist', 'residecommunity'], 1, 1, 'reside')" tabindex="1">
<option value="">- Country -</option>
<?php
foreach ($birthprovince as $key=>$value) {
if($space['resideprovince']==$key){
?>
<option value="<?=$key?>" selected="selected"><?=$value?></option>
<?php }else{?>
<option value="<?=$key?>"><?=$value?></option>
<?php }}?>
</select>&nbsp;&nbsp;</p><div class="rq mtn" id="showerror_residecity"></div><p class="d"></p></td>
</tr>
<tr id="tr_affectivestatus">
<th id="th_affectivestatus">Emotional status</th>
<td id="td_affectivestatus">
<input type="text" name="affectivestatus" id="affectivestatus" class="px" value="<?=$space['affectivestatus']?>" tabindex="1" /><div class="rq mtn" id="showerror_affectivestatus"></div><p class="d"></p></td>
</tr>
<tr id="tr_lookingfor">
<th id="th_lookingfor">Registering purposes</th>
<td id="td_lookingfor">
<input type="text" name="lookingfor" id="lookingfor" class="px" value="<?=$space['lookingfor']?>" tabindex="1" /><div class="rq mtn" id="showerror_lookingfor"></div><p class="d"></p></td>
</tr>
<tr id="tr_bloodtype">
<th id="th_bloodtype">Blood type</th>
<td id="td_bloodtype">
<select name="bloodtype" id="bloodtype" class="ps" tabindex="1">
<?php
foreach ($bloodtype as $key=>$value) {
if($space['bloodtype']==$key){
?>
<option value="<?=$key?>" selected="selected"><?=$value?></option>
<?php }else{?>
<option value="<?=$key?>"><?=$value?></option>
<?php }}?>
</select><div class="rq mtn" id="showerror_bloodtype"></div><p class="d"></p></td>
</tr>
<tr>
<th>&nbsp;</th>
<td colspan="2">
<input type="hidden" name="profilesubmit" value="true" />
<button type="submit" name="profilesubmitbtn" id="profilesubmitbtn" value="true" class="pn pnc" /><strong>Save</strong></button>
<span id="submit_result" class="rq"></span>
</td>
</tr>
</table>
</form>
</body>
</html>
