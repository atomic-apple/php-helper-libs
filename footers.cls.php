<?php

class Footer extends AppObject {
      /*
            Methods inherited from AppObject:
            findByQuery( $qry ) => returns an instantiated instance of the Calling Class...
            findAll() => returns instantiated instances of all database records of the Calling Class...
            findById( $id ) => returns the instance identified by $id in the Database, FALSE if not found...
            instantiate( $theRecord ) => accepts a recordset of the Calling Class from the Database and returns an Instance of that Class...
            hasTheAttr( $theAttr ) => checks if the 'attribute' $theAttr is part of the calling class - BOOL...
            properties() => returns $properties=>$value associative array of the instance...
            cleanProperties() => ensures that the db CRUD methods use only db-safe data by escaping the properties...
            CRUD => Create, Update, Destroy database recordsets from instances...
      */
      protected $footerID;
      protected $footerName;
      protected $footerText;
      
      protected static $dbTable = 'footer';
      protected static $dbIndex = 'footerID';
      protected static $dbFields = array(
            'footerID',
            'footerName',
            'footerText');
      
      public function __toString() {
            $humanReadable = "";
            $humanReadable .= "Footer ID: " . $this->footerID . "<br>";
            $humanReadable .= "Footer Name: " . $this->footerName . "<br>";
            $humanReadable .= "Footer Code: " . htmlspecialchars( $this->footerText ) . "<br>";
            return $humanReadable;
      }
}



?>