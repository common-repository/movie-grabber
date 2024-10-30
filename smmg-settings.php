<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<style>
.small{
	width: 150px;
}
.medium{
	width: 250px;
}
.large{
	width: 400px;
}
.smalldesc{
	font-size: 10px;
}
</style>
<?php
switch($activetab){
	case "general":
	include 'admin/general.php';
	break;

	default:
	include 'admin/general.php';
	break;
}
?>