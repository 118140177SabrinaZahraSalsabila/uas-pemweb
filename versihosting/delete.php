<!--
  Nama        : Sabrina Zahra Salsabila
  NIM         : 118140177
  Kelas       : RC
  Link GitHub : https://github.com/118140177SabrinaZahraSalsabila/uas-pemweb
  Web Hosting : https://118140177uaspemweb.000webhostapp.com/
-->

<?php

$host = "localhost";
$username = "id21685716_root";
$password = "Darminto26-"; 
$database = "id21685716_mahasiswa";
$koneksi = new mysqli('localhost', 'id21685716_root', 'Darminto26-', 'id21685716_mahasiswa');


if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    $query_hapus = "DELETE FROM datamahasiswa WHERE nim = '$nim'";
    
    if ($koneksi->query($query_hapus) === TRUE) {
        header("Location: index.php"); 
        exit();
    } else {
        echo "Error: " . $query_hapus . "<br>" . $koneksi->error;
    }
}
?>