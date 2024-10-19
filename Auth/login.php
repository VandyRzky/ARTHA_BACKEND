<?php 
    require '../connection.php';
    require 'adminCnfg.php';

    session_start();

    if (isset($_POST['login'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        if ($username === $adminUsr){
            if($password === $adminPass){
                $_SESSION['role'] = 'admin';
                $_SESSION['username'] = $username;
                echo "
                <script>
                    alert('Login berhasil!');
                    document.location.href = '../Admin/Produk/readProduk.php';
                </script>";
            }else{
                echo "
                <script>
                    alert('Password salah!');
                    document.location.href = 'login.php';
                </script>";
            }
        }else{
            $checkUserSql = "SELECT * FROM akun WHERE username = ?";
            $stmtCheckUser = $conn->prepare($checkUserSql);
            $stmtCheckUser->bind_param("s", $username);
            $stmtCheckUser->execute();
            $checkUserResult = $stmtCheckUser->get_result();

            if($checkUserResult->num_rows >0){
                $dataAkun = $checkUserResult->fetch_assoc();

                if(password_verify($password, $dataAkun['password_akun'])){
                    $_SESSION['role'] = 'user';
                    $_SESSION['username'] = $username;
                    echo "
                <script>
                    alert('Login berhasil!');
                    document.location.href = '../User/halamanTopUp.php';
                </script>";
                }else {
                    echo "
                    <script>
                        alert('Password salah!');
                        document.location.href = 'login.php';
                    </script>";
                }
            }else {
                echo "
                <script>
                    alert('Username salah!');
                    document.location.href = 'login.php';
                </script>
                ";
            }
            $stmtCheckUser->close();
        }
        $conn->close();

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <input type="submit" value="Login" name="login">
    </form>
</body>
</html>