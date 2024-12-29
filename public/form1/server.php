<?php
header('Content-Type: application/json');


// Koneksi ke database
$host = "localhost";
$username = "u595034490_admin";  // Ganti dengan username database Anda
$password = "Admincolorrun25!";  // Ganti dengan password database Anda
$dbname = "u595034490_registrations";  // Ganti dengan nama database Anda

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// Ambil data dari request
$data = json_decode(file_get_contents('php://input'), true);

// Generate nomor BIB (urut mulai dari 1, diawali dengan angka 20)
$sql = "SELECT MAX(bib_number) AS max_bib FROM registrations";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['max_bib']) {
    $next_bib_number = (int)substr($row['max_bib'], 2) + 1; // Ambil nomor terakhir dan tambahkan 1
} else {
    $next_bib_number = 1; // Mulai dari 1 jika belum ada data
}

$final_bib = "20" . str_pad($next_bib_number, 4, "0", STR_PAD_LEFT); // Contoh: 200001, 200002, dst.

// Simpan data ke database
$stmt = $conn->prepare("INSERT INTO registrations 
    (nama_lengkap, gender, nama_bib, no_wa, kategori, ukuran_baju, no_id, provinsi, kota, kecamatan, alamat, golongan_darah, riwayat_penyakit, kontak_darurat_nama, kontak_darurat_no, bib_number
)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "sssssssssssssssi",
    $data['nama_lengkap'],
     $data['gender'],
    $data['nama_bib'],
    $data['no_wa'],
    $data['kategori'],
    $data['ukuran_baju'],
    $data['no_id'],
    $data['provinsi'],
    $data['kota'],
    $data['kecamatan'],
    $data['alamat'],
    $data['golongan_darah'],
    $data['riwayat_penyakit'],
    $data['kontak_darurat_nama'],
    $data['kontak_darurat_no'],
    $final_bib
);

if ($stmt->execute()) {
    // Gunakan direct URL pembayaran Midtrans Anda, tambahkan nomor BIB
    $midtrans_base_url = "https://app.midtrans.com/payment-links/1735357615508"; // Ganti dengan direct URL pembayaran Anda
    $midtrans_url = $midtrans_base_url . "?order_id=" . $final_bib;

    // Kirim respon ke frontend
    echo json_encode(['success' => true, 'payment_url' => $midtrans_url]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save registration.']);
}

$stmt->close();
$conn->close();
?>
