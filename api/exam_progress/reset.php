<?php 

header("Content-Type: application/json; charset=UTF-8");
include_once "../handler.php";

// menggabungkan kode dari file kota.php
// yg mana model kota dibutuhkan
// untuk query
include("../../model/exam_progress.php");

// menggabungkan kode dari file db.php
// yg mana db digunakan untuk memanggil koneksi
// ke database
include("../../model/db.php");


// fungsi yg akan dipanggil untuk
// menghandle request yg dikirim client
$data = handle_request();

$usr = new exam_progress();
$result = $usr->reset(get_connection(include("../config.php")),$data->course_id,$data->user_id);

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>