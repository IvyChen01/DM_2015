/**
 * Created by rrr on 2015/1/29.
 */
$(function(){
    function login(){
        if(!$(".input-username").val() || !$(".input-userpwd").val()){
            alert('用户名或密码不能为空!')
            return;
        }
        if(!$(".verify-input").val()) {
            alert('请输入验证码!');
            return;
        }
        $.post("...",{username : $(".input-username").val(),userpwd : $(".input-userpwd").val(),code : $(".verify-input").val()},function(data){})
    }

    document.onkeydown = function(e){
        var keyCode = e ? e.keyCode : window.event.which;
        if(keyCode == 13) {
            login();
        }
    }
    $(".login-submit button").click(function(){
        login()
    })

})








