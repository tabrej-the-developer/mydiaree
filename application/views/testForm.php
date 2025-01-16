<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Test Form</title>
</head>
<body>
	<form action="<?= base_url('Reflections/createReflection'); ?>" method="post" enctype="multipart/form-data">
		<input type="text" name="title" placeholder="Title" value="Test Reflection Title v1">
		<br>
		<br>
		<input type="text" name="about" placeholder="About" value="Test Reflection About v1">
		<br>
		<br>
		<input type="hidden" name="status" value="PUBLISHED">
		<input type="hidden" name="centerid" value="1">
		<input type="file" name="refMedia[]" multiple="multiple">
		<br>
		<br>
		<input type="submit" value="submit">
	</form>
</body>
</html>