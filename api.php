<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include 'koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];

$response = [];

switch($method){

    // =========================
    // READ
    // =========================
    case 'GET':

        $query = mysqli_query($koneksi, "SELECT * FROM users");

        $users = [];

        while($row = mysqli_fetch_assoc($query)){
            $users[] = $row;
        }

        $response = [
            "status" => "success",
            "data" => $users
        ];

    break;

    // =========================
    // CREATE
    // =========================
    case 'POST':

        $json = json_decode(file_get_contents("php://input"), true);

        $nama  = $json['nama'] ?? '';
        $sandi = $json['sandi'] ?? '';

        if($nama != '' && $sandi != ''){

            $nama  = mysqli_real_escape_string($koneksi, $nama);
            $sandi = mysqli_real_escape_string($koneksi, $sandi);

            $insert = mysqli_query(
                $koneksi,
                "INSERT INTO users(nama, sandi)
                 VALUES('$nama', '$sandi')"
            );

            if($insert){

                $response = [
                    "status" => "success",
                    "message" => "Data berhasil ditambahkan"
                ];

            }else{

                $response = [
                    "status" => "error",
                    "message" => mysqli_error($koneksi)
                ];
            }

        }else{

            $response = [
                "status" => "error",
                "message" => "Nama dan sandi wajib diisi"
            ];
        }

    break;

    // =========================
    // DELETE
    // =========================
    case 'DELETE':

        if(isset($_GET['id'])){

            $id = (int) $_GET['id'];

            $delete = mysqli_query(
                $koneksi,
                "DELETE FROM users WHERE id='$id'"
            );

            if($delete){

                $response = [
                    "status" => "success",
                    "message" => "Data berhasil dihapus"
                ];

            }else{

                $response = [
                    "status" => "error",
                    "message" => mysqli_error($koneksi)
                ];
            }

        }else{

            $response = [
                "status" => "error",
                "message" => "ID tidak ditemukan"
            ];
        }

    break;

    default:

        $response = [
            "status" => "error",
            "message" => "Method tidak valid"
        ];

    break;
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>
