(function() {
   tinymce.create('tinymce.plugins.subtitle', {
      init : function(ed, url) {
         ed.addButton('subtitle', {
            title : 'Sub Title',
            image : url+'/subtitle.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Sub Title Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=subtitle-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "SubTitle",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('subtitle', tinymce.plugins.subtitle);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="subtitle-form"><table id="subtitle-table" class="form-table">\
			<tr>\
				<th><label for="subtitle_class">CSS Class</label></th>\
				<td><input type="text" name="class" id="subtitle_class" value="" /><br />\
				<small>Class Fro Custome CSS.</small></td>\
			</tr>\
			<tr>\
				<th><label for="subtitle_text">Sub Title Text</label></th>\
				<td><textarea name="text" id="subtitle_text"></textarea><br />\
				<small>Sub Title Display Text.</small></td>\
			</tr>\
			<tr>\
				<th><label for="subtitle_color">Sub Title Color</label></th>\
				<td><input type="text" name="color" id="subtitle_color" value="" /><br />\
				<small>Sub Title Text color.</small></td>\
			</tr>\
			<tr>\
				<th><label for="subtitle_fsize">Sub Title Font Size</label></th>\
				<td><input type="text" name="fsize" id="subtitle_fsize" value="" /><br />\
				<small>Sub Title Text Size.</small></td>\
			</tr>\
			<tr>\
				<th><label for="subtitle_align">Text Align</label></th>\
				<td><select name="align" id="subtitle_align">\
                                <option value="left">Left Align</option>\
                                <option value="center">Center Align</option>\
                                <option value="right">Right Align</option>\
                                </select><br />\
				<small>Sub Title Text Align.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="subtitle_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#subtitle_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'class'              : '',
				'text'               : '',
                                'color'              : '',
                                'fsize'              : '',
				'align'              : ''
				};
			var shortcode = '[doors-subtitle';
			
			for( var index in options) {
				var value = table.find('#subtitle_' + index).val();
				
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