// A function that displays the results to the browser
function displayResults(results) {

	// convert the JSON formatted string into JS objects
	let JSresponse = JSON.parse(results);
	console.log(JSresponse);
	console.log(JSresponse.resultCount);
	console.log(JSresponse.results[0].collectionName);

	// Clear out the previous search results before appending the new ones
	let tbody = document.querySelector("tbody");
	while( tbody.hasChildNodes() ) {
		tbody.removeChild(tbody.lastChild);
	}

	// Display all the results on the browser
	for( let i = 0; i < JSresponse.results.length; i++ ) {

		// Create a <tr> tag
		let trElement = document.createElement("tr");

		// Create a <td> tag for cover art
		let coverTd = document.createElement("td");
		// Create <img> for the cover art
		let img = document.createElement("img");
		img.src = JSresponse.results[i].artworkUrl100;

		// Append the <img> to the cover <td>
		coverTd.appendChild(img);
		console.log(coverTd);

		// Create a <td> tag for artist
		let artistTd = document.createElement("td");
		artistTd.innerHTML = JSresponse.results[i].artistName;

		// Create a <td> tag for track
		let trackTd = document.createElement("td");
		trackTd.innerHTML = JSresponse.results[i].trackName;

		// Create a <td> tag for album
		let albumTd = document.createElement("td");
		albumTd.innerHTML = JSresponse.results[i].collectionName;

		// Create a <td> tag for preview
		let previewTd = document.createElement("td");
		// Create <audio> tag for audio
		let audio = document.createElement("audio");
		audio.src = JSresponse.results[i].previewUrl;
		audio.controls = true;
		// Append audio tag to td
		previewTd.appendChild(audio);

		// Append all the <td> tags to the <tr> that we created way earlier
		trElement.appendChild(coverTd);
		trElement.appendChild(artistTd);
		trElement.appendChild(trackTd);
		trElement.appendChild(albumTd);
		trElement.appendChild(previewTd);

		// Append the <tr> tag to the <tbody> tag that exists already
		document.querySelector("tbody").appendChild(trElement);
	}
}



document.querySelector("#search-form").onsubmit = function(event) {

	event.preventDefault();

	// Grab what the user typed in
	let searchTerm = document.querySelector("#search-id").value.trim();
	let limit = document.querySelector("#limit-id").value;

	console.log(searchTerm);
	console.log(limit);

	// Construct the iTunes URL
	let url = "https://itunes.apple.com/search?term=" + searchTerm + "&limit=" + limit;

	// Make a HTTP request to iTunes
	// To make a HTTP request w/ JS, we will utilize the XMLHttpRequest object to make an AJAX request

	let httpRequest = new XMLHttpRequest();
	// .open() method to initialize a new request
	// 1st param: the method GET or POST
	// 2nd param: URL
	httpRequest.open("GET", url);
	// Send this request!
	httpRequest.send();

	// Set up an event handler that will run when iTunes eventually responds
	httpRequest.onreadystatechange = function() {
		// Run this function ONLY when we get some kind of response from iTunes. 
		console.log(httpRequest.readyState);

		// when httpRequest.readyState is 4, it means we have gotten a full response from iTunes
		if( httpRequest.readyState == 4 ) {
			// A success response? - 200 is the HTTP response status code for success

			if( httpRequest.status == 200 ) {
				// status 200 means we got a succesful response

				// responseText is the response we got from iTunes. It is a string
				console.log(httpRequest.responseText);

				// Call the displayResults() function
				displayResults(httpRequest.responseText);
			}
			else {
				// we did get response back, but there was an error
				console.log(httpRequest.status);
			}
		}
	}

	console.log("moving on with my life");

}










