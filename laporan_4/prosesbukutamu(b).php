<!DOCTYPE html>
<html lang="en">
<head>
    <title>Buku Tamu</title>
</head>
<body>
    <?php
        // Periksa apakah variabel-variabel ada sebelum mengaksesnya
        $nama = isset($_POST["nama"]) ? $_POST["nama"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $komentar = isset($_POST["komentar"]) ? $_POST["komentar"] : "";
    ?>
    <h1>Data Buku Tamu</h1>
    <hr>
    Nama Anda: <?php echo $nama; ?>
    <br>
    Email Address: <?php echo $email; ?>
    <br>
    Komentar:<textarea name="komentar" cols="40" rows="5"><?php echo $komentar; ?></textarea>
    <br>
</body>
</html>
