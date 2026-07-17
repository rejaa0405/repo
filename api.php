<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$user = "root";
$pass = "";
$db   = "pose_project";

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    echo json_encode(["status" => "error", "pesan" => "Koneksi gagal"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';
    $akurasi = isset($_POST['akurasi']) ? (int)$_POST['akurasi'] : 0;

    if ($kelas !== '') {
        $sql = "INSERT INTO log_deteksi (kelas, akurasi) VALUES ('$kelas', $akurasi)";
        if ($koneksi->query($sql) === TRUE) {
            echo json_encode(["status" => "sukses", "pesan" => "Data tersimpan"]);
        } else {
            echo json_encode(["status" => "error", "pesan" => "Gagal menyimpan"]);
        }
    } else {
        echo json_encode(["status" => "error", "pesan" => "Data kosong"]);
    }
} else {
    echo json_encode(["status" => "ready", "pesan" => "API siap"]);
}

$koneksi->close();
?>