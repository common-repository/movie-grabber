<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<h1>General & Custom Field Settings</h1>
<?php
if ( ! empty( $_POST ) && check_admin_referer( 'smmg_general_settings', 'smmg_general_settings_submit' ) ) {
	update_option('smmg_iframeWidth', 			    sanitize_text_field($_POST['smmg_iframeWidth']));
	update_option('smmg_iframeHeight', 			    sanitize_text_field($_POST['smmg_iframeHeight']));
	update_option('smmg_descriptionCustomField',    sanitize_text_field($_POST['smmg_descriptionCustomField']));
	update_option('smmg_thumbnailCustomField', 	    sanitize_text_field($_POST['smmg_thumbnailCustomField']));
	update_option('smmg_durationCustomField', 	    sanitize_text_field($_POST['smmg_durationCustomField']));
	update_option('smmg_directorCustomField', 	    sanitize_text_field($_POST['smmg_directorCustomField']));
	update_option('smmg_writerCustomField', 		sanitize_text_field($_POST['smmg_writerCustomField']));
	update_option('smmg_starsCustomField', 		    sanitize_text_field($_POST['smmg_starsCustomField']));
	update_option('smmg_ratingCustomField', 		sanitize_text_field($_POST['smmg_ratingCustomField']));
	update_option('smmg_genreCustomField', 		    sanitize_text_field($_POST['smmg_genreCustomField']));
	update_option('smmg_countryCustomField', 	    sanitize_text_field($_POST['smmg_countryCustomField']));
	update_option('smmg_nextpageCustomField', 	    sanitize_text_field($_POST['smmg_nextpageCustomField']));

	echo '<div id="message" class="updated fade" style="color:green;"><p>Options saved!</p></div>';

}

$iframeWidth  	= get_option("smmg_iframeWidth");
$iframeHeight 	= get_option("smmg_iframeHeight");
$description 	= get_option("smmg_descriptionCustomField");
$thumbnail		= get_option("smmg_thumbnailCustomField");
$duration 		= get_option("smmg_durationCustomField");
$director 		= get_option("smmg_directorCustomField");
$writer 		= get_option("smmg_writerCustomField");
$stars 			= get_option("smmg_starsCustomField");
$rating 		= get_option("smmg_ratingCustomField");
$genre 			= get_option("smmg_genreCustomField");
$country 		= get_option("smmg_countryCustomField");
$nextpage    	= get_option("smmg_nextpageCustomField");
?>
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
			<tr>
				<th scope="row">
					<label>Iframe Size</label>
				</th>
				<td>
                    <input name="smmg_iframeWidth" value="<?php echo $iframeWidth; ?>" class="small" /> width <input name="smmg_iframeHeight" value="<?php echo $iframeHeight; ?>" class="small" /> height
					<p class="smalldesc">Iframe width and height values (% or px)</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Nextpage Tag</label>
				</th>
				<td>
                    <input name="smmg_nextpageCustomField" value="<?php echo $nextpage; ?>" class="medium" />
					<p class="smalldesc">You can enter the label you use to move to the next page in the post</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Description</label>
				</th>
				<td>
                    <input name="smmg_descriptionCustomField" value="<?php echo $description; ?>" class="medium" />
					<p class="smalldesc">If you have custom field for video description, please enter. (all in one seo, yoast etc.)</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Thumbnail</label>
				</th>
				<td>
                    <input name="smmg_thumbnailCustomField" value="<?php echo $thumbnail; ?>" class="medium" />
					<p class="smalldesc">If you have custom field for video thumbnail, please enter.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Duration</label>
				</th>
				<td>
                    <input name="smmg_durationCustomField" value="<?php echo $duration; ?>" class="medium" />
					<p class="smalldesc">If you have custom field for video duration, please enter.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Director</label>
				</th>
				<td>
                    <input name="smmg_directorCustomField" value="<?php echo $director; ?>" class="medium" />
					<p class="smalldesc">If you have custom field for director, please enter.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Writer</label>
				</th>
				<td>
                    <input name="smmg_writerCustomField" value="<?php echo $writer; ?>" class="medium" />
					<p class="smalldesc">If you have custom field for writer, please enter.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Stars</label>
				</th>
				<td>
                    <input name="smmg_starsCustomField" value="<?php echo $stars; ?>" class="medium" />
					<p class="smalldesc">If you have custom field for stars, please enter.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Genre</label>
				</th>
				<td>
                    <input name="smmg_genreCustomField" value="<?php echo $genre; ?>" class="medium" />
					<p class="smalldesc">If you have custom field for genre, please enter.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Country</label>
				</th>
				<td>
                    <input name="smmg_countryCustomField" value="<?php echo $country; ?>" class="medium" />
					<p class="smalldesc">If you have custom field for country, please enter.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Rating (imDB)</label>
				</th>
				<td>
                    <input name="smmg_ratingCustomField" value="<?php echo $rating; ?>" class="medium" />
					<p class="smalldesc">If you have custom field for rating, please enter.</p>
				</td>
			</tr>
        </table>
        <p class="submit">
        <?php
        wp_nonce_field('smmg_general_settings', 'smmg_general_settings_submit');
        ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes" />
        </p>
    </form>
