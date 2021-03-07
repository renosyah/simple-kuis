<?php

    // fungsi yg akan digunakan untuk membuat string acak
    // sebagai filler
    function generate_random_string($length = 10) {

        // karakter yg digunakan
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // panjang string yang akan digenerate
        $charactersLength = strlen($characters);

        // deklarasi string kosong
        $randomString = '';

        // untuk setiap panjang
        for ($i = 0; $i < $length; $i++) {

            // tambahkan ke variabel
            // string kosong
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // return string acak
        // sebagai hasil dari fungsi
        return $randomString;
    }
?>