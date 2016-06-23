 <?php

class Page extends AppObject {

	public $pageID;
	public $pageName;
	public $pageHeaders;
	public $pageMeta = array();
	public $pageCSS = array();
	public $pageContent = array();
	public $pageJS = array();
	public $pageFooter;

	protected static $dbIndex = "pageID";
	protected static $dbTable = "pages";
	protected static $dbTableFields = array(
		'pageID',
		'pageName',
		'pageHeaders',
		'pageFooter');
	protected $dbIndexVal;

	public function __toString() {
            $humanReadable = "";
            $humanReadable .= "Page: " . $this->pageName . "<br>";
            $humanReadable .= "Page ID: " . $this->pageID . "<br>";
            foreach( $this->pageCSS as $cssEntry ) {
                  $humanReadable .= "CSS: '" . $cssEntry . "'<br>";
            }
            foreach( $this->pageJS as $jsEntry ) {
                  $humanReadable .= "JS: '" . $jsEntry . "'<br>";
            }
            return $humanReadable;
	}

	public function renderPage() {
            global $database;
            
            $page = "";
//             $section = array(
//                   1 => 'css',
//                   2 => 'js',
//                   3 => 'meta',
//                   4 => 'content',
//                   5 => 'header',
//                   6 => 'footer'
//             );
            if( isset( $this->pageID ) ) {
                  $qry = "SELECT * FROM `pageComponents` WHERE `pageID` = {$this->pageID}";
                  $result = $database->dbQuery( $qry );
                  
                  foreach( $result as $compKey => $component ) {
                        switch ( $component['classID'] ) {
                              case '1':
                                    $this->addCSS( $component['sectionID'] );
                                    break;
                              case '2':
                                    $this->addJS( $component['sectionID'] );
                                    break;
                              case '3':
                                    $this->addMeta( $component['sectionID'] );
                                    break;
                              case '4':
                                    $this->addContent( $component['sectionID'] );
                                    break;
                              case '5':
                                    $this->addHeader( $component['sectionID'] );
                                    break;
                              case '6':
                                    $this->addFooter( $component['sectionID'] );
                                    break;
                        }
                  }
            } else {
                  trigger_error( "Page Render Error:: PagePDO:: " . $result->errorInfo() );
            }

	}
      
      
      // Needs re-engineering to account for return of Assoc Array and pulling items from tables in database...
// 	private function fetchMeta() {
// 		global $database;

// 		$qry = "SELECT * FROM `meta` WHERE `metaID` = {$metaID}";
// 		$result = $database->dbQuery( $qry );

// 		foreach ( $result as $metaEntry ) {
// 			$this->pageMeta[] = $metaEntry;
// 		}
// 	}
      
      public function addMeta( $metaComponent ) {
            global $database;
            
            $qry = "SELECT * FROM `metas` WHERE `metaID` = {$metaComponent} LIMIT 1";
//             echo $qry . "<br>";
            $result = $database->dbQuery( $qry );
            foreach( $result as $metaItem ) {
                  $this->pageMeta[] = $metaItem['metaText'];
//                   var_dump( $metaItem );
            }
      }

// 	private function fetchCSS() {
// 		global $database;

// 		$qry = "SELECT * FROM `css` WHERE `pageID` = {$this->pageID}";
// 		$result = $database->dbQuery( $qry );

// 		foreach( $result as $cssEntry ) {
// 			$this->pageCSS[] = $cssEntry;
// 		}
// 	}
      
      public function addCSS( $cssComponent ) {
            global $database;
            
            $qry = "SELECT * FROM `css` WHERE `cssID` = {$cssComponent} LIMIT 1";
//             echo $qry . "<br>";
            $result = $database->dbQuery( $qry );
            foreach( $result as $cssItem ) {
                  $this->pageCSS[] = $cssItem['cssText'];
//                   var_dump( $metaItem );
            }
      }

// 	private function fetchContent() {
// 		global $database;

// 		$qry = "SELECT * FROM `content` WHERE `pageID` = {$this->pageID}";
// 		$result = $database->dbQuery( $qry );

// 		foreach( $result as $contentEntry ) {
// 			$this->pagecontent[] = $contentEntry;
// 		}
// 	}
      
      public function addContent( $contentComponent ) {
            global $database;
            
            $qry = "SELECT * FROM `contents` WHERE `contentID` = {$contentComponent} LIMIT 1";
//             echo $qry . "<br>";
            $result = $database->dbQuery( $qry );
            foreach( $result as $contentItem ) {
                  $this->pageContent[] = $contentItem['contentText'];
//                   var_dump( $metaItem );
            }
      }

// 	private function fetchJS() {
// 		global $database;

// 		$qry = "SELECT * FROM `js` WHERE `pageID` = {$this->pageID}";
// 		$result = $database->dbQuery( $qry );

// 		foreach( $result as $jsEntry ) {
// 			$this->pageJS[] = $jsEntry;
// 		}
// 	}
      
      public function addJS( $jsComponent ) {
            global $database;
            
            $qry = "SELECT * FROM `js` WHERE `jsID` = {$jsComponent} LIMIT 1";
//             echo $qry . "<br>";
            $result = $database->dbQuery( $qry );
            foreach( $result as $jsItem ) {
                  $this->pageJS[] = $jsItem['jsText'];
//                   var_dump( $metaItem );
            }
      }

}

?>
