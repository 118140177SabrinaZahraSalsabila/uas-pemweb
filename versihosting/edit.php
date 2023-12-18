<!--
  Nama        : Sabrina Zahra Salsabila
  NIM         : 118140177
  Kelas       : RC
  Link GitHub : https://github.com/118140177SabrinaZahraSalsabila/uas-pemweb
  Web Hosting : https://118140177uaspemweb.000webhostapp.com/
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UAS Pemrograman Web [118140177]</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="hdr">
    <h1>EDIT DATA PENDAFTAR</h1>
    <?php
    $host = "localhost";
    $username = "id21685716_root";
    $password = "Darminto26-"; 
    $database = "id21685716_mahasiswa";
    $koneksi = new mysqli('localhost', 'id21685716_root', 'Darminto26-', 'id21685716_mahasiswa');

    if ($koneksi->connect_error) {
        die("Koneksi database gagal: " . $koneksi->connect_error);
    }
    $nim_edit = "";
    $nama = "";
    $prodi = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nim'])) {
        $nim = $_GET['nim'];

        $query_edit = "SELECT * FROM datamahasiswa WHERE nim = '$nim'";
        $result_edit = $koneksi->query($query_edit);

        if ($result_edit->num_rows > 0) {
            $row = $result_edit->fetch_assoc();
            $nim_edit = $row['nim'];
            $nama = $row['nama'];
            $prodi = $row['prodi'];
        } else {
            echo "Data pendaftar tidak ditemukan.";
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $nim_edit = $_POST['nim_edit']; 
        $nim_baru = $_POST['nim'];
        $nama = $_POST['nama'];
        $prodi = $_POST['prodi'];

        $query_check_nim = "SELECT * FROM datamahasiswa WHERE nim = '$nim_baru'";
        $result_check_nim = $koneksi->query($query_check_nim);

        if ($result_check_nim->num_rows > 0 && $nim_baru !== $nim_edit) {
            echo "NIM sudah terdaftar! Mohon isi dengan NIM berbeda.";
        } else {

            $query_update = "UPDATE datamahasiswa SET nim = '$nim_baru', nama = '$nama', prodi = '$prodi' WHERE nim = '$nim_edit'";
            
            if ($koneksi->query($query_update) === TRUE) {
                echo "Data pendaftar dengan NIM $nim_edit berhasil diperbarui.";

                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $query_update . "<br>" . $koneksi->error;
            }
        }
    }
    ?>
    
    <form action="" method="post">
        <input type="hidden" name="nim_edit" value="<?php echo $nim_edit; ?>">
        <input type="text" name="nim" value="<?php echo $nim_edit; ?>" required>
        <input type="text" name="nama" value="<?php echo $nama; ?>" required>
        <input type="text" name="prodi" value="<?php echo $prodi; ?>" required>
        <button type="submit" name="update">Submit</button>
    </form>
    </div>
</body>
</html>
