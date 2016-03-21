<div class="item">
                <div  class="cate-title"><a href="{dede:field name='typeurl'/}">{dede:field name='typename'/}</a></div>
                {dede:arclist flag='c' row='1' orderby='pubdate'}
                <div class="list-pro"><a href="[field:arcurl/]"><img src="[field:litpic/]" alt=""/></a></div>
                {/dede:arclist}
                <div class="more-cate">
                    {dede:arclist row='4' orderby='pubdate'}
                    <a href="[field:arcurl/]">[field:shorttitle/]</a>
                    {/dede:arclist}
                    <a href="{dede:field name='typeurl'/}" class="shall-all">Shall All</a>
                </div>
                <div class="pic-coming-soon">
                    <img src="/images/oraimo/pic_coming_soon.png" alt=""/>
                </div>
                <script>
                    $(function(){
                        if($(".more-cate a").length<2){
                            $(".more-cate").remove();
                            $(".pic-coming-soon").show();
                        }else{
                            $(".pic-coming-soon").remove();
                        }
                        console.log($(".more-cate a").length)
                    })
                </script>
            </div>