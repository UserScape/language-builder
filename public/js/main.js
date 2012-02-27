$(function() {

	$('#toggle').click(function(){
		$('fieldset.hide').toggle("slow");
		$('#toggle i').toggleClass('icon-folder-open');
	});

	// See if all are translated
	var show_all = true;
	$('fieldset.show').each(function(index) {
		show_all = false;
	});
	if (show_all) {
		$('fieldset.hide').show();
	}
});
