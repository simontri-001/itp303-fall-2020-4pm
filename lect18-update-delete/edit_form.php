<?php
// require will "import" the file into this file. If the file does not exist, program will terminate

// require is more strict - if file does not exist, throws a fatal error and terminates the program

// include is less strict - if file does not exist, throws a warning and continues the program

require "config/config.php";

// Check that a track id is available
if( !isset($_GET["track_id"]) || empty($_GET["track_id"]) ) {
	echo "Invalid Track ID";
	exit();
}

// Move the credentials to a separate file

// $host = "303.itpwebdev.com";
// $user = "nayeon_db_user";
// $pass = "uscItp2020!";
// $db = "nayeon_song_db";

// DB Connection.
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

// -- Get details of this track
$sql = "SELECT * FROM tracks
WHERE track_id =" . $_GET["track_id"] . ";";

$results = $mysqli->query($sql);
if(!$results) {
	echo $mysqli->error;
	exit();
}

// We'll only get ONE track result back. Store it in a variable called $track
$track = $results->fetch_assoc();

// double check we got the right result
var_dump($track);


// Genres:
$sql_genres = "SELECT * FROM genres;";
$results_genres = $mysqli->query($sql_genres);
if ( $results_genres == false ) {
	echo $mysqli->error;
	exit();
}

// Close DB Connection
$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Form | Song Database</title>
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
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php">Details</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Edit a Song</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">

		<form action="edit_confirmation.php" method="POST">

			<div class="form-group row">
				<label for="name-id" class="col-sm-3 col-form-label text-sm-right">
					Track Name: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-9">
				<!-- value attribute determines what is typed in to this text field  -->
					<input type="text" class="form-control" id="name-id" name="track_name" value="<?php echo $track['name']; ?>">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">
					Genre: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-9">

<!-- While running through all the genres from the database, if the genre matches the genre of THIS song, add the attribute "selected" to the option tag. Otherwise, show the same option tag without the "selected" attribute -->
					<select name="genre" id="genre-id" class="form-control">
						<option value="" selected disabled>-- Select One --</option>

<?php while( $row = $results_genres->fetch_assoc() ): ?>

	<?php if( $row["genre_id"] == $track["genre_id"]) :?>

		<option selected value="<?php echo $row['genre_id']; ?>">
			<?php echo $row['name']; ?>
		</option>

	<?php else: ?>

		<option value="<?php echo $row['genre_id']; ?>">
			<?php echo $row['name']; ?>
		</option>

	<?php endif;?>

<?php endwhile; ?>
					</select>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="composer-id" class="col-sm-3 col-form-label text-sm-right">
					Composer:
				</label>
				<div class="col-sm-9">
					<input type="text" name="composer" id="composer-id" class="form-control" value="<?php echo $track['composer']; ?>">
				</div>
			</div> <!-- .form-group -->

<!-- Submit a hidden piece of information to edit_confirmation.php this way -->
<input type="hidden" name="track_id" value="<?php echo $_GET['track_id'];?>">

			<div class="form-group row">
				<div class="ml-auto col-sm-9">
					<span class="text-danger font-italic">* Required</span>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->
</body>
</html>