<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>
	<?php
		echo json_encode(array('a'=>1, 'b'=>2), JSON_PRETTY_PRINT);
	?>
</body>
</html>