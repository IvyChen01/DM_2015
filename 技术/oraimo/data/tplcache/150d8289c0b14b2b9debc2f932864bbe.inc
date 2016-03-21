
            <div class="item">
                <div class="cate-title"><a href="[field:typeurl/]">[field:typename/]</a></div>
                [field:id runphp='yes']

                global $dsql;
                $news_html="<div class='more-cate'></div>";
                $news_sql = "select id,litpic from oraimo_archives";
                $dsql->Execute($news_sql);
                $row = $dsql->GetObject();
                while($row = $dsql->GetArray()){
                echo $row['id'];
                echo $row['title'];
                }


                @me="<div class='list-pro'><a href=><img src= /></a></div>";
                [/field:id]
                [field:id runphp='yes']
                global $dsql;

                $new_html.="</div>";
                [/field:id]
            </div>

            