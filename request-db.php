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
    OR LOWER(track_name) LIKE CONCAT('%', LOWER(:str), '%') 
    OR LOWER(released_year) LIKE CONCAT('%', LOWER(:str), '%')";
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
        return $result;
    } catch (PDOException $e) {
        $e->getMessage();
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function createPlaylist($user_id, $playlist_name){
    global $db;
    $query = "CALL createPlaylist (:user_id, :playlist_name)";
    try {
        $statement = $db->prepare($query);
        // fill in the value
        $statement->bindValue(':user_id', $user_id[0]['user_id']); // Extract user_id from result
        $statement->bindValue(':playlist_name', $playlist_name);
        // execute
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function getPlaylist($user_id) {
    global $db;
    $query = "SELECT * FROM Playlist WHERE user_id=:user_id";
    try {
        if (is_array($user_id)) {
            $user_id = $user_id[0]['user_id'];
        }
        
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