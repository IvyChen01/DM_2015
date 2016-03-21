(function() {
   tinymce.create('tinymce.plugins.content', {
      init : function(ed, url) {
         ed.addButton('content', {
            text : 'Content',
            image : false,
            type: 'menubutton',
            menu: [
                    {
                            text: 'Carousel',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Carousel Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=carousel-form' );
                            }
                    },
                    {
                            text: 'Services',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Service Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=service-form' );
                            }
                    },
                    {
                            text: 'Testimonial',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Testimonial Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=testimonial-form' );
                            }
                    },
                    {
                            text: 'Portfolio',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Portfolio Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=portfolio-form' );
                            }
                    },
                    {
                            text: 'About Us',
                            menu: [
                                {
                                    text: 'Our Skill',
                                    onclick: function() {
                                        var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                        W = W - 80;
                                        H = H - 84;
                                        tb_show( 'Skill Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=skill-form' );
                                    }
                                },
                                {
                                    text: 'About Describe',
                                    onclick: function() {
                                        var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                        W = W - 80;
                                        H = H - 84;
                                        tb_show( 'About Describe Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=abdescribe-form' );
                                    }
                                },
                                {
                                    text: 'Our Team',
                                    onclick: function() {
                                        var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                        W = W - 80;
                                        H = H - 84;
                                        tb_show( 'Team Member Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=team-form' );
                                    }
                                }
                            ]
                            
                    },
                    {
                            text: 'Text Block',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Text Block Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=textblock-form' );
                            }
                    },
                    {
                            text: 'Recent Blog',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Recent Post Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=recentPost-form' );
                            }
                    },
                    {
                            text: 'Fun Facts',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show('Fun Facts Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=timer-form');
                            }
                    },
                    {
                            text: 'Our Clients',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Client Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=client-form' );
                            }
                    },
                    {
                            text: 'News Letter',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'News Latter Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=newslatter-form' );
                            }
                    },
                    {
                            text: 'Pricing Table',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show('Pricing Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=pricing-form');
                            }
                    },
                    {
                            text: 'Twitter',
                            onclick: function() {
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'twitter Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=twitter-form' );
                            }
                    },
                    {
                            text: 'Contact Us',
                            menu:[
                                {
                                    text: 'Contact Details',
                                    onclick: function() {
                                        var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                        W = W - 80;
                                        H = H - 84;
                                        tb_show( 'Contact Details', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=contactdetails-form' );
                                    }
                                },
                                {
                                    text: 'Contact Times',
                                    onclick: function() {
                                        var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                        W = W - 80;
                                        H = H - 84;
                                        tb_show( 'Contact time Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=contacttime-form' );
                                    }
                                },
                                {
                                    text: 'Contact Form',
                                    onclick: function() {
                                        var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                        W = W - 80;
                                        H = H - 84;
                                        tb_show( 'Contact Form Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=contactform-form' );
                                    }
                                }
                            ]
                    }
                ]
         });
      }
      
   });
   tinymce.PluginManager.add('content', tinymce.plugins.content);
   //========================
   // Carousel
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="carousel-form"><table id="carousel-table" class="form-table">\
			<tr>\
				<th><label for="carousel_category">Carousel With Category</label></th>\
				<td><input type="text" name="category" id="carousel_category" value="" /><br />\
				<small>Carousel generate with your given category ID. Or you can leave it blank for recent carousel item slider.</small></td>\
			</tr>\
			<tr>\
				<th><label for="carousel_item">Number of Carousel Item</label></th>\
				<td><input type="text" name="item" id="carousel_item" value="" /><br />\
				<small>Number of slider item.</small></td>\
			</tr>\
			<tr>\
				<th><label for="carousel_features">With Features</label></th>\
				<td><select name="features" id="carousel_features"><option value="1">Yes</option><option value="2">No</option></select><br />\
				<small>Number of slider item.</small></td>\
			</tr>\
			<tr>\
				<th><label for="carousel_effect">Effect</label></th>\
				<td><select name="effect" id="carousel_effect"><option value="slide">Slide</option><option value="fade">Fade</option></select><br />\
				<small>Select Slide Effect.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="carousel_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#carousel_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'category'              : '',
				'item'                  : '',
                                'features'              : '',
                                'effect'                : ''
				};
			var shortcode = '[doors-carousel';
			
			for( var index in options) {
				var value = table.find('#carousel_' + index).val();
				
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
   
   //========================
   // Services
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="service-form"><table id="service-table" class="form-table">\
			<tr>\
				<th><label for="service_sitem">Number of Item</label></th>\
				<td><select name="sitem" id="service_sitem"><option value="4">4 Items</option>\
				<option value="8">8 Items</option><option value="12">12 Items</option></select><br />\
				<small>Number of item.</small></td>\
			</tr>\\n\
                        <tr>\
				<th><label for="service_category">Service Category</label></th>\
				<td><input type="text" name="service_category" id="service_category" value="" /><br />\
				<small><b>if you use just one service section you dont need this</b> <br />if you want more service section. you can create service with category name and add the service category name here. </small></td>\
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
                                'sitem'              : '',
                                'category'           : ''
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
   
   
   //========================
   // Testimonial
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="testimonial-form"><table id="testimonial-table" class="form-table">\
			<tr>\
				<th><label for="testimonial_type">Testimonial Type</label></th>\
				<td><select name="type" id="testimonial_type">\
                                    <option value="slider">Slider</option></select><br />\
				<small>Select Testimonial View Type.</small></td>\
			</tr>\
			<tr>\
				<th><label for="testimonial_number">Number Of Member</label></th>\
				<td><input type="text" name="number" id="testimonial_number" value="8" /><br />\
				<small>How many Testimonial you want to show.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="testimonial_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#testimonial_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'type'            : '',
				'number'            : ''
				};
			var shortcode = '[tw-testimonial';
			
			for( var index in options) {
				var value = table.find('#testimonial_' + index).val();
				
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
   
   
   //========================
   // Portfolio
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="portfolio-form"><table id="portfolio-table" class="form-table">\
			<tr>\
				<th><label for="portfolio_formate">Portfolio Formate</label></th>\
				<td><select name="formate" id="portfolio_formate">\
                                    <option value="normal">Normal</filter>\
                                    <option value="filter">Filter</option>\
                                    <option value="slide">Slide</option></select><br />\
				<small>Select A Portfolio Formate. </small></td>\
			</tr>\
			<tr>\
				<th><label for="portfolio_number">Number Of Portfolio</label></th>\
				<td><input type="text" name="number" id="portfolio_number" value="4" /><br />\
				<small>How many member you want to show.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="portfolio_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#portfolio_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'formate'            : '',
				'number'             : ''
				};
			var shortcode = '[doors-portfolio';
			
			for( var index in options) {
				var value = table.find('#portfolio_' + index).val();
				
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
   
   
   //========================
   // Our Skills
   //========================
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
   
   //========================
   // Our Vision
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="abdescribe-form"><table id="abdescribe-table" class="form-table">\
			<tr>\
				<th><label for="abdescribe_title">Title</label></th>\
				<td><input type="text" name="title" id="abdescribe_title" value=""/><br />\
				<small>Insert About Description Title. </small></td>\
			</tr>\
			<tr>\
				<th><label for="abdescribe_description">Description</label></th>\
				<td><textarea name="description" id="abdescribe_description"></textarea><br />\
				<small>Insert Description.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="abdescribe_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#abdescribe_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'title'              : '',
				'description'            : ''
				};
			var shortcode = '[tw-abdescribe';
			
			for( var index in options) {
				var value = table.find('#abdescribe_' + index).val();
				
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
   
   
   //========================
   // Our Team
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="team-form"><table id="team-table" class="form-table">\
			<tr>\
				<th><label for="team_title">Title</label></th>\
				<td><input type="text" id="team_title" name="title" value="Meet Our Team">\<br />\
				<small>Insert Team Title. </small></td>\
			</tr>\
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
			<tr>\
				<th><label for="team_category">Category ID</label></th>\
				<td><input type="text" name="category" id="team_category" value=""/><br/>\
				<small>Insert Category ID.</small></td>\
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
                                'title'             : '',
				'type'              : '',
				'member'            : '',
				'category'            : ''
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
   
   //========================
   // Text Block
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="textblock-form"><table id="textblock-table" class="form-table">\
			<tr>\
				<th><label for="textblock-heading">Text Block Heading</label></th>\
				<td><textarea name="heading" id="textblock-heading"></textarea><br />\n\
                                <small>Text Block Heading Text.</small></td>\
			</tr>\
			<tr>\
				<th><label for="textblock-subtitle">Text Block Subtitle</label></th>\
				<td><textarea name="subtitle" id="textblock-subtitle"></textarea><br />\
				<small>Text Block Subtitle</small>\</td>\
			</tr>\
			<tr>\
				<th><label for="textblock-btntext">Button Text</label></th>\
				<td><input type="text" name="btntext" id="textblock-btntext" value=""/><br />\
				<small>Button Text</small></td>\
			</tr>\
			<tr>\
				<th><label for="textblock-btnlink">Button Link URL</label></th>\
				<td><input type="text" name="btnlink" id="textblock-btnlink" value="#" /><br />\
                                <small>Link Url.</small></td>\
			</tr>\
                </table>\
		<p class="submit">\
			<input type="button" id="textblock-submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#textblock-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'heading'           : '', 
				'subtitle'          : '',
				'btntext'           : '',
                                'btnlink'           : ''
				};
			var shortcode = '[doors-textblock';
			
			for( var index in options) {
				var value = table.find('#textblock-' + index).val();
				
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
   
   
  //========================
   // Recent Blog
   //========================
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
   
   
   //========================
   // Timer
   //========================
   jQuery(function() {
        // creates a form to be displayed everytime the button is clicked
        // you should achieve this using AJAX instead of direct html code like this
        var form = jQuery('<div id="timer-form"><table id="timer-table" class="form-table">\
			<tr>\
				<th><label for="timer-title">Timer Shortcode</label></th>\
				<td><small>Click Insert Button you will get a demo shortcode. After that edit the shortcode as you want. Demo Shortcode:</small><br /><br />\
				[doors-timer title="Clients Worked With" icon="fa-group" amount="1000"]<br/>\
				[doors-timer title="Completed Projects" icon="fa-gift" amount="986"]<br/>\
				[doors-timer title="Winning Awards" icon="fa-trophy" amount="23"]<br/>\
                                </td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="timer_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');

        var table = form.find('table');
        form.appendTo('body').hide();

        // handles the click event of the submit button
        form.find('#timer_submit').click(function() {
            // defines the options and their default values
            // again, this is not the most elegant way to do this
            // but well, this gets the job done nonetheless
            
            var shortcode = '[doors-timer title="Clients Worked With" icon="fa-group" amount="1000"]';
            shortcode += '[doors-timer title="Completed Projects" icon="fa-gift" amount="986"]';
            shortcode += '[doors-timer title="Winning Awards" icon="fa-trophy" amount="23"]';

            // inserts the shortcode into the active editor
            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

            // closes Thickbox
            tb_remove();
        });
    });
   
   //========================
   // Our Clients
   //========================
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
   
   
   //========================
   // News Letter
   //========================
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
   
   
   //========================
   // Pricing Table
   //========================
   jQuery(function() {
        // creates a form to be displayed everytime the button is clicked
        // you should achieve this using AJAX instead of direct html code like this
        var form = jQuery('<div id="pricing-form"><table id="pricing-table" class="form-table">\\n\
                        <tr>\
				<th><label for="pricing_feature">Feature Table</label></th>\
				<td><select name="feature" id="pricing_feature">\
                                    <option value="no">NO</option>\n\
                                    <option value="featured-table">yes</option></select><br />\
				<small>Select if you want this feature.</small></td>\
			</tr>\
			<tr>\
				<th><label for="pricing_title">Pricing Table Title</label></th>\
				<td><input type="text" name="title" id="pricing_title" value="Basic" /><br />\
				<small>Put Your Pricing Table Title.</small></td>\
			</tr>\
                        <tr>\
				<th><label for="pricing_currency">Deatils: </label></th>\
				<td><select name="currency" id="pricing_currency">\
                                    <option value="$">$</option>\
                                    <option value="€">€</option>\
                                    <option value="£">£</option>\
                                    <option value="₨">₨</option>\
                                    <option value="¥">¥</option>\
                                    <option value="₹">₹</option>\
                                    <option value="﷼">﷼</option>\
                                    </select>\
                                    <input type="text" style="width:80px" name="price" id="pricing_price" value="49" />\n\
                                    <input type="text" style="width:100px" name="billing" id="pricing_billing" value="monthly" /><br />\
				<small>Put Your Curency Symbol, Price and biling</small></td>\
			</tr>\
                        <tr>\
				<th><label for="devider_border">Deatils: </label></th>\
				<td><input type="text" name="details1" id="pricing_details1" value="5 Domain Names" /><br />\
				<small>Put Your Product details/small></td>\
			</tr>\
                        <tr>\
				<th><label for="devider_border">Deatils: </label></th>\
				<td><input type="text" name="details2" id="pricing_details2" value="1GB Dedicated Ram" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\
                        <tr>\
				<th><label for="devider_border">Deatils: </label></th>\
				<td><input type="text" name="details3" id="pricing_details3" value="5 Sub Domain" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\
                        <tr>\
				<th><label for="devider_border">Deatils: </label></th>\
				<td><input type="text" name="details4" id="pricing_details4" value="10 Addon Domain" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\
                        <tr>\
				<th><label for="devider_border">Deatils: </label></th>\
				<td><input type="text" name="details5" id="pricing_details5" value="24/7 Support" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\
                        <tr>\
				<th><label for="devider_border">Deatils: </label></th>\
				<td><input type="text" name="signuplink" id="pricing_signuplink" value="#" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\
                        <tr>\
				<th><label for="devider_border">Deatils: </label></th>\
				<td><input type="text" name="signup" id="pricing_signup" value="Sign-up" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="pricing_submit" class="button-primary" value="Insert Tab" name="submit" />\
		</p>\
		</div>');

        var table = form.find('table');
        form.appendTo('body').hide();

        // handles the click event of the submit button
        form.find('#pricing_submit').click(function() {
            // defines the options and their default values
            // again, this is not the most elegant way to do this
            // but well, this gets the job done nonetheless
            var options = {
                'feature': '',
                'title': '',
                'currency': '',
                'price': '',
                'billing': '',
                'details1': '',
                'details2': '',
                'details3': '',
                'details4': '',
                'details5': '',
                'signuplink': '',
                'signup': '',
            };
            var shortcode = '[tw-pricing';

            for (var index in options) {
                var value = table.find('#pricing_' + index).val();

                // attaches the attribute to the shortcode only if it's different from the default value
                if (value !== options[index])
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
   
   
   //========================
   // Twitter
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="twitter-form"><table id="twitter-table" class="form-table">\
			<tr>\
				<th><label for="devider_padding">Instructions</label></th>\
				<td><small>Please setup your twitter account information in \
                                <b>Appearence->Widgets</b>. Use the Twitter Feed sidebar.</small></td>\
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
			
			var shortcode = '[tw-twitter-feed-slide]';
			
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
   
   
   //========================
   // Images
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="images-form"><table id="images-table" class="form-table">\
			<tr>\
				<th><label for="images-url">Image Url</label></th>\
				<td><input type="text" name="url" id="images-url" value="" placeholder="http://" /><br />\n\
                                <small>Image Url.</small></td>\
			</tr>\
			<tr>\
				<th><label for="images-width">Image Width</label></th>\
				<td><input type="text" name="width" id="images-width" value="100%" /><br />\
                                <small>Image Width.</small></td>\
			</tr>\
			<tr>\
				<th><label for="images-margin">Image Margin</label></th>\
				<td><input type="text" name="margin" id="images-margin" value="" /><br />\
                                <small>Image margin.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="images-submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#images-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
                                'url'          : '', 
				'width'          : '',
                                'margin'         : ''
				};
			var shortcode = '[doors-images';
			
			for( var index in options) {
				var value = table.find('#images-' + index).val();
				
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
   
   
   //========================
   // Contact Details
   //========================
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
   
   
   //========================
   // Contact Times
   //========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="contacttime-form"><table id="contacttime-table" class="form-table">\
			<tr>\
				<th><label for="devider_padding">Contact Hour Title</label></th>\
				<td><input type="text" name="title" id="contacttime_title" value="Business Hours" /><br />\
				<small>Put Your Contact Hour Title.</small></td>\
			</tr>\
			<tr>\
				<th><label for="devider_border">Working Hour</label></th>\
				<td><input type="text" name="workinghour" id="contacttime_workinghour" value="Mon. - Fri. 8am to 5pm" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\\n\
                        <tr>\
				<th><label for="devider_border">Working Hour</label></th>\
				<td><input type="text" name="workinghour2" id="contacttime_workinghour2" value="Sat. 8am to 11am" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\\n\
                        <tr>\
				<th><label for="devider_border">Working Hour</label></th>\
				<td><input type="text" name="workinghour3" id="contacttime_workinghour3" value="Sun. Closed" /><br />\
				<small>Put Your working hour Time .</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="contacttime_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#contacttime_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'title'            : '',
                                'workinghour'             : '',
                                'workinghour2'             : '',
                                'workinghour3'             : '',
				};
			var shortcode = '[tw-contacttime';
			
			for( var index in options) {
				var value = table.find('#contacttime_' + index).val();
				
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
   
   
   //===========================
   // Contact Form
   //==========================
   jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="contactform-form"><table id="contactform-table" class="form-table">\
			<tr>\
				<th><label for="contactform_title">Contact Form Title</label></th>\
				<td><input type="text" name="title" id="contactform_title" value="Visit Our Office" /><br />\
				<small>Contact Form Title.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="contactform_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#contactform_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'title'            : ''
				};
			var shortcode = '[tw-contactform';
			
			for( var index in options) {
				var value = table.find('#contactform_' + index).val();
				
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
        
  //==============================
  // Google Map
  //==============================
  jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="googlemap-form"><table id="googlemap-table" class="form-table">\
			<tr>\
				<th><label for="googlemap_width">Map Width</label></th>\
				<td><input type="text" name="width" id="googlemap_width" value="100%" /><br />\
				<small>Set Width For Google Map with %.</small></td>\
			</tr>\
			<tr>\
				<th><label for="googlemap_height">Map Height</label></th>\
				<td><input type="text" name="height" id="googlemap_height" value="330px" /><br />\
				<small>Set Height For Google Map with px.</small></td>\
			</tr>\
			<tr>\
				<th><label for="googlemap_height">Instruction </label></th>\
				<td><small>Befor aplly Goole Map shortcode please setup Latitude and Longitude in theme option.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="googlemap_submit" class="button-primary" value="Insert Button" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#googlemap_submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'width'             : '',
				'height'            : ''
				};
			var shortcode = '[doors-googlemap';
			
			for( var index in options) {
				var value = table.find('#googlemap_' + index).val();
				
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