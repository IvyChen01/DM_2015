<?php
$z[0]=Array("typeurl","",83,99);
$z[1]=Array("typename","",101,118);
$z[2]=Array("id","\r\n                    global \$dsql;\r\n                    \$recom_sql=\"select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me\";\r\n                    \$recom=\$dsql->GetOne(\$recom_sql);\r\n                    \$links=GetOneArchive(\$recom['id']);\r\n                    \$url=\$links['arcurl'];\r\n                    \$pic=\$recom['litpic'];\r\n                global \$dsql;\r\n                \$news_html=\"<div class='more-cate'></div>\";\r\n                \$news_sql = \"Select * from oraimo_archives*\";\r\n                \$dsql->Execute(\$news_sql);\r\n\r\n                while(\$row = \$dsql->GetArray()){\r\n                echo \$row['id'];\r\n                echo \$row['title'];\r\n                }\r\n\r\n\r\n                @me=\"<div class='list-pro'><a href=\$url><img src=\$pic /></a></div>\".\$news_html;\r\n                ",146,985);
$z[2][4]['runphp']="yes";
$z[3]=Array("id","\r\n                global \$dsql;\r\n\r\n                \$new_html.=\"</div>\";\r\n                ",1003,1126);
$z[3][4]['runphp']="yes";

?>