</section>
<footer id="lcc_footer">
    <small>
        &copy; 2011 Lakeshore Community Chorus. Design by Corinna Schmidt.<br>
        PO Box 253 Douglas MI 49406<br>
        269-857-2837
    </small>
</footer>
<script src="/js/login.js"></script>
<script src="/js/logout.js"></script>

<?php if (cookieExists('lcc-first-name')) { ?>
<script src="http://cloud.github.com/downloads/wycats/handlebars.js/handlebars-1.0.0.beta.6.js"></script>
<script src="/js/modalwin.js"></script>
<div id="user-close" style="display:none;"><img src="/images/close.png"></div>
<script id="manage-user-tmpl" type="text/x-handlebars-template">
<div class="modal_header">
    Manage User
</div>
<div id="results_message" style="text-align:center;padding:5px;"></div>
<form id="manageUser" method="post">
<input type="hidden" name="action" value="saveUser">
<input type="hidden" name="user_id" value="{{user_id}}" id="user_id">
    <table style="width:100%;">
        <tr>
            <td>First Name:</td>
            <td><input type="text" name="first_name" value="{{first_name}}" required></td>
            <td>Voice Part:</td>
            <td>
                <select name="vocal_part">
                    <option value=""></option>
                    <option value="Soprano" {{selected vocal_part "Soprano"}}>Soprano</option>
                    <option value="Alto" {{selected vocal_part "Alto"}}>Alto</option	>
                    <option value="Tenor" {{selected vocal_part "Tenor"}}>Tenor</option>
                    <option value="Bass" {{selected vocal_part "Bass"}}>Bass</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><input type="text" name="last_name" value="{{last_name}}" required></td>
            <td>Folder #:</td>
            <td><input type="text" name="folder_num" value="{{integer folder_num}}" maxlength="3"></td>
        </tr>
        <tr>
            <td>E-mail Address:</td>
            <td><input type="email" name="email_address" value="{{email_address}}"></td>
            <td>Date of Birth:</td>
            <td><input type="text" name="dob" value="{{date dob}}" maxlength="5" pattern="[0-1][0-9]?/[0-3][0-9]?"> (MM/dd)</td>
        </tr>
        <tr>
            <td>Cell Phone:</td>
            <td><input type="text" name="cell_phone" value="{{cell_phone}}" maxlength="10"></td>
            <td><div class="password">New Password:</div></td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td>Home Phone:</td>
            <td><input type="text" name="home_phone" value="{{home_phone}}" maxlength="10"></td>
            <td><div class="password">Confirm Password:</div></td>
            <td><input type="password" name="confirm_password"></td>
        </tr>
    </table>
    <div style="text-align:center;">
        <input type="submit" value="Save">
    </div>
</form>
</script>
<?php } ?>