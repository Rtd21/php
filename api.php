<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];

$response = [];

switch($method){

    // =====================================
    // READ
    // GET /api.php
    // GET /api.php?id=1
    // =====================================
    case 'GET':

        if(isset($_GET['id'])){

            $id = (int) $_GET['id'];

            $query = mysqli_query(
                $koneksi,
                "SELECT * FROM users WHERE id='$id'"
            );

            $data = mysqli_fetch_assoc($query);

            if($data){

                $response = [
                    "status" => "success",
                    "data" => $data
                ];

            }else{

                $response = [
                    "status" => "error",
                    "message" => "Data tidak ditemukan"
                ];
            }

        }else{

            $query = mysqli_query(
                $koneksi,
                "SELECT * FROM users ORDER BY id DESC"
            );

            $users = [];

            while($row = mysqli_fetch_assoc($query)){
                $users[] = $row;
            }

            $response = [
                "status" => "success",
                "data" => $users
            ];
        }

    break;

    // =====================================
    // CREATE
    // POST /api.php
    // =====================================
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
                    "message" => "Data berhasil ditambahkan",
                    "id" => mysqli_insert_id($koneksi)
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

    // =====================================
    // UPDATE
    // PUT /api.php?id=1
    // =====================================
    case 'PUT':

        if(isset($_GET['id'])){

            $id = (int) $_GET['id'];

            $json = json_decode(file_get_contents("php://input"), true);

            $nama  = $json['nama'] ?? '';
            $sandi = $json['sandi'] ?? '';

            if($nama != '' && $sandi != ''){

                $nama  = mysqli_real_escape_string($koneksi, $nama);
                $sandi = mysqli_real_escape_string($koneksi, $sandi);

                $update = mysqli_query(
                    $koneksi,
                    "UPDATE users SET
                     nama='$nama',
                     sandi='$sandi'
                     WHERE id='$id'"
                );

                if($update){

                    $response = [
                        "status" => "success",
                        "message" => "Data berhasil diupdate"
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

        }else{

            $response = [
                "status" => "error",
                "message" => "ID wajib diisi"
            ];
        }

    break;

    // =====================================
    // DELETE
    // DELETE /api.php?id=1
    // =====================================
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
                "message" => "ID wajib diisi"
            ];
        }

    break;

    default:

        http_response_code(405);

        $response = [
            "status" => "error",
            "message" => "Method tidak diizinkan"
        ];

    break;
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>
