<?php
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Stock Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .zoomable {
            width: 100px;
        }

        .zoomable:hover {
            transform: scale(2.5);
            transition: 0.3s ease;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">NutriManageLite</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="stok.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-bag"></i></div>
                            Stock Item
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-cloud-arrow-down-fill"></i></div>
                            Incoming Product
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                            Exit Product
                        </a>
                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-box-arrow-right"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 mb-4">Produk Masuk</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalAddProdukMasuk">
                                Add Incoming Product
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tablemasuk" width="100%" cellspasing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Picture</th>
                                            <th>Name Item</th>
                                            <th>Totality</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $ambilsemuadatastok = mysqli_query($conn, "SELECT * FROM produk_masuk m, stok_produk s where s.idproduk =m.idproduk");
                                        while ($data = mysqli_fetch_array($ambilsemuadatastok)) {
                                            $idproduk = $data['idproduk'];
                                            $idm = $data['idmasuk'];
                                            $tanggal = $data['tanggal'];
                                            $namaproduk = $data['nama_produk'];
                                            $qty = $data['qty'];
                                            $keterangan = $data['keterangan'];

                                            // cek ada gambar atau tidak
                                            $gambar = $data['image']; // ambil gambar
                                            if ($gambar == null) {
                                                //jika tidak ada gambar
                                                $image = "No Photo";
                                            } else {
                                                //jika ada gambar
                                                $image = '<img src="image/' . $gambar . '" class="zoomable">';
                                            }

                                        ?>
                                            <tr>
                                                <td><?= $tanggal ?></td>
                                                <td><?= $image ?></td>
                                                <td><?= $namaproduk; ?></td>
                                                <td><?= $qty; ?></td>
                                                <td><?= $keterangan; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idm; ?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idm; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idm; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Product</h4>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="text" name="keterangan" value="<?= $keterangan; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="number" name="qty" value="<?= $qty; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="hidden" name="idproduk" value="<?= $idproduk; ?>">
                                                                <input type="hidden" name="idmasuk" value="<?= $idm; ?>">
                                                                <button type="submit" class="btn btn-primary" name="updateprodukmasuk">Submit</button>
                                                            </div>
                                                        </form>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?= $idm; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Product</h4>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus <?= $namaproduk; ?>?
                                                                <br>
                                                                <input type="hidden" name="idproduk" value="<?= $idproduk; ?>">
                                                                <input type="hidden" name="idmasuk" value="<?= $idm; ?>">
                                                                <input type="hidden" name="qty" value="<?= $qty; ?>">
                                                                <button type="submit" class="btn btn-danger" name="deleteprodukmasuk">Delete</button>
                                                            </div>
                                                        </form>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- The Modal for Add Incoming Product -->
    <div class="modal fade" id="ModalAddProdukMasuk">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Tambah Produk Masuk</h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <select name="produknya" class="form-control">
                            <?php
                            $ambilsemuadata = mysqli_query($conn, "SELECT * FROM stok_produk");
                            while ($fetcharray = mysqli_fetch_array($ambilsemuadata)) {
                                $namaproduknya = $fetcharray['nama_produk'];
                                $idproduknya = $fetcharray['idproduk'];
                            ?>
                                <option value="<?= $idproduknya; ?>"><?= $namaproduknya; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <br>
                        <input type="number" name="qty" placeholder="Quantity" class="form-control" required>
                        <br>
                        <input type="text" name="keterangan" placeholder="Description" class="form-control" required>
                        <br>

                        <!-- Button for Barcode Scanner -->
                        <div class="d-flex justify-content-between align-items-center">
                            <input type="text" name="barcode" placeholder="Scan Barcode" class="form-control" id="barcodeInput" required>
                            <button type="button" class="btn btn-outline-secondary ms-2" id="scanBarcodeBtn">
                                <i class="bi bi-camera"></i> Scan
                            </button>
                        </div>
                        <br>

                        <button type="submit" class="btn btn-primary" name="produkmasuk">Submit</button>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Barcode Scanning -->
    <div class="modal fade" id="barcodeScannerModal" tabindex="-1" aria-labelledby="barcodeScannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barcodeScannerModalLabel">Scan Barcode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <video id="barcodeScanner" width="100%" height="400" autoplay></video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
        const scanBarcodeBtn = document.getElementById('scanBarcodeBtn');
        const barcodeInput = document.getElementById('barcodeInput');
        const barcodeScannerModal = new bootstrap.Modal(document.getElementById('barcodeScannerModal'));
        const video = document.getElementById('barcodeScanner');

        // Function to open the camera and start scanning
        scanBarcodeBtn.addEventListener('click', function() {
            barcodeScannerModal.show();
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }).then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                });
            }
        });

        // Use a barcode scanner library (e.g., QuaggaJS) to detect the barcode and set the value to the input field
        // Example using QuaggaJS:
        // Quagga.onDetected(function(result) {
        //     barcodeInput.value = result.codeResult.code;
        //     barcodeScannerModal.hide();
        //     video.srcObject.getTracks().forEach(track => track.stop());
        // });

        // Stop the camera stream when the modal is closed
        barcodeScannerModal._element.addEventListener('hidden.bs.modal', function () {
            video.srcObject.getTracks().forEach(track => track.stop());
        });
    </script>

</body>

</html>
