<div class="item">
              <div  class="cate-title"><a href="{dede:field name='typeurl'/}">{dede:field name='typename'/}</a></div>
              {dede:arclist flag='c' row='1' orderby='pubdate'}
              <div class="list-pro"><a href="[field:arcurl/]"><img src="[field:litpic/]" alt=""/></a></div>              {/dede:arclist}
              <div class="more-cate">
              {dede:channel type='son' noself='yes'}
              <a href="[field:typelink/]">[field:typename/]</a>
              {/dede:channel}
              <a href="{dede:field name='typeurl'/}" class="shall-all">Shall All</a>
              </div>
              <div class="pic-coming-soon">
                  <img src="/images/oraimo/pic_coming_soon.png" alt=""/>
              </div>
              <script>
                  $(function(){
                      $(".pro-list .item").each(function(){


                      })
                  })
              </script>
          </div>