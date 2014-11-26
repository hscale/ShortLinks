<?php 

require_once('ShortLink.php');



/**
 * Short Link information passing class
 * 
 * Class used to pass Short Link details between functions, script and classes.  
 * 
 * @author sburg
 *
 */
class SN_Info {
	private $longURL;
	private $shortName;
	private $count;
	private $created;
	private $id;

	public function get_longURL() { return $this->longURL;	}
	public function get_shortName() { return $this->shortName;	}
	public function get_count() { return $this->count;	}
	public function get_created() { return $this->created;	}

	public function set_longURL($in) {	$this->longURL = $in; }
	public function set_shortName($in) { $this->shortName = $in; }
	public function set_count($in) { $this->count = $in; }
	public function set_created($in) { $this->created = $in; }
}


// Insert a new record and return the short code - or simply return the short code if the record already exists
function process_insert($longURL) {
	// Get the short name and create database record if necessary
	$short = ShortLink::createShortName($longURL);

	// Redirect to the view page for this short code
	header("Location: /view/" . $short);
}


// Given a short code, return a SN_Info object filled with the the info from the DB record
function retrieve_info($short) {
	// Retrieve the database record
	$sn_info = ShortLink::getShortNameInfo($short);
	
	return $sn_info;
}


// Given a short code, return the long URL (and increment the counter)
function getForwardLink($short) {
	// Decode the short name to get the ID	
	$id = ShortLink::decodeShortName($short);
	
	// Get the long URL
	$long = ShortLink::getForwardLink($id);
	
	return $long;	
}




	
	




?>