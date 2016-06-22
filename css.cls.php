<?php

class CSS extends AppObject {
      
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
      private $cssID;
      private $cssText;
      
      protected static $dbTable = 'css';
      protected static $dbIndex = 'cssID';
      protected static $dbFields = array(
            'cssID',
            'cssName',
            'cssText');
      
      public function __toString() {
            
      }
      
      public function setID( $id ) {
            $this->cssID = $id;
      }
      
      public function setText( $text ) {
            $this->cssText = $text;
      }
      
      public function getID() {
            return $this->cssID;
      }
      
      public function getText() {
            return $this->cssText;
      }
      

      
}

?>