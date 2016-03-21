(function() {
   tinymce.create('tinymce.plugins.team', {
      init : function(ed, url) {
         ed.addButton('team', {
            title : 'Team',
            image : url+'/team.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Team Member Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=team-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Team",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('team', tinymce.plugins.team);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="team-form"><table id="team-table" class="form-table">\
			<tr>\
				<th><label for="team_type">Team Type</label></th>\
				<td><select id="team_type" name="type">\
                                <option value="normal">Normal</option><option value="slide">Slide</option>\
                                </select><br />\
				<small>Select Team View Type. </small></td>\
			</tr>\
			<tr>\
				<th><label for="team_member">Number Of Member</label></th>\
				<td><select name="member" id="team_member">\
				<option value="4"> 4 Members</option><option value="8">8 Members</option><option value="12">12 Members</option></select><br />\
				<small>How many member you want to show.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="team_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#team_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'type'              : '',
				'member'            : ''
				};
			var shortcode = '[tw-team';
			
			for( var index in options) {
				var value = table.find('#team_' + index).val();
				
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