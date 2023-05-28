<?php
session_start();

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require 'config.php';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    

    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        var_dump(password_verify($password, '$2a$12$LyvTFxI3gRpngrJtOuv/duyDLX9J6Jo3vMKi6FFUeaFWsD3iDayge'));
        die;
        if (password_verify($password, $row['password'])) {
            $_SESSION["login"] = true;

            header("Location: index.php");
            exit;
        }
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

<body class="bg-warning">

    <div class="container bg-light position-absolute top-50 start-50 translate-middle rounded">
        <h2 class="position-absolute top-0 start-50 translate-middle-x">Login</h2><br><br>
        <form action="" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" name="password" id="password">
            </div>
            <button type="submit" name="login" class="btn btn-primary mb-3">Sumbit</button>
            </ul>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>