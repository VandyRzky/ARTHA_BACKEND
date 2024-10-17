<?php 
    require '../connection.php';

    $idProduk = $_GET['id_produk'];

    $sql = "SELECT p.nama_produk, dp.id_detail_produk, dp.jumlah, dp.harga
            FROM produk p
            LEFT JOIN detail_produk dp ON p.id_produk = dp.id_produk
            WHERE p.id_produk = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProduk); 
    $stmt->execute();
    $result = $stmt->get_result();
    $detailProduk = [];
    while ($row = $result->fetch_assoc()) {
        $detailProduk[] = $row;
    }
    $stmt->close();

    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $idProduk");
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

        $sqlUpdate = "UPDATE produk SET nama_produk = ?, foto_produk = ? WHERE id_produk=?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ssi", $namaProduk, $fotoProdukFinal, $idProduk);
        if ($stmtUpdate->execute()) {
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
    
        $stmtUpdate->close();
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

    <h3>Untuk detail menu</h3>

    <a href="tambahDetailProduk.php?id_produk=<?php echo $idProduk?>">
        <button>Tambah</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>Jumlah Top Up</th>
                <th>Harga</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($detailProduk as $dP): ?>
            <tr>
                <th><?php echo $dP['jumlah'] ?></th>
                <th><?php echo $dP['harga'] ?></th>
                <th>
                    <a href="DetailProduk/editDetailProduk.php?id_detail_produk=<?php echo $dP['id_detail_produk']?>">
                        <button>Edit</button>
                    </a>
                </th>
                <th>
                    <a href="DetailProduk/hapusDetailProduk.php?id_detail_produk=<?php echo $dP['id_detail_produk']?>">
                        <button>Hapus</button>
                    </a>
                </th>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

    <h3>Untuk edit menu game</h3>

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