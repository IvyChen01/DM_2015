(function() {
   tinymce.create('tinymce.plugins.contactdetails', {
      init : function(ed, url) {
         ed.addButton('contactdetails', {
            title : 'Contact Details',
            image : url+'/googlemap.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Contact Details', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=contactdetails-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Contactdetails",
             author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('contactdetails', tinymce.plugins.contactdetails);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="contactdetails-form"><table id="contactdetails-table" class="form-table">\
			<tr>\
				<th><label for="devider_padding">Address  Title</label></th>\
				<td><input type="text" name="title" id="contactdetails_title" value="Visit Our Office" /><br />\
				<small>Put Your Adress Heading Title.</small></td>\
			</tr>\
			<tr>\
				<th><label for="devider_border">Address</label></th>\
				<td><input type="text" name="address" id="contactdetails_address" value="31234 Street Name, City Name" /><br />\
				<small>Your Adsress.</small></td>\
			</tr>\
			<tr>\
				<th><label for="devider_border">Phone Number</label></th>\
				<td><input type="text" name="phone" id="contactdetails_phone" value="Phone: (123) 456-7890" /><br />\
				<small>Your Phone Number.</small></td>\
			</tr>\
			<tr>\
				<th><label for="devider_border">Email Address</label></th>\
				<td><input type="text" name="email" id="contactdetails_email" value="3tea@doors.com" /><br />\
				<small>Your Email Address.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="address_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#address_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'title'             : '',
                                'address'           : '',
                                'phone'             : '',
                                'email'             : '',
				};
			var shortcode = '[tw-contactdetails';
			
			for( var index in options) {
				var value = table.find('#contactdetails_' + index).val();
				
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