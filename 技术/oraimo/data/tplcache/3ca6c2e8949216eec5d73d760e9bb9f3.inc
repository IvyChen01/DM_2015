
                <a href='[field:typeurl/]'><span>[field:typename/]</span></a>
                [field:qupro runphp='yes']
                    global $dsql;
                  $art3="select title from oraimo_archives where id=109";
                  $arcRow = $dsql->GetOne($art3);
                  @me=$arcRow['title'];
            [/field:qupro]
                