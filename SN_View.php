<!DOCTYPE HTML>
<HTML>
<HEAD>

<STYLE>
	h1 { text-align: center; }
</STYLE>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	
</HEAD>
<BODY>


<?php 
	include "SN_Controller.php";
	include "phpqrcode.php";
	
	$url = $_SERVER['REQUEST_URI'];
	$tokens = explode('/', $url);
	
	$short = $tokens[sizeof($tokens)-1];
	$shortURL = "http://" . $_SERVER['HTTP_HOST'] . "//" . $short;
	
	// Grab the information from the DB
	$sn_info = retrieve_info($short);

?>

<div class="container">
    <div class="page-header">
		<h1>ShortLink Details</h1>
	</div>

	<table class="table">
 	   <tbody>
    	   <tr>
        	   <td><p class="text-right"><span class="label label-primary">Long URL:</span></p></td>
               <td><?php echo($sn_info->get_longURL()); ?></td>
           </tr>
    	   <tr>
        	   <td><p class="text-right"><span class="label label-primary">Short URL:</span></p></td>
               <td><?php echo($shortURL); ?></td>
           </tr>
	   	   <tr>
        	   <td><p class="text-right"><span class="label label-primary">Record created:</span></p></td>
               <td><?php echo($sn_info->get_created()); ?></td>
           </tr>
	   	   <tr>
        	   <td><p class="text-right"><span class="label label-primary">Number of redirects:</span></p></td>
               <td><?php echo($sn_info->get_count()); ?></td>
           </tr>
           </tbody>
    </table>

    
	<br>
    <img class="center-block" src="../qrcode.php?short=<?php echo($shortURL) ?>"  />
</div>
 
 
 	
</BODY>
</HTML>
