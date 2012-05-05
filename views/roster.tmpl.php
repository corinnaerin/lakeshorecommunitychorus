<!DOCTYPE html>
<html>
<head>
    <title>Lakeshore Community Chorus</title>
    <?php include ("_partials/head.php"); ?>
</head>
<body>
<?php include ("_partials/header.php");?>
<?php if ($message != "") { ?>
    <div style="text-align:center">
        <?php echo $message ?>
    </div>
<?php } else { ?>
<script id="user-tmpl" type="text/x-handlebars-template">
    {{#each this}}
    <tr>
        <td>{{first_name}}</td>
        <td>{{last_name}}</td>
        <td>{{phoneNbr cell_phone}}</td>
        <td>{{phoneNbr home_phone}}</td>
        <td>{{vocal_part}}</td>
        <td>{{integer folder_num}}</td>
        <td>{{date dob}}</td>
        <td style="text-align:right">
            <a href="mailto:{{email_address}}" id="{{email_address}}" class="email"><img src="/images/email.png"></a>
            <a href="javascript:void(0);" class="modifyUser" data-user-id="{{user_id}}"><img src="/images/cog.png"></a>
            <a href="javascript:void(0);" class="removeUser" data-user-id="{{user_id}}" data-name="{{fullName this}}"><img src="/images/remove.png"></a>
        </td>
    </tr>
    {{/each}}
</script>
<?php if (isset($_COOKIE['lcc-admin'])  && $_COOKIE['lcc-admin'] == true) { ?>
<div style="float:left;margin-top: 10px;">
    <a href="javscript:void(0)" id="addUser" data-user-id="0" class="icon_add">Add User</a>
</div>
<?php } ?>
<div style="text-align:right;float:right;">
    <form id="user-form">
        <input type="hidden" name="action" value="getUsers">
        Order By:
        <select name="user-order-by" class="reload">
            <option value="last_name">Last Name</option>
            <option value="first_name">First Name</option>
            <option value="vocal_part">Voice Part</option>
            <option value="dob">Date of Birth</option>
            <option value="folder_num">Folder #</option>
        </select>
        
        Filter:
        <select name="user-filter" class="reload">
            <option value="All">-- All --</option>
            <option value="Soprano">Soprano</option>
            <option value="Alto">Alto</option>
            <option value="Tenor">Tenor</option>
            <option value="Bass">Bass</option>
        </select>
    </form>
</div>
<table class="resultsTable">
    <thead>
        <tr>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Cell Phone</td>
            <td>Home Phone</td>
            <td>Voice Part</td>
            <td>Folder #</td>
            <td>DOB</td>
            <td>&nbsp;</td>
        </tr>
    </thead>
    <tbody id="roster">
    </tbody>
</table>
<?php }
 include ("_partials/footer.php");
 ?>
<script src="/js/tableData.js"></script>
<script src="/js/users.js"></script>
</body>
</html>