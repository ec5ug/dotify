<?php
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

function inFavorites($user_id, $song_id) {
    global $db;
    $user_id = getUserId($username);
    $query = "SELECT * FROM Favorites WHERE $user_id=:user_id AND $song_id=:song_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':song_id', $song_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if (!empty($result)) {
        return True;
    } else {
        return False;
    }
}

function addToFavorites($user_id, $song_id) {
    global $db;
    $user_id = getUserId($username);
    if not inFavorites($user_id, $song_id) {
        $query = "INSERT INTO Favorites(user_id, song_id) VALUES(:user_id, :song_id)";
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
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

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