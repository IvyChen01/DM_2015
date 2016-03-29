/**
 *
 */
// 使用jQuery代替$符号，避免与Discuz自带的js的$冲突

var isGoodCode = false;
var timer = null;
var count = 60;
var sendCount = 0;
function errormessage(id, msg) {
    if(jQuery('#tip_' + id)) {
        jQuery('#tip_' + id).html(msg);
    }
}
function trim(str) {
        return str.replace(/^\s*(.*?)[\s\n]*$/g, '$1');
}
function selectRegion(){
	alert("xiaobai");
        var region = jQuery('#international_code').val();
        //alert('region');
        jQuery('#code').html(region);
}

function submitCode(){
        isGoodCode = false;
        var code = jQuery('#verification_code').val().trim();
        if(code==""){
            errormessage('verification_code', 'Please enter the 6 a verification code');
            return ;
        }
        if(!code.match(/^\d{6,6}$/g)){
            errormessage('verification_code', 'Format is not correct, please enter the 6 digit number');
            return;
        }
        isGoodCode = true;
        // 是合格的验证码
        if(isGoodCode){
                var code = jQuery('#verification_code').val().trim();
                var phone = jQuery('#phone').html().trim();
                jQuery.post(
                          'httppost.php',
                          {
                                'tel':phone,
                                'vcode':code,
                                'flag': '2'
                          },
                          function (data)
                          {
                            if(data.trim() == "-11"){
                                errormessage('verification_code','Verification code has been expired');
                            }else if(data.trim() == "-12"){
                                errormessage('verification_code','Invalid verification code');
                            }else if(data.trim() == 0){
                                // 关闭定时
                                if(timer != null){
                                        clearInterval(timer);
                                }
                                window.location.href='member.php?mod=verification&mobile=2&flag=verification_success&mobile_phone='+phone;
                            }
                        }
                );
        }
}
function sendCode(){
        var code = jQuery('#international_code').attr('value').trim();
        var phone = jQuery('#phone').html().trim();
        jQuery.ajax( {
                type : "post",
                url : 'httppost.php',
                data : {
                                        'internationalCode':code.substring(1),
                                        'tel':phone,
                                        'param':"your verification code is [lijun]",
                                        'flag': '1'
                                },
                success : function(data) {

                        if(trim(data) == -1){
                                // 不允许点击发送
                                jQuery('#send_code').html('<strong>After '+count+'s send again</strong>');
                                jQuery('#send_code').unbind('click');
                        }else if(trim(data) == 0){
                                if(timer == null){
                                        timer = setInterval("checkSendSuccessful()",1000);
                                }else {
                                        clearInterval(timer);
                                        timer = setInterval("checkSendSuccessful()",1000);
                                }
                                jQuery('#send_code').css('width','160px');
                                jQuery('#send_code').html('<strong>After '+count+'s send again</strong>');
                        }
                },
                error : function(){
                        errormessage('verification_code','Server connection failure');
                }
        });
}

function checkSendSuccessful(){
        count = count - 1;
        jQuery('#send_code').html('<strong>After '+count+'s send again</strong>');
        if(count == 0){
                sendCount = sendCount + 1;
                // 如果已经自动发送了3次
                if(sendCount <= 2){
                        count = 60;
                        jQuery('#send_code').html('<strong>After '+count+'s send again</strong>');
                        sendCode();
                        jQuery("#send_code").live("click",sendCode);
                }else{
                        // 关闭定时
                if(timer != null){
                        clearInterval(timer);
                }
                jQuery('#send_code').html('<strong>Once again send</strong>');
                jQuery("#send_code").live("click",sendCode);
                sendCount = 0;
                }
        }
}

