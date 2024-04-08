<?php
// ======================================================
// utility function
// ======================================================
function resultToList($results) {
    $merged_results = [];
    foreach ($results as $result) {
        if (is_array($result)) {
            $merged_results = array_merge($merged_results, $result);
        } else {
            $merged_results[] = $result;
        }
    }
    $flattened_list = implode("', '", $merged_results);
    return $flattened_list;
}

// ======================================================
// accessing user information
// ======================================================
function getUsers() {
    global $db;
    $query = "SELECT * FROM Dotify_User";

    try {
        $statement = $db->prepare($query); // compile. does not do anything
        $statement->execute();
        $result = $statement->fetchAll(); // saving to a variable
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $e->getMessage();
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function getUserHash($username) {
    global $db;
    $query = "SELECT * FROM Dotify_User WHERE username=:username";
    try {
        $statement = $db->prepare($query);
        // fill in the value
        $statement->bindValue(':username', $username);
        // execute
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $e->getMessage();
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function getUserId($username) {
    global $db;
    $query = "SELECT user_id FROM Dotify_User WHERE username=:username";
    try {
        $statement = $db->prepare($query);
        // fill in the value
        $statement->bindValue(':username', $username);
        // execute
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result[0]['user_id'];
    } catch (PDOException $e) {
        $e->getMessage();
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function doesUserExist($username) {
    global $db;
    $query = "SELECT * FROM Dotify_User WHERE username=:username";
    try {
        $statement = $db->prepare($query);
        // fill in the value
        $statement->bindValue(':username', $username);
        // execute
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return !(empty($result));
    } catch (PDOException $e) {
        $e->getMessage();
    } catch (Exception $e) {
        $e->getMessage();
    }
}

// ======================================================
// login/signup
// ======================================================
function createAccount($username, $hash_password, $dob) {
    global $db;
    $query = "INSERT INTO Dotify_User(username, hash_password, date_of_birth) 
                VALUES (:username, :pass, :dob)";

    try {
        $statement = $db->prepare($query);
        // fill in the value
        $statement->bindValue(':username', $username);
        $statement->bindValue(':pass', $hash_password);
        $statement->bindValue(':dob', $dob);
        // execute
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $e->getMessage();
    } catch (Exception $e) {
        $e->getMessage();
    }
}

// ======================================================
// Song
// ======================================================
function searchSongs($str){
    global $db;
    $query = "SELECT * FROM Song NATURAL JOIN Song_Artist WHERE LOWER(artist_name) LIKE CONCAT('%', LOWER(:str), '%') 
    OR LOWER(track_name) LIKE CONCAT('%', LOWER(:str), '%') OR LOWER(released_year) LIKE CONCAT('%', LOWER(:str), '%')";
    //Case-insensitive + "contains" match (search "Eve" should match with "Eve" "Evening" "even", etc.)
    try {
        $statement = $db->prepare($query);
        // fill in the value
        $statement->bindValue(':str', $str);
        // execute
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        // Log or display the error message
        echo "PDOException: " . $e->getMessage();
        // return false or throw an exception
        return false;
    } catch (Exception $e) {
        // Log or display the error message
        echo "Exception: " . $e->getMessage();
        // return false or throw an exception
        return false;
    }
}

function getSongName($song_id){
    global $db;
    $query = "SELECT track_name
                FROM Song
                WHERE song_id=:song_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':song_id', $song_id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
        $statement->closeCursor();
        return $result[0];
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

// ======================================================
// Playlist
// ======================================================
function createPlaylist($username, $playlist_name){
    global $db;
    $query = "CALL createPlaylist (:user_id, :playlist_name)";
    try {
        $user_id = getUserId($username); // Get user_id
        $statement = $db->prepare($query);
        // fill in the value
        $statement->bindValue(':user_id', $user_id); // Extract user_id from result
        $statement->bindValue(':playlist_name', $playlist_name);
        // execute the stored procedure
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo "PDO Exception: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    }
}

function getPlaylist($username) {
    global $db;
    $user_id = getUserId($username);
    $query = "SELECT * FROM Playlist WHERE user_id=:user_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function deletePlaylist($playlist_id){
    global $db;
    $query = "DELETE FROM Playlist WHERE playlist_id=:playlist_id";
    try {        
        $statement = $db->prepare($query);
        $statement->bindValue(':playlist_id', $playlist_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

// ======================================================
// Playlist, Song
// Listed_In
// ======================================================
function addSongToPlaylist($song_id, $playlist_id){
    global $db;
    $query = "INSERT INTO Listed_In (playlist_id, song_id) VALUES (:playlist_id, :song_id)";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':playlist_id', $playlist_id);
        $statement->bindValue(':song_id', $song_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function removeSongFromPlaylist($song_id, $playlist_id){
    global $db;
    $query = "DELETE FROM Listed_In WHERE playlist_id=:playlist_id AND song_id=:song_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':playlist_id', $playlist_id);
        $statement->bindValue(':song_id', $song_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function getPlaylistsWithSong($username, $song_id){
    global $db;
    $user_id = getUserId($username);
    $query = "SELECT DISTINCT playlist_id
                FROM 
                    (SELECT * FROM Playlist WHERE user_id=:user_id) AS PlaylistsWithSong 
                    NATURAL JOIN Listed_In
                WHERE song_id=:song_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':song_id', $song_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

//returns if the song_id, playlist_id 
function listedItemInPlaylisting($song_id, $playlist_id){
    global $db;
    $query = "SELECT * FROM Listed_In WHERE playlist_id=:playlist_id AND song_id=:song_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':playlist_id', $playlist_id);
        $statement->bindValue(':song_id', $song_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return empty($result);
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function getSongsInPlaylist($playlist_id) {
    global $db;
    $query = "SELECT * FROM Listed_In WHERE playlist_id=:playlist_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':playlist_id', $playlist_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function deleteSongFromPlaylist($playlist_id, $song_id) {
    global $db;
    $query = "DELETE FROM Listed_In WHERE playlist_id=:playlist_id AND song_id=:song_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':playlist_id', $playlist_id);
        $statement->bindValue(':song_id', $song_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function getSongsInUserPlaylist($username) {
    global $db;
    $user_id = getUserId($username);
    $query = "SELECT * FROM Playlist NATURAL JOIN Listed_In WHERE user_id=:user_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function getArtistNames($song_id) {
    global $db;
    $query = "SELECT * FROM Song_Artist WHERE song_id=:song_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':song_id', $song_id);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        
        $artistNames = array(); // Array to store artist names
        
        foreach ($results as $result) {
            $artistNames[] = $result['artist_name'];
        }
        return implode(', ', $artistNames);
    } catch (PDOException $e) {
        error_log("PDOException in inFavorites: " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        error_log("Exception in inFavorites: " . $e->getMessage());
        return false;
    }
}

// ======================================================
// Favorites
// ======================================================
function inFavorites($username, $song_id) {
    global $db;
    $user_id = getUserId($username);
    $query = "SELECT * FROM Favorites WHERE user_id=:user_id AND song_id=:song_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':song_id', $song_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        error_log("PDOException in inFavorites: " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        error_log("Exception in inFavorites: " . $e->getMessage());
        return false;
    }
}

function addToFavorites($username, $song_id) {
    global $db;
    $user_id = getUserId($username);
    try {
        if (!inFavorites($username, $song_id)) {
            $query = "INSERT INTO Favorites(user_id, song_id) VALUES(:user_id, :song_id)";
            $statement = $db->prepare($query);
            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':song_id', $song_id);
            $statement->execute();
            $statement->closeCursor();
            return true;
        } else {
            return false; // Song already in favorites
        }
    } catch (PDOException $e) {
        error_log("PDOException in addToFavorites: " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        error_log("Exception in addToFavorites: " . $e->getMessage());
        return false;
    }
}

function removeFromFavorites($username, $song_id) {
    global $db;
    $user_id = getUserId($username);
    try {
        if (inFavorites($username, $song_id)) {
            $query = "DELETE FROM Favorites WHERE user_id=:user_id AND song_id=:song_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':song_id', $song_id);
            $statement->execute();
            $statement->closeCursor();
        }
    } catch (PDOException $e) {
        error_log("PDOException in addToFavorites: " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        error_log("Exception in addToFavorites: " . $e->getMessage());
        return false;
    }
}

function getFavorites($username){
    global $db;
    $user_id = getUserId($username);
    $query = "SELECT * FROM Favorites NATURAL JOIN Song NATURAL JOIN Song_Artist WHERE user_id=:user_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

// ======================================================
// access
// ======================================================
function get_access($username) {
    global $db;
    $user_id = getUserId($username);
    $query = "SELECT * FROM Has_Individual_Access WHERE user_id=:user_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function grantIndividualAccess($username, $playlist_id) {
}

// ======================================================
// Friend_Group
// ======================================================
function groupNameExists($group_name) {
    global $db;
    $query = "SELECT friend_group_id FROM Friend_Group WHERE group_name=:group_name";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':group_name', $group_name);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return !(empty($result));
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function getGroupId($group_name) {
    global $db;
    $query = "SELECT friend_group_id FROM Friend_Group WHERE group_name=:group_name";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':group_name', $group_name);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result[0]['friend_group_id'];
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function getGroupName($friend_group_id) {
    global $db;
    $query = "SELECT group_name FROM Friend_Group WHERE friend_group_id=:friend_group_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':friend_group_id', $friend_group_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result[0]['group_name'];
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function addToGroup($username, $group_name) {
    global $db;
    $query = "INSERT INTO Belongs_To (friend_group_id, user_id) VALUES (:friend_group_id, :user_id)";
    $friend_group_id = getGroupId($group_name);
    $user_id = getUserId($username);
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':friend_group_id', $friend_group_id);
        $statement->bindValue(':user_id', $user_id); // Corrected method name
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function createGroup($username, $group_name) {
    global $db;
    $query = "INSERT INTO Friend_Group (group_name, creator) VALUES (:group_name, :creator)";
    $user_id = getUserId($username);
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':group_name', $group_name);
        $statement->bindValue(':creator', $user_id);
        $statement->execute();
        $statement->closeCursor();
        addToGroup($username, $group_name);
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function retrieveUserFriendGroups($username) {
    global $db;
    $user_id = getUserId($username);
    $query = "SELECT * FROM Belongs_To WHERE user_id=:user_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id); // Corrected method name
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function removeUserFromFriendGroup($username, $friend_group_id) {
    global $db;
    $user_id = getUserId($username);
    $query = "DELETE FROM Belongs_To WHERE friend_group_id=:friend_group_id AND $user_id=:user_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':friend_group_id', $friend_group_id);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

// ======================================================
// reccomend songs by artist
// ======================================================
function artistsInPlaylists($username) {
    global $db;
    $user_id = getUserId($username);
    $query = "SELECT DISTINCT artist_name FROM Playlist NATURAL JOIN Listed_In NATURAL JOIN Song_Artist WHERE user_id=:user_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id); // Corrected method name
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function artistsInFavorites($username) {
    global $db;
    $user_id = getUserId($username);
    $query = "SELECT DISTINCT artist_name FROM Favorites NATURAL JOIN Song_Artist WHERE user_id=:user_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id); // Corrected method name
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function artistsInFavoritesPlaylist($username) {
    $artistInFavorites = artistsInFavorites($username);
    $artistsInPlaylists = artistsInPlaylists($username);
    $combined_artists = array_merge($artistInFavorites, $artistsInPlaylists);
    $unique_artists = array_unique($combined_artists, SORT_REGULAR);
    return $unique_artists;
}

function getFavoritesSongsAsList($username) {
    $favorite_songs = getFavorites($username);
    $favorite_song_ids = array_column($favorite_songs, 'song_id');
    $favorite_song_list = implode("', '", $favorite_song_ids);
    return $favorite_song_list;
}

function getSongsInPlaylistAsList($username) {
    $playlist_songs = getSongsInUserPlaylist($username);
    $playlist_song_ids = array_column($playlist_songs, 'song_id');
    $playlist_song_list = implode("', '", $playlist_song_ids);
    return $playlist_song_list;
}

function reccomendSongsByArtists($username) {
    global $db;

    $artists = artistsInFavoritesPlaylist($username);
    $artist_list = resultToList($artists);

    $favorite_song_list = getFavoritesSongsAsList($username);
    $playlist_song_list = getSongsInPlaylistAsList($username);

    $query = "SELECT * FROM Song NATURAL JOIN Song_Artist WHERE artist_name IN ('$artist_list') AND song_id NOT IN ('$favorite_song_list') AND song_id NOT IN ('$playlist_song_list')";

    try {
        $statement = $db->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $result_length = count($result);
        if ($result_length < 10) {
            return $result;
        } else {
            shuffle($result);
            $result = array_slice($result, 0, 10);
            return $result;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

// ======================================================
// reccomend songs by valence
// ======================================================
function calculateAverageEnergy($username) {
    global $db;

    $favorite_songs = getFavorites($username);
    $playlist_songs = getSongsInUserPlaylist($username);
    
    $favorite_energies = array_column($favorite_songs, 'energy');
    $playlist_energies = array_column($playlist_songs, 'energy');

    $combined_energies = array_merge($favorite_energies, $playlist_energies);
    $average_energy = count($combined_energies) > 0 ? array_sum($combined_energies) / count($combined_energies) : 0;
    return $average_energy;
}

function reccomendSongsByEnergy($username) {
    global $db;

    $avg_energy = calculateAverageEnergy($username);
    $favorite_song_list = getFavoritesSongsAsList($username);
    $playlist_song_list = getSongsInPlaylistAsList($username);
    $query = "SELECT song_id, track_name, (energy - :avg_energy) AS energy_diff FROM Song 
                WHERE (energy - :avg_energy) > 0 AND song_id NOT IN ('$favorite_song_list') AND song_id NOT IN ('$playlist_song_list')
                ORDER BY energy_diff";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':avg_energy', $avg_energy, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $result_length = count($result);
    
        if ($result_length < 10) {
            return $result;
        } else {
            shuffle($result);
            $result = array_slice($result, 0, 10);
            return $result;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}