<?php

function isXHR() {
	return isset( $_SERVER['HTTP_X_REQUESTED_WITH'] );
}

function connect() {
	global $pdo;
	$pdo = new PDO("mysql:host=localhost;dbname=lcc", "lakeshorecc", "qz4ULZVcEKNcmxGm");
}

function getUserByUsername($username) {
	global $pdo;
	
	$stmt = $pdo->prepare('
		SELECT user_id, first_name, username, password, admin
		FROM user
		WHERE username = :username
		LIMIT 1
	');
	
	$stmt->execute(array (':username' => $username));
	
	return $stmt->fetchAll( PDO::FETCH_OBJ );
}

function getRecordings() {
	global $pdo;

	$stmt = $pdo->prepare('
		SELECT title, vocal_part, mp3, ogg
		FROM recording
		');
	
	$stmt->execute();
	
	return $stmt->fetchAll( PDO::FETCH_OBJ );
}

?>