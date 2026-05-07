<?php include 'crud.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP CRUD Railway</title>
</head>
<body>

<?php
$edit = false;
$id = "";
$nama = "";
$sandi = "";

if(isset($_GET['edit'])){
    $edit = true;

    $id_edit = $_GET['edit'];

    $ambil = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id_edit'");
    $row = mysqli_fetch_assoc($ambil);

    $id = $row['id'];
    $nama = $row['nama'];
    $sandi = $row['sandi'];
}
?>

<h2>
    <?php echo $edit ? "Edit Data" : "Tambah Data"; ?>
</h2>

<form method="POST">

    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <input type="text"
           name="nama"
           placeholder="Nama"
           required
           value="<?php echo $nama; ?>">

    <input type="text"
           name="sandi"
           placeholder="Sandi"
           required
           value="<?php echo $sandi; ?>">

    <?php if($edit){ ?>
        <button type="submit" name="update">Update</button>
    <?php } else { ?>
        <button type="submit" name="tambah">Simpan</button>
    <?php } ?>

</form>

<h2>Data Users</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Sandi</th>
        <th>Aksi</th>
    </tr>

    <?php while($d = mysqli_fetch_array($data)){ ?>

    <tr>
        <td><?php echo $d['id']; ?></td>
        <td><?php echo $d['nama']; ?></td>
        <td><?php echo $d['sandi']; ?></td>

        <td>
            <a href="index.php?edit=<?php echo $d['id']; ?>">
                Edit
            </a>

            |

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
