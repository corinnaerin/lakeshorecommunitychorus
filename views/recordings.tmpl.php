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
        <td>{{titleAndSequence this}}</td>
        <td>{{vocal_part}}</td>
		<td>{{type}}</td>
        <td>
            <audio controls>
                <source src="recordings/{{filename}}.mp3" type="audio/mpeg"></source>
                <source src="recordings/{{filename}}.ogg" type="audio/ogg"></source>
				Your browser does not support audio files. Please upgrade your browser or use the download
				link to the right.
            </audio><br>
            
        </td>
		<td>
			<a href="recordings/{{filename}}.mp3" class="icon_download">Download</a>
		</td>
    </tr>
    {{/each}}
</script>
<form id="recordings-form">

</form>
<table class="resultsTable">
    <thead>
        <tr>
            <td>Title</td>
            <td>Part</td>
            <td>Type</td>
            <td>Recording</td>
            <td></td>
        </tr>
    </thead>
    <tbody id="recordings">
    
    </tbody>
</table>
<?php } ?>
<?php include ("_partials/footer.php"); ?>
<script src="/js/tableData.js"></script>
<script src="/js/manageuser.js"></script>
<script src="/js/recordings.js"></script>
</body>
</html>