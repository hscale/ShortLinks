<!DOCTYPE HTML>
<HTML>
<HEAD>
	<style>
		.label {
		    color:#538b01; 
		    font-weight:bold; 
		}
		.data {
			color:#000000;
		    font-weight: normal;
		}
	</style>
</HEAD>
<BODY>


<?php 
include "SN_Controller.php";

$url = $_SERVER['REQUEST_URI'];
$tokens = explode('/', $url);

$short = $tokens[sizeof($tokens)-1];


// Grab the information from the DB
$sn_info = retrieve_info($short);


?>

<span class="label">Long URL:</span> <span class='data'><?php echo($sn_info->get_longURL()); ?> </span><br>
<span class="label">Short URL:</span> <span class='data'><?php echo($short); ?> </span><br>
<span class='label'>Record created:</span> <span class='data'><?php echo($sn_info->get_created()); ?> </span><br>
<span class='label'>Number of redirects:</span> <span class='data'><?php echo($sn_info->get_count()); ?> </span><br>




</BODY>
</HTML>
