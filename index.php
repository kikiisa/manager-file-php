<?php 
require_once('koneksi.php');
session_start();
if(isset($_POST["login"]))
{

    $username = $_POST["username"];
    $password = md5($_POST["password"]);
    $data = $db->query("SELECT * FROM admin where username='$username' AND password='$password'");
    if($data->num_rows == 1)
    {
        $_SESSION["login"] = true;
        $_SESSION["id"] = $data->fetch_array()["id"];
        header("location:home.php");
    }else{
        header("location:index.php?status=error");
    }
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
    <link rel="manifest" href="public/js/web.webmanifest">
    <link rel="stylesheet" href="public/template/assets/css/shared/iconly.css">
    <link rel="stylesheet" href="public/template/assets/extensions/toastify-js/src/toastify.css">

</head>
<body>
    <div class="row justify-content-center">
        <div class="col-lg-4 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="auth-logo text-center">
                        <img src="/public/template/assets/images/folder.png" class="bg-dark rounded-circle" width="90" alt="" srcset="">
                    </div>
                    <h1 class="text-center auth-title mt-2">MANAGER FILE</h1>
                    <p class="text-center auth-subtitle">Silahkan masuk untuk melakukan manager file.</p>
                    <form method="POST" action="">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input required type="text" name="username" class="form-control form-control-xl" placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input required type="password" name="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button name="login" class="btn btn-primary btn-block btn-lg shadow-lg">Log in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="public/template/assets/js/bootstrap.js"></script>
    <script src="public/template/assets/js/app.js"></script>
    <script src="public/template/assets/extensions/toastify-js/src/toastify.js"></script>

    <?php if(isset($_GET['status'])){ ?>
        <script>
            Toastify({
                text: 'Username Atau Password Tidak Terdaftar',
                duration: 3000,
                close: true,
                backgroundColor: "#D61355",
            }).showToast();
        </script>
    <?php } ?>
    <script src="public/js/register.js"></script>
</body>
</html>
