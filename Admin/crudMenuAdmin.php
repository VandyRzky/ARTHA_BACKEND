<?php 
require "../connection.php";

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

    <a href="tambahMenu.php">
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
                <th>Manajemen Detail</th>
                <th>Hapus</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($produk as $pd): ?>
                <tr>
                    <td><?php echo $pd['nama_produk']; ?></td>
                    <td><img src="../MenuUploads/<?php echo $pd['foto_produk']?>" alt="Gambar Produk"width="100"></td>
                    <td>
                        <a href="editMenu.php?id=<?php echo $pd['id_produk']?>">
                            <button>Edit</button>
                        </a>
                    </td>
                    <td>
                        <a href="manajemenDetailProduk.php?id=<?php echo $pd['id_produk']?>">
                            <button>Detail Produk</button>
                        </a>
                    </td>
                    <td>Ini hapus</td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</body>
</html>