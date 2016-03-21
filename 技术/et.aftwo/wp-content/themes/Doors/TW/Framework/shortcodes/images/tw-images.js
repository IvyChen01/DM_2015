(function() {
   tinymce.create('tinymce.plugins.images', {
      init : function(ed, url) {
         ed.addButton('images', {
            title : 'Images',
            image : url+'/images.png',
            onclick : function() {
                    // triggers the thickbox
                    var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                    W = W - 80;
                    H = H - 84;
                    tb_show( 'Images Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=images-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Images",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('images', tinymce.plugins.images);
   
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="images-form"><table id="images-table" class="form-table">\
			<tr>\
				<th><label for="images-url">Image Url</label></th>\
				<td><input type="text" name="url" id="images-url" value="" placeholder="http://" /><br />\n\
                                <small>Image Url.</small></td>\
			</tr>\
			<tr>\
				<th><label for="images-width">Image Width</label></th>\
				<td><input type="text" name="width" id="images-width" value="100%" /><br />\
                                <small>Image Width.</small></td>\
			</tr>\
			<tr>\
				<th><label for="images-margin">Image Margin</label></th>\
				<td><input type="text" name="margin" id="images-margin" value="" /><br />\
                                <small>Image margin.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="images-submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#images-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'url'          : '', 
				'width'          : '',
                                'margin'         : ''
				};
			var shortcode = '[doors-images';
			
			for( var index in options) {
				var value = table.find('#images-' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();