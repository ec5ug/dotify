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