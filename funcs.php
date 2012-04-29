<?php

function isXHR() {
    return isset( $_SERVER['HTTP_X_REQUESTED_WITH'] );
}

function connect() {
    global $pdo;
    $pdo = new PDO("mysql:host=localhost;dbname=lcc", "lakeshorecc", "qz4ULZVcEKNcmxGm");
    //$pdo = new PDO("mysql:host=lakeshorecommunitych.ipagemysql.com;dbname=lakeshorecc", "lakeshorecc", "qz4ULZVcEKNcmxGm");
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

function getUsers($order_by, $filter) {
    global $pdo;
    
    $query = "SELECT * from user ";
    $params = array (':order_by' => $order_by);
    
    if ($filter != "All") {
        $query = "$query WHERE vocal_part = :filter";
        $params[':filter'] = $filter;
    }
    
    $query = "$query ORDER BY :order_by";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    
    return $stmt->fetchAll( PDO::FETCH_OBJ );
}

function checkLogon() {
    connect();
    
    global $message;
    $message = "";
    $loginSuccess = false;
    
    if (isset($_POST['username'])) {
        $results = getUserByUsername($_POST['username']);
    
        if ($results == null) {
            $message = "Invalid username.";
        } else {
            $user = $results[0];
            $passwordHash = sha1($_POST['password']);
                
                
            if ($user->password != $passwordHash) {
                $message = "Invalid password.";
            } else {
                $expiration = null;
                $remember = "false";
                if (isset($_POST['remember'])) {
                    $expiration =  60 * 60 * 24 * 60 + time();
                    $remember = "true";
                }
    
                setcookie('lcc-user-id',$user->user_id);
                setcookie('lcc-username',$user->username, $expiration);
                setcookie('lcc-first-name',$user->first_name, $expiration);
                setcookie('lcc-remember', $remember, $expiration);
                setcookie('lcc-admin', $user->admin);
                $loginSuccess = true;
            }
        }
    
        if ( isXHR() ) {
            echo $message;
            return false;
        }
    
    } else if (!isset($_COOKIE['lcc-user-id'])) {
        header("Location: index.php");
    }
    
    return true;
}

?>