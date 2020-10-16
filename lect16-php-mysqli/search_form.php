<?php 

// ---- STEP 1: Establish DB connection
$host = "303.itpwebdev.com";
$user = "nayeon_db_user";
$password = "uscItp2020!";
$db = "nayeon_song_db";

// To connect to the DB we need to make an instance of the built in mysqli class

// This line creates an instance of the mysqli class AND it attempts to connect to this database
$mysqli = new mysqli($host, $user, $password, $db);

// Check for errors
// connect_errno will return an error code if there is an error when attempting to connect to the db.
if( $mysqli->connect_errno){
	// Display the exact error message
	echo $mysqli->connect_error;
	// exit() terminates the program. Subsequent code will not run.
	exit();
}


// ---- STEP 2: Generate & Submit SQL query

// Write out the SQL statement as a string
$sql = "SELECT * FROM genres;";

// Double check the SQL statement string
echo "<hr>" . $sql . "<hr>";

// Submit the query to the database
// query() method submits the query to the DB and it returns a results object
$results = $mysqli->query($sql);

// let's quickly see what the results look like
var_dump($results);


// Error checking. $mysqli->query() will return FALSE if there were any errors with the query
if( !$results ) {
	echo $mysqli->error;
	// Terminate the rpogram.
	exit();
}

$sql_media = "SELECT * FROM media_types;";
$results_media = $mysqli->query($sql_media);
if( !$results_media ) {
	echo $mysqli->error;
	// Terminate the rpogram.
	exit();
}

// ---- STEP 3: Display Results
echo "<hr>";
echo "Number of results: " . $results->num_rows;

// To get the actual results, use a method called fetch_assoc()
// fetch_assoc() returns one result as an associative array
echo "<hr>";

// fetch_assoc() will returns FALSE when it reaches the end of the results
// $row is a temp variable that represents the one result as we loop through the results
// fetch_assoc() can be run through only once 
// while( $row = $results->fetch_assoc() ) {
// 	var_dump($row);
// 	// var_dump($row["name"]);
// 	echo "<hr>";
// }

// while( $row = $results->fetch_assoc() ) {
// 	var_dump($row);
// 	echo "<hr>";
// }

// foreach( $results->fetch_assoc() as $row) {
// 	var_dump($row);
// 	echo "<hr>";
// }


// ---- STEP 4: Close DB connection
$mysqli->close();


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Song Search Form</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Song Search Form</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">

		<form action="search_results.php" method="GET">

			<div class="form-group row">
				<label for="name-id" class="col-sm-3 col-form-label text-sm-right">Track Name:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="name-id" name="track_name">
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
				<div class="col-sm-9">
					<select name="genre" id="genre-id" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- <option value='1'>Rock</option>
						<option value='2'>Jazz</option>
						<option value='3'>Metal</option>
						<option value='4'>Alternative & Punk</option>
						<option value='5'>Rock And Roll</option> -->

<?php 
	// This is kinda messy
	// while($row = $results->fetch_assoc()) {
	// 	echo "<option value='" . $row["genre_id"]."'>" . $row["name"] . "<option>";
	// }
?>

<!-- Alternative PHP syntax. It separates the PHP from HTML -->

<?php while($row = $results->fetch_assoc()) : ?>
	<option value="<?php echo $row['genre_id']; ?>">
		<?php echo $row["name"]; ?>
	</option>
<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="media-type-id" class="col-sm-3 col-form-label text-sm-right">Media Type:</label>
				<div class="col-sm-9">
					<select name="media_type" id="media-type-id" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- <option value='1'>MPEG audio file</option>
						<option value='2'>Protected AAC audio file</option> -->
<?php while($row = $results_media->fetch_assoc()) : ?>
	<option value="<?php echo $row['media_type_id']; ?>">
		<?php echo $row["name"]; ?>
	</option>
<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Search</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->
</body>
</html>