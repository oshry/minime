$(document).ready(function() {

	$.matchPanels(); // match panel height to content
	$('#wrapper #header h1').click(function() { window.location = $(this).find('a').attr('href'); }); // logo link
	$('form.quicksearch input').enableHelper(); // input helpers
	
});

// matches grid panels to be same size
jQuery.matchPanels = function() {
	// match content & panel heights, first find the margin
	var h_margin = $('#wrapper #panel').height() - $('#wrapper #content').height();
	// now grab shorter element (#content or #panel)
	var shorter = $('#wrapper #'+(h_margin > 0 ? 'content' : 'panel'));
	// add the marginal height
	shorter.height(Math.abs(h_margin) + shorter.height());
};

// input helpers (toggling default value on inputs)
jQuery.fn.enableHelper = function(settings) {
	var config = {'color': '', 'img': ''};
	if (settings) $.extend(config, settings);
	this.each(
		function() {
			var el = $(this);
			var type = el.attr('type');
			switch (type)
			{
				case 'text':
					el
					.data('txt', el.val())
					.data('color', el.css('color'))
					.focus(
						function() {
							var el = $(this);
							if (el.val() == el.data('txt')) el.val('');
							if (config.color) el.css('color', el.data('color'));
						})
					.blur(
						function() {
							var el = $(this);
							if (el.val() == '') el.val(el.data('txt'));
							if (config.color) el.css('color', config.color);
						});
					break;
				case 'password':
					el
					.css('background-image', 'url('+config.img+')').css('background-repeat', 'no-repeat')
					.data('img', config.img)
					.focus(
						function() {
							$(this).css('background-image', 'none');
						})
					.blur(
						function () {
							var el = $(this);
							if ( ! el.val()) el.css('background-image', 'url('+el.data('img')+')');
						});
					
					break;
			}
		});
	return this;
};
