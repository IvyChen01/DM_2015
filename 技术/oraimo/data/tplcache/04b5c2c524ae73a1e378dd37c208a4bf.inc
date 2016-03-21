
            <div class="item">
                <div class="cate-title"><a href="[field:typeurl/]">[field:typename/]</a></div>
                [field:id runphp='yes']
                    global $dsql;

                    $recom_sql="select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me";
                    $recom=$dsql->GetOne($recom_sql);
                    $links=GetOneArchive($recom['id']);
                    $url=$links['arcurl'];
                    $pic=$recom['litpic'];

                $news_html="<div class='more-cate'>";
                $news_sql = "select id,litpic from oraimo_archives";
                $dsqlb = new DedeSql(false);
                $dsqlb->SetQuery($news_sql);
                $dsqlb->Execute();
                $row = $dsqlb->GetArray();
                if(!empty($row)){
                $news_html.="ddd";
                }
                $news_html.="</div>";
                @me="<div class='list-pro'><a href=$url><img src=$pic /></a></div>".$news_html;
                [/field:id]
                [field:id runphp='yes']
                global $dsql;

                $new_html.="</div>";
                [/field:id]
            </div>

            