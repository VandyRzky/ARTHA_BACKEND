<?php 
    require '../../connection.php';

    $idDetail = $_GET['id_detail_produk'];
    $query = mysqli_query($conn, "SELECT * FROM detail_produk WHERE id_detail_produk = $idDetail");
    $data = mysqli_fetch_assoc($query);
    $idProduk = $data['id_produk'];

    if (isset($_POST['update'])) {
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];

        $sqlUpdate = "UPDATE detail_produk SET jumlah=?, harga=? WHERE id_detail_produk=?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("iii", $jumlah, $harga, $idDetail);
        if ($stmtUpdate->execute()) {
            echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = '../Produk/manajemenProduk.php?id_produk=$idProduk';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal diubah!');
                document.location.href = '../Produk/manajemenProduk.php?id_produk=$idProduk';
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
    <title>Edit Detail Produk</title>
</head>
<body>

    <form action="" method="post">

        <input type="number" name="jumlah" id="jumlah" placeholder="jumlah" in="0" max="99999999.99" oninput="validity.valid||(value='');" value="<?php echo $data['jumlah']?>" required>

        <br>

        <input type="number" name="harga" id="harga" in="0" max="99999999.99" placeholder="Harga" oninput="validity.valid||(value='');" value="<?php echo $data['harga']?>" required>

        <br>

        <input type="submit" value="edit" name="update" id="update">

    </form>
</body>
</html>