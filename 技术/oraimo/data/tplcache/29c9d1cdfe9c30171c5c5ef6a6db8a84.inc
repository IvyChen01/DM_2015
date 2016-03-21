<div class="item">
                <div  class="cate-title"><a href="{dede:field name='typeurl'/}">{dede:field name='typename'/}</a></div>
                {dede:arclist flag='c' row='1' orderby='pubdate'}
                <div class="list-pro"><a href="[field:arcurl/]"><img src="[field:litpic/]" alt=""/></a></div>
                {/dede:arclist}
                <div class="more-cate">
                    {dede:arclist row='4' orderby='pubdate'}
                    <a href="[field:arcurl/]">[field:title/]</a>
                    {/dede:arclist}
                    <a href="{dede:field name='typeurl'/}" class="shall-all">Shall All</a>
                </div>
            </div>