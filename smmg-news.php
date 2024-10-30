<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<style>
@media (min-width: 1280px){
	.form-wrap{
		width: 28%; 
		float: left; 
		border: 2px solid #e1e1e1; 
		margin: 10px; 
		padding: 15px; 
		border-radius: 10px;
	}	
}
@media (max-width: 1279px){
	.form-wrap{
		width: 90%; 
		float: left; 
		border: 2px solid #e1e1e1; 
		margin: 3px; 
		padding: 3px; 
		border-radius: 10px;
	}	
}
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$result = smmg_getNews();
$result = json_decode($result);
foreach($result as $news){
	$title   = $news->title;
	$content = $news->content;
?>
	<h1 style="border-bottom: 1px dashed #333; padding-bottom: 10px; width: auto;">&middot; <?php echo $title; ?></h1>
	<p style="padding-left: 20px;"><?php echo $content; ?></p>
	<hr style="border-bottom: 2px solid #cecece;" />
<?php
}
?>