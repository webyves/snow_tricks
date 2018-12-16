/****************************************
file: main.js
Main JS file for custom JS
****************************************/

$(document).ready(function() {

    /****************************************
        Function 
    ****************************************/
    $(document).on("click", ".btn_action_ajax_tricks_list", function(){

    	$.ajax({
    		url: "/ajax_page/" + $(this).data("pagenb"),
    		dataType: "HTML"
    	}).done(function( result ) {
			$(".ajax_tricks_list").last().html(result);
		});
    });

});