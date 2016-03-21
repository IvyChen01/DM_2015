<?php
$z[0]=Array("field","",149,171);
$z[0][4]['name']="seotitle";
$z[1]=Array("global","",172,198);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("field","",223,252);
$z[2][4]['name']="keywords";
$z[3]=Array("field","",285,343);
$z[3][4]['name']="description";
$z[3][4]['function']="html2text(@me)";
$z[4]=Array("include","",645,680);
$z[4][4]['filename']="head.htm";
$z[5]=Array("include","",682,720);
$z[5][4]['filename']="tonglan.htm";
$z[6]=Array("field","",786,845);
$z[6][4]['name']="typeid";
$z[6][4]['function']="GetTopTypename(@me)";
$z[7]=Array("channel"," <a href=\"[field:typelink/]\" title=\"[field:typename /]\" >[field:typename /]</a> ",881,1066);
$z[7][4]['type']="sun";
$z[7][4]['currentstyle']="<a href='~typelink~' class='cur'>~typename~</a>";
$z[8]=Array("list"," \r\n      <li> <a href=\"[field:arcurl/]\" class=\"news_list_img bl fl\"> <img src=\"[field:litpic/]\">\r\n        <div class=\"img_round\"></div>\r\n        </a> &nbsp;\r\n        <div class=\"news_list_txt fr\">\r\n          <div class=\"bt\"> <a href=\"[field:arcurl/]\">[field:title /]</a> <span class=\"fgx\">/</span><span>[field:pubdate function=\"GetDateTimeMK(@me)\"/]</span></div>\r\n          <div class=\"con\">[field:body function='cn_substr(html2text(@me),500)'/]...</div>\r\n        </div>\r\n      </li>\r\n      ",1120,1645);
$z[8][4]['pagesize']="6";
$z[9]=Array("pagelist","",1696,1753);
$z[9][4]['listsize']="4";
$z[9][4]['listitem']="pageno pre next";
$z[10]=Array("include","",1779,1816);
$z[10][4]['filename']="footer.htm";

?>