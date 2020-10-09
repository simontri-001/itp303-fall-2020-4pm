-- Add album 'Fight On' by artist 'Spirit of Troy'
SELECT * FROM albums;

INSERT INTO albums (title, artist_id)
VALUES ('Fight On', 276);

-- Look for the primary key of spirit of troy artist
SELECT * FROM artists
WHERE name LIKE '%spirit%';

-- Doesn't exist, so let's add this artist
INSERT INTO artists (name)
VALUES ('Spirit of Troy');

-- Let's double check that this artist did get added
SELECT * FROM artists
ORDER BY artist_id DESC;

-- Let's double check that album was added
SELECT * FROM albums
ORDER BY album_id DESC;

-- Update track named 'All My Love' composed by E.Schrody and L. Dimant to be
-- part of the 'Fight On' album and composed by 'Tommy Trojan.'
SELECT * FROM tracks;

-- If I had run this statement, BOTH tracks named 'All My Love' would be updated
UPDATE tracks
SET composer = 'Tommy Trojan', album_id = 348
WHERE name = 'All My Love';

SELECT * FROM tracks
WHERE name = 'All My Love';

-- Recommended way to update this track
UPDATE tracks
SET composer = 'Tommy Trojan', album_id = 348
WHERE track_id = 3316;


-- DELETE the album 'Fight On'
-- good idea to double check what is being deleted
SELECT * FROM albums
WHERE album_id = 348;

-- Get an error here because album_id 348 is being referenced by 
-- another table, tracks (for All My Love)
DELETE FROM albums
WHERE album_id = 348;

-- Two ways to work around deleting records that are being referenced by another table
-- 1) Delete the record that references album_id = 348
DELETE FROM tracks
WHERE track_id = 3316;

-- 2) Set any records that reference album id 348 to album id null
UPDATE tracks
SET album_id = null
WHERE track_id = 3316;


-- Create a view that displays all albums and their artists names
-- only show album id, album title, and artist name
CREATE OR REPLACE VIEW album_artists AS
SELECT album_id, title, name, artists.artist_id
FROM albums
JOIN artists
	ON albums.artist_id = artists.artist_id;

-- Access the view
SELECT * FROM album_artists;

-- Can query from the view
SELECT * FROM album_artists
WHERE name LIKE 'AC/DC';


-- Aggregate functions
SELECT COUNT(*), COUNT(composer)
FROM tracks;

-- Min/max
SELECT MIN(milliseconds), MAX(milliseconds), AVG(milliseconds), SUM(milliseconds)
FROM tracks;

-- How long is an album?
SELECT SUM(milliseconds)
FROM tracks
WHERE album_id = 3;

SELECT * FROM tracks;

-- For each album, sum up the milliseconds
SELECT album_id, SUM(milliseconds)
FROM tracks
GROUP BY album_id;

-- We can still use JOIN here to get more info about the album
SELECT tracks.album_id, albums.title, SUM(milliseconds)
FROM tracks
JOIN albums
	ON tracks.album_id = albums.album_id
GROUP BY album_id;

-- One more GROUP BY example: For each artist, show artists and number 
-- of their albums
SELECT artists.name, artists.artist_id, COUNT(*)
FROM albums
JOIN artists
	ON artists.artist_id = albums.artist_id
GROUP BY artists.artist_id;

