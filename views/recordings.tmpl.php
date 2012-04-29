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
<script id="recording-tmpl" type="text/x-handlebars-template">
    {{#each this}}
    <tr>
        <td>{{title}}</td>
        <td>{{vocal_part}}</td>
        <td>
            <audio controls>
                <source src="recordings/{{mp3}}" type="audio/mpeg"></source>
                <source src="recordings/{{ogg}}" type="audio/ogg"></source>
            </audio><br>
            <a href="recordings/{{mp3}}">Download</a>
        </td>
    </tr>
    {{/each}}
</script>
<table class="resultsTable">
    <thead>
        <tr>
            <td>title</td>
            <td>part</td>
            <td>recording</td>
        </tr>
    </thead>
</table>
<?php } ?>
<?php include ("_partials/footer.php"); ?>
</body>
</html>