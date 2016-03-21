(function() {
   tinymce.create('tinymce.plugins.carousel', {
      init : function(ed, url) {
         ed.addButton('carousel', {
            title : 'Carousel',
            image : url+'/carousel.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Carousel Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=carousel-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Carousel",
             author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('carousel', tinymce.plugins.carousel);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="carousel-form"><table id="carousel-table" class="form-table">\
			<tr>\
				<th><label for="carousel_category">Carousel With Category</label></th>\
				<td><input type="text" name="category" id="carousel_category" value="" /><br />\
				<small>Carousel generate with your given category ID. Or you can leave it blank for recent carousel item slider.</small></td>\
			</tr>\
			<tr>\
				<th><label for="carousel_item">Number of Carousel Item</label></th>\
				<td><input type="text" name="item" id="carousel_item" value="" /><br />\
				<small>Number of slider item.</small></td>\
			</tr>\
			<tr>\
				<th><label for="carousel_features">With Features</label></th>\
				<td><select name="features" id="carousel_features"><option value="1">Yes</option><option value="2">No</option></select><br />\
				<small>Number of slider item.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="carousel_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#carousel_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'category'              : '',
				'item'                  : '',
                                'features'              : ''
				};
			var shortcode = '[doors-carousel';
			
			for( var index in options) {
				var value = table.find('#carousel_' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
                                {
					shortcode += ' ' + index + '="' + value + '"';
                                }
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();