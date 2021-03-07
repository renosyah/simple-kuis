<?php 

header("Content-Type: application/json; charset=UTF-8");
include("../model/result_query.php");
include("../util/generator.php");

$result = new result_query();
$result->data = null;

$file_name		 = $_FILES['file']['name'];
$tmp_file	 	 = $_FILES['file']['tmp_name'];
$type_file		 = $_FILES['file']['type'];
$file_size		 = $_FILES['file']['size'];

$maxsize_file = 1000000;
$allowed_ext =  array('image/png', 'image/jpg','image/jpeg');

if (!in_array($type_file, $allowed_ext)) {
    $result->error = "file extension is not allowed!";
    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	exit;
}

if ($file_size > $maxsize_file) {
    $result->error = "file size is too big!";
    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	exit;
}

$ext = pathinfo($file_name, PATHINFO_EXTENSION);
$rand_file_name = generate_random_string(10).".".$ext;

$dir_file = "../img/".$rand_file_name;
move_uploaded_file($tmp_file, $dir_file);

$result->data = array(
    'file_name' => $rand_file_name,
    'url' => "/img/".$rand_file_name,
);

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>