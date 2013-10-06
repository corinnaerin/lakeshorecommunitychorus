<header id="lcc_header">
    <?php
        require_once '/home/users/web/b441/ipg.lakeshorecommunitych/funcs.php';
//        require_once '/funcs.php';
        if (cookieExists('lcc-first-name')) {
            $firstname = getCookie('lcc-first-name');
            $username = getCookie('lcc-username');
        }
        if ((cookieExists('lcc-user-id') && isset($firstname)) || (isset($loginSuccess) && $loginSuccess)) {
    ?>
    <div id="welcome">Welcome,
        <a href="javascript:void(0);" class="modifyUser" data-user-id="<? echo getCookie('lcc-user-id'); ?>">
            <?php echo $firstname; ?></a>.
        <button id="logout">Logout</button></div>
    <?php }  else { ?>
    <button id="login-open">Login</button><br>
    <form action="/recordings.php" method="post" id="login-win">
        <div id="login-close"><img src="/images/close.png"></div>
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
<section class="lcc_section">
<?php
if ((cookieExists('lcc-user-id') && isset($firstname)) || (isset($loginSuccess) && $loginSuccess)) {
//    include '/_partials/links.php';
     include '/home/users/web/b441/ipg.lakeshorecommunitych/_partials/links.php';
} ?>