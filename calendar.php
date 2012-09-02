<?php
    require_once 'funcs.php';
    if (checkLogon()) {
        include ('views/calendar.tmpl.php');
    }
?>