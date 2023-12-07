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
    $folder = $_SESSION["device"] . "/";
    $destination2 = "file/";
    // Membuat nama file yang unik dengan tambahan timestamp
    $uniqueFileName = uniqid() . '_' . $files;
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="public/template/assets/css/main/app.css">
    <link rel="stylesheet" href="public/template/assets/css/main/app-dark.css">
    <link rel="stylesheet" href="public/template/assets/css/shared/iconly.css">
    <link rel="stylesheet" href="/public/datatable/datatables.min.css">
</head>

<body>
    <div id="app">
        <?php require_once('layouts/sidebar.php') ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <h3>Dashboard</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Selamat Datang, <strong>Admin</strong></h4>
                            </div>
                            <div class="card-body">
                                <?php if (isset($_SESSION["device"])) { ?>
                                    <span class="badge bg-success">Perangkat Terhubung</span>
                                    <p class="mt-3">Nama Device Saat Ini : <strong><?= $_SESSION["device"] ?></strong></p>
                                    <form action="" method="post">
                                        <button class="btn btn-danger" type="submit" name="eject">Eject Device</button>
                                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Upload File</a>
                                    </form>
                                <?php } else { ?>
                                    <span class="badge bg-danger">Perangkat Tidak Terkoneksi</span>
                                    <br><button class="btn btn-primary mt-3" name="cek_hardisk" data-bs-toggle="modal" data-bs-target="#add">Hardisk Eksternal</button>
                                <?php } ?>
                                <hr>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <?php if(isset($_SESSION["device"])){ ?>
                                <?php $data = $db->query("SELECT * FROM file_upload"); ?>
                                <?php if ($data->num_rows > 0) { ?>
                                    <table class="table table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama File</th>

                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            <?php $i = 0 ?>
                                            <?php while ($row = $data->fetch_assoc()) { ?>
                                                <?php $i += 1 ?>
                                                <tr>
                                                    <th scope="row"><?= $i ?></th>
                                                    <td><?= $row["nama_file"] ?></td>
                                                    <td><?= $row["keterangan"] ?></td>
                                                    <td>
                                                        <?php if (isset($_SESSION["device"])) { ?>
                                                            <a class="btn btn-primary" href="/file/<?= $row['path_file'] ?>"><i class="bi bi-download"></i></a>
                                                        <?php } else { ?>
                                                            <a href="javascript:void()" class="badge bg-danger">Belum Terhubung</a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <div class="alert alert-danger fw-bold text-center">Data Kosong</div>
                                <?php  } ?>
                                <?php }else{ ?>
                                    <div class="alert alert-danger fw-bold text-center">Perangkat Tidak Terhubung</div>
                                <?php } ?>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah File</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="fw-bold">Nama File</label>
                            <input required type="text" name="judul" placeholder="Masukkan nama file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="fw-bold">Keterangan</label>
                            <textarea required name="keterangan" class="form-control" id="" cols="30" rows="10" placeholder="Keterangan File"></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label>Pilih File</label>
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
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Input Device</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="fw-bold mb-3">Masukan Nama Hardisk / Flaskdisk</label>
                            <input required type="text" name="device" placeholder="Masukan Nama Hardisk / Flaskdisk" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="checkup" value="checkup" class="btn btn-primary">cek device</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="public/template/assets/js/bootstrap.js"></script>
    <script src="public/template/assets/js/app.js"></script>
    <script src="/public/datatable/jquery.js"></script>
    <script src="/public/datatable/datatables.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
</body>

</html>