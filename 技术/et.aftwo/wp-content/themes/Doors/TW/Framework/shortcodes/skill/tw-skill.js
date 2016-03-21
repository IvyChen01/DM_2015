(function() {
   tinymce.create('tinymce.plugins.skill', {
      init : function(ed, url) {
         ed.addButton('skill', {
            title : 'Skill',
            image : url+'/skill.png',
            onclick : function() {
               // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Skill Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=skill-form' );
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Skill",
            author : 'XpeedStudio',
            authorurl : 'http://www.XpeedStudio.com',
            infourl : 'http://www.XpeedStudio.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('skill', tinymce.plugins.skill);
   // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="skill-form"><table id="skill-table" class="form-table">\
			<tr>\
				<th><label for="skill_slider">Skill Shortcode</label></th>\
				<td><small>\
                                Please Press Insert button. You will get a Demo Shortcode.<br/>\
                                Edit the shortcode to achive your requirement. ie(Use Image 28x28.)<br/><br/>\
                                <strong>Demo Shortcode</strong><br/>\
                                [tw-skills title="our Skils"]<br/>\
                                [tw-skill id="circle-one" parcentange="90"]Software[/tw-skill]<br/>\
                                [tw-skill id="circle-two" parcentange="45"]HTML[/tw-skill]<br/>\
                                [tw-skill id="circle-three" parcentange="65"]CSS[/tw-skill]<br/>\
                                [tw-skill id="circle-four" parcentange="75"]WORDPRESS[/tw-skill]\
                                [/tw-skills]<br/>\
                                </small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="skill_submit" class="button-primary" value="Insert Tab" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#skill_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			
			var shortcode = '[tw-skills title="our Skils"]';
                            shortcode += '[tw-skill id="circle-one" parcentange="90"]Software[/tw-skill]';
                            shortcode += '[tw-skill id="circle-two" parcentange="45"]HTML[/tw-skill]';
                            shortcode += '[tw-skill id="circle-three" parcentange="65"]CSS[/tw-skill]';
                            shortcode += '[tw-skill id="circle-four" parcentange="75"]WORDPRESS[/tw-skill]';
                            shortcode += '[/tw-skills]';
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();