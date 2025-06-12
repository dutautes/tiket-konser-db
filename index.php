<?php 
include 'proses.php';
include 'koneksi.php';

$proses = new Beli();
$proses->setHarga(700000, 1300000, 2000000, 2700000);
$proses->getFasilitas('Masuk Reguler', 'Free Minuman', 'Snack dan Minuman', 'meet & greet + souvenir');
if(isset($_POST['submit'])) {
    $proses->jumlah = $_POST['jumlah'];
    $proses->jenis = $_POST['jenis'];
    $proses->nama = $_POST['nama'] ?? 'Anonim';

    $proses->hargaBeli();
    $proses->simpanPembelian($conn);
    
    // agar tidak tersubmit ulang saat user mereload website nya
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

$dataPembelian = $proses->ambilSemua($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="XU-A-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Konser Hearts2Hearts</title>
    <!-- style -->
    <style>
        .baner {
            object-fit: cover;
            width: 100%;
            height: 100%;
            max-height: 400px;
        }
        .divv {
            height: 400px;
            overflow: hidden;
        }
        .judul {
            padding-top: 19rem;
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="card text-bg-dark divv border-0">
        <img src="assets/logo.webp" class="card-img baner" alt="h2h-logo">
        <div class="card-img-overlay">
            <h5 class="card-title judul fw-bold fs-1 text-secondary">Pembelian Tiket Hearts2Hearts</h5>
        </div>
    </div>
        
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body p-4">
                <form action="" onsubmit="pembelianBerhasil()" method="post">
                    <div>
                        <p class="fw-bold fs-3 text-secondary">Form Pembelian</p>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pelanggan</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jumlah_tiket" class="form-label">Jumlah Tiket</label>
                        <input type="number" id="jumlah_tiket" name="jumlah" class="form-control" placeholder="Jumlah tiket yang dibeli" min="1">
                    </div>
                    
                    <div class="mb-4">
                        <label for="jenis" class="form-label">Jenis Tiket</label>
                        <select name="jenis" id="jenis" class="form-select" required>
                            <option value="" disabled selected>Pilih jenis tiket</option>
                            <option value="Silver">Silver - Rp 700.000 - Masuk Reguler</option>
                            <option value="Platinum">Platinum - Rp 1.300.000 - Free Minuman</option>
                            <option value="Premium">Premium - Rp 2.000.000 - Snack dan Minuman</option>
                            <option value="VIP">VIP - Rp 2.700.000 - Meet & Greet + Souvenir</option>
                        </select>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg">Beli Tiket</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="my-5">
        
        <div class="text-center mb-4">
            <h2 class="fw-bold">Data Riwayat Pembelian Tiket</h2>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jumlah Tiket</th>
                        <th>Jenis</th>
                        <th>Total Harga</th>
                        <th>Tanggal</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 1;
                        foreach ($dataPembelian as $row) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $no++ . "</th>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $row['jumlah_tiket'] . "</td>";
                            echo "<td>" . $row['jenis_tiket'] . "</td>";
                            echo "<td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                            echo "<td>" . $row['tanggal'] . "</td>";
                            echo "<td><a href='detail.php?id=" . $row['id'] . "' class='btn btn-sm btn-outline-primary' target='_blank'>Detail</a></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="card-footer text-body-secondary">

        <p class="text-center">&copy; Duta Suksesi F.  #pplgwajibngulik</p>
    </footer>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous"></script>
    <script>
        function pembelianBerhasil() {
            alert("Pembelian Tiket Berhasil");
            return true;
        }
    </script>
</body>
</html>