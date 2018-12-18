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
    		url: "/ajax_page/" + $(this).data("pagenb"),
            dataType: "HTML"
            // dataType: "JSON"
    	}).done(function( result ) {
			$(".ajax_tricks_list").last().html(result);
            // console.log(Object.keys(result.tricks[0]));
            // $.each(JSON.parse(result.tricks), function(i, item){
            //     alert(i);
            //     console.log(item["name"]);
            //     // alert(item["name"]);
            // });
            // alert(result.nbPages);
            // alert(result.pageNb);
		});
    });

});