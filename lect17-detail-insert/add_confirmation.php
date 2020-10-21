<?php

// server-side validation is also neccesary even if client-side validation (like JS) exists because client-side validation can be tampered with (e.g. disable JS)

var_dump($_POST);

// Make sure the REQUIRED fields from Add form have been submitted
if ( !isset($_POST['track_name']) || 
	empty($_POST['track_name']) || 
	!isset($_POST['media_type']) || 
	empty($_POST['media_type']) || 
	!isset($_POST['genre']) || 
	empty($_POST['genre']) || 
	!isset($_POST['milliseconds']) || 
	empty($_POST['milliseconds']) || 
	!isset($_POST['price']) || 
	empty($_POST['price']) ) {

	$error = "Please fill out all required fields";
}
else {
	// All required fields are given. Ready to connect to the DB!

	$host = "303.itpwebdev.com";
	$user = "nayeon_db_user";
	$password = "uscItp2020!";
	$db = "nayeon_song_db";

	// DB Connection
	$mysqli = new mysqli($host, $user, $password, $db);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	// Optional fields.
	if( isset($_POST['album']) && !empty($_POST['album']) ) {
		// User has selected an album
		$album_id = $_POST["album"];
	}
	else {
		$album_id = "null";
	}
	if( isset($_POST['composer']) && !empty($_POST['composer']) ) {
		// User has typed in a composer
		$composer = "'" .  $_POST["composer"] . "'";
	}
	else {
		$composer = "null";
	}
	if( isset($_POST['bytes']) && !empty($_POST['bytes']) ) {
		// User has typed in bytes
		$bytes = $_POST["bytes"];
	}
	else {
		$bytes = "null";
	}

	// real_escape_string method escapes certain characters including single quotes, double quotes, etc that causes problems when inserted into a SQL statement.
	$track_name = $mysqli->real_escape_string($_POST["track_name"]);

	// Generate INSERT statement to add this track
	$sql = "INSERT INTO tracks(name, album_id, media_type_id, genre_id, composer, 
milliseconds, bytes, unit_price)
		VALUES('" . $track_name . "'," 
		. $album_id . "," 
		. $_POST["media_type"] . ","
		. $_POST["genre"] . ", " 
		. $composer . "," 
		. $_POST["milliseconds"] . ", "
		. $bytes . ", "
		. $_POST["price"] . ");";

	// Double check the SQL statement by echoing out
	echo "<hr>" . $sql . "<hr>";

	// If all looks good, run it!
	$results = $mysqli->query($sql);
	if(!$results) {
		echo $mysqli->error;
		exit();
	}

	// $mysqli->affected_rows returns the number of rows inserted. Works for updated, deleted or inserted SQL commands
	echo "Inserted: " . $mysqli->affected_rows;

	// can now use this to create $isInserted variable and use this for the confirmation messsage
	if($mysqli->affected_rows == 1) {
		$isInserted = true;
	}

	$mysqli->close();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Confirmation | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Add a Song</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

			<?php if(isset($error) && !empty($error)): ?>
				<div class="text-danger">
					<?php echo $error; ?>
				</div>
			<?php endif;?>

			<?php if( $isInserted ): ?>
				<div class="text-success">
					<span class="font-italic"><?php echo $_POST["track_name"]?></span> was successfully added.
				</div>
			<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="add_form.php" role="button" class="btn btn-primary">Back to Add Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>