$(document).ready(function() {
	$('#fileInput').on('change', function() {
		var input = this;
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('.img-box img').attr('src', e.target.result);
			};

			reader.readAsDataURL(input.files[0]);
			$('#previousImage').hide();
		}
	});
});

jQuery(document).ready(function() {
    setTimeout(function() {
      jQuery('#success-message, #error-message').fadeOut('slow');
    }, 2000);
});