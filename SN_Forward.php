<?php 

include "SN_Controller.php";

/**
 * Script to redirect the browser to the actual URL represented by the Short Link
 */

// Grab the short code
$short = $_GET['short'];

// Convert to the long URL
$long = getForwardLink($short);

// Redirect to the link location
header("Location: " . $long);


?>