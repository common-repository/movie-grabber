<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;

$home  = explode('/', home_url());
$urli  = str_replace('www.', '', $home[2]);
$getc  = smmg_getCategories();
$getc  = json_decode($getc);
$categories = array();
$listvideos = array();
foreach($getc as $cat){
	$categories[$cat->catID] = $cat->catname;
}

?>
<form method="post" action="" novalidate="novalidate">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label>Select Category & Page</label>
			</th>
			<td>
				<select name="category" class="medium">
					<?php echo smmg_makeDropDown($categories, sanitize_text_field($_POST['category'])); ?>
				</select>					
				&middot; <strong>Page:</strong> <input type="text" name="page" class="small" value="<?php if(sanitize_text_field($_POST['page']) == ""){ echo "1"; } else{ echo sanitize_text_field($_POST['page']); } ?>" />		
                <?php
                wp_nonce_field('smmg_get_videos', 'smmg_get_videos_submit');
                ?>                
				<input type="submit" name="submit" id="submit" class="button button-primary" value="Get Videos" />
				<input type="hidden" name="getvideos" value="1" />
			</td>
		</tr>
	</table>
</form>
<hr />
<?php
$user = wp_get_current_user();
$allowed_roles = array('editor', 'administrator');
if( array_intersect($allowed_roles, $user->roles ) ) {

if(sanitize_text_field($_POST['addvideo']) == 1 && check_admin_referer( 'smmg_add_video', 'smmg_add_video_submit' )){
	include "save-video.php";
}
if(sanitize_text_field($_POST['getvideos']) == 1 && check_admin_referer( 'smmg_get_videos', 'smmg_get_videos_submit' )){
	$zlmxsdir = plugins_url() . '/'. plugin_basename(plugin_dir_path( __FILE__ ));
	$category = sanitize_text_field($_POST['category']);
	$page	  = sanitize_text_field($_POST['page']);
	$getvideo = smmg_getVideos($category, $page);
	$getvideo = json_decode($getvideo, true);
	foreach($getvideo as $mov){
		$title 		= $mov[0]['title'];
		$image 		= "https://www.streamov.xyz/" . $mov[0]['poster'];
		$duration 	= $mov[0]['duration'];
		$director	= $mov[0]['director'];
		$writer		= $mov[0]['writer'];
		$stars		= $mov[0]['stars'];
		$summary	= strip_tags($mov[0]['summary']);
		$rating		= $mov[0]['rating'];
		$genre		= $mov[0]['genre'];
		$country    = $mov[0]['country'];
		$videoid  	= $mov[0]['fileID'];
		$oloadid    = $mov[0]['openload'];
		$mangoid    = $mov[0]['streamango'];
		$openload	= smmg_base64urlencode("openload|$videoid|$urli");
		$streamango = smmg_base64urlencode("streamango|$videoid|$urli");
		$embedoload = SMMG_PLAY_URL . "?movie=$openload";
		$embedmango = SMMG_PLAY_URL . "?movie=$streamango";
	?>
		<div class="form-wrap">
		<form id="addmovie" method="post" action="" class="validate">
		<div class="form-field form-required term-poster-wrap" style="float: left;">
		<pre>Press and hold CTRL to make multiple selections</pre>
			<span style="width: 30%; float: left">
				<label for="tag-poster"><img style="width: 100%;" src="<?php echo $image; ?>" /></label>
			</span>
			<span style="width: 65%; float: left; margin-left: 8px;">
				<select name="yourcat" style="width: 100%;" multiple="multiple">
				<?php smmg_multipleCat(); ?>
			</select>
			<input type="hidden" name="image" value="<?php echo $image; ?>" />
			<input type="hidden" name="oloadid" value="<?php echo $oloadid; ?>" />
			<input type="hidden" name="mangoid" value="<?php echo $mangoid; ?>" />
			<input type="hidden" name="embedoload" value="<?php echo $embedoload; ?>" />
			<input type="hidden" name="embedmango" value="<?php echo $embedmango; ?>" />
			<input type="hidden" name="rating" value="<?php echo $rating; ?>" />
			<input type="hidden" name="fileID" value="<?php echo $videoid; ?>" />
			<input type="hidden" name="addvideo" value="1" />
			</span>
		</div>
		<div class="form-field form-required term-name-wrap">
			<label for="tag-title" style="font-weight: bold;">&middot; Post Status</label>
			<select name="status">
				<option value="publish">Publish</option>
				<option value="draft">Draft</option>
			</select>
		</div>
		<div class="form-field form-required term-name-wrap">
			<label for="tag-title" style="font-weight: bold;">&middot; Title ( imDB Rating: <?php echo $rating; ?> )</label>
			<input name="title" id="tag-title" type="text" value="<?php echo $title; ?>" size="50" aria-required="true" />
		</div>
		<div class="form-field term-slug-wrap">
			<label for="tag-description" style="font-weight: bold;">&middot; Description</label>
			<input name="description" id="tag-description" type="text" value="" placeholder="meta description" size="50" />
		</div>
		<div class="form-field term-slug-wrap">
			<label for="tag-duration" style="font-weight: bold;">&middot; Duration</label>
			<input name="duration" id="tag-duration" type="text" value="<?php echo $duration; ?>" size="50" />
		</div>
		<div class="form-field term-slug-wrap">
			<label for="tag-tags" style="font-weight: bold;">&middot; Tags</label>
			<input name="tags" id="tag-tags" type="text" value="" placeholder="meta keywords and wordpress tags" size="50" />
		</div>
		<div class="form-field term-slug-wrap">
			<label for="tag-director" style="font-weight: bold;">&middot; Director</label>
			<input name="director" id="tag-director" type="text" value="<?php echo $director; ?>" size="50" />
		</div>
		<div class="form-field term-slug-wrap">
			<label for="tag-writer" style="font-weight: bold;">&middot; Writer</label>
			<input name="writer" id="tag-writer" type="text" value="<?php echo $writer; ?>" size="50" />
		</div>
		<div class="form-field term-slug-wrap">
			<label for="tag-stars" style="font-weight: bold;">&middot; Stars</label>
			<input name="stars" id="tag-stars" type="text" value="<?php echo $stars; ?>" size="50" />
		</div>
		<div class="form-field term-slug-wrap">
			<label for="tag-genre" style="font-weight: bold;">&middot; Genre</label>
			<input name="genre" id="tag-genre" type="text" value="<?php echo $genre; ?>" size="50" />
		</div>
		<div class="form-field term-slug-wrap">
			<label for="tag-country" style="font-weight: bold;">&middot; Country</label>
			<input name="country" id="tag-country" type="text" value="<?php echo $country; ?>" size="50" />
		</div>
		<div class="form-field term-description-wrap">
			<label for="tag-summary" style="font-weight: bold;">&middot; Summary</label>
			<textarea name="summary" id="tag-summary" rows="5" cols="40"><?php echo $summary; ?></textarea>
		</div>
        <?php
        wp_nonce_field('smmg_add_video', 'smmg_add_video_submit');
        ?>     
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Add New Movie" /></p>
		</form>
		</div>
		<!-- /col-left -->
<?php
	}
}
}
?>