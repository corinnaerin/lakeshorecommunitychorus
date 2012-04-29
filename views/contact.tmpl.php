<!DOCTYPE html>
<html>
<head>
<title>Lakeshore Community Chorus - Contact Us</title>
<?php include ("_partials/head.php"); ?>
</head>
<body>
<?php include ("_partials/header.php"); ?>
<br>
<div class="greybox">
    <div id="contactFormMessage">
    <?php
        if (isset($usrMessage)) {
            echo $usrMessage;
        }
    ?>
    </div>
    <form action="contact.php" method="post" id="contactform">
        <input type="hidden" name="action" required/>
        Name<br>
        <input type="text" name="name" required><br><br>
        E-mail<br>
        <input type="email" name="email" placeholder="johnsmith@email.com" required><br><br>
        Subject<br>
        <input type="text" name="subject" required><br><br>
        Message<br>
        <textarea rows="5" cols="40" name="message" required></textarea><br><br>
        <div align="center">
            <input type="submit" name="send" value="Send">
        </div>
    </form>
</div>
<?php include ("_partials/footer.php"); ?>
<script src="js/message.js"></script>
</body>
</html>