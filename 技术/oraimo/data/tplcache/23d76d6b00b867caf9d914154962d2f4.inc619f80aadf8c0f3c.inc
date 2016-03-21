<?php
$z[0]=Array("typeurl","",51,67);
$z[1]=Array("typename","",69,86);
$z[2]=Array("id","\r\n                global \$dsql;\r\n                \$sql=\"select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me\";\r\n                \$recom=\$dsql->GetOne(\$sql);\r\n                @me=\"<div class='list-pro'><a href=\"GetOneArchive(\$recom['id'])\"><img src=\"\$recom['litpic']\" alt=\"\"/></a></div>\";\r\n                ",114,473);
$z[2][4]['runphp']="yes";
$z[3]=Array("id","",491,502);
$z[4]=Array("qupro","-->\r\n                    <!--global \$dsql;-->\r\n                  <!--\$art3=\"select title from oraimo_archives where id=109\";-->\r\n                  <!--\$links=GetOneArchive(109);-->\r\n                  <!--\$url=\$url['arcurl'];-->\r\n                <!--",527,816);
$z[4][4]['runphp']="yes";

?>