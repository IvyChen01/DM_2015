(function() {
   tinymce.create('tinymce.plugins.textblock', {
      init : function(ed, url) {
         ed.addButton('textblock', {
            title : 'Text Block',
            image : url+'/textblock.png',
            onclick : function() {
                    // triggers the thickbox
                    var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                    W = W - 80;
                    H = H - 84;
                    tb_show( 'Text Block Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=textblock-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Text Block",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('textblock', tinymce.plugins.textblock);
   
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="textblock-form"><table id="textblock-table" class="form-table">\
			<tr>\
				<th><label for="textblock-heading">Text Block Heading</label></th>\
				<td><textarea name="heading" id="textblock-heading"></textarea><br />\n\
                                <small>Text Block Heading Text.</small></td>\
			</tr>\
			<tr>\
				<th><label for="textblock-subtitle">Text Block Subtitle</label></th>\
				<td><textarea name="subtitle" id="textblock-subtitle"></textarea><br />\
				<small>Text Block Subtitle</small>\</td>\
			</tr>\
			<tr>\
				<th><label for="textblock-btntext">Button Text</label></th>\
				<td><input type="text" name="btntext" id="textblock-btntext" value=""/><br />\
				<small>Button Text</small></td>\
			</tr>\
			<tr>\
				<th><label for="textblock-btnlink">Button Link URL</label></th>\
				<td><input type="text" name="btnlink" id="textblock-btnlink" value="#" /><br />\
                                <small>Link Url.</small></td>\
			</tr>\
                </table>\
		<p class="submit">\
			<input type="button" id="textblock-submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#textblock-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'heading'           : '', 
				'subtitle'          : '',
				'btntext'           : '',
                                'btnlink'           : ''
				};
			var shortcode = '[doors-textblock';
			
			for( var index in options) {
				var value = table.find('#textblock-' + index).val();
				
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