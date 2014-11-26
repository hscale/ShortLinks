<?php 

require_once('DBConn.php');

/**
 * Short link and URL functionality
 * 
 * 'Static' class to encapsulate the encoding/decoding of Short Links as well as other 
 * related functionality.
 * 
 * @author sburg
 *
 */
class ShortLink {

	// Receives a Base10 integer and returns its Base36 representation
	public static function createShortName($longURL) {
		// Create a database connectivity object
		$dbconn = new DBConn();
		
		// Create the database record and retrieve the id
		$id = $dbconn->initialInsert($longURL);
		
		return base_convert($id, 10, 36);
	}
	
	// Receives a Base36 string and returns its Base10 representation
	public static function decodeShortName($short) {
		return base_convert($short, 36, 10);
	}
	
	// Given a short name, returns a class object containing all other pertinent info
	public static function getShortNameInfo($short) {
		// Create a database connectivity object
		$dbconn = new DBConn();	
		
		$sn = new SN_Info();
		$sn->set_shortName($short);
		
		// Get the ID from the short name
		$id = ShortLink::decodeShortName($short);
		
		// Retrieve the rest of the info from the database
		$dbconn->select($id, $sn);
		
		return $sn;		
	}
	
	public static function getForwardLink($id) {
		// Create a database connectivity object
		$dbconn = new DBConn();
		
		$long = $dbconn->getForwardLink($id);
		
		return $long;
	}
}



?>