jQuery(document).ready(function($){
  // Uploading files
  var file_frame;
  var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
  var set_to_post_id = 10; // Set this
  var count = 0;
 
  $('.form-table .button').click(function( event ){
 
    event.preventDefault();    

    $('div.dw-halloween-image-select img').last().remove();  
   
    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      // Set the post ID to what we want
      file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
      // Open frame
      file_frame.open();
      return;
    } else {
      // Set the wp.media post id so the uploader grabs the ID we want when initialised
      wp.media.model.settings.post.id = set_to_post_id;
    }
 
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: 'Uploader',
      button: {
        text: 'Choose images',
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });
 
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
 
      // Do something with attachment.id and/or attachment.url here   
      var fullurl = attachment.url,
          filename = fullurl.substr( (fullurl.lastIndexOf('/') +1) ),
          id = attachment.id;
      $('.dw-halloween-image .dw-halloween-image-select').append('<img id="dw-halloween-custom-image-'+filename+'" class="hide" src="'+fullurl+'">');

      $("img").one("load", function() {

        $('div.dw-halloween-image-select input').last().remove();
        $('div.dw-halloween-image-select br').last().remove();
        $('div.dw-halloween-image-select label').last().remove();  

        var width = document.getElementById('dw-halloween-custom-image-'+filename).width;
        var height = document.getElementById('dw-halloween-custom-image-'+filename).height; 

        $('.dw-halloween-image .dw-halloween-image-select').append('<input type="hidden" name="dw-halloween[customimageid]" value="'+id+'"><input checked="checked" type="radio" name="dw-halloween[image]" id="dw-halloween-image-'+filename+'" value="'+filename+'" data-image="'+fullurl+'" data-width="'+width+'" data-height="'+height+'" data-frame="1"  class="image_select"> <label for="dw-halloween-image-'+filename+'"  >Custom image ('+filename+') </label><br>');
        $( '#pumpkin_settings input.image_select' ).change();        

      }).each(function() {
      if(this.complete) $(this).load();
      });

      jQuery('#publish').click();
      // Restore the main post ID
      wp.media.model.settings.post.id = wp_media_post_id;
    });
 
    // Finally, open the modal
    file_frame.open();

    count++;
  });
  
  // Restore the main ID when the add media button is pressed
  jQuery('a.add_media').on('click', function() {
    wp.media.model.settings.post.id = wp_media_post_id;
  });
});

