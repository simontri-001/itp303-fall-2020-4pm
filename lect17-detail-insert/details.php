<?php

var_dump($_GET);

if(!isset($_GET["track_id"]) || empty($_GET["track_id"])) {
	// A track id is not given, show error message. Don't do anything else.
	$error = "Invalid Track ID";
}
else {
	// A track id is given so continue to connect to the DB.
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

	$mysqli->set_charset('utf8');

	// Generate the SQL
	// track_id will be dynamic. Depends on what song the user clicks on.
	$sql = "SELECT tracks.name AS track, artists.name AS artist, composer, 
albums.title AS album
FROM tracks
JOIN albums
	ON albums.album_id = tracks.album_id
JOIN artists
	ON artists.artist_id = albums.artist_id
WHERE track_id =" . $_GET["track_id"] . ";";

	// Before runing the query, echo out the SQL string to make sure the SQL statement looks correct

	echo "<hr>" . $sql . "<hr>";

	// Run the query!
	$results = $mysqli->query($sql);
	if(!$results) {
		echo $mysqli->error;
		exit();
	}

	// This SQL statement will return only ONE record, so no need to run a while loop
	$row = $results->fetch_assoc();
	var_dump($row);

	$mysqli->close();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Song Details | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item active">Details</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Song Details</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">


<?php if( isset($error) && !empty($error)): ?>
	<div class="text-danger">
		<?php echo $error; ?>
	</div>
<?php else: ?>
				
				<table class="table table-responsive">
					<tr>
						<th class="text-right">Track Name:</th>
						<td><?php echo $row["track"];?></td>
					</tr>
					<tr>
						<th class="text-right">Artist Name:</th>
						<td><?php echo $row["artist"];?></td>
					</tr>
					<tr>
						<th class="text-right">Composer:</th>
						<td><?php echo $row["composer"];?></td>
					</tr>
					<tr>
						<th class="text-right">Album:</th>
						<td><?php echo $row["album"];?></td>
					</tr>
					<tr>
						<th class="text-right">Genre:</th>
						<td>Genre</td>
					</tr>
					<tr>
						<th class="text-right">Milliseconds:</th>
						<td>Milliseconds</td>
					</tr>
					<tr>
						<th class="text-right">Bytes:</th>
						<td>Bytes</td>
					</tr>
					<tr>
						<th class="text-right">Price:</th>
						<td>Price</td>
					</tr>
				</table>
<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>