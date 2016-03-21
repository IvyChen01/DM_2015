<div class="item">
              <div  class="cate-title"><a href="{dede:field name='typeurl'/}">{dede:field name='typename'/}</a></div>
              {dede:field name='typeid'/}
              <!--{dede:arclist typid=id}{/dede:arclist}-->
              <!--[field:id runphp='yes']-->
                  <!--$typeid=@me;-->
                  <!--global $dsql;-->
                  <!--$sql_comm_pro="SELECT * from oraimo_archives WHERE typeid IN(SELECT id FROM oraimo_arctype WHERE reid=$typeid)";-->
                  <!--$dsql->SetQuery($sql_comm_pro);-->
                  <!--$dsql->Execute();-->
                  <!--while($row=$dsql->GetArray()){-->
                       <!--@me.=$row['title'];-->
                  <!--}-->
              <!--[/field:id]-->
          </div>