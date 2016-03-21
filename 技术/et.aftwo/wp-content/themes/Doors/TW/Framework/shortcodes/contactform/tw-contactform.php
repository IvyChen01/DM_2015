<?php
function contactform($atts)
{
    extract(shortcode_atts(array(
        'title'            => 'Visit Our Office'
    ), $atts));
    
    $result = '<div class="col-sm-4 wow zoomIn contact-content" data-wow-duration="700ms" data-wow-delay="500ms">
                    <h2>'.$title.'</h2>
                    <form id="contact-form" class="contact-form" name="contact-form" action="#">
                        <div class="row">
                            <div class="form-group col-sm-6 name-field">
                                <input type="text" id="conname" name="conname" class="form-control" required="required" placeholder="Name">
                            </div>
                            <div class="form-group col-sm-6 email-field">
                                <input type="email" id="conemail" name="email" class="form-control" required="required" placeholder="Email Id">
                            </div>
                            <div class="form-group col-sm-12">
                                <textarea name="message" id="conmessage" id="message" required="required" class="form-control" rows="8" placeholder="Your Text"></textarea>
                            </div> 
                        </div>				                                   
                        <div class="form-group">
                            <button type="submit" id="consubmit" class="btn btn-default">Submit</button>
                        </div>
                    </form>				
            </div>';
    
    return $result;
}
add_shortcode( "tw-contactform", "contactform" );