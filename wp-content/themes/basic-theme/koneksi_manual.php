<?php
$host = 'localhost'; // Sesuaikan dengan host database Anda
$username = 'ghost'; // Sesuaikan dengan username database Anda
$password = 'taharica2024'; // Sesuaikan dengan password database Anda
$database = 'staging_eknowledge_baru'; // Sesuaikan dengan nama database Anda

// untuk production pakai kode yang dibawah
// // $host = 'localhost'; // Sesuaikan dengan host database Anda
// // $username = 't1aharicacoid_eknowlegde'; // Sesuaikan dengan username database Anda
// // $password = 'shalatku17'; // Sesuaikan dengan password database Anda
// // $database = 't1aharicacoid_eknowlegde'; // Sesuaikan dengan nama database Anda


// Membuat koneksi
$koneksi = new mysqli($host, $username, $password, $database);

// Memeriksa apakah koneksi berhasil
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
