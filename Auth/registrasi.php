<?php 
    require '../connection.php';
    require 'adminCnfg.php';

    if (isset($_POST['registrasi'])) {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

        $checkUserSql = "SELECT * FROM akun WHERE username = ?";
        $stmtCheckUser = $conn->prepare($checkUserSql);
        $stmtCheckUser->bind_param("s", $username);
        $stmtCheckUser->execute();
        $checkUserResult = $stmtCheckUser->get_result();

        if (mysqli_num_rows($checkUserResult) > 0){
            echo "
            <script>
                alert('Username sudah digunakan! Silakan gunakan username lain.');
                document.location.href = 'registrasi.php';
            </script>
            ";
        }else if ($username === $adminUsr){
            echo "
            <script>
                alert('Username tidak dapat digunakan');
                document.location.href = 'registrasi.php';
            </script>
            ";
        }else{
            $insertUserSql = "INSERT INTO akun (username, password_akun, email_akun) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertUserSql);
            $stmt->bind_param("sss", $username, $password, $email);
            if($stmt->execute()){
                echo "<script>
                alert('Berhasil melakukan registrasi!');
                document.location.href = 'login.php';
                </script>";
            }else{
                echo "<script>
                alert('Gagal melakukan registrasi!');
                document.location.href = 'registrasi.php';
                </script>";
            }
            $stmt->close();
            $conn->close();
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="username" id="username" placeholder="Usernamme" required>

        <br>

        <input type="email" name="email" id="email" placeholder="Email" required>

        <br>

        <input type="password" name="password" id="password" placeholder="Password" required>

        <br>

        <input type="submit" value="Registrasi" name="registrasi" id="registrasi">
    </form>
</body>
</html>