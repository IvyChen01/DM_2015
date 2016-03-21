jQuery(document).ready(function() {
    jQuery("#pageSelect").select2(); 
    jQuery("#selectLayout").select2();
    jQuery("#SelectFont, #selectf, #selectf2, #selectf3, #selectf4, #selectf5, #selectf6, #pFont, #aFont, #selectLayoutSingel, #selectpreset").select2();
});

jQuery(document).ready(function(){
   jQuery("#pageSelect").change(function(){
       var name = jQuery("option:selected",this).html();
       var val = jQuery(this).val();
       jQuery("#pagelistul").append('<li><p class="page_sereal"><span>'+name+'</span><input type="hidden" name="pID[]" value="'+val+'"><a href="#" class="deduct">x</a></p></li>');
   }) ;
   jQuery(document.body).on('click', '.deduct', function(e){
        e.preventDefault();
        jQuery(this).parent().remove(); 
    });
});

jQuery(document).ready(function(){
   jQuery('#baseColor, #h1Color, #h2Color, #h3Color, #h4Color, #h5Color, #h6Color, #pColor, #aColor').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		jQuery(el).val(hex);
		jQuery(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		jQuery(this).ColorPickerSetColor(this.value);
	}
})
.bind('keyup', function(){
	jQuery(this).ColorPickerSetColor(this.value);
}); 
});

jQuery(document).ready(function(){
   jQuery("#pagelistul").dragsort({ dragSelector: "p", dragBetween: true, dragEnd: saveOrder, placeHolderTemplate: "<li class='placeHolder'><div></div></li>" });
		
    function saveOrder() {
            var data = jQuery("#pagelistul li").map(function() { return jQuery(this).children().html(); }).get();
            jQuery("input[name=list1SortOrder]").val(data.join("|"));
    };
});


jQuery(document).ready(function(){

        jQuery('.importerbuttoon').click(function(e){
            e.preventDefault();
            
            $import_true = confirm('are you sure to import dummy content ? it will overwrite the existing data');
            if($import_true == false) return;

            jQuery('.import_message').html(' Data is being imported please be patient, while the awesomeness is being created :)  ');
        var data = {
            'action': 'my_action'       
        };

       // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            jQuery('.import_message').html('<div class="import_message_success">'+ response +'</div>');
            //alert('Got this from the server: ' + response); <i class="fa fa-spinner fa-3x fa-spin"></i>
        });
    });
});

jQuery(document).ready(function($){
    window.formfield = '';

    $('.upload_button').on('click', function() {
        window.formfield = $('.upload_field',$(this).parent());
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        return false;
    });

    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html) {
        if (window.formfield) {
            imgurl = $('img',html).attr('src');
            window.formfield.val(imgurl);
            tb_remove();
        }
        else {
            window.original_send_to_editor(html);
        }
        window.formfield = '';
        window.imagefield = false;
    }
});
jQuery(document).ready(function(){
   jQuery("#doors_page_section").on('change', function(){
      var sec = jQuery(this).val();
      if(sec === 'contact')
      {
          jQuery("#contactpageoption").fadeIn('slow');
      }
      else
      {
          jQuery("#contactpageoption").fadeOut('slow');
      }
   });
});


jQuery(document).ready(function(){
   jQuery("#sliderbutton").click(function(e){
       e.preventDefault();
       var effect = jQuery("#slideeffect").val();
       if(effect === '')
       {
           var ef = 'slide';
       }
       else
       {
           var ef = effect;
       }
       
       var numitem = jQuery("#slideritem").val();
       if(numitem === '')
       {
           var item = 3;
       }
       else
       {
           var item = numitem;
       }
       
       var features = jQuery("#featuresstatus").val();
       if(features === '')
       {
           var fea = 1;
       }
       else
       {
           var fea = features;
       }
       
       var shortcode = '[doors-carousel category="" item="'+item+'" features="'+fea+'" effect="'+ef+'"]';
       jQuery("#slider_shortcode").val(shortcode);
       
   });
});