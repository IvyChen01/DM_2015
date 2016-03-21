
            <div class="item">
                <div class="cate-title"><a href="[field:typeurl/]">[field:typename/]</a></div>
                [field:id runphp='yes']
                global $dsql;
                $ds=$dsql;
                $recom_sql="select id,litpic from oraimo_archives where flag LIKE '%c%' and typeid=@me";
                $recom=$dsql->GetOne($recom_sql);
                $links=GetOneArchive($recom['id']);
                $url=$links['arcurl'];
                $pic=$recom['litpic'];
                $dsql->Close();
                $sql = "Select * from oraimo_archives";
                $ds->SetQuery($sql);
                $ds->Execute();
                while($row = $ds->GetArray()){

                }
                @me="<div class='list-pro'><a href=$url><img src=$pic /></a></div>";
                [/field:id]
        </div>

        