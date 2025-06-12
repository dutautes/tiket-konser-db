<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
<?php 
    include 'koneksi.php';
    include 'proses.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $proses = new Beli();
        $data = $proses->ambilById($conn, $id);

        if($data) {
            $fasilitas = $proses->getFasilitas($data['jenis_tiket']);

            echo 
            '
            <div class="container mt-5">
                <div class="card mx-auto shadow" style="max-width: 400px;">
                    <div class="card-header text-center bg-primary text-white">
                        <h4 class="mb-0 fs-4 p-1">Struk Pembelian Tiket</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Nama:</strong> ' . $data['nama'] . '</p>
                        <p><strong>Jenis Tiket:</strong> ' . $data['jenis_tiket'] . '</p>
                        <p><strong>Jumlah Tiket:</strong> ' . $data['jumlah_tiket'] . '</p>
                        <p><strong>Fasilitas:</strong> ' . $fasilitas . '</p>
                        <p><strong>Tanggal Pembelian:</strong> ' . $data['tanggal'] . '</p>
                        <hr>
                        <p><strong>Total Bayar:</strong> <span class="fw-bolder ps-5 ms-5 fs-6 text-primary"> Rp. ' . number_format($data['total_harga'], 0, "", ".") . '</span></p>
                    </div>
                    <div class="card-footer text-center">
                    <a href="index.php" class="btn btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
            ';
        } else {
            echo "Data tidak ditemukan";
            echo "<br><br>";
            echo "<a href='index.php'><button class='btn btn-danger'>Kembali ke halaman utama</button></a>";
        }
    }
    ?>
</body>
</html>