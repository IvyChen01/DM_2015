/**
 * Created by rrr on 2015/3/4.
 */
var id = window.location.href.match(/userid=(\d+)$/)[1];
function bindUserInfo(){
    $.ajax({
        url         :       '/?m=survey&a=getCustomer',
        type        :       'GET',
        data        :       {id:id},
        success     :       function(data){
            if(data.indexOf("{") != 0) {
                throw  new Error('Server error!');
                return;
            }

            var data = JSON.parse(data);

            $(".sl-country").text(data.data.country)
            $(".wo-number").text(data.data.wo_number)
            $(".cus-name").text(data.data.customer_name)
            $(".cus-phone").text(data.data.phone)
            $(".cus-model").text(data.data.model)
            $(".sa-sn").text(data.data.wo_number)


        },
        timeout     :       3000,
        error       :       function(){
            throw  new Error('Server error!');
        }

    })

}

$(function(){
    bindUserInfo();

    $(".ty-eb a").click(function(){$(".imf-dialog").fadeIn();})
    $(".st-cot .st-cl").click(function(){$(".imf-dialog").fadeOut();})
    $(".bow-cot input").change(function () {
        $(".fs-pas").val($(this).val());
    })
})