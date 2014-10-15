jQuery(document).ready(function($) {
    $('#dw-halloween-animation').on('change', function(event) {
        if ('advance' == $(this).val()) {
            $('#dw-halloween-animation-area').slideUp();
            $('#dw-halloween-animation-preset').slideDown();
        } else {
            $('#dw-halloween-animation-area').slideDown();
            $('#dw-halloween-animation-preset').slideUp();
        }
    });

    $('#dw-halloween-closeable').on('change', function(event) {
        if ('1' == $(this).val()) {
            $(this).nextAll('.hide').slideDown();
        } else {
            $(this).nextAll('.hide').slideUp();
        }
    });

    $('#pumpkin_settings').on('change', 'input.image_select', function(event) {
        var checked = $(this);
        var $preview = $('#pumpkin_settings .dw-halloween-image .preview');
        var width = checked.data('width');
        var frame = checked.data('frame');
        var height = checked.data('height') / frame;
        var img = checked.data('image');
        var filename = img.split('/').pop();

        if ( filename == 'Special_item_Bat_f1.gif' || filename == 'Special_item_Cat_f1.gif')
        {
            $('.normal-setting').css({
                'display': 'none'
            });
        } else {
            $('.normal-setting').css({
                'display': ''
            });
        }
        
        $preview.data('width', width);
        $preview.attr('data-width', width);
        $preview.data('height', height);
        $preview.attr('data-height', height);
        $preview.data('frame', frame);
        $preview.attr('data-frame', frame);
        $preview.data('image', img);
        $preview.attr('data-image', img);

        if (width > 300)
        {
            $preview.css({   
            'width': width,
            'height': height, 
            'background-image': 'url(' + img + ')',
            'background-position': '0 0',      
            'width': '300',
            'background-size': '100%',
            'background-repeat': 'no-repeat'
            });
        }else if ( height > 300) {
            $preview.css({   
            'width': width,
            'height': height, 
            'background-image': 'url(' + img + ')',
            'background-position': '0 0',      
            'height': '300px',
            'background-size': '100%',
            'background-repeat': 'no-repeat'
            });
        } else {
            $preview.css({
            'width': width,
            'height': height,
            'background-image': 'url(' + img + ')',
            'background-position': '0 0',             
            'background-size': '',
            'background-repeat': ''
            });
        }
    });

    $('#pumpkin_settings .halloween-image').click(function(event) {
        event.preventDefault();
        $('#pumpkin_settings .halloween-image').each(function() {
            $(this).removeClass('selected');
        });
        $(this).addClass('selected');
        $('#pumpkin_settings input:radio[name=dw-halloween[image]]').val($(this).data('image'));
    });

    // Preview setting
    if ($('#pumpkin_settings .dw-halloween-image .preview').length > 0) {
        var $preview = $('#pumpkin_settings .dw-halloween-image .preview');
        var width = $preview.data('width');
        var frame = $preview.data('frame');
        var height = $preview.data('height') / frame;
        var img = $preview.data('image');

        if (width > 300)
        {
            $preview.css({   
            'width': width,
            'height': height, 
            'background-image': 'url(' + img + ')',
            'background-position': '0 0',      
            'width': '300',
            'background-size': '100%',
            'background-repeat': 'no-repeat'
            });
        }else if ( height > 300) {
            $preview.css({   
            'width': width,
            'height': height, 
            'background-image': 'url(' + img + ')',
            'background-position': '0 0',      
            'height': '300px',
            'background-size': '100%',
            'background-repeat': 'no-repeat'
            });
        } else {
            $preview.css({
            'width': width,
            'height': height,
            'background-image': 'url(' + img + ')',
            'background-position': '0 0',             
            'background-size': '',
            'background-repeat': ''
            });
        }

        var animatting = false;
        var preview = null;

        $('#pumpkin_settings .dw-halloween-image .preview').on('mouseover', function(event) {
            var wing_speed = 1000 / 30;
            var seft = $(this);
            frame = $preview.data('frame');
            height = $preview.data('height');

            if (frame != 1) {

                if (animatting) return;
                animatting = true;
                var pos = 0;
                preview = setInterval(function() {
                    seft.css('background-position', '0 -' + (pos * height) + 'px');
                    pos++;
                    if (pos == 18) pos = 0;

                }, wing_speed);
            }
        });

        $('#pumpkin_settings .dw-halloween-image .preview').on('mouseout', function(event) {
            $(this).css('background-position', '0 0');
            clearInterval(preview);
            animatting = false;
        });
    }

    // Change fade effect 
    $('#dw-halloween-effect').on('change load', function(event) {
        if ('1' == $(this).val()) {
            $('#dw-halloween-fade-effect').removeClass('hide').addClass('active');
            $('#dw-halloween-fade-toggle-effect').removeClass('hide').addClass('active');
    	} else {
            $('#dw-halloween-fade-effect').removeClass('active').addClass('hide');
            $('#dw-halloween-fade-toggle-effect').removeClass('active').addClass('hide');
        }
    });
});