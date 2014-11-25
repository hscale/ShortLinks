<!DOCTYPE HTML>
<HTML>
<HEAD>
<STYLE>
	.err {color: #FF0000;}
</STYLE>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
 
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
	
	<div class="row">
        <div class="col-md-1"><p class="text-right">Long URL:</p></div>
        <div class="col-md-4"><input type="text" name="longURL" size="35" value="<?php echo htmlspecialchars($longURL);?>"></div>
        <div class="col-md-2"><span class="err"><?php echo $longURL_error;?></span></div>
    </div>
	<div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-4"><input type="submit" value="Submit"></div>
        <div class="col-md-2"></div>
    </div>
    
</form>

</BODY>
</HTML>


