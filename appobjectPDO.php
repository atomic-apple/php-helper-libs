<?php
/*
*	Copyright 2016 Atomic-Apple.com.  All rights reserved.
*/


class AppObject {
	
	// These three protected static $vars MUST be overidden by any inheriting/extending classes as
	// the $database method calls rely on them to query the database.

	protected static $dbTable = "";
	protected static $dbTableFields = array();
	protected static $dbIndex = "";	// dbTable Index name
	protected $dbIndexVal;	// dbTable Index value

	public static function findAll() {
		// Executes the query and returns a zero-indexed array of instances of the calling class
		$sql = "SELECT * FROM " . static::$dbTable;
		return static::findByQuery( $sql );
	}

	public static function findByID( $id ) {
		// Takes the $id and fetches the recordset and returns the found instance or FALSE is it
		// doesn't exist
		$sql = "SELECT * FROM " . static::$dbTable . " WHERE " . static::$dbIndex . " = " . $id . " LIMIT 1";
		$theResultArray = static::findByQuery( $sql );

		return !empty( $theResultArray ) ? array_shift( $theResultArray ) : false;
	}

	public static function findByQuery( $sql ) {
		// Fetch recordsets as Associative array and instatiante each record as an Instance of the
		// Calling Class.  $objectRef is the index of the associative Array returned from the dbQuery method
		// and has no use in the instantiation method.  We are after the array of data referred to by this
		// index which will be used to create the instance.

		// The returned, instantiated instances are then stacked in the $objectArray array() and returned to
		// the calling method, as a zero-indexed array.
		global $database;

		$resultSet = $database->dbQuery( $sql );
		$objectArray = array();

		foreach( $resultSet as $objectRef=>$objectData ){
			$objectArray[] = static::instantiation( $objectData );
		}

		return $objectArray;
	}

	public static function instantiation( $theRecord ) {
		// Recieves an associative array of instance data, creates the instance if the fields match the
		// class properties, and assigns the values to the matching properties.
		// Returns the instance.
		$callingClass = get_called_class();
		$theObject = new $callingClass;

		foreach ($theRecord as $theAttr => $value) {
			if( $theObject->hasTheAttr( $theAttr ) ) {
				$theObject->$theAttr = $value;
			}
		}

		return $theObject;
	}

	protected function hasTheAttr( $theAttr ) {
		// Boolean return if an array key matches an object property so that the instantiation method can assign
		// the appropriate value to it
		$objectProperties = get_object_vars( $this );

		return array_key_exists( $theAttr, $objectProperties );
	}

	protected function properties() {
		// Returns an associative array of class properties=>property values of an Instance.  Used
		// in the database CRUD methods of the AppObject.
		$properties = array();
		foreach( static::$dbTableFields as $dbField ) {
			if( property_exists( $this, $dbField ) ) {
				$properties[$dbField] = $this->dbField;
			}
		}

		return $properties;
	}

	protected function cleanProperties() {
		// Ensures that the $properties associative array is properly escaped prior to being inserted in
		// to the database table.  Used in the AppObject CRUD methods.
		global $database;

		$cleanProperties = array();
		foreach( $this->properties() as $key => $value ) {
			$cleanProperties[$key] = $database->escapeString( $value );
		}

		return $cleanProperties;
	}

	public function save() {
		// Tertiary check if the $dbIndex is set for the instance and selects update or create call to
		// the database table.
		return isset( $this->dbIndex) ? $this->update() : $this->create();
	}

	public function create() {
		// Creates a database entry for the instance in the absence of any matching record (Based on the
		// index value ONLY!).
		global $database;

		$properties = $this->cleanProperties();
		$sql = "INSERT INTO " . static::$dbTable . " (" . implode(",", array_keys( $properties ) ) . ")";
		$sql .= " VALUES (" . implode( "','", array_values( $properties ) ) . "')";

		if( $database->dbQuery( $sql ) ) {
			$this->indexVal = $database->theInsertID();
			return true;
		} else {
			return false;
		}
	}

	public function update() {
		// Method updates the datbase record of the instance, based on the $indexVal.
		global $database;

		$properties = $this->properties();
		$propPairs = array();

		foreach( $properties as $key => $value ) {
			$propPairs[] = "{$key} = '{$value}'";
		}

		$sql = "UPDATE " . static::$dbTable . " SET " . implode( ", ", $propPairs);
		$sql .= " WHERE " . static::$dbIndex . "= " . $database->escapeString( $this->indexVal );

		$database->dbQuery( $sql );
		// Untested PDO::rowCount() call...
		return ( $database->connection->rowCount() == 1 ) ? true : false;
	}

	public function delete() {
		// Methid deletes the record of the instance from the database, based on the $indexVal.
		global $database;

		$sql = "DELETE FROM " . static::$dbTable . " WHERE " . static::$dbIndex . "=";
		$sql .= $database->escapeString( $this->indexVal ) . " LIMIT 1";

		$database->dbQuery( $sql );
		// Untested PDO::rowCount() call...
		return ( $database->connection->rowCount() == 1 ) ? true : false;
	}

}

?>
