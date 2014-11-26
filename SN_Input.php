<!DOCTYPE HTML>
<HTML>
<HEAD>
<STYLE>
	.err {color: #FF0000;}
	h1 { text-align: center; }
</STYLE>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

</HEAD>
<BODY>
 

<?php 
	include "SN_Controller.php";
	
	$longURL_error = "";
	$longURL = "";
	
	
	// Don't run this code on initial display, only when attempting to submit
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$longURL = normalize_data($_POST["longURL"]);
		
		if (empty($longURL))
			$longURL_error = "Long URL is required.<br>";
		else if(!filter_var($longURL, FILTER_VALIDATE_URL))
			$longURL_error .= "Long URL is not valid.<br>";
		else {
			// Success - submit the data
			process_insert($longURL);
		}
	}
	
	// Trim white space and encode special chars to avoid XSS
	function normalize_data($data) {
		$data = trim($data);
		$data = htmlspecialchars($data);
		
		return $data;
	}

?>

<div class="container">
    <div class="page-header">
		<h1>Create a ShortLink</h1>
	</div>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	
	
	<table class="table">
 	   	<tbody>
    	   	<tr>
        	   	<td><p class="text-right"><span class="label label-primary">Long URL:</span></p></td>
               	<td><input type="text" name="longURL" size="35" value="<?php echo htmlspecialchars($longURL);?>"></td>
               	<td><span class="err"><?php echo $longURL_error;?></span></td>
           	</tr>
           	<tr>
           		<td></td>
           		<td><input type="submit" value="Submit"></td>
           		<td></td>
           	</tr>
		</tbody>
	</table>
 	
    
</form>

</BODY>
</HTML>


