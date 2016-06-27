 <?php

include_once( 'page.init.inc.php' );

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
      
      public function __construct( $id ) {
            // The constructor assigns the pageID of the page for reading data from the Database.
            // It then populates it's data structure using the database, and then Renders the data to
            // the output buffer.
            $this->pageID = $id;
            $this->makePage();
            $this->renderPage();
      }

	public function __toString() {
            // This method provides a Human Readable description of the instance for debugging
            $humanReadable = "";
            $humanReadable .= "Page: " . $this->pageName . "<br>";
            $humanReadable .= "Page ID: " . $this->pageID . "<br>";
            foreach( $this->pageCSS as $cssEntry ) {
                  foreach( $cssEntry as $cssObject ) {
                        $humanReadable .= "CSS: '" . htmlspecialchars( $cssObject->cssText ) . "'<br>";
                  }
            }
            foreach( $this->pageJS as $jsEntry ) {
                  foreach( $jsEntry as $jsObject ) {
                        $humanReadable .= "JS: '" . htmlspecialchars( $jsObject->jsText ) . "'<br>";
                  }
            }
            
            foreach( $this->pageMeta as $metaIndex => $metaEntry ) {
                  foreach( $metaEntry as $metaObject ){
                        $humanReadable .= "Meta-Tag: ";
                        $humanReadable .= htmlspecialchars( $metaObject->metaText );
                        $humanReadable .= "<br>";
                  }
            }
            foreach( $this->pageContent as $contentEntry ) {
                  foreach( $contentEntry as $contentObject ){
                        $humanReadable .= "Content: ";
                        $humanReadable .= htmlspecialchars( $contentObject->metaText );
                        $humanReadable .= "<br>";
                  }
            }
            return $humanReadable;
	}
      
      public function renderPage() {
            // This method echoes the instance data to the output buffer in the order specified
            echo $this->pageHeaders;
            foreach( $this->pageCSS as $cssEntry ) {
                  foreach( $cssEntry as $cssCode ) {
                        echo $cssCode->cssText;
                  }
            }
            foreach( $this->pageMeta as $metaEntry ) {
                  foreach( $metaEntry as $metaCode ) {
                        echo $metaCode->metaText;
                  }
            }
            foreach( $this->pageContent as $contentEntry ) {
                  foreach( $contentEntry as $contentCode ) {
                        echo $contentCode->contentText;
                  }
            }
            foreach( $this->pageJS as $jsEntry ) {
                  foreach( $jsEntry as $jsCode ) {
                        echo $jsCode->jsText;
                  }
            }
            echo $this->pageFooter;
      }

	public function makePage() {
            // This method populates the instance with the data from the database for rendering...
            global $database;
            
//             For Reference, the classID for each component is:
//                   1 => 'css',
//                   2 => 'js',
//                   3 => 'meta',
//                   4 => 'content',
//                   5 => 'header',
//                   6 => 'footer'
            
            if( isset( $this->pageID ) ) {
                  $qry = "SELECT * FROM `pageComponents` WHERE `pageID` = '{$this->pageID}' AND `componentActive` = 1";
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
      
      public function addMeta( $metaComponent ) {
            global $database;
            
            $qry = "SELECT * FROM `metas` WHERE `metaID` = {$metaComponent} LIMIT 1";
            $newMeta = new Meta();
            $metaArray = $newMeta::findByQuery( $qry );
            if( $newMeta ) {
                  $this->pageMeta[] = $metaArray;
            } else {
                  trigger_error( "$newMeta $component NOT FOUND Error:: pagePDO:: addMeta()..." );
            }
      }
      
      public function addCSS( $cssComponent ) {
            global $database;
            
            $qry = "SELECT * FROM `css` WHERE `cssID` = {$cssComponent} LIMIT 1";
            $newCSS = new CSS();
            $cssArray = $newCSS::findByQuery( $qry );
            if( $newCSS ) {
                  $this->pageCSS[] = $cssArray;
            } else {
                  trigger_error( "newCSS $component NOT FOUND Error:: pagePDO:: addCSS()..." );
            }
      }

      public function addContent( $contentComponent ) {
            global $database;
            
            $qry = "SELECT * FROM `contents` WHERE `contentID` = {$contentComponent} LIMIT 1";
            $newContent = new Content();
            $contArray = $newContent::findByQuery( $qry );
            if( $newContent ) {
                  $this->pageContent[] = $contArray;
            } else {
                  trigger_error( "newContent $content NOT FOUNF Error:: pagePDO:: addContent()..." );
            }
      }

      public function addJS( $jsComponent ) {
            global $database;
            
            $qry = "SELECT * FROM `js` WHERE `jsID` = {$jsComponent} LIMIT 1";
            $newJS = new JS();
            $jsArray = $newJS::findByQuery( $qry );
            if( $newJS ) {
                  $this->pageJS[] = $jsArray;
            } else {
                  trigger_error( "newCSS $component NOT FOUND Error:: pagePDO:: add CSS()..." );
            }
      }

}

?>
