<?php

// fungsi get connection
// yang membutuhkan parameter
// path ke file config.php
function get_connection($configs){

    // menggambil value username
    $username = $configs['username'];

    // menggambil value password
    $password = $configs['password'];

    // menggambil value host
    $host = $configs['host'];

    // menggambil value port
    $port = $configs['port'];

    // menggambil value database
    $dbname = $configs['name'];
    
    // memanggil fungsi mysqli
    // mysqli adalah fungsi untuk 
    // koneksi aman ke database
    // yg saat ini digunakan
    $db = new mysqli($host,$username,$password,$dbname);

    // jika terjadi error
    if ($db->connect_error) {

        // maka program akan dimatikkan
        // dan ditampilkan error
        die("Connection failed: " . $conn->connect_error);
    }

    // mengembalikan object db sebagai hasil
    // dari fungsi koneksi ke database
    return $db;
}


?>