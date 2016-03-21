<?php
$z[0]=Array("global","",147,173);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("global","",214,241);
$z[1][4]['name']="cfg_keywords";
$z[2]=Array("global","",337,367);
$z[2][4]['name']="cfg_description";
$z[3]=Array("include","",452,487);
$z[3][4]['filename']="head.htm";
$z[4]=Array("arclist","\r\n      <li><a href=\"/\"><span style=\"background: url([field:litpic/]) center top no-repeat\"></span></a></li>\r\n      ",555,710);
$z[4][4]['typeid']="31";
$z[5]=Array("arclist","<a href=\"javascript:;\" class=\"[field:global runphp='yes' name=autoindex](@me < 1)?@me=\"on\":@me=\"\";[/field:global] \"></a>",796,955);
$z[5][4]['typeid']="31";
$z[6]=Array("sql","\r\n          [field:content function='cn_substr(html2text(@me),400)'/].....\r\n          ",1427,1583);
$z[6][4]['sql']="Select content from #@__arctype where id=1";
$z[7]=Array("arclist","\r\n        <div class=\"about_con_bt zp_bt\"> <a href=\"[field:arcurl/]\"> [field:title/]</a> </div>\r\n        <div class=\"zp_time\">[field:pubdate function=\"GetDateTimeMK(@me)\"/]</div>\r\n        <div class=\"about_con_txt zp_txt\"> [field:body function='cn_substr(html2text(@me),300)'/]......</div>\r\n        ",1757,2139);
$z[7][4]['typeid']="29";
$z[7][4]['row']="1";
$z[7][4]['flag']="p";
$z[7][4]['channelid']="1";
$z[7][4]['addfields']="body";
$z[8]=Array("arclist","\r\n    <li>\r\n      <div class=\"img\"><img src=\"[field:litpic/]\" width=\"294\" height=\"210\"></div>\r\n      <a href=\"[field:arcurl/]\" class=\"bl\">\r\n      <div class=\"case_plate_txt\"> [field:title/] </div>\r\n      <div class=\"case_plate_ico\"> </div>\r\n      </a> </li>\r\n    ",2291,2592);
$z[8][4]['typeid']="6";
$z[9]=Array("arclist","\r\n        <li style=\"display:none\"> <a href=\"[field:arcurl/]\" class=\"news_list_img bl fl\"> <img src=\"[field:litpic/]\" width=\"70\" height=\"70\"/>\r\n          <div class=\"img_round\"></div>\r\n          </a>\r\n          <div class=\"news_list_txt fr\">\r\n            <div class=\"bt\"><a href=\"[field:arcurl/]\" target=\"_blank\">[field:title/]</a></div>\r\n            <div class=\"con\">[field:body function='cn_substr(html2text(@me),180)'/]...</div>\r\n          </div>\r\n        </li>\r\n        ",5232,5789);
$z[9][4]['typeid']="27";
$z[9][4]['row']="4";
$z[9][4]['flag']="p";
$z[9][4]['channelid']="1";
$z[9][4]['addfields']="body";
$z[10]=Array("arclist","\r\n        <li style=\"display:none\"> <a href=\"[field:arcurl/]\" class=\"news_list_img bl fl\"> <img src=\"[field:litpic/]\" width=\"70\" height=\"70\"/>\r\n          <div class=\"img_round\"></div>\r\n          </a>\r\n          <div class=\"news_list_txt fr\">\r\n            <div class=\"bt\"><a href=\"[field:arcurl/]\" target=\"_blank\">[field:title/]</a></div>\r\n            <div class=\"con\">[field:body function='cn_substr(html2text(@me),180)'/]...</div>\r\n          </div>\r\n        </li>\r\n        ",6092,6649);
$z[10][4]['typeid']="26";
$z[10][4]['row']="4";
$z[10][4]['flag']="p";
$z[10][4]['channelid']="1";
$z[10][4]['addfields']="body";
$z[11]=Array("include","",6696,6733);
$z[11][4]['filename']="footer.htm";

?>