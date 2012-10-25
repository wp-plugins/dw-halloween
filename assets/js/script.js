jQuery(document).ready(function($) {
	$('#dw-halloween-animation').on('change',function(event){
		if( 'advance' == $(this).val() ){
			$('#dw-halloween-animation-area').slideUp();
			$('#dw-halloween-animation-preset').slideDown();
		}else{
			$('#dw-halloween-animation-area').slideDown();
			$('#dw-halloween-animation-preset').slideUp();
		}
	});

	$('#dw-halloween-closeable').on('change',function(event){
		if( '1' == $(this).val() ){
			$(this).nextAll('.hide').slideDown();
		}else{
			$(this).nextAll('.hide').slideUp();
		}
	});

	$('#pumpkin_settings input.image_select').on('change',function(event){
		var checked = $(this);
		var $preview = $('#pumpkin_settings .dw-halloween-image .preview');
		var width = checked.data('width');
		var frame = checked.data('frame');
		var height = checked.data('height') / frame;
		var img = checked.data('image');
		
		$preview.css({
			'width': width, 
			'height': height, 
			'background-image': 'url('+img+')',
			'background-position' : '0 0'

		});
	});

	$('#pumpkin_settings .halloween-image').click(function(event){
		event.preventDefault();
		$('#pumpkin_settings .halloween-image').each(function(){
			$(this).removeClass('selected');
		});
		$(this).addClass('selected');
		$('#pumpkin_settings input:radio[name=dw-halloween[image]]').val($(this).data('image'));
	});

	// Preview setting
	if ( $('#pumpkin_settings .dw-halloween-image .preview').length > 0 ){
		var $preview = $('#pumpkin_settings .dw-halloween-image .preview');
		var width = $preview.data('width');
		var frame = $preview.data('frame');
		var height = $preview.data('height') / frame;
		var img = $preview.data('image');

		$preview.css({
			'width': width, 
			'height': height, 
			'background-image': 'url('+img+')',
			'background-position' : '0 0'

		});

		var animatting = false;
		var preview = null;

		$('#pumpkin_settings .dw-halloween-image .preview').on('mouseover',function(event){
			var wing_speed = 1000 / 30;
			var seft = $(this);

			if( animatting ) return;
			animatting = true;
			var pos = 0;
			preview = setInterval(function(){
				seft.css('background-position','0 -'+( pos * height )+'px');
				pos++;
				if( pos == 18 ) pos = 0;

			},wing_speed);
		});

		$('#pumpkin_settings .dw-halloween-image .preview').on('mouseout',function(event){
			$(this).css('background-position','0 0');
			clearInterval(preview);
			animatting = false;
		});

	}
});
