<?php

error_reporting(1);
ini_set( 'error_reporting', E_ALL);

include_once( 'functions.php' );
include_once( 'databasePDO.php' );
include_once( 'session.php' );
// var_dump( $session );
// include_once( 'appobject.php' );
include_once( 'appobjectPDO.php' );
include_once( 'userPDO.php' );
include_once( 'mediaPDO.php' );
include_once( 'pagePDO.php' );

set_error_handler( 'atomicErrors' );

 ?>
