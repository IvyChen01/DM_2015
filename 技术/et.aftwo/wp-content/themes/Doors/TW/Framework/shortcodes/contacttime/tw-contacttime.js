(function() {
   tinymce.create('tinymce.plugins.contacttime', {
      init : function(ed, url) {
         ed.addButton('contacttime', {
            title : 'Contact Time',
            image : url+'/devider.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Contact time Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=contacttime-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Contacttime",
             author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('contacttime', tinymce.plugins.contacttime);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="contacttime-form"><table id="contacttime-table" class="form-table">\
			<tr>\
				<th><label for="devider_padding">Contact Hour Title</label></th>\
				<td><input type="text" name="title" id="contacttime_title" value="Business Hours" /><br />\
				<small>Put Your Contact Hour Title.</small></td>\
			</tr>\
			<tr>\
				<th><label for="devider_border">Working Hour</label></th>\
				<td><input type="text" name="workinghour" id="contacttime_workinghour" value="Mon. - Fri. 8am to 5pm" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\\n\
                        <tr>\
				<th><label for="devider_border">Working Hour</label></th>\
				<td><input type="text" name="workinghour2" id="contacttime_workinghour2" value="Sat. 8am to 11am" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\\n\
                        <tr>\
				<th><label for="devider_border">Working Hour</label></th>\
				<td><input type="text" name="workinghour3" id="contacttime_workinghour3" value="Sun. Closed" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="contacttime_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#contacttime_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'title'            : '',
                                'workinghour'             : '',
                                'workinghour2'             : '',
                                'workinghour3'             : '',
				};
			var shortcode = '[tw-contacttime';
			
			for( var index in options) {
				var value = table.find('#contacttime_' + index).val();
				
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