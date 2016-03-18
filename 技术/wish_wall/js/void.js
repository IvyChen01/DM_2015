$(function(){

  /*intr enter*/
  $("canvas").load(function(){
    $("nav.intr_nav anim").style.background=$("nav.intr_nav anim").data("date-src");
  })
  $(".intr_agree_btn").click(function(){
    if($(".intr_argee_text").hasClass('agree')){
      //location.href="?m=wish&a=main";
    }else{
      $('.intr_argee h2').css("color","#f00");
      alert('I agree to this term!')
    }
  })
  $(".intr_argee").click(function(){
    $(".intr_argee_text img").css("visibility","visible");
    $(".intr_argee_text").addClass('agree');
  })
  
  //chose ballnoom
  $(".cont-select span a").click(function(){
    
      var j= $(this).index();
      var p=j+1;
      var $spana=$('.cont-select span a');
    for(var i=0;i<$spana.length;i++){
        var $sbg=$($spana[i]).css("background-image");
        console.log($sbg);
        var k=i+1;
        var $sbgi="";
            $sbgi=$sbgi+'url(./images/image/ti'+k+'.png?v=2015.12.14_17.18)';
        var $sbgit="";
            $sbgit=$sbgit+'url(./images/image/ti'+k+'t.png?v=2015.12.14_17.18)';
       $($spana[i]).css("background-image",$sbgit); 
        if(k==p){
            $($spana[k-1]).css("background-image",$sbgi); 
        }
    }
  })
})
