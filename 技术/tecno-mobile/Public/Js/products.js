/*compare-wrapper*/
$(function(){
  var selectedProducts=[];
  $("#products-list").on("click",".compare",function(p){
    p.preventDefault();
    if(!$(this).hasClass("selected")){
      var o=$(this).closest('li').find('h2').text();
      var q=$(this).closest('li').find('img').prop('src');
      var n=$(this).closest('li').attr("data-product-id");
      var i=$('.compare-wrapper ul').children().length;

      if(i<=3){
        $(this).addClass("selected").addClass('selected_to_compare').css({cursor:"default",opacity:".2"});
        $('.compare-wrapper').css({'display':'block'});
        $('.compare-wrapper ul').prepend('<li data-product-id="'+n+'"><a class="closeprod">close</a><img src="'+q+'" alt="'+o+'" /><h3>'+o+'</h3></li>')

        if(i==1){
          $('.compare-wrapper li.compare').css('display','none');
        }else{
          if(i==3){
            $('#products-list .compare').css({cursor:'default',opacity:'.2'});
            $('.compare-wrapper li.compare').css('display','inline-block')
          }else{
            $('.compare-wrapper li.compare').css('display','inline-block')
          }
        }

        selectedProducts=[];
        $('.selected_to_compare').each(function(index,element){
          var productID=$(this).attr('rel');
          if(productID!=''){
            selectedProducts.push(productID);
          }
        })

      }

      $('.compare-wrapper .closeprod').on('click',function(r){
        r.preventDefault();
        var t=$(this).closest('li').attr('data-product-id');
        $('#products-list li[data-product-id="'+t+'"] .compare').removeClass('selected').removeClass('selected_to_compare');
        $('#products-list .compare').not('.selected').css({cursor:'cell',opacity:'1'});
        $(this).closest('li').remove();

        var s=$('.compare-wrapper ul').children().length-1;
        if(s<2){
          $('.compare-wrapper li.compare').css('display','none');
        }else{
          $('.compare-wrapper li.compare').css('display','inline-block');
        }
      })
    }
  });

  $('.compare-wrapper .compare-close').on('click',function(i){
    i.preventDefault();
    $('#products-list .compare').removeClass('selected').removeClass('selected_to_compare');
    $('#products-list .compare').css({cursor:'cell',opacity:'1'});
    $('.compare-wrapper li').not('.compare').remove();
    $('.compare-wrapper li.compare').css('display','none');
  });

  $('.btn-compare').click(function(e){
    e.preventDefault();
    var selectedProducts=[];
    $('.selected_to_compare').each(function(index,element){
      var productID=$(this).attr('rel');
      if(productID!=''){
        selectedProducts.push(productID);
      }
    });

    $('html,body').animate({scrollTop:0},0);
    var p1=$('.compare-wrapper ul li:nth-child(1)');
    var t1=p1.find('h3').text();
    var i1=p1.find('img').prop('src');
    var p2=$('.compare-wrapper ul li:nth-child(2)');
    var t2=p2.find('h3').text();
    var i2=p2.find('img').prop('src');
    if(!$('.compare-wrapper ul li:nth-child(3)').hasClass('compare')){
      var p3=$('.compare-wrapper ul li:nth-child(3)');
      var t3=p3.find('h3').text();
      var i3=p3.find('img').prop('src');
    }

    $('.compare-wrapper').hide();
    $('.overlay').show();
    $('#compare-popup').show();

    if(!$('compare-wrapper ul li:nth-child(3)').hasClass('compare')){
      $('#compare-poup table tbody').prepend('<tr class="t-header"><td></td><td><img src="'+i3+'" alt="'+t3+'" /><h2>'+t3+"</h2></td>"+'<td><img src="'+i2+'" alt="'+t2+'" /><h2>'+t2+"</h2></td>"+'<td><img src="'+i1+'" alt="'+t1+'" /><h2>'+t1+"</h2></td></tr>");
    }else{
      $('#compare-poup table tbody').prepend('<tr class="t-header"><td></td><td><img src="'+i2+'" alt="'+i2+'" /><h2>'+t2+"</h2></td>"+'<td><img src="'+i1+'" alt="'+t1+'" /><h2>'+t1+"</h2></td></tr>");
    }

  $.post("index.php?m=Home&c=Product&a=comparedetails",{'selsected':selectedProducts},function(data){
      var length = data.length;
      var json = eval(data);
      html = '<tr>'
      for(var i=0;i<length;i++){
    	  html += '<td class=t-header><img  src='+json[i].goodsImg+' alt="" /><h2>'+json[i].goodsName+'</h2></td>'
      }
      html += '</tr><tr>'
      for(var i=0;i<length;i++){
        	  html += '<td class=alternate>'+json[i].goodsSpec+'</td>'
      } 
      html += '</tr>';
      $('#compare-table').html(html);	  
    });

    $('#compare-poup table td:gt(9)').remove();
  });

  $('#compare-popup .closepopup,.overlay').on('click',function(i){
    i.preventDefault();
    $('#compare-poup table tbody .t-header').remove();
    $('#compare-popup').hide();
    $('.overlay').hide();
    $('.compare-wrapper').show();
  })

})

$(function(){
  /*products-content-nav*/
  $('.products-content-nav li').click(function(q){
    q.preventDefault();
    $('.products-content-nav li').removeClass('products-cent-active');
    $(this).addClass('products-cent-active');
    //tab
  })
  /*end products-content-nav*/
})
