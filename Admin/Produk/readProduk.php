<?php 
require "../../connection.php";

session_start();
if($_SESSION['role'] !== 'admin'){
    echo 
    "<script>
    alert('Tidak bisa mengakses halaman ini!');
    document.location.href = '../../Auth/login.php';
    </script>";
    exit;
}

$sql = mysqli_query($conn, "SELECT * FROM produk");

$produk =[];
while ($row = mysqli_fetch_assoc($sql)) {
    $produk[] = $row;
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
    <h3>Buat log out</h3>

    <a href="../../Auth/logOut.php">
        <button>Log Out</button>
    </a>

    <h3>Untuk tambah menu dan lihat menu</h3>

    <a href="tambahProduk.php">
        <button>
            Tambah
        </button>
    </a>
    
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Foto</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($produk as $pd): ?>
                <tr>
                    <td><?php echo $pd['nama_produk']; ?></td>
                    <td><img src="../../MenuUploads/<?php echo $pd['foto_produk']?>" alt="Gambar Produk"width="100"></td>
                    <td>
                        <a href="manajemenProduk.php?id_produk=<?php echo $pd['id_produk']?>">
                            <button>Edit</button>
                        </a>
                    </td>
                    <td>
                        <a href="hapusProduk.php?id_produk=<?php echo $pd['id_produk']?>">
                            <button>Hapus</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</body>
</html>