<?php 
    require '../../connection.php';
    $idDetail = $_GET['id_detail_produk'];

    $query = mysqli_query($conn, "SELECT * FROM detail_produk WHERE id_detail_produk = $idDetail");
    $data = mysqli_fetch_assoc($query);
    $idProduk = $data['id_produk'];

    $hapus = mysqli_query($conn, "DELETE FROM detail_produk WHERE id_detail_produk = $idDetail");

    if ($hapus) {
        echo "
        <script>
            alert('Data berhasil dihapus!');
            document.location.href = '../Produk/manajemenProduk.php?id_produk=$idProduk';
        </script>";
    } else {
        echo "
        <script>
            alert('Data gagal dihapus!');
            document.location.href = '../Produk/manajemenProduk.php?id_produk=$idProduk';
        </script>";
    }

?>