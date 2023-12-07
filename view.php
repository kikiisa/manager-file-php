<?php
require_once "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
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
                <h3>Detail</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card ">
                            <div class="card-body">
                               <a href="/home.php" class="btn btn-primary mb-2">Kembali</a>
                               <iframe width="100%" height="500" src="/file/<?= $_GET['file'] ?>" frameborder="0"></iframe>   
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
    <script>
        new DataTable('#example');
    </script>
</body>

</html>