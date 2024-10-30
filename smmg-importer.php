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
switch($activetab){
	case "list":
	include 'importer/list.php';
	break;	

	default:
	include 'importer/list.php';
	break;
}
?>