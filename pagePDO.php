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

	}

	public function renderPage() {

	}

	private function fetchMeta() {
		global $database;

		$qry = "SELECT * FROM `meta` WHERE `pageID` = {$this->pageID}";
		$result = $database->dbQuery( $qry );

		foreach ( $result as $metaEntry ) {
			$this->pageMeta[] = $metaEntry;
		}
	}

	private function fetchCSS() {
		global $database;

		$qry = "SELECT * FROM `css` WHERE `pageID` = {$this->pageID}";
		$result = $database->dbQuery( $qry );

		foreach( $result as $cssEntry ) {
			$this->pageCSS[] = $cssEntry;
		}
	}

	private function fetchContent() {
		global $database;

		$qry = "SELECT * FROM `content` WHERE `pageID` = {$this->pageID}";
		$result = $database->dbQuery( $qry );

		foreach( $result as $contentEntry ) {
			$this->pagecontent[] = $contentEntry;
		}
	}

	private function fetchJS() {
		global $database;

		$qry = "SELECT * FROM `js` WHERE `pageID` = {$this->pageID}";
		$result = $database->dbQuery( $qry );

		foreach( $result as $jsEntry ) {
			$this->pageJS[] = $jsEntry;
		}
	}

}

?>
