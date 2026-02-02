<?php
if (isset($_POST['file_path'])) {
	$_file_path = $_POST['file_path'];
	if(file_exists($_file_path)){
		unlink($_file_path);
	}
}