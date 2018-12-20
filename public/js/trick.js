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
            data: { trickid : $(this).data("trickid") }
      	}).done(function( result ) {
			$(".ajax_comments_list").last().html(result);
		});
    });

});