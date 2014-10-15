<?php  
/**
 * 	Plugin Name: DW Halloween
 * 	Author: DesignWall
 * 	Author URI: http://designwall.com
 * 	Description: Flying Pumpkins screaming Halloween are ready for your Wordpress Site.
 * 	Version: 1.1
 *  License: GPLv2
 */

add_action ( 'admin_enqueue_scripts', function () {
        if (is_admin ())
            wp_enqueue_media ();
    } );

function dw_halloween_enqueue_scripts(){
	wp_enqueue_script('dw-halloween-script', plugin_dir_url(__FILE__).'assets/js/halloween.js', array('jquery'));
	wp_enqueue_style('dw-halloween-style', plugin_dir_url(__FILE__).'assets/css/halloween.css');
}
add_action('wp_enqueue_scripts', 'dw_halloween_enqueue_scripts');

function dw_halloween_admin_enqueue_scripts(){
	wp_enqueue_script('dw-halloween-script', plugin_dir_url(__FILE__).'assets/js/halloween.js', array('jquery'));
	wp_enqueue_script('dw-halloween-custom', plugin_dir_url(__FILE__).'assets/js/script.js', array( 'jquery' ) );
	wp_enqueue_script('dw-halloween-mediabutton', plugin_dir_url(__FILE__).'assets/js/customizemedia.js', array( 'jquery' ) );
	wp_localize_script('dw-halloween-custom', 'dw_halloween', array( 
			'ajax_url'		=>	admin_url('admin-ajax.php'),
			'image_folder' 	=> 	plugin_dir_url(__FILE__).'assets/img/'
		) );
	wp_enqueue_style('dw-halloween-style-admin', plugin_dir_url(__FILE__).'style.css');
}
add_action('admin_enqueue_scripts', 'dw_halloween_admin_enqueue_scripts');

function dw_halloween_posttype() {
	//Pumpkin
	$pumpkin_labels = array(
		'name' => _x('Halloween item', 'post type general name'),
		'singular_name' => _x('Pumpkin', 'post type singular name'),
		'add_new' => _x('Add New', 'pumpkin'),
		'add_new_item' => __('Add halloween item'),
		'edit_item' => __('Edit halloween item'),
		'new_item' => __('New halloween item'),
		'all_items' => __('All items'),
		'view_item' => __('View halloween item'),
		'search_items' => __('Search halloween item'),
		'not_found' =>  __('No items found'),
		'not_found_in_trash' => __('No pumpkins found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => __('DW Halloween')

	);
	$pumpkin_args = array(
		'labels' => $pumpkin_labels,
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'menu_icon' => plugin_dir_url(__FILE__).'icon.png' , 
		'query_var' => false,
		'rewrite' => false,
		'capability_type' => 'post',
		'has_archive' => false, 
		'hierarchical' => false,
		'supports' => array( 'title')
	); 
	register_post_type( 'dw-halloween', $pumpkin_args );
}
add_action('init', 'dw_halloween_posttype');

function dw_halloween_metabox(){
	add_meta_box('pumpkin_settings', 'Halloween item settings', 'dw_halloween_animate_settings', 'dw-halloween','normal');
}
add_action('admin_init', 'dw_halloween_metabox');
function dw_halloween_animate_settings($post){
	$settings = get_post_meta($post->ID, 'dw-halloween', true);
	$settings = wp_parse_args($settings, array( 
			'size'				=> 	'zoomlv2',
			'image'				=>	'Pumpkin_f66.png',
			'customimageid'		=> 	NULL,
			'frame-width'		=>	180,
			'frame-height'		=>	80,
			'message'			=> 	'Wishing you a scary halloween!!!',
			'animation'			=>	'random',
			'flying-speed'		=>	3000,
			'swing-speed'		=>	45,
			'delay-time'		=>	2000,
			'delay-start'		=>	0,
			'frame-start'		=>	0,
			'effect'			=> 	0,
			'fade-toggle-time'	=>	1000,
			'fade-time'			=>  500,
			'closeable'			=> 	0,
			'close-type'		=>  1,
			'preset'			=>	'100,100,1000,600,300,200',
			'area'				=>	'100, 100, 1000, 600',
			'class'				=>	'dw-halloween'

		) );
	?>
	<table class="form-table">
		<tbody>
			<tr valign="top" class="pumpkin-image">
				<th><?php dw_halloween_('Flying item') ?></th>				
				<td class="dw-halloween-image">
					<?php 
						if( !empty($settings['image'])  ){
							$image = dw_halloween_get_image_info($settings['image'], $settings['customimageid']) ;
							if( !empty($image)){ 
								extract($image);
					?>
					<table>
						<tr>
							<td>
								<div class="preview-container">
									<div class="preview" data-image="<?php echo $url ?>" data-width="<?php echo $width ?>" data-height="<?php echo $height ?>" data-frame="<?php echo $frame; ?>" ></div>
								</div>
								<?php 	
										}
									}
								?>
							</td>
							<td>
								<div class="dw-halloween-image-select">
									<?php dw_halloween_load_image($settings['image'], $settings['customimageid']); ?>
								</div>
							</td>
						</tr>
					</table>
					<br class="clear">
					<p class="description"><?php dw_halloween_('Choose a scary Halloween item.'); ?></p>
				</td>
			</tr>	
			<tr>
				<th scope="row"><label for=""><?php dw_halloween_('Upload Image') ?></label></th>
				<td>
					<div class="uploader-image">
						<button id="dw-halloween-upload-button" class="button" name="dw-halloween-button" value="Upload">Upload</button>
					</div>
					<p class="description"><?php dw_halloween_('Upload your custom flying object. You should prepare a gif image with tranparent background before add it to this plugin.'); ?></p>
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row"><label for=""><?php dw_halloween_('Image Size') ?></label> </th>
				<td>
					<select name="dw-halloween[size]" id="dw-halloween-size">
						<option <?php selected($settings['size'], 'zoomlv2') ?> value="zoomlv2"><?php dw_halloween_('Default') ?></option>
						<option <?php selected($settings['size'], 'zoomlv3') ?> value="zoomlv3"><?php dw_halloween_('Small') ?></option>
						<option <?php selected($settings['size'], 'zoomlv1') ?> value="zoomlv1"><?php dw_halloween_('Big') ?></option>
					</select>
				</td>
			</tr>
			<!-- Frame dimesions ? -->
			<tr valign="top" class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Message') ?></th>
				<td>
					<textarea name="dw-halloween[message]" id="dw-halloween-message" cols="30" rows="10" class="large-text" ><?php echo $settings['message']; ?></textarea>
					<p class="description"><?php dw_halloween_('HTML is supported. The message will be shown once the user clicks on the image.') ?></p>
				</td>
			</tr>
			<tr valign="top" class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Animation Type') ?></th>
				<td>
					<select class="regular-text has-option" name="dw-halloween[animation]" id="dw-halloween-animation" >
						<option <?php selected($settings['animation'], 'random'); ?> value="random"><?php dw_halloween_('Random') ?></option>
						<option <?php selected($settings['animation'], 'advance'); ?> value="advance"><?php dw_halloween_('Custom') ?></option>
					</select>
					<p class="description">
						<?php dw_halloween_('Select from 2 defined animation types.<br>
						(1) Random: The image will follow random positions.<br>
						(2) Path: The image follows a predefined animation path.<br>
						') ?>
					</p>
					<div id="dw-halloween-animation-preset" class="<?php dw_halloween_hided( $settings['animation'], 'random') ?>" style="padding-top: 5px;">
						<label><?php dw_halloween_('Set your XY coordinates'); ?></label>
						<input type="text" name="dw-halloween[preset]" id="dw-halloween-preset" class="large-text" value="<?php echo $settings['preset'] ?>" >
						<p class="description"><?php dw_halloween_('An array of x,y values to set custom position of your animation. The image will move to your defined positions.'); ?></p>
					</div>
					<div id="dw-halloween-animation-area" class="<?php dw_halloween_hided( $settings['animation'], 'advance') ?>" style="padding-top: 5px;">
						<label><?php dw_halloween_('Animation area'); ?></label>
						<input type="text" name="dw-halloween[area]" id="dw-halloween-area" class="large-text" value="<?php echo $settings['area'] ?>" >
						<p class="description"><?php dw_halloween_('Defines a rectangular boundry area with 4 coordinates "Left, Top, Right, Bottom". The animation is limited to this area. If you leave it empty the full viewport will be used.'); ?></p>
					</div>

				</td>	
			</tr>
			<tr valign="top" class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Animation Speed') ?></th>
				<td>

					<select name="dw-halloween[flying-speed]" id="dw-halloween-flying-speed">
						<option <?php selected($settings['flying-speed'], 3000) ?> value="3000"><?php dw_halloween_('Default') ?></option>
						<option <?php selected($settings['flying-speed'], 4500) ?> value="4500"><?php dw_halloween_('Slow') ?></option>
						<option <?php selected($settings['flying-speed'], 1500) ?> value="1500"><?php dw_halloween_('Fast') ?></option>
					</select>
					<p class="description"><?php dw_halloween_('Select the pre-defined animation speed. Default, Fast, Slow.') ?></p>
				</td>	
			</tr>
			<tr valign="top" class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Wing Speed') ?></th>
				<td>
					<select name="dw-halloween[swing-speed]" id="dw-halloween-swing-speed">
						<option <?php selected($settings['swing-speed'], 40) ?> value="40"><?php dw_halloween_('Default') ?></option>
						<option <?php selected($settings['swing-speed'], 25) ?> value="25"><?php dw_halloween_('Slow') ?></option>
						<option <?php selected($settings['swing-speed'], 60) ?> value="60"><?php dw_halloween_('Fast') ?></option>
					</select>
					<p class="description"><?php dw_halloween_('Select from Default, Slow, Fast to set the wing speed.') ?></p>
				</td>
			</tr>
			<tr valign="top" class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Pause Time (ms)') ?></th>
				<td><input type="text" name="dw-halloween[delay-time]" id="dw-halloween-delay-time" class="small-text" value="<?php echo $settings['delay-time'] ?>" > </td>
			</tr>
			<tr valign="top" class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Delay time (ms)') ?></th>
				<td><input type="text" name="dw-halloween[delay-start]" id="dw-halloween-delay-start" class="small-text" value="<?php echo $settings['delay-start'] ?>" > 
					<p class="description"><?php dw_halloween_('Animation will start after your defined delay time (ms).') ?></p>	
				</td>
			</tr>
			<tr valign="top" class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Frame Start') ?></th>
				<td><input type="text" name="dw-halloween[frame-start]" id="dw-halloween-frame-start" class="small-text" value="<?php echo $settings['frame-start'] ?>" > 
					<p class="description"><?php dw_halloween_('') ?></p>	
				</td>
			</tr>
			<tr valign="top" class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Fade effect') ?></th>
				<td>
					<select name="dw-halloween[effect]" id="dw-halloween-effect"  class="regular-text has-option"> 
						<option <?php selected($settings['effect'], 0) ?> value="0"><?php dw_halloween_('No'); ?></option>
						<option <?php selected($settings['effect'], 1) ?> value="1"><?php dw_halloween_('Yes'); ?></option>
					</select>
				</td>
			</tr>
			<tr valign="top" id="dw-halloween-fade-toggle-effect" <?php if ( $settings['effect'] !=1 ) echo 'class="hide"'; ?> class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Fade toggle time (ms)') ?></th>
				<td><input type="text" name ="dw-halloween[fade-toggle-time]" id="dw-halloween-fade-toggle-time" class="small-text" value="<?php echo $settings['fade-toggle-time'] ?>" >
					<p class="description"><?php dw_halloween_('Time (ms) between fade in and fade out.') ?>
				</td>
			</tr>
			<tr valign="top" id="dw-halloween-fade-effect" <?php if ( $settings['effect'] != 1 ) echo 'class="hide"'; ?> class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">	
				<th><?php dw_halloween_('Fade time (ms)') ?></th>
				<td><input type="text" name ="dw-halloween[fade-time]" id="dw-halloween-fade-time" class="small-text" value="<?php echo $settings['fade-time'] ?>" >
					<p class="description"><?php dw_halloween_('Time (ms) to fade in/fade out.') ?>
				</td>
			</tr>
			<tr valign="top" class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Closeable?') ?></th>
				<td>
					<select name="dw-halloween[closeable]" id="dw-halloween-closeable"  class="regular-text has-option"> 
						<option <?php selected($settings['closeable'], 0) ?> value="0"><?php dw_halloween_('No'); ?></option>
						<option <?php selected($settings['closeable'], 1) ?> value="1"><?php dw_halloween_('Yes - Temporary'); ?></option>
						<option <?php selected($settings['closeable'], 2) ?> value="2"><?php dw_halloween_('Yes - Permanently'); ?></option>
					</select>					
				</td>
			</tr>
			<tr valign="top" class="normal-setting <?php if ( $settings['image'] == 'Special_item_Bat_f1.gif' || $settings['image'] == 'Special_item_Cat_f1.gif' ) echo 'hide'; ?>">
				<th><?php dw_halloween_('Custom CSS class') ?></th>
				<td>
					<input type="text" value="<?php echo $settings['class'] ?>" name="dw-halloween[class]" id="dw-halloween-class" class="regular-text" >
					<p class="description"><?php dw_halloween_('Add your custom CSS class to write custom styles.'); ?></p>
				</td>
			</tr>
			</table>
		</tbody>
	</table>
	<?php
}

function dw_halloween_save_settings($post_id){
	$slug = 'dw-halloween';
    /* check whether anything should be done */
	if ( isset($_POST['post_type']) && $slug != $_POST['post_type'] ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if( isset($_POST['dw-halloween']) ){
		update_post_meta($post_id, 'dw-halloween', $_POST['dw-halloween'] );
	}
}
add_action('save_post', 'dw_halloween_save_settings');

// Print text with context _e
function dw_halloween_($text, $echo = true){
	if( $echo !== true )
		return __($text, 'dw-halloween');
	_e($text, 'dw-halloween');	
}

function dw_halloween_hided($a, $b){
	if( $a == $b )
		echo ' hide ';
}

function dw_halloween_display(){
	$pumpkins = get_posts( array(
		'numberposts'		=>	-1,
		'post_type'			=>	'dw-halloween',
		'post_status'		=>	'publish' )
	);

	ob_start();
	echo '<script type="text/javascript">';
	foreach ($pumpkins as $p) {
			$settings = get_post_meta($p->ID, 'dw-halloween', true);
			$settings = wp_parse_args($settings, array( 

				'size'				=> 	'zoomlv1',
				'image'				=>	'Pumpkin_f66.png',
				'customimageid'		=> 	NULL,
				'frame-width'		=>	180,
				'frame-height'		=>	80,
				'message'			=> 	'Wishing you a scary halloween!!!',
				'animation'			=>	'random',
				'preset'			=>	'\'auto\', \'auto\', \'auto\', \'auto\'',
				'area'				=> 	'\'auto\', \'auto\', \'auto\', \'auto\'',
				'flying-speed'		=>	3000,
				'swing-speed'		=>	45,
				'delay-time'		=>	2000,
				'delay-start'		=>	0,
				'frame-start'		=>	0,	
				'effect'			=>  0,
				'fade-toggle-time'	=> 	1000,
				'fade-time'			=>  500,
				'closeable'			=> 	0,
				'action'			=>	0,
				'class'				=>	'dw-halloween'

			) );

			if($settings['area']==''){
					$settings['area']="'auto', 'auto', 'auto', 'auto'";
			}
			if($settings['preset']==''){
					$settings['preset']="'auto', 'auto', 'auto', 'auto'";
			}

			$image = dw_halloween_get_image_info( $settings['image'], $settings['customimageid']);

			if( $image['width'] <= 0 || $image['height'] <=0 || $image['frame'] <=0 )
				continue;

			if( isset($settings['customimageid']))
			$imageuri = wp_get_attachment_url($settings['customimageid']);

			?>
		var pumpkin1 = new Frame({
			id:	'halloween-<?php echo $p->ID;  ?>',
			cls:	'<?php echo $settings['class'].' '.$settings['size']; ?>',
			<?php if( $settings['customimageid'] == NULL ) { ?> 
			image: '<?php echo plugin_dir_url(__FILE__) ?>assets/img/<?php echo $settings['image'] ?>',
			<?php }else { ?>
			image: '<?php echo $imageuri ?>',
			<?php } ?>
			tip: '<?php echo $settings['message']; ?>',
			width: <?php echo $image['width'] ?>,
			height: <?php echo ($image['height'] / $image['frame']) ?>,
			frame: <?php echo $image['frame'] ?>,
			framestart:<?php echo $settings['frame-start'] ?>,
			delaystart: <?php echo $settings['delay-start'] ?>,
			<?php if( 'random' != $settings['animation'] ){  ?>
			type: 'preset',
			data: [<?php echo $settings['preset']; ?>],
			<?php } else { ?>
			data: [<?php echo $settings['area']; ?>],
			<?php } ?>
			duration: <?php echo $settings['flying-speed'] ?>,
			fps:	<?php echo $settings['swing-speed'] ?>,
			delay: <?php echo $settings['delay-time'] ?>,
			effect: 	<?php echo $settings['effect'] ?>,
			fadetoggletime: <?php echo $settings['fade-toggle-time'] ?>,
			fadetime: <?php echo $settings['fade-time'] ?>,
			closable: <?php echo $settings['closeable']; ?>
		});
		<?php
	}
	echo '</script>';

	$pumpkin = ob_get_contents();
	$pumpkin = preg_replace('/^\s+|\n|\r|\s+$/m', '', $pumpkin);
	ob_end_clean();

	echo $pumpkin;
}
add_action('wp_footer', 'dw_halloween_display');

function dw_halloween_load_image($setting, $custom_image){

	$plugin_dir = plugin_dir_path(__FILE__).'assets/img/';

	if ( $handle = opendir($plugin_dir) ) {

	    /* This is the correct way to loop over the directory. */
	    while (false !== ($entry = readdir($handle))) {
	    	if( is_file($plugin_dir.$entry) ){

				extract( dw_halloween_get_image_info($entry) );
				if($image_ext !='png' && $image_ext !='gif') continue; 

    			?>
    			<input <?php checked($setting, $basename); ?> type="radio" name="dw-halloween[image]" id="dw-halloween-image-<?php echo $basename ?>" value="<?php echo $basename ?>" data-image="<?php echo $url ?>" data-width="<?php echo $width ?>" data-height="<?php echo $height ?>" data-frame="<?php echo $frame ?>" class="image_select"> <label for="dw-halloween-image-<?php echo $basename ?>"  ><?php echo $label ?></label>
    			<br>    			
    			<?php 
	    	}
	    }

	    closedir($handle);
	}

	if (!isset($custom_image)) return;
	$imageuri = wp_get_attachment_url($custom_image);
	$filename = basename(get_attached_file($custom_image));
	$filetype = wp_check_filetype( $imageuri );	
	if ( $filetype['ext'] == 'png' || $filetype['ext'] == 'jpg' || $filetype['ext'] == 'gif' ) 
	{
		$customimagesize = getimagesize($imageuri);
		$customimagewidth = $customimagesize[0];
		$customimageheight = $customimagesize[1];
	} else {
		$customimagewidth = NULL;
		$customimageheight = NULL;
	}		
	
	if ($setting == $filename) {
		?>
			<input type="hidden" name="dw-halloween[customimageid]" value="<?php echo $custom_image ?>">
		<?php
	}

	?>
		<input <?php checked($setting,$filename); ?> type="radio" name="dw-halloween[image]" id="dw-halloween-image-<?php echo $filename ?>" value="<?php echo $filename ?>" data-image="<?php echo $imageuri ?>" data-width="<?php echo $customimagewidth?>" data-height="<?php echo $customimageheight ?>" data-frame="1" class="image_select"> <label for="dw-halloween-image-<?php echo $filename ?>">Custom image (<?php echo $filename ?>)</label> <br>	
	<?php	
}

function dw_halloween_get_image_info($entry, $customimage = false){
	$plugin_url = plugin_dir_url(__FILE__).'assets/img/';
	$plugin_dir = plugin_dir_path(__FILE__).'assets/img/';

	$image_basename = pathinfo($entry, PATHINFO_BASENAME);
	$image_filename = pathinfo($entry, PATHINFO_FILENAME);
    $image_ext = pathinfo($entry,PATHINFO_EXTENSION);
	$image_url = $plugin_url.$image_basename; 
	if( is_file($plugin_dir.$entry) ){
		$image_size = getimagesize($image_url);
		$width = $image_size[0];
		$height = $image_size[1];
		$split = explode('_', $image_filename);
		$frame = str_replace('f', '', ( end($split) ) ) ;
		$label = preg_replace('/_f[0-9]+/i', '', $image_filename);
		return array(
			'label' 	=>  str_replace('_',' ', $label)	,
			'url'		=>	$image_url,
			'width'		=>	$width,
			'height'	=>	$height,
			'frame'		=>	$frame,
			'basename'	=>	$image_basename,
			'image_ext' => 	$image_ext
		);
	}

	if (empty($customimage)) return;
	$imageuri = wp_get_attachment_url($customimage);
	$filetype = wp_check_filetype( $imageuri );	
	if ( $filetype['ext'] != 'png' && $filetype['ext'] != 'jpg' && $filetype['ext'] != 'gif' ) return;
	$customimagesize = getimagesize($imageuri);
	$customimagewidth = $customimagesize[0];
	$customimageheight = $customimagesize[1];
	return array(
		'url'		=> $imageuri,
		'width'		=> $customimagewidth,
		'height'	=> $customimageheight,
		'frame'		=> 1
		);
}
?>