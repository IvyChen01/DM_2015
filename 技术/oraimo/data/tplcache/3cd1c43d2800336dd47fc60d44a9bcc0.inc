
            <div class="item">
                <div class="cate-title"><a href="[field:typeurl/]">[field:typename/]</a></div>
                [field:id runphp='yes']
                global $dsql;
                $sql="select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me";
                $recom=$dsql->GetOne($sql);
                $links=GetOneArchive($recom['id']);
                $url=$links['arcurl'];
                $pic=$recom['litpic'];
                @me="<div class='list-pro'><a href=$url><img src=$pic /></a></div>";
                [/field:id]
            </div>

            