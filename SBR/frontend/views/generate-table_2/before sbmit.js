    $("form#{$model->formName()}").on("beforeSubmit", function(e){
    var \$form = $(this);
            $.post(
                    \$form.attr("action"),
                    \$from.serialize()
                    )
            .done(function(result){
            if (result.message == "Success"){
            $(document).find("#secondmodal").modal("hide");
                    $.pjax.reload({container:"#commodity-grid"});
            } else
            {
            $(\$form).trigger("reset");
                    $("#message").html(result.message);
            }
            }).fail(function(){
    console.log("server error");
    });
            return false;
    });