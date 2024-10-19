<?php 
    require '../../connection.php';

    session_start();
    if($_SESSION['role'] !== 'admin'){
        echo 
        "<script>
        alert('Tidak bisa mengakses halaman ini!');
        document.location.href = '../../Auth/login.php';
        </script>";
        exit;
}

    if (isset($_POST['tambah'])){
        $namaProduk = htmlspecialchars($_POST['nama_menu']);

        $gambarProduk = $_FILES['foto_menu']['name'];
        $gambarProdukTemp = $_FILES['foto_menu']['tmp_name'];

        $fileEkstensi = pathinfo($gambarProduk, PATHINFO_EXTENSION);
        $gambarProdukFinal = date('YmsHis').'.'.$fileEkstensi;

        $targetDir = "../../MenuUploads/";
        $targetUpload = $targetDir . $gambarProdukFinal;

        if (move_uploaded_file($gambarProdukTemp, $targetUpload)){
            $sql = "INSERT INTO produk (nama_produk, foto_produk) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $namaProduk, $gambarProdukFinal);

            if($stmt->execute()){
                echo "<script>
                alert('Data Berhasil Ditambahkan!');
                document.location.href = 'readProduk.php';
                </script>";
            }else{
                echo "<script>
                alert('Data Gagal Ditambahkan!');
                document.location.href = 'readProduk.php';
                </script>";
            }
            $stmt->close();
        }else{
            echo "<script>
            alert('Gagal Mengupload Gambar!');
            </script>";
        }
        $conn->close();
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="nama_menu" id="nama_menu" placeholder="Nama Menu" required>
    <br>
    <br>
    <label for="foto_menu"></label>
    <input type="file" name="foto_menu" id="foto_menu" required>
    <br>
    <br>
    <input type="submit" value="Tambah" name="tambah" id="tambah">

    </form>


</body>
</html>