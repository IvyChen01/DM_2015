(function() {
   tinymce.create('tinymce.plugins.newslatter', {
      init : function(ed, url) {
         ed.addButton('newslatter', {
            title : 'News Latter',
            image : url+'/newslatter.png',
            onclick : function() {
                    // triggers the thickbox
                    var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                    W = W - 80;
                    H = H - 84;
                    tb_show( 'News Latter Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=newslatter-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "News Latter",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('newslatter', tinymce.plugins.newslatter);
   
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="newslatter-form"><table id="newslatter-table" class="form-table">\
			<tr>\
				<th><label for="mybtn-text">Instruction</label></th>\
				<td><small>Please Active Simple subscribe plugin to get Subscribe Form.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="newslatter-submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#newslatter-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = {
				};
			var shortcode = '[doors-newslatter';
			
			for( var index in options) {
				var value = table.find('#newslatter-' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();