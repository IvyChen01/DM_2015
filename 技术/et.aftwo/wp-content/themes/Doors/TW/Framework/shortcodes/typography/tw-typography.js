(function() {
   tinymce.create('tinymce.plugins.typography', {
      init : function(ed, url) {
         ed.addButton('typography', {
            text : 'Typography',
            image : false,
            type: 'menubutton',
            menu: [
                    {
                            text: 'Heading',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Heading Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=heading-form' );
                            }
                    },
                    {
                            text: 'Section Title',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Section Title', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sectiontitle-form' );
                            }
                    },
                    {
                            text: 'Sub Title',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Sub Title Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=subtitle-form' );
                            }
                    },
                    {
                            text: 'Paragraph',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Paragraph Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=paragraph-form' );
                            }
                    }
                ]
         });
      }
      
   });
   tinymce.PluginManager.add('typography', tinymce.plugins.typography);
   //========================
   // Section Title
   //========================
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
   
   //========================
   // Heading 
   //========================
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
   
   
   //========================
   // Sub Title
   //========================
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
   
   //========================
   // Paragraph
   //========================
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