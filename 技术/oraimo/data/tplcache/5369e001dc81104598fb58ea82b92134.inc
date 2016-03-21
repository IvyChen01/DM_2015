
                <div class="cate-title"><a href="[field:typeurl/]">[field:typename/]</a></div>
                [field:id runphp='yes']
                global $dsql;
                $sql="select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me";
                $recom=$dsql->GetOne($sql);
                $url=GetOneArchive($recom['id']);
                @me="<div class='list-pro'><a href=$url></a></div>";
                [/field:id]
            <!--[field:id/]-->
                <!--[field:qupro runphp='yes']-->
                    <!--global $dsql;-->
                  <!--$art3="select title from oraimo_archives where id=109";-->
                  <!--$links=GetOneArchive(109);-->
                  <!--$url=$url['arcurl'];-->
                <!--[/field:qupro]-->
                