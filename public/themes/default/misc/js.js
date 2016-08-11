$(function(){

	$('a').click(function(){

			$.pjax({
			  url: $(this).attr('href'),
			  container: '#html'
			});

	});

});