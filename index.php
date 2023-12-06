<?php 

session_start();
if(isset($_POST["login"]))
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    if($username == "admin" && $password == "admin123")
    {
        $_SESSION["login"] = true;
        header("location:dashboard.php");
    }else{
        echo "<script>
        alert('Username atau Password anda salah');
        </script>";
        header("location:index.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/bootstrap/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 35px;">
            <div class="col-lg-4 col-12">
                <h1 class="fs-4 text-center">Sistem Informasi Manager File</h1>
                <div class="card border-0">
                    <div class="card-body">
                        <p class="fw-bold">Login Ke Akun</p>
                        <hr>
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="fw-bold mb-2 mt-2" for="username">Username</label>
                                <input type="text" required placeholder="Masukkan username" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="fw-bold mb-2 mt-2" for="password">Password</label>
                                <input type="password" required placeholder="Masukkan password" name="password" id="password" class="form-control">
                            </div>
                            <button name="login" class="btn btn-dark fw-bold mt-3 w-100">simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>