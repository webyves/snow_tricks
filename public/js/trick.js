/****************************************
file: home.js
Main JS file for home view
****************************************/

$(document).ready(function() {

    /****************************************
        Function Extend home tricks list
    ****************************************/
    $(document).on("click", ".btn_action_ajax_comments_list", function(){
        $.ajax({
            url: "/ajax_comments_list/" + $(this).data("pagenb"),
            dataType: "HTML",
            method: "POST",
            data: { trickid : trickId }
        }).done(function( result ) {
            $(".ajax_comments_list").last().html(result);
        });
    });

    /****************************************
        Function Change Image list
    ****************************************/
    $(document).on("click", ".btn_action_images_list", function(){
        if($(this).data("loadimage") >= 0 && $(this).data("loadimage") < nbImages) {
            var prevloadimage = $("#btnImgPrev").data("loadimage");
            var nextloadimage = $("#btnImgNext").data("loadimage");
            if($(this).data("dir") === "next") {
                $("#imgClickable_1").attr('src', $("#imgClickable_2").attr('src'));
                $("#imgClickable_2").attr('src', $("#imgClickable_3").attr('src'));
                $("#imgClickable_3").attr('src', "/uploads/trick_images/" + trickImagesTab[$(this).data("loadimage")]);
                prevloadimage = prevloadimage + 1;
                nextloadimage = nextloadimage + 1;
            } else if ($(this).data("dir") === "prev"){
                $("#imgClickable_3").attr('src', $("#imgClickable_2").attr('src'));
                $("#imgClickable_2").attr('src', $("#imgClickable_1").attr('src'));
                $("#imgClickable_1").attr('src', "/uploads/trick_images/" + trickImagesTab[$(this).data("loadimage")]);
                prevloadimage = prevloadimage - 1;
                nextloadimage = nextloadimage - 1;
            }
            $("#btnImgPrev").data("loadimage", prevloadimage)
            $("#btnImgNext").data("loadimage", nextloadimage)
        }
    });

    /****************************************
        Function Change Video list
    ****************************************/
    $(document).on("click", ".btn_action_videos_list", function(){
        if($(this).data("loadvideo") >= 0 && $(this).data("loadvideo") < nbVideos) {
            var prevloadvideo = $("#btnVidPrev").data("loadvideo");
            var nextloadvideo = $("#btnVidNext").data("loadvideo");
            if($(this).data("dir") === "next") {
                $("#divVideo_1").html($("#divVideo_2").html());
                $("#divVideo_2").html($("#divVideo_3").html());
                $("#divVideo_3").html(trickVideosTab[$(this).data("loadvideo")]);
                prevloadvideo = prevloadvideo + 1;
                nextloadvideo = nextloadvideo + 1;
            } else if ($(this).data("dir") === "prev"){
                $("#divVideo_3").html($("#divVideo_2").html());
                $("#divVideo_2").html($("#divVideo_1").html());
                $("#divVideo_1").html(trickVideosTab[$(this).data("loadvideo")]);
                prevloadvideo = prevloadvideo - 1;
                nextloadvideo = nextloadvideo - 1;
            }
            $("#btnVidPrev").data("loadvideo", prevloadvideo)
            $("#btnVidNext").data("loadvideo", nextloadvideo)
        }
    });



    /****************************************
        Function View Geater Image
    ****************************************/
    $(document).on("click", ".imgClickable", function(){
        var source = $(this).attr('src');
        $("#imgFull").attr('src', source);
    });

});