<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../login.php");
    exit;
}

include 'config.php';



if (isset($_POST['tambah'])) {

    $id = $_POST['id'];
    $karyawan = $_POST['karyawan'];
    $level = $_POST['level'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = mysqli_query($conn, "INSERT INTO tb_user (id_user, id_karyawan, id_level, username, password) VALUES ('$id', '$karyawan', '$level', '$username', '$password')");
}

$sql2 = mysqli_query($conn, "SELECT id_user FROM tb_user ORDER BY id_user DESC LIMIT 1");
$row2 = mysqli_fetch_assoc($sql2);
if ($row2) {
    $lastId = $row2['id_user'];
    $lastNumber = substr($lastId, 3);
    $newNumber = intval($lastNumber) + 1;
    $newId = "USR" . $newNumber;
} else {
    $newId = "USR1";
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apotek | User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>

<body>

    <nav class="navbar sticky-top bg-bodytertiary bg-info bg-gradient">
        <div class="container-fluid">
            <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><span class="navbar-toggler-icon"></span></button>
            <h4 class="me-3 fw-bold">APOTEK CENTRAL</h4>
            <div class="collapse navbar-collapse nav justify-content-end" id="navbarScroll">
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start text-bg-dark w-25" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">APOTEK CENTRAL</h5>
            <div data-bs-theme="dark">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="dashboard mb-3">
                <a href="index.php" class="btn btn-light w-100">Dashboard</a>
            </div>
            <div class="dropdown mb-3">
                <button class="btn btn-light w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Data Master
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a href="obat.php" class="dropdown-item">Obat</a></li>
                    <li><a href="jenis.php" class="dropdown-item">Jenis Obat</a></li>
                    <li><a href="kategori.php" class="dropdown-item">Kategori Obat</a></li>
                    <li><a href="rak.php" class="dropdown-item">Rak</a></li>
                </ul>
            </div>
            <div class="karyawan">
                <a href="karyawan.php" class="btn btn-light w-100 mb-3">Karyawan</a>
            </div>
            <div class="level">
                <a href="level.php" class="btn btn-light w-100 mb-3">Level</a>
            </div>
            <div class="user">
                <a href="user.php" class="btn btn-light w-100 mb-3 active">User</a>
            </div>
            <div class="transaksi">
                <a href="transaksi.php" class="btn btn-light w-100 mb-3">Transaksi</a>
            </div>
            <div class="logout">
                <a href="logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h1 class="text-center mt-3 mb-3">User</h1>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah" data-bs-whatever="@getbootstrap">Tambah Data</button>
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary" data-bs-theme="dark">
                        <h1 class="modal-title fs-5  text-light" id="exampleModalLabel">Tambah Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="id" class="col-form-label">Id User:</label>
                                <input type="text" class="form-control" name="id" id="id" value="<?php echo $newId; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="karyawan" class="col-form-label">Karyawan:</label>
                                <select name="karyawan" id="karyawan" class="form-select shadow bg-body-tertiary rounded">
                                    <?php
                                    include 'config.php';
                                    $query = mysqli_query($conn, "SELECT * FROM tb_karyawan");

                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $id = $row['id_karyawan'];
                                        $nama_karyawan = $row['nama_karyawan'];
                                        echo "<option value='$id'>$nama_karyawan</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="level" class="col-form-label">Level:</label>
                                <select name="level" id="level" class="form-select shadow bg-body-tertiary rounded">
                                    <?php
                                    include 'config.php';
                                    $query = mysqli_query($conn, "SELECT * FROM tb_level");

                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $id = $row['id_level'];
                                        $nama_level = $row['nama_level'];
                                        echo "<option value='$id'>$nama_level</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="col-form-label">Username:</label>
                                <input type="text" class="form-control" name="username" id="username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="modal-footer ">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success" name="tambah">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered mt-3 mb-5" id="tbl_user">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Karyawan</th>
                    <th>Level</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                include 'config.php';
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM tb_user JOIN tb_karyawan ON tb_user.id_karyawan = tb_karyawan.id_karyawan JOIN tb_level ON tb_user.id_level = tb_level.id_level");
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td> <?php echo $data['id_user']; ?> </td>
                        <td> <?php echo $data['nama_karyawan']; ?> </td>
                        <td> <?php echo $data['nama_level']; ?> </td>
                        <td> <?php echo $data['username']; ?> </td>
                        <td> <?php echo $data['password']; ?> </td>
                        <td class="d-flex"> <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#modalUbah<?php echo $data['id_user']; ?>">
                                Ubah
                            </button>
                            <form action="" method="post">
                                <div class="modal fade" id="modalUbah<?php echo $data['id_user']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="id2" class="col-form-label">Id User:</label>
                                                    <input type="text" class="form-control" name="id2" id="id2" value="<?php echo $data['id_user']; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="karyawan2" class="col-form-label">Karyawan:</label>
                                                    <select name="karyawan2" id="karyawan2" class="form-select shadow bg-body-tertiary rounded">
                                                        <?php
                                                        include 'config.php';
                                                        $query2 = mysqli_query($conn, "SELECT * FROM tb_karyawan");
                                                        while ($row = mysqli_fetch_array($query2)) {
                                                            $selected = null;
                                                            if ($data['id_karyawan'] == $row['id_karyawan']) {
                                                                $selected = 'selected';
                                                            }
                                                            $id = $row['id_karyawan'];
                                                            $nama_karyawan = $row['nama_karyawan'];
                                                            echo "<option value='$id' $selected>$nama_karyawan</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="level2" class="col-form-label">Level:</label>
                                                    <select name="level2" id="level2" class="form-select shadow bg-body-tertiary rounded">
                                                        <?php
                                                        include 'config.php';
                                                        $query2 = mysqli_query($conn, "SELECT * FROM tb_level");
                                                        while ($row = mysqli_fetch_array($query2)) {
                                                            $selected = null;
                                                            if ($data['id_level'] == $row['id_level']) {
                                                                $selected = 'selected';
                                                            }
                                                            $id = $row['id_level'];
                                                            $nama_level = $row['nama_level'];
                                                            echo "<option value='$id' $selected>$nama_level</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="username2" class="col-form-label">Username:</label>
                                                    <input type="text" class="form-control" name="username2" id="username2" value="<?php echo $data['username']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password2" class="col-form-label">Password:</label>
                                                    <input type="password" class="form-control" name="password2" id="password2" value="<?php echo $data['password']; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" name="ubah">Ubah</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?php echo $data['id_user']; ?>">
                                Hapus
                            </button>
                            <div class="modal fade" id="modalHapus<?php echo $data['id_user']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah anda yakin?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                            <a class="btn btn-danger" href="user.php?id_user=<?php echo $data['id_user']; ?>" name="hapus">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                    $no++;
                }

                if (isset($_POST['ubah'])) {

                    $id2 = $_POST['id2'];
                    $karyawan2 = $_POST['karyawan2'];
                    $level2 = $_POST['level2'];
                    $username2 = $_POST['username2'];
                    $password2 = $_POST['password2'];

                    $passwordd = password_hash($password2, PASSWORD_DEFAULT);

                    $sql3 = mysqli_query($conn, "UPDATE tb_user SET id_user='$id2', id_karyawan='$karyawan2', id_level='$level2', username='$username2', password='$passwordd' WHERE id_user = '$id2' ");

                    if ($sql3) {
                        echo "<meta http-equiv='refresh' content=0.1; url=apotek/user.php>";
                    }
                }

                if (isset($_GET['id_user'])) {
                    $idhapus = $_GET['id_user'];
                    $query3 = mysqli_query($conn, "DELETE FROM tb_user WHERE id_user = '$idhapus'");
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $('#tbl_user').DataTable()
    </script>
</body>

</html>