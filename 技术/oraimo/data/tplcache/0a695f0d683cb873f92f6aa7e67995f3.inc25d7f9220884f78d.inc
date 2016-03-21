<?php
$z[0]=Array("typeurl","",83,99);
$z[1]=Array("typename","",101,118);
$z[2]=Array("id","\r\n                global \$dsql;\r\n                \$ds=\$dsql;\r\n                \$recom_sql=\"select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me\";\r\n                \$recom=\$dsql->GetOne(\$recom_sql);\r\n                \$links=GetOneArchive(\$recom['id']);\r\n                \$url=\$links['arcurl'];\r\n                \$pic=\$recom['litpic'];\r\n                @me=\"<div class='list-pro'><a href=\$url><img src=\$pic /></a></div>\";\r\n                ",146,633);
$z[2][4]['runphp']="yes";

?>