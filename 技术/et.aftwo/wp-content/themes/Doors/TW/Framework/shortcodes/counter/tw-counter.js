(function() {
   tinymce.create('tinymce.plugins.counter', {
      init : function(ed, url) {
         ed.addButton('counter', {
            title : 'Counter',
            image : url+'/counter.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Counter Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=counter-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Counter",
             author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('counter', tinymce.plugins.counter);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="counter-form"><table id="counter-table" class="form-table">\
			<tr>\
				<th><label for="counter_icon">Counter Icon</label></th>\
				<td><input type="text" name="icon" id="counter_icon" value="" /><br />\
				<small>Enter Your Counter Icon Class From Fontawesome( fa fa-facebook).</small></td>\
			</tr>\
			<tr>\
				<th><label for="counter_title">Counter Title</label></th>\
				<td><input type="text" name="title" id="counter_title" value="" /><br />\
				<small>Enter Your Counter Title</small></td>\
			</tr>\
                        <tr>\
				<th><label for="counter_percentange">Percentange Status</label></th>\
				<td><input type="text" name="percentange" id="counter_percentange" value="" /><br />\
				<small>Please Insert yes or no for percentange.</small></td>\
			</tr>\
                        <tr>\
				<th><label for="counter_value">Counter Value</label></th>\
				<td><input type="text" name="value" id="counter_value" value="99" /><br />\
				<small>Enter your Counter Value</small></td>\
			</tr>\
                        <tr>\
				<th><label for="counter_tcolor">Counter Text Color</label></th>\
				<td><input type="text" name="tcolor" id="counter_tcolor" value="#333333" /><br />\
				<small>Enter HEX color Code for Counter all text color.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="counter_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#counter_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'icon'               : '',
                                'title'              : '',
                                'percentange'        : '',
                                'value'              : '',
                                'tcolor'             : ''
				};
			var shortcode = '[tw-counter';
			
			for( var index in options) {
				var value = table.find('#counter_' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
                                {
					shortcode += ' ' + index + '="' + value + '"';
                                }
			}
			
			shortcode += ']Please Enter Your Content[/tw-counter]';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();