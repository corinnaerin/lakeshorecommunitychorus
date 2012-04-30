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
        <td><a href="mailto:{{email_address}}">{{email_address}}</a></td>
        <td>{{cell_phone}}</td>
        <td>{{home_phone}}</td>
        <td>{{vocal_part}}</td>
        <td>{{integer folder_num}}</td>
        <td>{{date dob}}</td>
    </tr>
    {{/each}}
</script>
<?php if (isset($_COOKIE['lcc-admin'])  && $_COOKIE['lcc-admin'] == true) { ?>
<div style="float:left;">
    <a href="javscript:void()" id="addUser" data-user-id="0">Add User</a>
</div>
<?php } ?>
<div style="text-align:right;float:right;">
    <form id="user-form">
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
            <td>E-mail Address</td>
            <td>Cell Phone</td>
            <td>Home Phone</td>
            <td>Voice Part</td>
            <td>Folder #</td>
            <td>DOB</td>
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