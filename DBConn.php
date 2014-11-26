<?php


/**
 * Database interface class
 * 
 * Class to encapsulate all of the database-related funcctionality. 
 * 
 * @author Steven Burg
 *
 */
class DBConn {
	
	// MySQL hostname
	private $hostname = 'localhost';
	
	// MySQL username
	private $username = 'SNmaster';
	
	// MySQL password
	private $password = '';
	
	// MySQL database name
	private $dbname = 'shortnames';
	
	private $db;
	private $insertSQL = "INSERT INTO SN_Lookup (long_url) VALUES (?)";
	private $selectSQL = "SELECT long_url, created, count FROM SN_Lookup WHERE id = ?";
	private $getForwardSQL = "SELECT long_url FROM SN_Lookup WHERE id = ?";
	private $updateCounterSQL = "UPDATE SN_Lookup SET count = count + 1 WHERE id = ?";
	private $existsSQL = "SELECT ID FROM SN_Lookup WHERE long_url = ?";
	private $insertStatement;
	private $selectStatement;
	private $getForwardStatement;
	private $updateCounterStatement;
	private $existsStatement;
	
	public function __construct() {
		$this->connect();
	}
	
	public function __destruct() {
		$this->disconnect();
	}
	
	public function connect() {
		
		$this->db = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
		
		if ($this->db->connect_errno > 0) {
			die('Unable to connect to database [' . $this->db->connect_error . ']');
		}
		
		// Create the prepared statements
		$this->insertStatement = $this->db->prepare($this->insertSQL);
		$this->selectStatement = $this->db->prepare($this->selectSQL);
		$this->getForwardStatement = $this->db->prepare($this->getForwardSQL);
		$this->updateCounterStatement = $this->db->prepare($this->updateCounterSQL);
		$this->existsStatement = $this->db->prepare($this->existsSQL);
		
	}
	
	public function disconnect() {
		$this->db->close();
	}
	
	// Insert the long URL and return the new auto-generated ID
	public function initialInsert($long) {
		// Check if the record already exists
		$id = $this->exists($long);
		if ($id > -1)
			return $id;

		// Bind parameters
		$this->insertStatement->bind_param('s', $long);
			
		// Execute
		if (!$this->insertStatement->execute()) {
			echo "Execute failed: (" . $this->insertStatement->errno . ") " . $this->insertStatement->error;
		}
		
		return $this->insertStatement->insert_id;
	}
	
	// Fills the given SN_Info object with the record values for a given ID - if the record does not exist, or there is a problem, returns false - otherwise true
	public function select($id, SN_Info &$obj) {
		// Bind parameters
		$this->selectStatement->bind_param('i', $id);
		
		// Execute
		if (!$this->selectStatement->execute()) {
			echo "Execute failed: (" . $this->selectStatement->errno . ") " . $this->selectStatement->error;
			$this->selectStatement->free_result();
			return false;
		}
				
		// Retrieve results
		$this->selectStatement->store_result();
		
		// Check for a result
		if ($this->selectStatement->num_rows <= 0) {
			$this->selectStatement->free_result();
			return false;
		}

		$this->selectStatement->bind_result($long, $created, $count);
		$this->selectStatement->fetch();
		
		$obj->set_longURL($long);
		$obj->set_created($created);
		$obj->set_count($count);
		
		$this->selectStatement->free_result();
		
		return true;
	}
	
	// Given an ID, return the long URL and increment the counter
	public function getForwardLink($id) {
		$this->getForwardStatement->bind_param('i', $id);
		
		// Execute
		if (!$this->getForwardStatement->execute()) {
			echo "Execute failed: (" . $this->getForwardStatement->errno . ") " . $this->getForwardStatement->error;
			$this->getForwardStatement->free_result();
			return "";
		}
		
		// Retrieve results
		$this->getForwardStatement->store_result();
		
		// Check for a result
		if ($this->getForwardStatement->num_rows <= 0) {
			$this->getForwardStatement->free_result();
			return "";
		}
		
		$this->getForwardStatement->bind_result($long);
		$this->getForwardStatement->fetch();
		$this->getForwardStatement->free_result();
		
		// Update the counter
		$this->updateCounterStatement->bind_param('i', $id);

		// Execute
		if (!$this->updateCounterStatement->execute()) {
			echo "Execute failed: (" . $this->updateCounterStatement->errno . ") " . $this->updateCounterStatement->error;
			$this->updateCounterStatement->free_result();
			return "";
		}
		
		$this->updateCounterStatement->free_result();
		
		return $long;
	}
	
	// Check if the long URL already exists in the DB - if so, return its ID - otherwise, returns -1
	protected function exists($longURL) {
		// Bind parameters
		$this->existsStatement->bind_param('s', $longURL);
		
		// Execute
		if (!$this->existsStatement->execute()) {
			echo "Execute failed: (" . $this->existsStatement->errno . ") " . $this->existsStatement->error;
		}
		
		$this->existsStatement->store_result();
		
		if ($this->existsStatement->num_rows <= 0) {
			$this->existsStatement->free_result();
			return -1;
		}
		
		$this->existsStatement->bind_result($id);
		$this->existsStatement->fetch();
		$this->existsStatement->free_result();
		
		return $id;
	}
	
}









?>