<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="lib.css" />

<?php
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
var_dump( $mediaArray );

foreach ( $mediaArray as $instance ) {
	echo $instance;
}

$mediaArray[1]->mediaAvailable = true;
echo "<br><br>";
foreach ( $mediaArray as $instance ) {
	echo $instance;
}

?>
