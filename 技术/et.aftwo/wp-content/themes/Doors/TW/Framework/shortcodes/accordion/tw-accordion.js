(function() {
   tinymce.create('tinymce.plugins.accordion', {
      init : function(ed, url) {
         ed.addButton('accordion', {
            title : 'Accordion',
            image : url+'/accordion.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Accordion Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=accordion-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Accordion",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('accordion', tinymce.plugins.accordion);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="accordion-form"><table id="accordion-table" class="form-table">\
			<tr>\
				<th><label for="accordion_slider">Accordion Shortcode</label></th>\
				<td><small>\
                                Please Press Insert button. You will get a Demo Shortcode.<br/>\
                                Edit the shortcode Title and content to achive your requirement<br/><br/>\
                                <strong>Demo Shortcode</strong><br/>\
                                [tw-accordions]<br/>\
                                [tw-accordion title="Accordion number 1"]Toggle 1 content goes here.[/tw-accordion]<br/>\
                                [tw-accordion title="Accordion number 1"]Toggle 1 content goes here.[/tw-accordion]<br/>\
                                [tw-accordion title="Accordion number 1"]Toggle 1 content goes here.[/tw-accordion]<br/>\
                                [/tw-accordions]<br/>\
                                </small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="accordion_submit" class="button-primary" value="Insert Tab" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#accordion_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'slider'            : '',
				'member'            : ''
				};
			var shortcode = '[tw-accordions]';
                            shortcode += '[tw-accordion title="Accordion number 1"]Toggle 1 content goes here.[/tw-accordion]';
                            shortcode += '[tw-accordion title="Accordion number 2"]Toggle 2 content goes here.[/tw-accordion]';
                            shortcode += '[tw-accordion title="Accordion number 3"]Toggle 3 content goes here.[/tw-accordion]';
                            shortcode += '[/tw-accordions]';
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();