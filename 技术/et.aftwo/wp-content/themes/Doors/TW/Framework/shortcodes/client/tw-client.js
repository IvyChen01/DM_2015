(function() {
   tinymce.create('tinymce.plugins.client', {
      init : function(ed, url) {
         ed.addButton('client', {
            title : 'Client',
            image : url+'/client.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Client Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=client-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Client",
             author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('client', tinymce.plugins.client);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="client-form"><table id="client-table" class="form-table">\
			<tr>\
				<th><label for="client_type">View type</label></th>\
				<td><select name="type" id="client_type">\
                                <option value="normal">Normal</option><option value="slide">Slide</option></select><br />\
				<small>Type in small letter (yes/no). </small></td>\
			</tr>\
			<tr>\
				<th><label for="client_number">Number Of Client</label></th>\
				<td><select name="number" id="client_number"><option value="4">4 Item</option><option value="8">8 Item</option><option value="12">12 Item</option></select><br />\
				<small>How many Client Logo you want to show.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="client_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#client_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'type'            : '',
				'number'            : ''
				};
			var shortcode = '[doors-client';
			
			for( var index in options) {
				var value = table.find('#client_' + index).val();
				
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