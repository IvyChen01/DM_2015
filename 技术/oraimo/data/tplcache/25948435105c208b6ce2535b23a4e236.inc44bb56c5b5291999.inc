<?php
$z[0]=Array("typeurl","",83,99);
$z[1]=Array("typename","",101,118);
$z[2]=Array("id","\r\n                    global \$dsql;\r\n\r\n                    \$recom_sql=\"select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me\";\r\n                    \$recom=\$dsql->GetOne(\$recom_sql);\r\n                    \$links=GetOneArchive(\$recom['id']);\r\n                    \$url=\$links['arcurl'];\r\n                    \$pic=\$recom['litpic'];\r\n\r\n                \$news_html=\"<div class='more-cate'>\";\r\n                \$news_sql = \"select id,litpic from oraimo_archives\";\r\n                \$dsqlb = new DedeSql(false);\r\n                \$dsqlb->Execute(\$news_sql);\r\n                while(\$row = \$dsqlb->GetArray()){\r\n                \$news_html.=\$row['title'];\r\n                }\r\n                \$news_html.=\"</div>\";\r\n                @me=\"<div class='list-pro'><a href=\$url><img src=\$pic /></a></div>\".\$news_html;\r\n                ",146,1013);
$z[2][4]['runphp']="yes";
$z[3]=Array("id","\r\n                global \$dsql;\r\n\r\n                \$new_html.=\"</div>\";\r\n                ",1031,1154);
$z[3][4]['runphp']="yes";

?>