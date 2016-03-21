(function() {
    tinymce.create('tinymce.plugins.pricing', {
        init: function(ed, url) {
            ed.addButton('pricing', {
                title: 'Pricing',
                image: url + '/pricing.png',
                onclick: function() {
                    // triggers the thickbox
                    var width = jQuery(window).width(), H = jQuery(window).height(), W = (720 < width) ? 720 : width;
                    W = W - 80;
                    H = H - 84;
                    tb_show('Pricing Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=pricing-form');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "Pricing",
                author: 'XpeedStudio',
                authorurl: 'http://www.xpeedstudio.com',
                infourl: 'http://www.xpeedstudio.com',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('pricing', tinymce.plugins.pricing);
    // executes this when the DOM is ready
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
})();