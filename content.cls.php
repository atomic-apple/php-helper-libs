<?php

class Content extends AppObject {
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
      
      public $contentID;
      public $contentName;
      public $contentText;
      public $contentActive;
      
      protected static $dbTable = 'content';
      protected static $dbIndex = 'contentID';
      protected static $dbFields = array(
            'contentID',
            'contentName',
            'contentText',
            'contentActive');
      
      public function __tostring() {
            $humanReadable = "";
            $humanReadable .= "Content ID: " . $this->contentID . "<br>";
            $humanReadable .= "Content Name: " . $this->contentName . "<br>";
            $humanReadable .= "Content Code: " . htmlspecialchars( $this->contentText ) . "<br>";
            $humanReadable .= "Content Active: ";
            $humanReadable .= ( $this->contentActive == 1 || $this->contentActive == true ) ? "Yes" : "No";
            $humanReadable .= "<br>";
            return $humanReadable;
      }
      
}

?>