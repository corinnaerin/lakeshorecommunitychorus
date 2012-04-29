<header id="lcc_header">
    <img src="/images/logo.png" alt="Lakeshore Community Chorus">
    <?php 
    	if (isset($_COOKIE['lcc-first-name'])) {
    		$firstname = $_COOKIE['lcc-first-name'];
    	}
    	if ((isset($_COOKIE['lcc-user-id']) && isset($firstname)) || (isset($loginSuccess) && $loginSuccess)) {
     ?>
   			<div id="welcome">Welcome, <?php echo $firstname; ?>.<button id="logout">Logout</button></div>
    <?php 	}  else { ?>
    <button id="login-open">Login</button><br>
    <form action="/recordings.php" method="post" id="login-win">
        <div id="login-close">X</div>
        <div id="login-error"></div>
        Username<br>
        <input type="text" name="username" required value="<?php if (isset($username)) { echo $username; }?>"><br><br>
        Password<br>
        <input type="password" name="password" required><br><br>
        <label><input type="checkbox" name="remember" value="true" <?php if (isset($username)) { echo "checked"; }?>> Remember me on this computer</label>
        <div align="center">
            <input type="submit" value="Login" id="login-submit">
        </div>
    </form>
    <?php } ?>
    <nav>
	   <ul>
	       <li><a href="/index.php">home</a></li>
	       <li><a href="/news">news</a></li>
	       <li><a href="/gallery.php">photo gallery</a></li>
	       <li><a href="/about.php">about</a></li>
	       <li><a href="/contact.php">contact us</a></li>
	   </ul>
	</nav>
</header>