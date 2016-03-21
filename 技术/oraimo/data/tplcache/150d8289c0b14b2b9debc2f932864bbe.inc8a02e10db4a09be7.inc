<?php
$z[0]=Array("typeurl","",83,99);
$z[1]=Array("typename","",101,118);
$z[2]=Array("id","\r\n\r\n                global \$dsql;\r\n                \$news_html=\"<div class='more-cate'></div>\";\r\n                \$news_sql = \"select id,litpic from oraimo_archives\";\r\n                \$dsql->Execute(\$news_sql);\r\n                \$row = \$dsql->GetObject();\r\n                while(\$row = \$dsql->GetArray()){\r\n                echo \$row['id'];\r\n                echo \$row['title'];\r\n                }\r\n\r\n\r\n                @me=\"<div class='list-pro'><a href=><img src= /></a></div>\";\r\n                ",146,672);
$z[2][4]['runphp']="yes";
$z[3]=Array("id","\r\n                global \$dsql;\r\n\r\n                \$new_html.=\"</div>\";\r\n                ",690,813);
$z[3][4]['runphp']="yes";

?>