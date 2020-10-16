<?php
	
var_dump($_GET);
echo "<hr>";
echo "User chose genre id: " . $_GET["genre"];

// ---- STEP 1: Establish DB connection
$host = "303.itpwebdev.com";
$user = "nayeon_db_user";
$password = "uscItp2020!";
$db = "nayeon_song_db";

$mysqli = new mysqli($host, $user, $password, $db);

// Check for errors
// connect_errno will return an error code if there is an error when attempting to connect to the db.
if( $mysqli->connect_errno){
	// Display the exact error message
	echo $mysqli->connect_error;
	// exit() terminates the program. Subsequent code will not run.
	exit();
}

// Set character set
$mysqli->set_charset("utf8");

// ---- STEP 2: Generate & Submit SQL query
$sql = "SELECT tracks.name AS track, genres.name AS genre, 
media_types.name AS media_type
FROM tracks
JOIN genres
	ON tracks.genre_id = genres.genre_id
JOIN media_types
	ON tracks.media_type_id = media_types.media_type_id
WHERE 1=1";

// If user has typed in a search term for track name
if( isset($_GET["track_name"]) && !empty($_GET["track_name"]) ) {
	$sql = $sql . " AND tracks.name LIKE '%" . $_GET["track_name"] . "%' ";
}
// If user has selected a genre
if( isset($_GET["genre"]) && !empty($_GET["genre"]) ) {
	$sql = $sql . " AND tracks.genre_id = " . $_GET["genre"];
}

// If user has selected a media type
if( isset($_GET["media_type"]) && !empty($_GET["media_type"]) ) {
	$sql = $sql . " AND tracks.media_type_id = " . $_GET["media_type"];
}

// semicolon at the end of sql statement
$sql = $sql . ";";

echo "<hr>" . $sql . "<hr>";

$results = $mysqli->query($sql);
if( !$results) {
	echo $mysqli->error;
	exit();
}

$mysqli->close();


?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Song Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<h1 class="col-12 mt-4">Song Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
	<div class="container-fluid">
		<div class="row mb-4 mt-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">

				Showing 2 result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>Track</th>
							<th>Genre</th>
							<th>Media Type</th>
						</tr>
					</thead>
					<tbody>

						<!-- <tr>
							<td>For Those About To Rock (We Salute You)</td>
							<td>Rock</td>
							<td>MPEG audio file</td>
						</tr>

						<tr>
							<td>Put The Finger On You</td>
							<td>Rock</td>
							<td>MPEG audio file</td>
						</tr> -->
<?php while($row = $results->fetch_assoc() ): ?>

	<tr>
		<td><?php echo $row["track"];?></td>
		<td><?php echo $row["genre"];?></td>
		<td><?php echo $row["media_type"];?></td>
	</tr>

<?php endwhile;?>


					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
</body>
</html>












