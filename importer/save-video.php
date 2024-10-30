<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if($_POST['addvideo'] == 1 && check_admin_referer( 'smmg_add_video', 'smmg_add_video_submit' )){

	// add post array	
	$mypost = array();
	$uppost = array();

	// custom fields
	$iframeWidthCustomField  	= get_option("smmg_iframeWidth");
	$iframeHeightCustomField 	= get_option("smmg_iframeHeight");
	$descriptionCustomField 	= get_option("smmg_descriptionCustomField");
	$thumbnailCustomField		= get_option("smmg_thumbnailCustomField");
	$durationCustomField 		= get_option("smmg_durationCustomField");
	$directorCustomField 		= get_option("smmg_directorCustomField");
	$writerCustomField 		    = get_option("smmg_writerCustomField");
	$starsCustomField 			= get_option("smmg_starsCustomField");
	$ratingCustomField 		    = get_option("smmg_ratingCustomField");
	$genreCustomField 			= get_option("smmg_genreCustomField");
	$countryCustomField 		= get_option("smmg_countryCustomField");
	$nextpageCustomField    	= get_option("smmg_nextpageCustomField");

	// post values	
	$title 		 = sanitize_text_field($_POST['title']);
	$description = sanitize_text_field($_POST['description']);
	$duration 	 = sanitize_text_field($_POST['duration']);
	$tags		 = sanitize_text_field($_POST['tags']);
	$director    = sanitize_text_field($_POST['director']);
	$writer      = sanitize_text_field($_POST['writer']);
	$stars       = sanitize_text_field($_POST['stars']);
	$genre       = sanitize_text_field($_POST['genre']);
	$country     = sanitize_text_field($_POST['country']);
	$rating      = sanitize_text_field($_POST['rating']);
	$summary     = sanitize_text_field($_POST['summary']);
	$embedoload  = sanitize_text_field($_POST['embedoload']);
	$embedmango  = sanitize_text_field($_POST['embedmango']);
	$image		 = sanitize_text_field($_POST['image']);	
	$category    = sanitize_text_field($_POST['yourcat']);	
	$poststatus  = sanitize_text_field($_POST['status']);
	$fileID		 = sanitize_text_field($_POST['fileID']);
	$oloadid	 = sanitize_text_field($_POST['oloadid']);
	$mangoid	 = sanitize_text_field($_POST['mangoid']);
	
	$iframeoload  = '<iframe src="' . $embedoload . '" width="' . $iframeWidth . '" height="' . $iframeHeight . '" scrolling="no" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>';
	$iframemango  = '<iframe src="' . $embedmango . '" width="' . $iframeWidth . '" height="' . $iframeHeight . '" scrolling="no" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>';
	
	if($oloadid != '' AND $mangoid != ''){
		$content = $summary . '<!--more-->' . $iframeoload . $nextpage . $iframemango;
	}
	elseif($oloadid != '' AND $mangoid == ''){
		$content = $summary . '<!--more-->' . $iframeoload;
	}
	elseif($oloadid == '' AND $mangoid != ''){
		$content = $summary . '<!--more-->' . $iframemango;
	}
	
	$imgurl   = get_bloginfo('url')."/wp-content/uploads/" . $kon['subdir'] . "/$filename.$uz";

	// add post	
	$mypost['post_title'] 		= $title;
	$mypost['post_type'] 		= 'post';
	$mypost['post_status']		= $poststatus;
	$mypost['post_content']     = $content;;
	$mypost['post_category']	= $category;
	$mypost['tags_input']		= $tags;
	$mypost['post_author'] 		= 1;

	$postid = wp_insert_post($mypost);
	if($postid){
		smmg_apiInsert($urli, $fileID);

		add_post_meta($postid, $descriptionCustomField, $description);
		add_post_meta($postid, $durationCustomField, $duration);
		add_post_meta($postid, $directorCustomField, $director);
		add_post_meta($postid, $writerCustomField, $writer);
		add_post_meta($postid, $starsCustomField, $stars);
		add_post_meta($postid, $genreCustomField, $genre);
		add_post_meta($postid, $countryCustomField, $country);
		add_post_meta($postid, $ratingCustomField, $rating);
        add_post_meta($postid, $thumbnailCustomField, $imgurl);
		
        smmg_generate_featured_image($image, $postid, $title);
        echo '<div id="message" class="updated fade" style="color:green;"><p>Movie saved!</p></div>';        
	}
}
?>