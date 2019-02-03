/****************************************
file: home.js
Main JS file for home view
****************************************/

$(document).ready(function() {

/****************************************
Function Extend home tricks list
****************************************/
    $(document).on("click", ".btn_action_ajax_tricks_list", function(){
        $.ajax({
            url: "/ajax_tricks_list/" + $(this).data("pagenb"),
            dataType: "HTML"
        }).done(function( result ) {
            $(".ajax_tricks_list").last().html(result);
        });
    });
});
