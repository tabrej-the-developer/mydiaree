<?php

$uploadDir = $_GET['dir'];

$name='';
if (!empty($_FILES)) {
 $tmpFile = $_FILES['file']['tmp_name'];
	$name=base64_encode(file_get_contents($_FILES['file']['tmp_name']));
 $filename = basename(html_entity_decode($_FILES['file']['name'], ENT_QUOTES, 'UTF-8'));
 $filename=time().'-'.$filename;
	//move_uploaded_file($tmpFile,$uploadDir.$filename);
}

echo $name;


?>