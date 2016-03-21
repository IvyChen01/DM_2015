(function() {
   tinymce.create('tinymce.plugins.recentPost', {
      init : function(ed, url) {
         ed.addButton('recentPost', {
            title : 'Recent Post',
            image : url+'/recentpost.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Recent Post Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=recentPost-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Recent Post",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('recentPost', tinymce.plugins.recentPost);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="recentPost-form"><table id="testimonial-table" class="form-table">\
			<tr>\
				<th><label for="recentPost_number">Number Of Recent Post</label></th>\
				<td><select name="number" id="recentPost_number"><br />\
				<option value="4">4 Items</option><option value="8">8 Items</option><option value="12">12 Items</option></select><br />\
				<small>How many Recent Post you want to show.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="recentPost_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#recentPost_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'number'           : ''
				};
			var shortcode = '[doors-recentPost';
			
			for( var index in options) {
				var value = table.find('#recentPost_' + index).val();
				
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