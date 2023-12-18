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
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="hdr">
        <h1>PENDAFTARAN ASISTEN PRAKTIKUM</h1>

        <form action="" method="post">
            <input type="text" name="nim" placeholder="NIM" required>
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="text" name="prodi" placeholder="Program Studi" required>
            <button type="submit" name="tambah">Submit</button>
        </form>

        <div class="message">
            <?php
            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "mahasiswa";
            $koneksi = new mysqli($host, $username, $password, $database);

            if ($koneksi->connect_error) {
                die("Koneksi database gagal: " . $koneksi->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
                $nim = $_POST['nim'];
                $nama = $_POST['nama'];
                $prodi = $_POST['prodi'];

                $query_tambah = "INSERT INTO datamahasiswa (nim, nama, prodi) VALUES ('$nim', '$nama', '$prodi') 
                ON DUPLICATE KEY UPDATE nama = '$nama', prodi = '$prodi'";

                if ($koneksi->query($query_tambah) === TRUE) {
                    echo "Data pendaftaran berhasil ditambahkan.";
                } else {
                    echo "Error: " . $query_tambah . "<br>" . $koneksi->error;
                }
            }
            ?>
        </div>

        <?php
        $query_tampilkan = "SELECT * FROM datamahasiswa";
        $result = $koneksi->query($query_tampilkan);

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>NIM</th><th>Nama</th><th>Program Studi</th><th>Aksi</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['nim']."</td>";
                echo "<td>".$row['nama']."</td>";
                echo "<td>".$row['prodi']."</td>";
                echo "<td><a href='edit.php?nim=".$row['nim']."'>Edit</a> | <a href='delete.php?nim=".$row['nim']."'>Hapus</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ada data pendaftar.</p>";
        }
        ?>

        <h1>DATA PENDAFTAR</h1>
        <form action="" method="get">
            <select name="prodi">
                <option value="">-- Pilih Program Studi</option>
                <?php
                $query_program_studi = "SELECT DISTINCT prodi FROM datamahasiswa";
                $result_program_studi = $koneksi->query($query_program_studi);

                while ($row = $result_program_studi->fetch_assoc()) {
                    echo "<option value='" . $row['prodi'] . "'>" . $row['prodi'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="cari">Cari</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cari']) && isset($_GET['prodi'])) {
            $prodi = $koneksi->real_escape_string($_GET['prodi']);

            $query_cari = "SELECT * FROM datamahasiswa WHERE prodi = '$prodi'";
            $result_cari = $koneksi->query($query_cari);

            if ($result_cari->num_rows > 0) {
                echo "<h2>Hasil Pencarian</h2>";
                echo "<table border='1'>";
                echo "<tr><th>NIM</th><th>Nama</th><th>Program Studi</th><th>Aksi</th></tr>";
                while ($row = $result_cari->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['nim']."</td>";
                    echo "<td>".$row['nama']."</td>";
                    echo "<td>".$row['prodi']."</td>";
                    echo "<td><a href='edit.php?nim=".$row['nim']."'>Edit</a> | <a href='delete.php?nim=".$row['nim']."'>Hapus</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Data tidak ditemukan.</p>";
            }
        }

        $koneksi->close();
        ?>
    </div>
</body>
</html>
