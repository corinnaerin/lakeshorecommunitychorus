<?php
    include ('funcs.php');
    if (checkLogon()) {
        include ('views/recordings.tmpl.php');
    }
?>