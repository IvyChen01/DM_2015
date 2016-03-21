(function() {
   tinymce.create('tinymce.plugins.paragraph', {
      init : function(ed, url) {
         ed.addButton('paragraph', {
            title : 'Paragraph',
            image : url+'/paragraph.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Paragraph Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=paragraph-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Paragraph",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('paragraph', tinymce.plugins.paragraph);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="paragraph-form"><table id="paragraph-table" class="form-table">\
			<tr>\
				<th><label for="paragraph_class">CSS Class</label></th>\
				<td><input type="text" name="class" id="paragraph_class" value="" /><br />\
				<small>Class Fro Custome CSS.</small></td>\
			</tr>\
			<tr>\
				<th><label for="paragraph_color">Paragraph Color</label></th>\
				<td><input type="text" name="color" id="paragraph_color" value="" /><br />\
				<small>Paragraph Text color. id(#000000)</small></td>\
			</tr>\
			<tr>\
				<th><label for="paragraph_fsize">Paragraph Font Size</label></th>\
				<td><input type="text" name="fsize" id="paragraph_fsize" value="" /><br />\
				<small>Paragraph Text Size. ie(13px)</small></td>\
			</tr>\
			<tr>\
				<th><label for="paragraph_padding">Paragraph Padding</label></th>\
				<td><input type="text" name="padding" id="paragraph_padding" value="0px 0px 0px 0px" /><br />\
				<small>Paragraph padding. ie(Top Right Bottom Left).</small></td>\
			</tr>\
			<tr>\
				<th><label for="paragraph_align">Text Align</label></th>\
				<td><select name="align" id="paragraph_align">\
                                <option value="left">Left Align</option>\
                                <option value="center">Center Align</option>\
                                <option value="right">Right Align</option>\
                                </select><br />\
				<small>Paragraph Text Align.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="paragraph_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#paragraph_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'class'              : '',
                                'color'              : '',
                                'fsize'              : '',
                                'padding'            : '',
                                'align'              : ''
				};
			var shortcode = '[doors-paragraph';
			
			for( var index in options) {
				var value = table.find('#paragraph_' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
                                {
					shortcode += ' ' + index + '="' + value + '"';
                                }
			}
			
			shortcode += ']Your Paragraph write here[/doors-paragraph]';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();