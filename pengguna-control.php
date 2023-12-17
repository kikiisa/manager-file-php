<?php
require_once "koneksi.php";
// Koneksi ke database


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update"])) {
        $id = $_POST["id"];
        $nomor = $_POST['nomor'];
        $nama_lengkap = $_POST['nama_lengkap'];
        
        if ($_FILES['files']['name'] !== '') {
            $sql = "SELECT * FROM mahasiswa WHERE id = '$id'";
            $result = $db->query($sql)->fetch_object();
            unlink($result->profile);
            $file_name = $_FILES['files']['name'];
            $file_temp = $_FILES['files']['tmp_name'];
            $random_name = uniqid() . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
            $file_dest = "profile/" . $random_name;
            $allowed_extensions = array('png', 'jpg', 'jpeg');
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
            if (in_array($file_extension, $allowed_extensions)) {
                if (move_uploaded_file($file_temp, $file_dest)) {
                    $sql = "UPDATE mahasiswa SET nomor='$nomor', nama_lengkap='$nama_lengkap', profile='$file_dest' WHERE id='$id'";            
                    if($db->query($sql) == true)
                    {
                        header("location: pengguna.php?success=true");
                    }else{
                        header("location: pengguna.php?success=false");
                    }
                } else {
                    header("location: pengguna.php?success=false");
                }
            } else {
                header("location: pengguna.php?success=false");
            }
        } else {
            $sql = "UPDATE mahasiswa SET nomor='$nomor', nama_lengkap='$nama_lengkap' WHERE id='$id'";
            if($db->query($sql) == true)
            {
                header("location: pengguna.php?success=true");
            }else{
                header("location: pengguna.php?success=false");
            }
        }
    } 
    if(isset($_POST["simpan"]))
    {
        if (isset($_POST['nomor']) && isset($_POST['nama_lengkap']) && isset($_FILES['files'])) {
            $nomor = $_POST['nomor'];
            $nama_lengkap = $_POST['nama_lengkap'];
            
            // Proses upload file
            $file_name = $_FILES['files']['name'];
            $file_temp = $_FILES['files']['tmp_name'];
            
            // Membuat nama file unik dengan uniqid()
            $random_name = uniqid() . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
            $file_dest = "profile/" . $random_name;
    
            // Cek apakah file adalah gambar dan memiliki ekstensi yang diizinkan
            $allowed_extensions = array('png', 'jpg', 'jpeg');
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
            if (in_array($file_extension, $allowed_extensions)) {
                if (move_uploaded_file($file_temp, $file_dest)) {
                    // Simpan data ke database
                    $sql = "INSERT INTO mahasiswa (nomor, nama_lengkap, profile) VALUES ('$nomor', '$nama_lengkap', '$file_dest')";
                    
                    if ($db->query($sql) === TRUE) {
                        header("location: pengguna.php?success=true");
                    } else {
                        header("location: pengguna.php?success=false");
                    }
                } else {
                    echo "Gagal mengunggah file!";
                }
            } else {
                header("Location: pengguna.php?error=files");
                // echo "Hanya file PNG, JPG, dan JPEG yang diizinkan!";
            }
        } else {
            echo "Semua field harus diisi!";
        }
    }
   


} 

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET["hapus"]))
    {
        $id = $_GET["hapus"];
        $data = $db->query("SELECT * FROM mahasiswa WHERE id = '$id' ")->fetch_object()->profile;
        $dir = unlink($data);
        $delete = $db->query("DELETE FROM mahasiswa WHERE id = '$id' ");
        if($delete)
        {
            header("location: pengguna.php");
        }else{
            header("location: pengguna.php");
        }
    }
    
}

$db->close();
?>
