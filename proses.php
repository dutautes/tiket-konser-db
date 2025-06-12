<?php 

class Tiket {
    protected $ppn;

    private $Silver,
            $Platinum,
            $Premium,
            $VIP;

    public $jumlah;
    public $jenis;
    public $nama;

    function __construct() {
        $this->ppn = 0.1;
    }

    public function setHarga($tipe1, $tipe2, $tipe3, $tipe4) {
        $this->Silver = $tipe1;
        $this->Platinum = $tipe2;
        $this->Premium = $tipe3;
        $this->VIP = $tipe4;
    }

    public function getHarga() {
        $data["Silver"] = $this->Silver;
        $data["Platinum"] = $this->Platinum;
        $data["Premium"] = $this->Premium;
        $data["VIP"] = $this->VIP;
        return $data;
    }
}

class Beli extends Tiket {

    public function hargaBeli() {
        $dataHarga = $this->getHarga();
        $jumlah = $this->jumlah;
        $hargaBeli = $jumlah * $dataHarga[$this->jenis];
        $hargaPPN = $hargaBeli * $this->ppn;
        $hargaBayar = $hargaBeli + $hargaPPN;
        return $hargaBayar;
    }

    public function simpanPembelian($conn) {
    $total = $this->hargaBeli();
    
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO pembelian_tiket (nama, jumlah_tiket, jenis_tiket, total_harga, tanggal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $this->nama, $this->jumlah, $this->jenis, $total, $tanggal);

    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    }
    }

    public function getFasilitas($jenis) {
        $fasilitas = [
        'Silver' => 'Masuk reguler',
        'Platinum' => 'Free minuman',
        'Premium' => 'Snack dan minuman',
        'VIP' => 'Meet & Greet + Souvenir'
        ];
        return $fasilitas[$jenis] ?? 'Tidak ada fasilitas';
    }

    public function ambilSemua($conn) {
        $sql = "SELECT * FROM pembelian_tiket ORDER BY id ASC";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; 
        }

        return $data;
    }

    public function ambilById($conn, $id) {
        $sql = "SELECT * FROM pembelian_tiket WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}


?>
