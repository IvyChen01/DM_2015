<?php
$z[0]=Array("typeurl","",51,67);
$z[1]=Array("typename","",69,86);
$z[2]=Array("id","\r\n                global \$dsql;\r\n                \$sql=\"select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me\";\r\n                \$recom=\$dsql->GetOne(\$sql);\r\n                \$links=GetOneArchive(\$recom['id']);\r\n                \$url=\$links['arcurl'];\r\n                @me=\"<div class='list-pro'><a href=\$url></a></div>\";\r\n                ",114,505);
$z[2][4]['runphp']="yes";
$z[3]=Array("id","",523,534);
$z[4]=Array("qupro","-->\r\n                    <!--global \$dsql;-->\r\n                  <!--\$art3=\"select title from oraimo_archives where id=109\";-->\r\n                  <!--\$links=GetOneArchive(109);-->\r\n                  <!--\$url=\$url['arcurl'];-->\r\n                <!--",559,848);
$z[4][4]['runphp']="yes";

?>