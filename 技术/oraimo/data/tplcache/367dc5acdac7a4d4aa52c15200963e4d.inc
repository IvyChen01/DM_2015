
            <div class="item">
                <div class="cate-title"><a href="[field:typeurl/]">[field:typename/]</a></div>
                [field:id runphp='yes']
                    global $dsql;global $dsqln;
                    $recom_sql="select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me";
                    $new_sql="select id,title from oraimo_archives where flag not like "%c%" and typeid=@me order by pubdate desc limit 5";


                    $recom=$dsql->GetOne($recom_sql);
                    $links=GetOneArchive($recom['id']);
                    $url=$links['arcurl'];
                    $pic=$recom['litpic'];
                    @me="<div class='list-pro'><a href=$url><img src=$pic /></a></div>";
                [/field:id]
            </div>

            