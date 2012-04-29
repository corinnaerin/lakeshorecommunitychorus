<?php
    include ('funcs.php');
    if (checkLogon()) {
        if (isXHR()) {
            echo json_encode(getUsers($_POST['user-order-by'], $_POST['user-filter']));
            return;
        } else {
            include ('views/roster.tmpl.php');
        }
    }
?>