<?php 
    require '../../connection.php';
    
    $idProduk = $_GET['id_produk'];
    session_start();
    if($_SESSION['role'] !== 'admin'){
        echo 
        "<script>
        alert('Tidak bisa mengakses halaman ini!');
        document.location.href = '../../Auth/login.php';
        </script>";
        exit;
    }
    
    // if (isset($_GET['id_produk'])){

    //     $sql = "SELECT nama_produk FROM produk WHERE id_produk = ?";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param("i", $id_produk);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     if ($result->num_rows > 0) {
    //         $row = $result->fetch_assoc();
    //         $nama_produk = $row['nama_produk'];
    //     } else {
    //         echo "Produk tidak ditemukan.";
    //         exit;
    //     }
    // } else {
    //     echo "ID Produk tidak tersedia.";
    //     exit;
    // }

    if (isset($_POST['tambah'])) {
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];

        $sql = "INSERT INTO detail_produk (id_produk, jumlah, harga) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isd", $idProduk, $jumlah, $harga);

        if ($stmt->execute()) {
            echo "<script>
                alert('Data Berhasil Ditambahkan!');
                document.location.href = '../Produk/manajemenProduk.php?id_produk=$idProduk';
                </script>";
        } else {
            echo "<script>
                alert('Data Gagal Ditambahkan!');
                document.location.href = '../Produk/manajemenProduk.php?id_produk=$idProduk';
                </script>";
        }

        $stmt->close();
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
    <form action="" method="post">
        <input type="number" name="jumlah" id="jumlah" min="0" max="99999999.99" placeholder="Jumlah" oninput="validity.valid||(value='');" required>
        <br>
        <input type="number" name="harga" id="harga" min="0" max="99999999.99" placeholder="Harga" oninput="validity.valid||(value='');" required>
        <br>
        <input type="submit" value="tambah" name="tambah" id="tambah">

    </form>
</body>
</html>

