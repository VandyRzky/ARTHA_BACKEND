<?php 
    require '../../connection.php';

    $idProduk = $_GET['id_produk'];

    $deleteDetail = "DELETE FROM detail_produk WHERE id_produk = ?";
    $stmtDeleteDetail =$conn->prepare($deleteDetail);
    $stmtDeleteDetail->bind_param("i", $idProduk);
    $stmtDeleteDetail->execute();
    $stmtDeleteDetail->close();

    $getGambarProduk = mysqli_query($conn, "SELECT foto_produk FROM produk WHERE id_produk=$idProduk");
    $data = mysqli_fetch_assoc($getGambarProduk);
    $gambar = $data['foto_produk'];
    $pathGambar = '../../MenuUploads/'.$gambar;


    if (file_exists($pathGambar)){
        unlink($pathGambar);
    }


    $deleteProduk = "DELETE FROM produk WHERE id_produk = ?";
    $stmtProduk = $conn->prepare($deleteProduk);
    $stmtProduk->bind_param("i", $idProduk);

    if($stmtProduk->execute()){
        echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'readProduk.php';
                </script>"
                ;
    }else{
        echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'readProduk.php';
                </script>";
    }
    $stmtProduk->close();
    $conn->close();

?>