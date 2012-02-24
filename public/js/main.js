$(function() {

	$('#toggle').click(function(){
		$('fieldset.hide').toggle("slow");
		$('#toggle i').toggleClass('icon-folder-open');
	});
});
