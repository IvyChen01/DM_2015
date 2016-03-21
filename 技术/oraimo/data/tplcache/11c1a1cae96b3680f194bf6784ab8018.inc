
                <div class="cate-title"><a href="[field:typeurl/]">[field:typename/]</a></div>
                [field:recom runphp='yes']
                global $dsql;
                $sql="select title from oraimo_archives where flag LIKE '%c%' and typeid=16";
                $recom=$dsql->GetOne($sql);
                @me=$recom['title'];
                [/field:recom]
            <!--[field:id/]-->
                <!--[field:qupro runphp='yes']-->
                    <!--global $dsql;-->
                  <!--$art3="select title from oraimo_archives where id=109";-->
                  <!--$links=GetOneArchive(109);-->
                  <!--$url=$url['arcurl'];-->
                <!--[/field:qupro]-->
                