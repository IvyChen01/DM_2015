(function() {
   tinymce.create('tinymce.plugins.service', {
      init : function(ed, url) {
         ed.addButton('service', {
            title : 'Service',
            image : url+'/service.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Service Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=service-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Service",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('service', tinymce.plugins.service);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="service-form"><table id="service-table" class="form-table">\
			<tr>\
				<th><label for="service_type">View type</label></th>\
				<td><select name="type" id="service_type"><option value="normal">Normal</option><option value="slide">Slide</option></select><br />\
				<small>Select View Formate.</small></td>\
			</tr>\
			<tr>\
				<th><label for="service_sitem">Number of Item</label></th>\
				<td><select name="sitem" id="service_sitem"><option value="4">4 Items</option>\
				<option value="8">8 Items</option><option value="12">12 Items</option></select><br />\
				<small>Number of item.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="service_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#service_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'type'               : '',
                                'sitem'              : ''
				};
			var shortcode = '[doors-service';
			
			for( var index in options) {
				var value = table.find('#service_' + index).val();
				
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