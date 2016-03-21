(function() {
   tinymce.create('tinymce.plugins.googlemap', {
      init : function(ed, url) {
         ed.addButton('googlemap', {
            title : 'Google Map',
            image : url+'/googlemap.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Google Map Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=googlemap-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Google Map",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('googlemap', tinymce.plugins.googlemap);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="googlemap-form"><table id="googlemap-table" class="form-table">\
			<tr>\
				<th><label for="googlemap_width">Map Width</label></th>\
				<td><input type="text" name="width" id="googlemap_width" value="100%" /><br />\
				<small>Set Width For Google Map with %.</small></td>\
			</tr>\
			<tr>\
				<th><label for="googlemap_height">Map Height</label></th>\
				<td><input type="text" name="height" id="googlemap_height" value="330px" /><br />\
				<small>Set Height For Google Map with px.</small></td>\
			</tr>\
			<tr>\
				<th><label for="googlemap_height">Instruction </label></th>\
				<td><small>Befor aplly Goole Map shortcode please setup Latitude and Longitude in theme option.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="googlemap_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#googlemap_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'width'             : '',
				'height'            : ''
				};
			var shortcode = '[doors-googlemap';
			
			for( var index in options) {
				var value = table.find('#googlemap_' + index).val();
				
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