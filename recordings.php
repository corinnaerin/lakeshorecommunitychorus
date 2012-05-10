<?php
    include ('funcs.php');
    if (checkLogon()) {
        if (isXHR()) {
            echo json_encode(getRecordings());
            return;
        } else {
            include ('views/recordings.tmpl.php');
        }
    }
?>