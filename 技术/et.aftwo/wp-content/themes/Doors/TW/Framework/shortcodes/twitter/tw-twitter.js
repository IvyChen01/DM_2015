(function() {
   tinymce.create('tinymce.plugins.twitter', {
      init : function(ed, url) {
         ed.addButton('twitter', {
            title : 'Twitter',
            image : url+'/devider.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'twitter Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=twitter-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Twitter",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('twitter', tinymce.plugins.twitter);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="twitter-form"><table id="twitter-table" class="form-table">\
			<tr>\
				<th><label for="devider_padding">Twitter Message</label></th>\
				<td><input type="text" name="message" id="twitter_message" value="PASSION LEADS TO DESIGN, DESIGN LEADS TO PERFORMANCE, PERFORMANCE LEADS TO SUCCESS!" /><br />\
				<small>Put Your Contact Hour Title.</small></td>\
			</tr>\
			<tr>\
				<th><label for="devider_border">Profile Link</label></th>\
				<td><input type="text" name="twitterlink" id="twitter_twitterlink" value="#" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\\n\
                        <tr>\
				<th><label for="devider_border">User Name</label></th>\
				<td><input type="text" name="username" id="twitter_username" value="ThemeRegion" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\\n\
                        <tr>\
				<th><label for="devider_border">Message Date</label></th>\
				<td><input type="text" name="date" id="twitter_date" value="August 13th, 2014" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="twitter_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#twitter_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'message'            : '',
                                'twitterlink'             : '',
                                'username'             : '',
                                'date'             : '',
				};
			var shortcode = '[tw-twitter';
			
			for( var index in options) {
				var value = table.find('#twitter_' + index).val();
				
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