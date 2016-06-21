<?php

class Media extends AppObject {

	public $mediaID;
	public $mediaName;
	public $mediaURL;
	public $mediaDuration;
	public $mediaAvailable;

	protected static $dbIndex = "mediaID";
	protected static $dbTable = "media";
	protected static $dbTableFields = array(
		'mediaID',
		'mediaName',
		'mediaURL',
		'mediaDuration',
		'mediaAvailable'
	);
	protected $dbIndexVal;

	public function __toString() {
		// method that provides a human readable description of the Class.
		$humanReadable = "<div class='col-md-8 text-center'>
		Media Title: {$this->mediaName}<br />
		Media Duration: {$this->mediaDuration}<br />
		Media Live (Y/N): ";
		$humanReadable .= ( $this->mediaAvailable == 1) ? "Yes" : "No";
		$humanReadable .= "<br /><br /></div>";
            return $humanReadable;
	}


}

?>
