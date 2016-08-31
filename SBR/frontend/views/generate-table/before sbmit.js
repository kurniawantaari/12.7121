    $("form#table-generator-form").on("beforeSubmit", function(e){
    var \$form = $(this);
            $.post(
                    \$form.attr("action"),
                    \$from.serialize()
                    )
            .done(function(result){
            if (result.message == "Success"){
            $("#message").html(result.message);
                    //   $(document).find("#secondmodal").modal("hide");
                    //            $.pjax.reload({container:"#commodity-grid"});
            } else
            {
    //  $(\$form).trigger("reset");
            //
            }
            }).fail(function(){
    console.log("server error");
    });
            return false;
    });