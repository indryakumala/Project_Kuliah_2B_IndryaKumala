<?php
session_start();

// Membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_nutrimanagenutri");

//menambah produk baru
if (isset($_POST['addnewproduk'])) {
    $foto = $_POST['fotoproduk'];
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stokproduk = $_POST['stok'];

    //soal gambar
    $allowed_extension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //mengambil nama gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); // mengambil ekstensi
    $ukuran = $_FILES['file']['size']; // mengambil size filenya
    $file_tmp = $_FILES['file']['tmp_name']; //mengambil lokasi file

    //penamaan file -> engkripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; //menggabungkan nama file yg diengkripsi dengan ekstensinya
    $addtotable = mysqli_query($conn, "INSERT INTO stok_produk (foto, nama_produk, deskripsi, stok_produk) values ('$foto', '$namaproduk', '$deskripsi', $stokproduk)");
    if ($addtotable) {
        header('location:stok.php');
    } else {
        echo 'Gagal';
        header('location:stok.php');
    }
}
;

// menambah produk masuk
if (isset($_POST['produkmasuk'])) {
    $produk = $_POST['produk'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstoksekarang = mysqli_query($conn, "SELECT * FROM stok_produk WHERE idproduk='$produk'");
    $ambildata = mysqli_fetch_array($cekstoksekarang);

    $stoksekarang = $ambildata['stok_produk'];
    $tambahakanstoksekarangdenganquantity = $stoksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "INSERT INTO produk_masuk (idproduk, keterangan, qty) values ('$produk', '$keterangan', '$qty')");
    $updatestokmasuk = mysqli_query($conn, "UPDATE stok_produk SET stok_produk='$tambahakanstoksekarangdenganquantity' WHERE idproduk='$produk'");
    if ($addtomasuk && $updatestokmasuk) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}


// menambah produk keluar
if (isset($_POST['addprodukkeluar'])) {
    $produk = $_POST['produk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstoksekarang = mysqli_query($conn, "SELECT * FROM stok_produk WHERE idproduk='$produk'");
    $ambildata = mysqli_fetch_array($cekstoksekarang);

    $stoksekarang = $ambildata['stok_produk'];
    $tambahakanstoksekarangdenganquantity = $stoksekarang - $qty;

    $addtomasuk = mysqli_query($conn, "INSERT INTO produk_keluar (idproduk, penerima, qty) values ('$produk', '$penerima', '$qty')");
    $updatestokmasuk = mysqli_query($conn, "UPDATE stok_produk SET stok_produk='$tambahakanstoksekarangdenganquantity' WHERE idproduk='$produk'");
    if ($addtomasuk && $updatestokmasuk) {
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}

//update info barang
if (isset($_POST['updateproduk'])) {
    $idproduk = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn, "UPDATE stok_produk SET nama_produk= '$namaproduk', deskripsi='$deskripsi' WHERE idproduk ='$idproduk'");
    if ($update) {
        header('location:stok.php');
    } else {
        echo 'Gagal';
        header('location:stok.php');
    }

}

// menghapus produk dari stok
if (isset($_POST['deleteproduk'])) {
    $idproduk = $_POST['idproduk'];

    $hapus = mysqli_query($conn, "DELETE FROM stok_produk WHERE idproduk='$idproduk'");
    if ($hapus) {
        header('location:stok.php');
    } else {
        echo 'Gagal';
        header('location:stok.php');
    }
}

//mengubah data produk masuk
if (isset($_POST['updateprodukmasuk'])) {
    $idproduk = $_POST['idproduk'];
    $idm = $_POST['idmasuk'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstok = mysqli_query($conn, "SELECT * FROM stok_produk WHERE idproduk='$idproduk'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stokskrg = $stoknya['stok_produk'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM produk_masuk WHERE idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stokskrg - $selisih;
        $kurangistoknya = mysqli_query($conn, "UPDATE stok_produk SET stok_produk='$kurangin' WHERE idproduk='$idproduk'");
        $updatenya = mysqli_query($conn, "UPDATE produk_masuk set qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");
        if ($kurangistoknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stokskrg + $selisih;
        $kurangistoknya = mysqli_query($conn, "UPDATE stok_produk SET stok_produk='$kurangin' WHERE idproduk='$idproduk'");
        $updatenya = mysqli_query($conn, "UPDATE produk_masuk set qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");
        if ($kurangistoknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    }
}

// menghapus produk masuk
if (isset($_POST['deleteprodukmasuk'])) {
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['kty'];
    $idm = $_POST['idmasuk'];

    $getdatastok = mysqli_query($conn, "SELECT * FROM stok_produk WHERE idproduk='$idproduk'");
    $data = mysqli_fetch_array($getdatastok);
    $stok = $data['stok_produk'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn,"UPDATE stok_produk set stok_produk='$selisih' WHERE idproduk='$idproduk'");
    $hapusdata = mysqli_query($conn,"DELETE FROM produk_masuk WHERE idmasuk='$idm'");

    
    if ($update && $hapusdata) {
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}
?>