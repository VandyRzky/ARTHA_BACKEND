<?php 
    require '../connection.php';

    $id = $_GET['id'];

    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id");
    $data = mysqli_fetch_assoc($query);

    if(isset($_POST['update'])){
        $namaProduk = htmlspecialchars($_POST['nama_produk']);
        $fotoLama = $data['foto_produk'];

        if ($_FILES['foto_produk']['name']) {
            $fotoUpload = $_FILES['foto_produk']['name'];
            $fotoUploadTemp = $_FILES['foto_produk']['tmp_name'];

            $fileEkstensi = pathinfo($fotoUpload, PATHINFO_EXTENSION);
            $fotoProdukFinal = date('YmsHis').'.'.$fileEkstensi;

            $pathFotoLama = "../MenuUploads/". $fotoLama;
            $pathFotoBaru = "../MenuUploads/". $fotoProdukFinal;

            if (file_exists($pathFotoLama)) {
                unlink($pathFotoLama);
            }

            move_uploaded_file($fotoUploadTemp, $pathFotoBaru);
        }else{
            $fotoProdukFinal = $fotoLama;
        }

        $sql = "UPDATE produk SET nama_produk = ?, foto_produk = ? WHERE id_produk=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $namaProduk, $fotoProdukFinal, $id);
        if ($stmt->execute()) {
            echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'crudMenuAdmin.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'crudMenuAdmin.php';
            </script>";
        }
    
        $stmt->close();
        $conn->close();
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
</head>
<body>
    <img src="../MenuUploads/<?php echo $data['foto_produk']?>" alt="Foto produk" width="100">

    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="nama_produk" id="nama_produk" value="<?php echo $data['nama_produk']?>">
        <br>
        <br>
        <input type="file" name="foto_produk" id="foto_produk">
        <br>
        <br>
        <input type="submit" value="update" name="update">
    </form>
</body>
</html>