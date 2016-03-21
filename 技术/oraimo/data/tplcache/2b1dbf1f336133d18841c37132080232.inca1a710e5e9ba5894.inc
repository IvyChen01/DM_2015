<?php
$z[0]=Array("typeurl","",83,99);
$z[1]=Array("typename","",101,118);
$z[2]=Array("id","\r\n                    global \$dsql;\r\n                    \$recom_sql=\"select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me\";\r\n                    \$recom=\$dsql->GetOne(\$recom_sql);\r\n                    \$links=GetOneArchive(\$recom['id']);\r\n                    \$url=\$links['arcurl'];\r\n                    \$pic=\$recom['litpic'];\r\n                \$news_html=\"<div class='more-cate'></div>\";\r\n                \$news_sql = \"Select * from oraimo_archives*\";\r\n                \$dsql->SetQuery(\$news_sql);\r\n                \$dsql->ExecNoneQuery();\r\n               \r\n\r\n                @me=\"<div class='list-pro'><a href=\$url><img src=\$pic /></a></div>\".\$news_html;\r\n                ",146,869);
$z[2][4]['runphp']="yes";
$z[3]=Array("id","\r\n                global \$dsql;\r\n\r\n                \$new_html.=\"</div>\";\r\n                ",887,1010);
$z[3][4]['runphp']="yes";

?>