/**
 * Created by rrr on 14-4-25.
 */
$(function(){
    var img_val_index=0;
    $(".upload-img").click(function(){
        $("body").append("<div class='body-shadow'></div>");
        $(".upload-img-box").show();
        img_val_index=$(".upload-img").index($(this));
    })
    $(".dialog").each(function () {
        var dialog = $(this);
        dialog.find(".close-btn a").click(function () {
            dialog.hide();
            $(".body-shadow").detach();
        })
    })

    $("#buttonUpload").click(function(){
        ajaxFileUpload();
        $(".upload-img-box").hide();
        $(".body-shadow").detach();
    });
    function ajaxFileUpload()
    {
        $("#loading")
            .ajaxStart(function(){
                $(this).show();
            })
            .ajaxComplete(function(){
                $(this).hide();
            });

        $.ajaxFileUpload
        (
            {
                url:'/?m=admin&a=upload_jq_image',
                secureuri:false,
                fileElementId:'fileToUpload',
                dataType: 'json',
                data:{name:'logan', id:'id'},
                success: function (data, status)
                {
                    if(typeof(data.error) != 'undefined')
                    {
                        if(data.error != '')
                        {
                            alert(data.error);
                        }else
                        {
//                            alert('file: ' + data.url);
                            $(".img-val").eq(img_val_index).val(data.url);

                        }
                    }
                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
        )

        return false;

    }




})