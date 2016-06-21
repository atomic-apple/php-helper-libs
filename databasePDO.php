<?php

/*
*	Copyright 2016 Atomic-Apple.com.  All rights reserved.
*/

// This script DEPENDS upon the use of a custom errorhandler as atomicErrors() from the functions.php
// script, set with the set_error_handler() BIF at the end of init.inc.php script, and called with the
// trigger_error() BIF.  This is a drop in replacement for the 'die()' BIF normally used.

// It also requires the 'configFile.inc.php' for CONSTANTS used to log-in to the Database server.
include_once('configFile.inc.php');

class Database {

	public $connection;

	function __construct() {
		$this->openDBConnection();
	}

	public function openDBConnection() {
		// Method attempts to open a PDO database instance, using the driver and log-in details
		// supplied in the included 'configFile.inc.php'
		try {
			$this->connection = new PDO( PDODRIVER, PDOUSER, PDOPASS );
		} catch( PDOException $e ) {
			trigger_error( "<br />DATABASE:: openDBConnection=> Error:<br />" . $e );
		}

	}

	public function dbQuery( $sql ) {
		// Method PDO::prepares the $sql for query'ing of the database, executes it, handles any PDO::errors
		// and returns an associative array of the result of the query.
		$stmt = $this->connection->prepare( $sql );
		// var_dump( $stmt ) . "<br />";
		try {
			$stmt->execute();
			// var_dump( $result );
			if( $stmt ) {
				$result = $stmt->fetchAll( PDO::FETCH_ASSOC );
			}
		} catch ( PDOException $e ) {
			trigger_error( "QUERY FAILURE:: PDO::errorinfo():<br />" . $this->connection->errorInfo() );
		}

		return $result;
	}


	public function escapeString( $string ) {
		// Method escapes $string by 'quoting' and the insertion of escape chars in the string
		// before returning.  This is to minimise the chances of SQL injection attacks
		$newStr = $this->connection->quote( $string );
		return $newStr;
	}

	public function theInsertID() {
		// Method returns the insertid of the last inserted item, so that the calling class can
		// use this information to set the $indexval (AppObject in particular)
		return $this->connection->lastInsertId();
	}

}

$database = new Database();

?>
