<?php
/*
	* Plugin Name: Movie Grabber
	* Plugin URI: http://www.streamov.xyz
	* Description: Grab thousands of movies.
	* Version: 1.0
	* Author: Streamov.xyz
	* License: MIT
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('SMMG_API_URL', 'https://www.streamov.xyz/api.php');
define('SMMG_PLAY_URL', 'https://www.streamov.xyz/play.php');

global $wpdb;
$home  = explode('/', home_url());
$urli  = str_replace('www.', '', $home[2]);

function smmg_cleanText($text){  
    $text = preg_replace("'<script[^>]*>.*?</script>'si", '', $text);  
    $text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)',$text);  
    $text = preg_replace('/<!--.+?-->/', '', $text);  
    $text = preg_replace('/{.+?}/', '', $text);  
    $text = preg_replace('/&nbsp;/', ' ', $text);  
    $text = preg_replace('/&amp;/', ' ', $text);  
    $text = preg_replace('/&quot;/', ' ', $text);
	$text = preg_replace("#\((.*?)\)#", '', $text);
	$text = strip_tags($text, '<strong><em><i><b><p>');  
    return $text;  
}

function smmg_splitData($ilk, $son, $nerde){
	$x = explode($ilk, $nerde);
	$x = explode($son, $x[1]);
	return trim($x[0]); 
}

function smmg_replaceSpace($string){
   $string = preg_replace("/\s+/", " ", $string);
   $string = trim($string);
   return $string;
}

function smmg_base64urlencode($s) {
    return str_replace(array('+', '/'), array('-', '_'), base64_encode($s));
}

function smmg_getCategories(){

	global $wp_version;
	global $wpdb;
	$home  = explode('/', home_url());
	$urli  = str_replace('www.', '', $home[2]);
	$response = wp_remote_get(SMMG_API_URL."?select=category", array( 'timeout' => 120, 'httpversion' => '1.1' ) );
	$content  = $response['body'];
	return $content;
}

function smmg_getVideos($category, $page){

	global $wp_version;
	global $wpdb;
	$home  = explode('/', home_url());
	$urli  = str_replace('www.', '', $home[2]);
	$response = wp_remote_get(SMMG_API_URL."?select=movie&category=$category&domain=$urli&page=$page", array( 'timeout' => 120, 'httpversion' => '1.1' ) );
	$content  = $response['body'];
	return $content;
}

function smmg_getNews(){

	global $wp_version;
	global $wpdb;
	$home  = explode('/', home_url());
	$urli  = str_replace('www.', '', $home[2]);
	$response = wp_remote_get(SMMG_API_URL."?select=news", array( 'timeout' => 120, 'httpversion' => '1.1' ) );
	$content  = $response['body'];
	return $content;
}

function smmg_apiInsert($urli, $value){

	global $wp_version;
	global $wpdb;
	$home  = explode('/', home_url());
	$urli  = str_replace('www.', '', $home[2]);
	$response = wp_remote_get(SMMG_API_URL."?select=domain&domain=$urli&value=$value", array( 'timeout' => 120, 'httpversion' => '1.1' ) );
	$content  = $response['body'];
	return $content;
}
 

register_activation_hook(__FILE__, 'install_smmg');

function install_smmg(){
	// iframe settings
	
	add_option("smmg_iframeWidth", "100%");
	add_option("smmg_iframeHeight", "400px");
	add_option("smmg_descriptionCustomField", "description");
	add_option("smmg_thumbnailCustomField", "thumbnail");
	add_option("smmg_durationCustomField", "duration");
	add_option("smmg_directorCustomField", "director");
	add_option("smmg_writerCustomField", "writer");
	add_option("smmg_starsCustomField", "stars");
	add_option("smmg_ratingCustomField", "rating");
	add_option("smmg_genreCustomField", "genre");
	add_option("smmg_countryCustomField", "country");
	add_option("smmg_nextpageCustomField", "<!--nextpage-->");
	
	smmg_apiInsert($urli, 2147483647);
	
}

add_action('admin_menu', 'add_smmg_menus');
function add_smmg_menus(){
	add_menu_page('Movie Grabber', 'Movie Grabber', 'manage_options', 'smmg_news', 'smmg_news');
	add_submenu_page('smmg_news', 'News', 'News', 'manage_options', 'smmg_news', 'smmg_news');
	add_submenu_page('smmg_news', 'Importer', 'Importer', 'manage_options', 'smmg_importer', 'smmg_importer');
	add_submenu_page('smmg_news', 'Settings', 'Settings', 'manage_options', 'smmg_settings', 'smmg_settings');
	add_submenu_page('smmg_news', 'Feedback', 'Feedback', 'manage_options', 'smmg_feedback', 'smmg_feedback');
}

function smmg_settings(){ 
	include "smmg-settings.php"; 
}

function smmg_importer(){
	include "smmg-importer.php";
}

function smmg_news(){ 
	include "smmg-news.php"; 
}

function smmg_feedback(){ 
	include "smmg-feedback.php"; 
}

function smmg_makedropdown($options, $selected) {
	$output = "";
	foreach($options as $value => $description ) {
		$output .= "<option value=\"$value\"";
		if( $selected == $value ) {
			$output .= " selected ";
		}
		$output .= ">$description</option>\n";
	}
	return $output;
}

function smmg_findExt($param){
	$array = explode('/', $param);
	$count = count($array) -1;
	$exten = $array[$count];				 
	return $exten;
}

function smmg_getSlug($string){
	$string = preg_replace("'<[\/\!]*?[^<>]*?>'si", "", $string);
    $turkce = array('ı', 'ö', 'ü', 'ğ', 'ş', 'ç', 'İ', 'Ö', 'Ü', 'Ğ', 'Ş', 'Ç', '.', '  ', ' ');
    $digeri = array('i', 'o', 'u', 'g', 's', 'c', 'i', 'O', 'U', 'G', 'S', 'C', '-', '-', '-');
    $string = str_replace($turkce, $digeri, $string);
	$string = str_replace('--', '-', $string);
	$string = strtolower($string);
	$string = ereg_replace("[^A-Za-z0-9-]", "", $string);
	if(substr($string, strlen($string)-2, strlen($string)) == '--')
	{
		$string = substr($string, 0, strlen-2);
	}
	if(substr($string, strlen($string)-1, strlen($string)) == '-')
	{
		$string = substr($string, 0, strlen-1);
	}
	if(substr($string,0,2)=='--')
	{
		$string = substr($string, 2, strlen($string));
	}
	if(substr($string, 0, 1) == '-')
	{
		$string = substr($string, 1, strlen($string));
	}
	$a = array('--');
    $b = array('-');
    $string = str_replace($a, $b, $string);
    
    return $string;
}

function smmg_getImage($resimlinki, $resimadi){
	$uzanti  = smmg_findExt(trim($resimlinki));
	$content = wp_remote_retrieve_body(wp_remote_get($resimlinki, array( 'timeout' => 120, 'httpversion' => '1.1' )));
	$handle = fopen(ABSPATH . 'wp-content/uploads/' . smmg_getSlug(trim($resimadi)).'.'.$uzanti, 'wb');
	fwrite($handle, $content);
    fclose($handle);
}

function smmg_generate_featured_image( $file, $post_id, $desc ){
    // Set variables for storage, fix file filename for query strings.
    preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
    if ( ! $matches ) {
         return new WP_Error( 'image_sideload_failed', __( 'Invalid image URL' ) );
    }

    $file_array = array();
    $file_array['name'] = basename( $matches[0] );

    // Download file to temp location.
    $file_array['tmp_name'] = download_url( $file );

    // If error storing temporarily, return the error.
    if ( is_wp_error( $file_array['tmp_name'] ) ) {
        return $file_array['tmp_name'];
    }

    // Do the validation and storage stuff.
    $id = media_handle_sideload( $file_array, $post_id, $desc );

    // If error storing permanently, unlink.
    if ( is_wp_error( $id ) ) {
        @unlink( $file_array['tmp_name'] );
        return $id;
    }
    return set_post_thumbnail( $post_id, $id );

}

function smmg_multipleCat(){
	global $wpdb; 
	$sorgu = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "terms WHERE term_id IN (SELECT term_id FROM ". $wpdb->prefix . "term_taxonomy WHERE taxonomy = 'category') ORDER BY name"); 
	foreach($sorgu as $veri){
		echo '<option value="' . $veri->term_id . '">' . $veri->name . '</option>';
	}
}
?>