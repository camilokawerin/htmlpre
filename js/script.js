jQuery(function($){
	$('#code').focus(function(){
		if ($(this).val() == '<p>hello world</p>') {
			$(this).val('');
		} else {
			this.select();
		}
	});
	$('form').submit(function(){
		$.post( $(this).attr('action'), {
			code: $('#code').val(),
			ajax: 1
			}, 
		function(data) {
			$('#_code').val($(data).find('code').text());
			$('#result').html($(data).find('result').text());
			}, 'xml' );
		return false;
	});
	$('pre textarea').click(function(){
		this.select();
	});
});