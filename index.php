<?php

// ======================
// TAMBAH DATA
// ======================
if(isset($_POST['tambah'])){

    $data = [
        "nama" => $_POST['nama'],
        "sandi" => $_POST['sandi']
    ];

    $options = [
        "http" => [
            "method"  => "POST",
            "header"  => "Content-Type: application/json",
            "content" => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);

    file_get_contents("http://localhost/api.php", false, $context);

    header("Location: index.php");
    exit;
}

// ======================
// HAPUS DATA
// ======================
if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    $options = [
        "http" => [
            "method" => "DELETE"
        ]
    ];

    $context = stream_context_create($options);

    file_get_contents("http://localhost/api.php?id=$id", false, $context);

    header("Location: index.php");
    exit;
}

// ======================
// AMBIL DATA DARI API
// ======================
$json = file_get_contents("http://localhost/api.php");

$result = json_decode($json, true);

$users = $result['data'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD API PHP</title>
</head>
<body>

<h2>Tambah Data</h2>

<form method="POST">

    <input type="text"
           name="nama"
           placeholder="Nama"
           required>

    <input type="text"
           name="sandi"
           placeholder="Sandi"
           required>

    <button type="submit" name="tambah">
        Simpan
    </button>

</form>

<h2>Data Users</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Sandi</th>
        <th>Aksi</th>
    </tr>

    <?php foreach($users as $d){ ?>

    <tr>

        <td><?php echo $d['id']; ?></td>

        <td><?php echo $d['nama']; ?></td>

        <td><?php echo $d['sandi']; ?></td>

        <td>

            <a href="index.php?hapus=<?php echo $d['id']; ?>"
               onclick="return confirm('Yakin hapus data?')">
               Hapus
            </a>

        </td>

    </tr>

    <?php } ?>

</table>

</body>
</html>
