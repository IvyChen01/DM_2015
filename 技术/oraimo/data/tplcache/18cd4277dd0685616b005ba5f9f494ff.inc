
            <div class="item">
                <div class="cate-title"><a href="[field:typeurl/]">[field:typename/]</a></div>
                [field:id runphp='yes']
                    global $dsql;
                    $recom_sql="select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me";
                    $recom=$dsql->GetOne($recom_sql);
                    $links=GetOneArchive($recom['id']);
                    $url=$links['arcurl'];
                    $pic=$recom['litpic'];
                    @me="<div class='list-pro'><a href=$url><img src=$pic /></a></div>";
                [/field:id]
                [field:id runphp='yes']
                global $dsql;
                $new_sql="select id,title from oraimo_archives where flag not like "%c%" and typeid=@me order by pubdate desc limit 5";
                $news=$dsql->SetQuery($new_sql);
                $dsql->Execute();
               
                $new_html.="</div>";
                [/field:id]
            </div>

            