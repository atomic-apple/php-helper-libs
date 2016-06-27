<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="lib.css" />

<?php
ob_start();
require_once( 'init.inc.php' );

$users = new User();

$userArray = $users->findAll();
// var_dump( $userArray );

// $firstUser = $userArray[0]->findById( 1 );
// var_dump( $firstUser );
foreach( $userArray as $instance ) {
	// User class has a __toString method so can be echo'd directly
	echo $instance;
}

$media = new Media();

$mediaArray = $media->findAll();
// var_dump( $mediaArray );

foreach ( $mediaArray as $instance ) {
	echo $instance;
//   var_dump( $instance );
}

$mediaArray[1]->mediaAvailable = false;
echo "<br><br>";
foreach ( $mediaArray as $instance ) {
	echo $instance;
}

$page = new Page(1);
$page->pageName = "Home";
// $page->addCSS( 1 );
// $page->pageID = 1;
// $page->addMeta( 1 );
// $page->addJS( 1 );
// $page->addMeta( 2 );
// $page->addCSS( 2 );
// $page->addJS( 4 );
$page->makePage();

// echo $page;
$page->renderPage();
// foreach( $page->pageMeta as $item ) {
//       echo "<br>";
//       foreach( $item as $object ) {
//             echo $object->metaText;
//       }
// }

$page2 = new Page(2);
$page2->pageName = "Test Page";
// $page2->addCSS( 1 );
$page2->pageID = 2;
// $page2->addMeta( 1 );
// $page2->addJS( 1 );
// $page2->addMeta( 2 );
// $page->addCSS( 2 );
// $page->addJS( 4 );

// $renderedPage = $page2->makePage();
// var_dump( $renderedPage );
$page2->makePage();
echo $page2;
?>
