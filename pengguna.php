<?php
require_once "koneksi.php";
session_start();
if(!isset($_SESSION["login"]))
{
    header("location:index.php");
}
$statusErrorFiles = "";
$directory = "";
if (isset($_POST['checkup'])) {
    error_reporting(0);
    $device = $_POST["device"] . ":";
    $directory = $device;
    if (is_dir($device)) {
        $_SESSION["device"] = $directory;
        $files = scandir($directory);
    }
}

if (isset($_POST["simpan"])) {
    $judul = $_POST["judul"];
    $keterangan = $_POST["keterangan"];
    $files = $_FILES["files"]["name"];
    $tmp_files = $_FILES["files"]["tmp_name"];
    $ekstensi = pathinfo($_FILES["files"]["name"], PATHINFO_EXTENSION);
    $folder = $_SESSION["device"] . "/";
    $destination2 = "file/";
    // Membuat nama file yang unik dengan tambahan timestamp
    $uniqueFileName = uniqid() . '.' . $ekstensi;
    $simpan = move_uploaded_file($tmp_files, $folder . $uniqueFileName);
    copy($folder . $uniqueFileName, $destination2 . $uniqueFileName);
    $db->query("INSERT INTO file_upload(nama_file, keterangan,path_file) VALUES('$judul', '$keterangan', '$uniqueFileName')");
    $db->commit();
    $db->close();
    if ($simpan && $move2) {
        header("Location: home.php");    
    } else {
        header("Location: home.php");
    }
}

if (isset($_POST["eject"])) {
    unset($_SESSION["device"]);
    header("location:home.php");
}
if(isset($_GET['hapus']))
{
    $id = $_GET["hapus"];
    $data = $db->query("SELECT * FROM file_upload WHERE id = '$id' ")->fetch_object()->path_file;
    $dir1 = unlink($_SESSION["device"] . "/" .$data);
    $dir2 = unlink("file/" .$data);
    $delete = $db->query("DELETE FROM file_upload WHERE id = '$id' ");
    if($delete)
    {
        header("location:home.php");
    }else{
        header("location:home.php");
    }

}

if(isset($_POST["simpan"]))
{
    echo 'simpan';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <link rel="stylesheet" href="public/template/assets/css/main/app.css">
    <link rel="stylesheet" href="public/template/assets/css/main/app-dark.css">
    <link rel="stylesheet" href="public/template/assets/css/shared/iconly.css">
    <link rel="stylesheet" href="/public/datatable/datatables.min.css">
    <!-- <script src="/template/assets/static/js/initTheme.js"></script> -->
</head>
<body>
    <script src="/public/template/assets/static/initTheme.js"></script>
    <div id="app">
        <?php require_once('layouts/sidebar.php') ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <h3>Data Pengguna</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="mt-3">
                                <button class="btn btn-primary mt-3 mb-2" name="cek_hardisk" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Pengguna</button>
                                    <?php $data = $db->query("SELECT * FROM mahasiswa"); ?>
                                    <?php if ($data->num_rows > 0) { ?>
                                        <table class="table table-striped" id="example">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nim</th>
                                                    <th scope="col">Nama Lengkap</th>
                                                   
                                                    <th scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-group-divider">
                                                <?php $i = 0 ?>
                                                <?php while ($row = $data->fetch_assoc()) { ?>
                                                    <?php $i += 1 ?>
                                                    <tr>
                                                        <th scope="row"><?= $i ?></th>
                                                        <td><?= $row["nomor"] ?></td>
                                                        <td><?= $row["nama_lengkap"] ?></td>
                                                        <td>
                                                           <a href="home.php?id=<?= $row["id"] ?>" class="btn btn-primary">Lihat Semua File</a>
                                                           <a href='pengguna-control.php?hapus=<?= $row["id"] ?>' class="btn btn-danger">Hapus</a>
                                                           <a href="edit-pengguna.php?edit=<?= $row["id"] ?>" class="btn btn-warning">Edit</a>
                                                        </td>
                                                    </tr>
    
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="alert alert-danger fw-bold text-center">Data Kosong</div>
                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pengguna</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="pengguna-control.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="fw-bold">Nim/Nidn/Nip/Nis</label>
                            <input required type="text" name="nomor" placeholder="Masukan Nomor" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="fw-bold">Nama Lengkap</label>
                            <input type="text" placeholder="Nama Lengkap" name="nama_lengkap" class="form-control">
                        </div>
                        <div class="form-group mt-3">
                            <label>Pilih Profile</label>
                            <input required type="file" name="files" id="files" class="form-control-file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="simpan" class="btn btn-primary">simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="public/template/assets/js/bootstrap.js"></script>
    <script src="public/template/assets/js/app.js"></script>
    <script src="/public/datatable/jquery.js"></script>
    <script src="/public/datatable/datatables.min.js"></script>
    <script src="/public/template/assets/static/dark.js"></script>
    <script src="/public/template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/public/template/assets/"></script>
    
    <script src="/public/template/assets/compiled/app.js"></script>
    <script>
        new DataTable('#example');
    </script>
</body>

</html>