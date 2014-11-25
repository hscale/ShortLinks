<?php 

include "SN_Controller.php";


// Grab the short code
$short = $_GET['short'];

// Convert to the long URL
$long = getForwardLink($short);

// Redirect to the link location
header("Location: " . $long);


?>