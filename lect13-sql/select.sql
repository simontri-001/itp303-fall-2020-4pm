-- SQL comments
/*
	Multi-line comments
*/

-- SELECT: specify which columns to show
-- FROM: specify which table to get data from
SELECT *
FROM tracks;

SELECT track_id, name, composer 
FROM tracks
LIMIT 100;

-- Display tracks that cost more than 0.99.
-- Sort them from shortest to longest (in length of song)
-- Only show the track's id, name, price, and length
SELECT track_id, name, unit_price, milliseconds 
FROM tracks
WHERE unit_price > 0.99
ORDER BY milliseconds DESC;


-- Display a track that has a composer
-- Only show the track's id, name, composer, and price.
SELECT track_id, name, composer, unit_price
FROM tracks
WHERE composer IS NOT NULL;

SELECT * FROM tracks;

-- Display tracks that have 'you' or 'day' in their titles
SELECT * 
FROM tracks
WHERE name LIKE '%you%' OR name LIKE '%day%';

-- Display tracks composed by U2 that have 'you' or 'day' in their titles
SELECT * 
FROM tracks
WHERE (name LIKE '%you%' OR name LIKE '%day%') AND composer LIKE '%U2%';

-- Display all albums and artists corresponding to each album.
-- Only show the album title and artists name.
SELECT albums.title AS album_title, name as artist_name
FROM albums
JOIN artists
	ON albums.artist_id = artists.artist_id;


-- Display all Jazz tracks
-- Show track name, genre name, album title, and artist name
SELECT tracks.name AS track_name, genres.name AS genre_name, 
albums.title AS album_name, artists.name AS artist_name
FROM tracks
JOIN genres
	ON tracks.genre_id = genres.genre_id
JOIN albums
	ON tracks.album_id = albums.album_id
JOIN artists
	ON albums.artist_id = artists.artist_id
WHERE genres.genre_id = 2;

