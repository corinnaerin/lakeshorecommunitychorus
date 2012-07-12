<?php

function isXHR() {
    return isset( $_SERVER['HTTP_X_REQUESTED_WITH'] );
}

function connect() {
    global $pdo;
//     $pdo = new PDO("mysql:host=localhost;dbname=lcc", "lakeshorecc", "qz4ULZVcEKNcmxGm");
    $pdo = new PDO("mysql:host=lakeshorecommunitych.ipagemysql.com;dbname=lakeshorecc", "lakeshorecc", "qz4ULZVcEKNcmxGm");
}

function getUserByUsername($username) {
    global $pdo;
    
    $stmt = $pdo->prepare('
        SELECT user_id, first_name, username, password, admin, vocal_part
        FROM user
        WHERE username = :username
        LIMIT 1
    ');
    
    $stmt->execute(array (':username' => $username));
    
    return $stmt->fetchAll( PDO::FETCH_OBJ );
}

function getUserByID() {
    global $pdo;

    $stmt = $pdo->prepare('
        SELECT *
        FROM user
        WHERE user_id = :user_id
        LIMIT 1
    ');

    $stmt->execute(array (':user_id' => $_POST['user_id']));

    return $stmt->fetchAll( PDO::FETCH_OBJ );
}

function getRecordings() {
    global $pdo;
    $filter = $_POST['user-filter'];

    $query = 'SELECT title, vocal_part, sequence, type, filename
        FROM recording';
    $params = array();
    
    if ($filter != "All") {
        $query = "$query WHERE vocal_part LIKE :filter";
        
        if ($filter != "Accompaniment" && $filter != "Performance") {
            $query = "$query OR vocal_part = 'Accompaniment'
            				 OR vocal_part = 'Performance'";
        }

        $params[':filter'] = "%$filter%";
    }
    
    $query = "$query ORDER BY title, vocal_part, sequence";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    
    return $stmt->fetchAll( PDO::FETCH_OBJ );
}

function getUsers() {
    $order_by = $_POST['user-order-by'];
    $filter = $_POST['user-filter'];
    global $pdo;
    
    $query = "SELECT * from user ";
    $params = array ();
    
    if ($filter != "All") {
        $query = "$query WHERE vocal_part = :filter";
        $params[':filter'] = $filter;
    }
    
    $query = "$query ORDER BY $order_by";
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
                setcookie('lcc-vocal-part', $user->vocal_part);
                $loginSuccess = true;
            }
        }
    
        if ( isXHR() ) {
            echo $message;
            return false;
        }
    
    } else if (!cookieExists('lcc-user-id')) {
        header("Location: index.php");
    }
    
    return true;
}

function saveUser() {
    global $pdo;
    $userID = $_POST['user_id'];
    
    if (isset($_POST['confirm_password']) && ($_POST['confirm_password'] != $_POST['password'])) {
        die(json_encode(array("1", "Passwords must match.")));
    }
    
    foreach($_POST as $key => $value) {
        $params[':'.$key] = $value;
    }
    if (strlen($params[':dob']) > 0) {
        $params[':dob'] = '2011/'.$params[':dob'];
    }
    
    if ($userID > 0) {
        unset($params[':confirm_password']);
        $query =
            "UPDATE user SET
            first_name = :first_name,
            last_name = :last_name,
            email_address = :email_address,
            cell_phone = :cell_phone,
            home_phone = :home_phone,
            vocal_part = :vocal_part,
            folder_num = :folder_num,
            dob = :dob";
        
        if(isset($params[':password']) && $params[':password'] != "") {
            $params[':password'] = sha1($params[':password']);
            $query = $query.", password = :password";
        } else {
            unset($params[':password']);
        }
        
        $query = $query." WHERE user_id = :user_id";
    } else {
        $username = strtolower(substr($_POST['first_name'], 0, 1).$_POST['last_name']);
        
        $params[':username'] = $username;
        $params[':password'] = sha1($username);
        
        unset($params[":user_id"]);
        $query =
            "INSERT INTO user (
                username, password, first_name, last_name, email_address, cell_phone, home_phone,
                vocal_part, folder_num, dob
            ) VALUES (
                :username, :password, :first_name, :last_name, :email_address, :cell_phone, :home_phone,
                :vocal_part, :folder_num, :dob
            )";
    }
    
    $stmt = $pdo->prepare($query);
    if (!$stmt->execute($params)) {
        echo json_encode($stmt->errorInfo());
    }
}

function deleteUser() {
    global $pdo;
    
    $query = "DELETE FROM user WHERE user_id = :user_id";
    
    $stmt = $pdo->prepare($query);
    if (!$stmt->execute(array(':user_id' => $_POST['user_id']))) {
        echo json_encode($stmt->errorInfo());
    }
}

function cookieExists($name) {
    return isset($_COOKIE[$name]) && strlen($_COOKIE[$name]) > 0;
}

function getCookie($name) {
    if (cookieExists($name)) {
        return $_COOKIE[$name];
    }
    return null;
}

?>