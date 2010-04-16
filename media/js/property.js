$(document).ready(function() {
	$('#price_type_range').change(setupPrice);
	$('#price_type_fixed').change(setupPrice);
	setupPrice();
	
	$("#imageUpload").fileUpload({
		'uploader': '/minime/media/images/uploader.swf',
		'script': '/minime/media/uploadify/upload.php',
		'checkScript': '/minime/media/uploadify/check.php',
		'folder': '/minime/media/uploads',
		'cancelImg': '/minime/media/images/cancel.png',
		'multi': true,
		'buttonText': 'Select Files',
		'auto' : false,
		'displayData': 'speed',
		'simUploadLimit': 2,
		onComplete: function (evt, queueID, fileObj, response, data) {
			console.log(fileObj);
			var html = '<img src="'+fileObj.filePath+'" width="50" height="50" />';
			$('#images').prepend(html);
		}
	});
	
});

function setupPrice() {
	if ($('#price_type_range').attr('checked')) {
		$('#pricerange').removeClass('hide');
	} else {
		$('#pricerange').addClass('hide');
	}
}
