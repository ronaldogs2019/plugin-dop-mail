(function ($) {

	if ($("#formDopDopMail form").length){
		$("#formDopDopMail form").attr("method", "post");
		$("#formDopDopMail form").attr("action", "http://dev.wordpress.test/wp-admin/options-general.php?page=dopdop-mail-send-email");
	}else{
		$( "#formDopDopMail" ).wrap( "<form action='http://dev.wordpress.test/wp-admin/options-general.php?page=dopdop-mail-send-email' method='post'></form>" );
	}	

})(jQuery);
