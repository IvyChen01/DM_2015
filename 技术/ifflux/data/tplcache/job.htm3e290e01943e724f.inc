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
$z[5]=Array("include","",683,721);
$z[5][4]['filename']="tonglan.htm";
$z[6]=Array("field","",786,845);
$z[6][4]['name']="typeid";
$z[6][4]['function']="GetTopTypename(@me)";
$z[7]=Array("list"," \r\n      <li> <a href=\"[field:arcurl/]\" class=\"news_list_img bl fl\"> <img src=\"[field:litpic/]\">\r\n        <div class=\"img_round\"></div>\r\n        </a> &nbsp;\r\n        <div class=\"news_list_txt fr\">\r\n          <div class=\"bt\"> <a href=\"[field:arcurl/]\">[field:title /]</a> <span class=\"fgx\">/</span><span>[field:pubdate function=\"GetDateTimeMK(@me)\"/]</span></div>\r\n          <div class=\"con\">[field:body function='cn_substr(html2text(@me),500)'/]...</div>\r\n        </div>\r\n      </li>\r\n      ",897,1422);
$z[7][4]['pagesize']="4";
$z[8]=Array("pagelist","",1473,1530);
$z[8][4]['listsize']="4";
$z[8][4]['listitem']="pageno pre next";
$z[9]=Array("include","",1556,1593);
$z[9][4]['filename']="footer.htm";

?>