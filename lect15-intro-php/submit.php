<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Intro to PHP</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Intro to PHP</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">
		<div class="row">

			<h2 class="col-12 mt-4 mb-3">PHP Output</h2>

			<div class="col-12">
				<!-- Display Test Output Here -->
<?php
	// Write PHP here

	// echo displays strings - kinda like a print statement
	echo "hello world!";
	echo 'hello world!';
	echo "<strong>i'm bold</strong>";
	echo "<hr>";

	// Variables
	$name = "Tommy";
	$age = 25;

	echo $name;
	echo "<hr>";

	// Concatenate - use period to add two strings together (instead of + in JS)
	echo "My name is " . $name;

	// Double quotes vs single quotes
	// With double quotes, you can utilize variable interpolation 
	echo "<hr>";
	echo "My name is $name \" ";
	echo "<hr>";
	echo 'My name is $name';


	// Setting timezone - PHP has date/time functions built in
	date_default_timezone_set("America/Los_Angeles");

	echo "<hr>";

	// Current date/time - use date() function
	// date() returns the current date/time in the specified format

	// Show current date/time in this format: 
	// 10-13-2020 5:12PM PDT
	echo date("m-d-Y g:i:s T");


	// Arrays and loops
	$colors = ["red", "blue", "green"];
	echo "<hr>";
	echo $colors[0];

	// Loop through array
	for($i = 0; $i < sizeof($colors); $i++) {
		echo $colors[$i];

	}

	// Associative Arrays: an array with string keys
	$courses = [
		"ITP 303" => "Full-Stack Web Development",
		"ITP 404" => "Advanced Front-End Web Development",
		"ITP 405" => "Advanced Back-End Web Development"
	];

	echo "<hr>";
	echo $courses["ITP 303"];
	echo "<hr>";

	// Loop through the associative array
	// $courseNumber is a temp variable, represents KEY
	// $courseName is a temp variable, represents VALUE
	foreach($courses as $courseNumber => $courseName) {
		echo $courseNumber . ": " . $courseName;
		echo "<br>";
	}

	echo "<hr>";
	// Show only the VALUES in an assoc array
	foreach($courses as $courseName) {
		echo  $courseName;
		echo "<br>";
	}

	echo "<hr>";
	// var_dump method is useful to quickly see what value the variable holds
	var_dump($courses);

	echo "<hr>";
	// ---- SUPERGLOBALS
	var_dump($_SERVER);
	echo "<hr>";
	echo $_SERVER["HTTP_HOST"];

	echo "<hr>";
	echo "GET superglobal: ";
	var_dump($_GET);


	echo "<hr>";
	echo "POST superglobal: ";
	var_dump($_POST);
?>

			</div>

		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">
		<div class="row">

			<h2 class="col-12 mt-4">Form Data</h2>

		</div> <!-- .row -->

		<div class="row mt-3">
			<div class="col-3 text-right">Name:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if( isset($_POST["name"]) && !empty($_POST["name"]) ) {
						echo $_POST["name"];
					}
					else {
						echo "Name is empty";
					}
					
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Email:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if( isset($_POST["email"]) && !empty($_POST["email"]) ) {
						echo $_POST["email"];
					}
					else {
						echo "Email is empty";
					}
					
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Current Student:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Subscribe:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if( isset($_POST["subscribe"]) && !empty($_POST["subscribe"]) ) {
						foreach($_POST["subscribe"] as $subscribe) {
							echo $subscribe . ", ";
						}
					}
					else {
						echo "Subscribe is empty";
					}
					
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Subject:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				
			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Message:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				
			</div>
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<a href="form.php" role="button" class="btn btn-primary">Back to Form</a>
		</div> <!-- .row -->

	</div> <!-- .container -->
	
</body>
</html>