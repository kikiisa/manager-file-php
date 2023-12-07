<?php 
session_start();
require_once("koneksi.php");
if(!isset($_SESSION["login"]))
{
    header("location:index.php");
}
$data = $db->query("SELECT * FROM admin WHERE id = '$_SESSION[id]'")->fetch_array();
if(isset($_POST["update"]))
{
    
    $username = $_POST["username"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    if($password == "")
    {   
        $data = $db->query("UPDATE admin SET name = '$name', username = '$username' WHERE id = '$_SESSION[id]'");
        if($data)
        {
            header("location:profile.php?status=success");
        }else{
            header("location:profile.php?status=error");
        }
    }else{
        $password = md5($password);    
        $data = $db->query("UPDATE admin SET name = '$name', username = '$username', password = '$password' WHERE id = '$_SESSION[id]'");
        if($data)
        {
            header("location:profile.php?status=success");
        }else{
            header("location:profile.php?status=error");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="public/template/assets/css/main/app.css">
    <link rel="stylesheet" href="public/template/assets/css/main/app-dark.css">
    <link rel="stylesheet" href="public/template/assets/css/shared/iconly.css">
    <link rel="stylesheet" href="/public/datatable/datatables.min.css">
    <link rel="stylesheet" href="public/template/assets/extensions/toastify-js/src/toastify.css">

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
                <h3>Profile </h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-6 col-lg-6">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="">Nama Lengkap</label>
                                        <input type="text" value="<?= $data["name"] ?>" placeholder="Nama Lengkap" name="name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" value="<?= $data["username"] ?>" placeholder="Username" name="username" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" placeholder="Password" name="password" class="form-control">
                                        <small class="text-danger">Kosongkan Jika Tidak Ingin Mengubah</small>
                                    </div>
                                   <button class="btn btn-primary" name="update">simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script src="public/template/assets/js/bootstrap.js"></script>
    <script src="public/template/assets/js/app.js"></script>
    <script src="/public/datatable/jquery.js"></script>
    <script src="/public/datatable/datatables.min.js"></script>
    <script src="public/template/assets/extensions/toastify-js/src/toastify.js"></script>
    <?php if(isset($_GET['status'])){ ?>
        <?php if($_GET['status'] == 'success'){ ?>
            <script>
                Toastify({
                    text: 'Berhasil Mengubah Password',
                    duration: 3000,
                    close: true,
                    backgroundColor: "#20C997",
                }).showToast();
            </script>
        <?php } ?>
        <?php if($_GET['status'] == 'error'){ ?>
            <script>
                Toastify({
                    text: 'Terjadi Kesalahan',
                    duration: 3000,
                    close: true,
                    backgroundColor: "#D61355",
                }).showToast();
            </script>
        <?php } ?>
    <?php } ?>
</body>

</html>