<?php
    include ('funcs.php');
    if (checkLogon()) {
        if (isXHR()) {
            if (isset($_POST['action'])) {
                $action = $_POST['action'];
                unset($_POST['action']);
                switch ($action) {
                    case 'saveUser':
                        saveUser();
                        break;
                    case 'getUser':
                        echo json_encode(getUserByID());
                        break;
                    case 'getUsers':
                        echo json_encode(getUsers());
                        break;
                }
            }
            return;
        } else {
            include ('views/roster.tmpl.php');
        }
    }
?>