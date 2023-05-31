<?php
session_start();
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require 'db/config.php';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];



    $result = mysqli_query($conn, "SELECT * FROM tb_user JOIN tb_karyawan ON tb_user.id_karyawan = tb_karyawan.id_karyawan WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            if ($row['id_level'] == "LVL1") {
                $_SESSION["login"] = true;
                $_SESSION["nama"] = $row['nama_karyawan'];
                $_SESSION["id"] = $row['id_user'];
                header("Location: admin/index.php");
                exit;
            } elseif ($row['id_level'] == "LVL2") {
                $_SESSION["login"] = true;
                $_SESSION["nama"] = $row['nama_karyawan'];
                $_SESSION["id"] = $row['id_user'];
                header("Location: kasir/index.php");
                exit;
            }
        }
        echo "username atau password anda salah";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apotek | LogIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body class="bg-info bg-gradient">

    <div class="container bg-light position-absolute top-50 start-50 translate-middle rounded w-25 border border-secondary">
        <h2 class="text-center mb-2">Login</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <button type="submit" name="login" class="btn btn-primary mb-3">Sumbit</button>
            </ul>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>