<?php



/*
	Plugin Name: carousel Video Gallery, pluginswp.com
	Plugin URI: http://www.pluginswp.com/ultimate-carousel-video-gallery/
	Description: With this plugin you can create 3D carousel video galleries with youtube videos or/and flv files. You can use the plugin as widgets or insert in your pages or posts. USE: Install and activate the plugin. You will see a new button on your wordpress administrator, "carousel Video." Click here to create your videos galleries. To insert a gallery in your posts, type [carousel_video X/], where X is the ID of the gallery.
	Version: 2.2
	Author: pluginswp.com
	Author URI: http://www.pluginswp.com/
*/


$contador=0;

$nombrebox="Webpsilon".rand(99, 99999);
function carousel_video_head() {

	$site_url = get_option( 'siteurl' );
	echo '<script type="text/javascript" src="'.$site_url.'/wp-content/plugins/carousel-free-video-gallery/js/swfobject.js"></script>';
		
}
function carousel_video($content){
	$content = preg_replace_callback("/\[carousel_video ([^]]*)\/\]/i", "carousel_video_render", $content);
	return $content;
	
}

function carousel_video_render($tag_string){
$contador=rand(9, 9999999);
	$site_url = get_option( 'siteurl' );
global $wpdb; 	
$table_name = $wpdb->prefix . "carousel_video";	


if(isset($tag_string[1])) {
	$auxi1=str_replace(" ", "", $tag_string[1]);
	$myrows = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = ".$auxi1.";" );
}
if(count($myrows)<1) $myrows = $wpdb->get_results( "SELECT * FROM $table_name;" );
	$conta=0;
	$id= $myrows[$conta]->id;
	$video = $myrows[$conta]->video;
	$titles = $myrows[$conta]->titles;
	$width = $myrows[$conta]->width;
	$height = $myrows[$conta]->height;
	$widthi = $myrows[$conta]->widthi;
	$heighti = $myrows[$conta]->heighti;
	$images = $myrows[$conta]->images;
	$round = $myrows[$conta]->round;
	$controls = $myrows[$conta]->controls;
	$skin = $myrows[$conta]->skin;
	$overplay = $myrows[$conta]->overplay;
	$row= $myrows[$conta]->row;
	$color1 = $myrows[$conta]->color1;
	$color2 = $myrows[$conta]->color2;
	$autoplay = $myrows[$conta]->autoplay;

	$tags = $myrows[$conta]->tags;
	
	$texto='';
	
	


$texto='title='.$titles.'&controls=1&color1=dddddd&color2=222222&round=10&autoplay=&skin=1&youtube='.$youtube.'&overplay='.$overplay.'&rows='.$row.'&widthi='.$widthi.'&heighti='.$heighti.'&tags=12';

$links = array();
$titlesa = array();
if($video!="") $links=preg_split ("/\n/", $video);
if($titles!="") $titlesa=preg_split ("/\n/", $titles);
if($images!="") $imagesa=preg_split ("/\n/", $images);
$cont1=0;
$linksajax="";
while($cont1<count($links)) {
	$auxititle="";
	$auxivideo="";
	$auxiimages="";
	$auxtipo=0;
	if(isset($titlesa[$cont1])) $auxititle=$titlesa[$cont1];
	if(isset($links[$cont1])) $auxivideo=$links[$cont1];
	if(isset($imagesa[$cont1])) $auxiimages=$imagesa[$cont1];
	if($auxivideo!="") {
		$auxtipo=1;
		if(strstr($auxivideo, "http")) {
			if(strpos($auxivideo, "youtube")>0) {
				$auxivideo=getYTidcarousel($auxivideo);
				$auxtipo=2;
				
			}
			else $auxtipo=1;
		}
		else $auxtipo=2;
		

	}
	$texto.='&video'.$cont1.'='.$auxivideo.'&title'.$cont1.'='.$auxititle.'&tipo'.$cont1.'='.$auxtipo.'&image'.$cont1.'='.$auxiimages.'&vurl'.$cont1.'='.$links[$cont1].'';
	
	
	
	
	$linksajax.= '<a rel="shadowbox;width=405;height=340;player=swf;" title="'.$auxititle.'" href="'.$links[$cont1].'">uuuu</a>';
	
	$cont1++;
}
$texto.='&cantidad='.$cont1;
	
	

	
	$table_name = $wpdb->prefix . "carousel_video";
	$saludo= $wpdb->get_var("SELECT id FROM $table_name ORDER BY RAND() LIMIT 0, 1; " );
	
	
	
	
	
	
	
	
	
	
	$output='
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$width.'" height="'.$height.'" id="carousel'.$id.'-'.$contador.'" title="'.$titles.'">
  <param name="movie" value="'.$site_url.'/wp-content/plugins/carousel-free-video-gallery/carouselfree_video.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
  	<param name="flashvars" value="'.$texto.'" />
	   <param name="allowFullScreen" value="true" />
  <param name="swfversion" value="9.0.45.0" />
  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="'.$site_url.'/wp-content/plugins/carousel-free-video-gallery/carouselfree_video.swf" width="'.$width.'" height="'.$height.'">
    <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="transparent" />
    	<param name="flashvars" value="'.$texto.'" />
		   <param name="allowFullScreen" value="true" />
    <param name="swfversion" value="9.0.45.0" />
    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
    <div>
      <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>
';
	return $output;
}


function getYTidcarousel($ytURL) {
#
 
#
$ytvIDlen = 11; // This is the length of YouTube's video IDs
#
 
#
// The ID string starts after "v=", which is usually right after
#
// "youtube.com/watch?" in the URL
#
$idStarts = strpos($ytURL, "?v=");
#
 
#
// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my
#
// bases covered), it will be after an "&":
#
if($idStarts === FALSE)
#
$idStarts = strpos($ytURL, "&v=");
#
// If still FALSE, URL doesn't have a vid ID
#
if($idStarts === FALSE)
#
die("YouTube video ID not found. Please double-check your URL.");
#
 
#
// Offset the start location to match the beginning of the ID string
#
$idStarts +=3;
#
 
#
// Get the ID string and return it
#
$ytvID = substr($ytURL, $idStarts, $ytvIDlen);
#
 
#
return $ytvID;
#
 
#
}


function carousel_video_instala(){
	global $wpdb; 
	$table_name= $wpdb->prefix . "carousel_video";
   $sql = " CREATE TABLE $table_name(
		id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
		video longtext NOT NULL ,
		titles longtext NOT NULL ,
		width tinytext NOT NULL ,
		height tinytext NOT NULL ,
		widthi tinytext NOT NULL ,
		heighti tinytext NOT NULL ,
		images longtext NOT NULL ,
		round tinytext NOT NULL ,
		controls tinytext NOT NULL ,
		skin tinytext NOT NULL ,
		overplay tinytext NOT NULL ,
		row tinytext NOT NULL ,
		color1 tinytext NOT NULL ,
		color2 tinytext NOT NULL ,
		autoplay tinytext NOT NULL ,
		tags tinytext NOT NULL ,
		PRIMARY KEY ( `id` )	
	) ;";

   	$id= $myrows[$conta]->id;
	$video = $myrows[$conta]->video;
	$titles = $myrows[$conta]->titles;
	$width = $myrows[$conta]->width;
	$height = $myrows[$conta]->height;

	$widthi = $myrows[$conta]->widthi;
	$heighti = $myrows[$conta]->heighti;
	
	$images = $myrows[$conta]->images;
	$round = $myrows[$conta]->round;
	$controls = $myrows[$conta]->controls;
	$skin = $myrows[$conta]->skin;
	$overplay = $myrows[$conta]->overplay;
	$row= $myrows[$conta]->row;
	$color1 = $myrows[$conta]->color1;
	$color2 = $myrows[$conta]->color2;
	$autoplay = $myrows[$conta]->autoplay;
   	$tags = $myrows[$conta]->tags;
   
	$wpdb->query($sql);
	$sql = "INSERT INTO $table_name (video, titles, width, height, images, round, controls, skin, overplay, row, color1, color2, autoplay, tags, widthi, heighti) VALUES ('http://www.youtube.com/watch?v=sCXXgjwXcxQ\nhttp://www.youtube.com/watch?v=kBtMJjLVB90', 'CAROUSEL VIDEO GALLERY\nWidget or plugin, youtube and flv videos.', '100%', '300px', '', '20', '2',  '1', '0', '1', '000000', 'dddddd', '', '14', '150', '100');";
	$wpdb->query($sql);
}
function carousel_video_desinstala(){
	global $wpdb; 
	$table_name = $wpdb->prefix . "carousel_video";
	$sql = "DROP TABLE $table_name";
	$wpdb->query($sql);
}	
function carousel_video_panel(){
	global $wpdb; 
	$table_name = $wpdb->prefix . "carousel_video";	
	
	if(isset($_POST['crear'])) {
		$re = $wpdb->query("select * from $table_name");
//autos  no existe
if(empty($re))
{
  $sql = " CREATE TABLE $table_name(
	id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
		video longtext NOT NULL ,
		titles longtext NOT NULL ,
		width tinytext NOT NULL ,
		height tinytext NOT NULL ,
		widthi tinytext NOT NULL ,
		heighti tinytext NOT NULL ,
		images longtext NOT NULL ,
		round tinytext NOT NULL ,
		controls tinytext NOT NULL ,
		skin tinytext NOT NULL ,
		overplay tinytext NOT NULL ,
		row tinytext NOT NULL ,
		color1 tinytext NOT NULL ,
		color2 tinytext NOT NULL ,
		autoplay tinytext NOT NULL ,
		tags tinytext NOT NULL ,
		PRIMARY KEY ( `id` )	
	) ;";
	$wpdb->query($sql);

}
		
	$sql = "INSERT INTO $table_name (video, titles, width, height, images, round, controls, skin, overplay, row, color1, color2, autoplay, tags, widthi, heighti) VALUES ('http://www.youtube.com/watch?v=sCXXgjwXcxQ\nhttp://www.youtube.com/watch?v=kBtMJjLVB90', 'CAROUSEL VIDEO GALLERY\nWidget or plugin, youtube and flv videos.', '100%', '300px', '', '20', '2',  '1', '0', '1', '000000', 'dddddd', '', '14', '150', '100');";
	$wpdb->query($sql);
	}
	
if(isset($_POST['borrar'])) {
		$sql = "DELETE FROM $table_name WHERE id = ".$_POST['borrar'].";";
	$wpdb->query($sql);
	}
	if(isset($_POST['id'])){	


$sql= "UPDATE $table_name SET `video` = '".$_POST["video".$_POST['id']]."', `titles` = '".$_POST["titles".$_POST['id']]."', `width` = '".$_POST["width".$_POST['id']]."', `height` = '".$_POST["height".$_POST['id']]."', `images` = '".$_POST["images".$_POST['id']]."', `round` = '".$_POST["round".$_POST['id']]."', `controls` = '".$_POST["controls".$_POST['id']]."', `skin` = '".$_POST["skin".$_POST['id']]."', `overplay` = '".$_POST["overplay".$_POST['id']]."', `row` = '".$_POST["row".$_POST['id']]."', `color1` = '".$_POST["color1".$_POST['id']]."', `color2` = '".$_POST["color2".$_POST['id']]."', `autoplay` = '".$_POST["autoplay".$_POST['id']]."', `tags` = '".$_POST["tags".$_POST['id']]."', `widthi` = '".$_POST["widthi".$_POST['id']]."', `heighti` = '".$_POST["heighti".$_POST['id']]."' WHERE `id` =  ".$_POST["id"]." LIMIT 1";
			$wpdb->query($sql);
	}
	$myrows = $wpdb->get_results( "SELECT * FROM $table_name" );
$conta=0;



include('template/cabezera_panel.html');
while($conta<count($myrows)) {
	$id= $myrows[$conta]->id;
	$video = $myrows[$conta]->video;
	$titles = $myrows[$conta]->titles;
	$width = $myrows[$conta]->width;
	$height = $myrows[$conta]->height;
	
	$widthi = $myrows[$conta]->widthi;
	$heighti = $myrows[$conta]->heighti;
	
	$images = $myrows[$conta]->images;
	$round = $myrows[$conta]->round;
	$controls = $myrows[$conta]->controls;
	$skin = $myrows[$conta]->skin;
	$overplay = $myrows[$conta]->overplay;
	$row= $myrows[$conta]->row;
	$color1 = $myrows[$conta]->color1;
	$color2 = $myrows[$conta]->color2;
	$autoplay = $myrows[$conta]->autoplay;
	$tags = $myrows[$conta]->tags;
	include('template/panel.html');			
	$conta++;
	}

}
function carousel_video_add_menu(){	
	if (function_exists('add_options_page')) {
		//add_menu_page
		add_menu_page('carousel_video', 'carousel Video', 8, basename(__FILE__), 'carousel_video_panel');
	}
}
if (function_exists('add_action')) {
	add_action('admin_menu', 'carousel_video_add_menu'); 
}








// class widget new

class wp_carousel_videowg extends WP_Widget {
	
	
	

	
	
	
	function wp_carousel_videowg() {
		$widget_ops = array('classname' => 'wp_carousel_videowg', 'description' => 'With this widget you can create 3D carousel video galleries with youtube videos or/and flv files. Write the url of the videos (flv files on your server or videos on youtube) you can add titles, change the aspect of thumbnails and more.' );
		$this->WP_Widget('wp_carousel_videowg', 'CAROUSEL VIDEO', $widget_ops);
	}
	
	
	function widget($args, $instance) {
		$site_url = get_option( 'siteurl' );
			
			echo $before_widget;
			

			$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
			$video = empty($instance['video']) ? '&nbsp;' : apply_filters('widget_video', $instance['video']);
			$titles = empty($instance['titles']) ? '&nbsp;' : apply_filters('widget_titles', $instance['titles']);
			$width = empty($instance['width']) ? '&nbsp;' : apply_filters('widget_width', $instance['width']);
			$height = empty($instance['height']) ? '&nbsp;' : apply_filters('widget_height', $instance['height']);
			$widthi = empty($instance['widthi']) ? '&nbsp;' : apply_filters('widget_widthi', $instance['widthi']);
			$heighti = empty($instance['heighti']) ? '&nbsp;' : apply_filters('widget_heighti', $instance['heighti']);
			$images = empty($instance['images']) ? '&nbsp;' : apply_filters('widget_images', $instance['images']);
			$round = empty($instance['round']) ? '&nbsp;' : apply_filters('widget_round', $instance['round']);
			$controls = empty($instance['controls']) ? '&nbsp;' : apply_filters('widget_controls', $instance['controls']);
			$skin = empty($instance['skin']) ? '&nbsp;' : apply_filters('widget_skin', $instance['skin']);
			$overplay = empty($instance['overplay']) ? '&nbsp;' : apply_filters('widget_overplay', $instance['overplay']);
			$row = empty($instance['row']) ? '&nbsp;' : apply_filters('widget_row', $instance['row']);
			$color1 = empty($instance['color1']) ? '&nbsp;' : apply_filters('widget_color1', $instance['color1']);
			$color2 = empty($instance['color2']) ? '&nbsp;' : apply_filters('widget_color2', $instance['color2']);
			$autoplay = empty($instance['autoplay']) ? '&nbsp;' : apply_filters('widget_autoplay', $instance['autoplay']);

			$tags = empty($instance['tags']) ? '&nbsp;' : apply_filters('widget_tags', $instance['tags']);
			
			
			if($autoplay==" " || $autoplay=="&nbsp;") $autoplay="";
			
			
			/// vars
			
			$texto='';
	
	if($autoplay==" ") $autoplay="";
	if($row==" ") $row="";





$texto='title='.$titles.'&controls=1&color1=dddddd&color2=222222&round=10&autoplay=&skin=1&youtube='.$youtube.'&overplay='.$overplay.'&rows='.$row.'&widthi='.$widthi.'&heighti='.$heighti.'&tags=12';


$links = array();
$titlesa = array();
if($video!="") $links=preg_split ("/\n/", $video);
if($titles!="") $titlesa=preg_split ("/\n/", $titles);
$cont1=0;

while($cont1<count($links)) {
	$auxititle="";
	$auxivideo="";
	$auxtipo=0;
	if(isset($titlesa[$cont1])) $auxititle=$titlesa[$cont1];
	if(isset($links[$cont1])) $auxivideo=$links[$cont1];
	if($auxivideo!="") {
		$auxtipo=1;
		if(strstr($auxivideo, "http")) {
			if(strpos($auxivideo, "youtube")>0) {
				$auxivideo=getYTidcarousel($auxivideo);
				$auxtipo=2;
			}
			else $auxtipo=1;
		}
		else $auxtipo=2;
		

	}
	$texto.='&video'.$cont1.'='.$auxivideo.'&title'.$cont1.'='.$auxititle.'&tipo'.$cont1.'='.$auxtipo.'&vurl'.$cont1.'='.$links[$cont1].'';
	$cont1++;
}
$texto.='&cantidad='.$cont1;
			
			
			/////////////////
			
		
			
			echo $before_title . $widget_title . $after_title;
			
			if($widget_title!="") echo '<br/><br/>';
			

			
			echo '
			
			
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$width.'" height="'.$height.'" id="carouselswidget" title="'.$titles.'">
  <param name="movie" value="'.$site_url.'/wp-content/plugins/carousel-free-video-gallery/carouselfree_video.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
  	<param name="flashvars" value="'.$texto.'" />
	   <param name="allowFullScreen" value="true" />
  <param name="swfversion" value="9.0.45.0" />
  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="'.$site_url.'/wp-content/plugins/carousel-free-video-gallery/carouselfree_video.swf" width="'.$width.'" height="'.$height.'">
    <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="transparent" />
    	<param name="flashvars" value="'.$texto.'" />
		   <param name="allowFullScreen" value="true" />
    <param name="swfversion" value="9.0.45.0" />
    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
    <div>
      <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>
';
			
			
			
			echo $after_widget;
		
	}
	
	

	
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['video'] = strip_tags($new_instance['video']);
		$instance['titles'] = strip_tags($new_instance['titles']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['widthi'] = strip_tags($new_instance['widthi']);
		$instance['heighti'] = strip_tags($new_instance['heighti']);
		$instance['images'] = strip_tags($new_instance['images']);
		$instance['round'] = strip_tags($new_instance['round']);
		$instance['controls'] = strip_tags($new_instance['controls']);
		$instance['skin'] = strip_tags($new_instance['skin']);
		$instance['overplay'] = strip_tags($new_instance['overplay']);
		$instance['row'] = strip_tags($new_instance['row']);
		$instance['color1'] = strip_tags($new_instance['color1']);
		$instance['color2'] = strip_tags($new_instance['color2']);
		$instance['autoplay'] = strip_tags($new_instance['autoplay']);
		$instance['tags'] = strip_tags($new_instance['tags']);
		
		
		
		return $instance;
	}
	function form($instance) {
		
		
		
		
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'CAROUSEL VIDEO', 'video' =>  'http://www.youtube.com/watch?v=sCXXgjwXcxQ', 'titles' => 'VIDEO CAROUSEL', 'width' => '100%', 'height' => '300px', 'images' => '', 'round' => '10', 'controls' => '2', 'skin' => '1', 'overplay' => '0', 'row' => '1', 'color1' => '000000', 'color2' => 'dddddd','autoplay' => '', 'tags' => '12', 'widthi' => '100', 'heighti' => '80') );
		
		
		
		$title = strip_tags($instance['title']);
		$video = strip_tags($instance['video']);
		$titles = strip_tags($instance['titles']);
		$width = strip_tags($instance['width']);
		$height = strip_tags($instance['height']);
		$widthi = strip_tags($instance['widthi']);
		$heighti = strip_tags($instance['heighti']);
		$images = strip_tags($instance['images']);
		$round = strip_tags($instance['round']);
		$controls = strip_tags($instance['controls']);
		$skin = strip_tags($instance['skin']);
		$overplay = strip_tags($instance['overplay']);
		$row = strip_tags($instance['row']);
		$color1 = strip_tags($instance['color1']);
		$color2 = strip_tags($instance['color2']);
		$autoplay = strip_tags($instance['autoplay']);
		$tags = strip_tags($instance['tags']);
		$overplay_checked[$overplay] = 'checked';
		$checked[$skin] = 'checked';
		$checked[$controls] = 'checked';
	
		
?>
			<p>Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>
            
            <p>Video URLs youtube of flv files(one url x line):
            <textarea class="widefat" rows="6" id="<?php echo $this->get_field_id('video'); ?>" name="<?php echo $this->get_field_name('video'); ?>" ><?php echo attribute_escape($video); ?></textarea></p>
            
             <p>Video titles(one title x line):
            <textarea class="widefat" rows="6" id="<?php echo $this->get_field_id('titles'); ?>" name="<?php echo $this->get_field_name('titles'); ?>" ><?php echo attribute_escape($titles); ?></textarea></p>
            
            <p>Width, number with px or %: <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" /></p>
            
                        <p>Height, number with px or %: <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo attribute_escape($height); ?>" /></p>
        	
            <p>Thumbnail width: <input class="widefat" id="<?php echo $this->get_field_id('widthi'); ?>" name="<?php echo $this->get_field_name('widthi'); ?>" type="text" value="<?php echo attribute_escape($widthi); ?>" /></p>
            
            <p>Thumbnail height: <input class="widefat" id="<?php echo $this->get_field_id('heighti'); ?>" name="<?php echo $this->get_field_name('heighti'); ?>" type="text" value="<?php echo attribute_escape($heighti); ?>" /></p>
            

            
            <p>Thumbnail video capture size(<10): <input class="widefat" id="<?php echo $this->get_field_id('row'); ?>" name="<?php echo $this->get_field_name('row'); ?>" type="text" value="<?php echo attribute_escape($row); ?>" /></p>
            

   
                <br/><br/><br/>



               <a href="http://www.pluginswp.com/ultimate-carousel-video-gallery/">Download CAROUSEL VIDEO GALLERY EXTENDED PLUGIN</a> More options: font size, colors, round, multiple design styles, image background, ... <br/><br/>
               
                <a href="http://www.pluginswp.com/sliderpro/">Download SLIDERPRO. IMAGE AND VIDEO</a><br/><br/>
                
               <a href="http://www.pluginswp.com">... more in PLUGINSWP.com</a><br/><br/>
              
                
<?php
	}
}





add_action( 'widgets_init', create_function('', 'return register_widget("wp_carousel_videowg");') );
add_action('wp_head', 'carousel_video_head');
add_filter('the_content', 'carousel_video');
add_action('activate_carousel_video/ultimate_carouselfree_video.php','carousel_video_instala');
add_action('deactivate_carousel_video/ultimate_carouselfree_video.php', 'carousel_video_desinstala');
?>