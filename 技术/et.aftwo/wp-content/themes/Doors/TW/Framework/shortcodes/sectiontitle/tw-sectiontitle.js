(function() {
   tinymce.create('tinymce.plugins.sectiontitle', {
      init : function(ed, url) {
         ed.addButton('sectiontitle', {
            title : 'Section Title',
            image : url+'/sectiontitle.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Section Title', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sectiontitle-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Section Title",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('sectiontitle', tinymce.plugins.sectiontitle);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="sectiontitle-form"><table id="sectiontitle-table" class="form-table">\
			<tr>\
				<th><label for="sectiontitle_class">CSS Class</label></th>\
				<td><input type="text" name="class" id="sectiontitle_class" value="" /><br />\
				<small>Class Fro Custome CSS.</small></td>\
			</tr>\
			<tr>\
				<th><label for="sectiontitle_text">Title Text</label></th>\
				<td><textarea name="text" id="sectiontitle_text"></textarea><br />\
				<small>Title Display Text.</small></td>\
			</tr>\
			<tr>\
				<th><label for="sectiontitle_color">Title Color</label></th>\
				<td><input type="text" name="color" id="sectiontitle_color" value="" /><br />\
				<small>Title Text color.</small></td>\
			</tr>\
			<tr>\
				<th><label for="sectiontitle_fsize">Title Font Size</label></th>\
				<td><input type="text" name="fsize" id="sectiontitle_fsize" value="" /><br />\
				<small>Title Text Size.</small></td>\
			</tr>\>\
			<tr>\
				<th><label for="sectiontitle_style">Title Style</label></th>\
				<td><select name="style" id="sectiontitle_style"><option value="withbg">With Border</option><option value="withoutborder">Without Border</option></select><br />\
				<small>Heagin Text Size.</small></td>\
			</tr>\
			<tr>\
				<th><label for="sectiontitle_align">Text Align</label></th>\
				<td><select name="align" id="sectiontitle_align">\
                                <option value="left">Left Align</option>\
                                <option value="center">Center Align</option>\
                                <option value="right">Right Align</option>\
                                </select><br />\
				<small>Title Alingment</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="sectiontitle_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#sectiontitle_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'class'              : '',
				'text'               : '',
                                'color'              : '',
                                'fsize'              : '',
                                'style'              : '',
                                'align'              : ''
				};
			var shortcode = '[doors-sectiontitle';
			
			for( var index in options) {
				var value = table.find('#sectiontitle_' + index).val();
				
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