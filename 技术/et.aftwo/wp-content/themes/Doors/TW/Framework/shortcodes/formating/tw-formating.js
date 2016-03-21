(function() {
   tinymce.create('tinymce.plugins.formating', {
      init : function(ed, url) {
         ed.addButton('formating', {
            text : 'Skeleton',
            image : false,
            type: 'menubutton',
            menu: [
                    {
                            text: 'Section',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Section Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=section-form' );
                            }
                    },
                    {
                            text: 'Columns',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Columns Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=columns-form' );
                            }
                    }
                ]
         });
      }
      
   });
   tinymce.PluginManager.add('formating', tinymce.plugins.formating);
   //========================
   // Section
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="section-form"><table id="section-table" class="form-table">\
			<tr>\
				<th><label for="section_class">CSS Class</label></th>\
				<td><input type="text" name="class" id="section_class" value="" /><br />\
				<small>Class Fro Custome CSS.</small></td>\
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
                                'class'              : '',
				};
			var shortcode = '[tw-section';
			
			for( var index in options) {
				var value = table.find('#section_' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
                                {
					shortcode += ' ' + index + '="' + value + '"';
                                }
			}
			
			shortcode += '][/tw-section]';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
   
   //========================
   // Cloumns
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="columns-form"><table id="columns-table" class="form-table">\
			<tr>\
				<th><label for="columns_part">Team Slider</label></th>\
				<td><select name="part" id="columns_part">\
                                <option value="1">1 of 12 Columns</option>\
                                <option value="2">2 of 12 Columns</option>\
                                <option value="3">3 of 12 Columns</option>\
                                <option value="4">4 of 12 Columns</option>\
                                <option value="5">5 of 12 Columns</option>\
                                <option value="6">6 of 12 Columns</option>\
                                <option value="7">7 of 12 Columns</option>\
                                <option value="8">8 of 12 Columns</option>\
                                <option value="9">9 of 12 Columns</option>\
                                <option value="10">10 of 12 Columns</option>\
                                <option value="11">11 of 12 Columns</option>\
                                <option value="12">12 of 12 Columns</option>\
                                </select><br />\
				<small>Select Column Layout. </small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="columns_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#columns_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'part'            : ''
				};
			var shortcode = '[tw-columns';
			
			for( var index in options) {
				var value = table.find('#columns_' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
                                {
					shortcode += ' ' + index + '="' + value + '"';
                                }
			}
                        shortcode += ']';
			shortcode += 'Insert your content here';
			shortcode += '[/tw-columns]';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
   
})();