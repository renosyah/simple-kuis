<?php 

header("Content-Type: application/json; charset=UTF-8");
include_once "../handler.php";

// menggabungkan kode dari file kota.php
// yg mana model kota dibutuhkan
// untuk query
include("../../model/user.php");

// menggabungkan kode dari file db.php
// yg mana db digunakan untuk memanggil koneksi
// ke database
include("../../model/db.php");


// menggabungkan kode dari file list_query
// yg mana list_query digunakan sebagai
// object yg digunakan untuk parameter query
include("../../model/list_query.php");


// fungsi yg akan dipanggil untuk
// menghandle request yg dikirim client
$data = handle_request();
$query = new list_query();
$query->set($data);

$usr = new user();
$result = $usr->all(get_connection(include("../config.php")),$query);

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>