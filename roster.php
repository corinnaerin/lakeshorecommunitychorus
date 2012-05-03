<?php
    include ('funcs.php');
    if (checkLogon()) {
        if (isXHR()) {
            if (isset($_POST['user_id'])) {
                saveUser();
            } else if (isset($_POST['get_user_id'])) {
                echo json_encode(getUserByID());
            } else if (isset($_POST['user-order-by'])) {
                echo json_encode(getUsers());
            }
            return;
        } else {
            include ('views/roster.tmpl.php');
        }
    }
?>