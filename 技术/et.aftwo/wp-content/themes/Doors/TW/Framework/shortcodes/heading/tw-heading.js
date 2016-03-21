(function() {
   tinymce.create('tinymce.plugins.heading', {
      init : function(ed, url) {
         ed.addButton('heading', {
            title : 'Heading',
            image : url+'/heading.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Heading Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=heading-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Heading",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('heading', tinymce.plugins.heading);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="heading-form"><table id="heading-table" class="form-table">\
			<tr>\
				<th><label for="heading_type">Heading Formate</label></th>\
				<td><select name="type" id="heading_type">\
                                <option value="1">Heading 1</option>\
                                <option value="2">Heading 2</option>\
                                <option value="3">Heading 3</option>\
                                <option value="4">Heading 4</option>\
                                <option value="5">Heading 5</option>\
                                <option value="6">Heading 6</option>\
                                </select><br />\
				<small>Select Heagin Formate.</small></td>\
			</tr>\
			<tr>\
				<th><label for="heading_class">CSS Class</label></th>\
				<td><input type="text" name="class" id="heading_class" value="" /><br />\
				<small>Class Fro Custome CSS.</small></td>\
			</tr>\
			<tr>\
				<th><label for="heading_text">Heading Text</label></th>\
				<td><textarea name="text" id="heading_text"></textarea><br />\
				<small>Heading Display Text.</small></td>\
			</tr>\
			<tr>\
				<th><label for="heading_color">Heading Color</label></th>\
				<td><input type="text" name="color" id="heading_color" value="" /><br />\
				<small>Heagin Text color.</small></td>\
			</tr>\
			<tr>\
				<th><label for="heading_fsize">Heading Font Size</label></th>\
				<td><input type="text" name="fsize" id="heading_fsize" value="" /><br />\
				<small>Heagin Text Size.</small></td>\
			</tr>\
			<tr>\
				<th><label for="heading_align">Text Align</label></th>\
				<td><select name="align" id="heading_align">\
                                <option value="left">Left Align</option>\
                                <option value="center">Center Align</option>\
                                <option value="right">Right Align</option>\
                                </select><br />\
				<small>Heagin Highlighted Text Align.</small></td>\
			</tr>\
			<tr>\
				<th><label for="heading_margin">Margin</label></th>\
				<td><input type="text" value="20px 0px 20px 0px" id="heading_margin" name="margin"/><br />\
				<small>Margin Settings Clockwise.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="section_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#section_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'type'               : '',
                                'class'              : '',
				'text'               : '',
                                'color'              : '',
                                'fsize'              : '',
                                'align'              : '',
                                'margin'             : ''
				};
			var shortcode = '[doors-heading';
			
			for( var index in options) {
				var value = table.find('#heading_' + index).val();
				
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