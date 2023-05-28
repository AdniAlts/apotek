<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include 'config.php';



if (isset($_POST['tambah'])) {

    $id = $_POST['id'];
    $level = $_POST['level'];

    $sql = mysqli_query($conn, "INSERT INTO tb_level (id_level, nama_level) VALUES ('$id', '$level')");
}

$sql2 = mysqli_query($conn, "SELECT id_level FROM tb_level ORDER BY id_level DESC LIMIT 1");
$row2 = mysqli_fetch_assoc($sql2);
if ($row2) {
    $lastId = $row2['id_level'];
    $lastNumber = substr($lastId, 3);
    $newNumber = intval($lastNumber) + 1;
    $newId = "LVL" . $newNumber;
} else {
    $newId = "LVL1";
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apotek | Level</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-bodytertiary bg-secondary">
        <div class="container-fluid">
            <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><span class="navbar-toggler-icon"></span></button>
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
                <button class="btn btn-light w-100 dropdown-toggle " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Data Master
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a href="obat.php" class="dropdown-item ">Obat</a></li>
                    <li><a href="jenis.php" class="dropdown-item ">Jenis Obat</a></li>
                    <li><a href="kategori.php" class="dropdown-item ">Kategori Obat</a></li>
                    <li><a href="rak.php" class="dropdown-item">Rak</a></li>
                </ul>
            </div>
            <div class="karyawan">
                <a href="karyawan.php" class="btn btn-light w-100 mb-3">Karyawan</a>
            </div>
            <div class="user">
                <a href="user.php" class="btn btn-light w-100 mb-3">User</a>
            </div>
            <div class="level">
                <a href="level.php" class="btn btn-light w-100 mb-3 active">Level</a>
            </div>
            <div class="transaksi">
                <a href="" class="btn btn-light w-100 mb-3">Transaksi</a>
            </div>
            <div class="logout">
                <a href="logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h1 class="text-center mt-3 mb-3">Level</h1>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah" data-bs-whatever="@getbootstrap">Tambah Data</button>
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary" data-bs-theme="dark">
                        <h1 class="modal-title fs-5  text-light" id="exampleModalLabel">Tambah Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="id" class="col-form-label">Id Level:</label>
                                <input type="text" class="form-control" name="id" id="id" value="<?php echo $newId; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="level" class="col-form-label">Level:</label>
                                <input type="text" class="form-control" name="level" id="level">
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
        <table class="table table-striped table-bordered mt-3 mb-5" id="tbl_level">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                include 'config.php';
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM tb_level");
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td> <?php echo $data['id_level']; ?> </td>
                        <td> <?php echo $data['nama_level']; ?> </td>
                        <td class="d-flex"> <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#modalUbah<?php echo $data['id_level']; ?>">
                                Ubah
                            </button>
                            <form action="" method="post">
                                <div class="modal fade" id="modalUbah<?php echo $data['id_level']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="id2" class="col-form-label">Id Level:</label>
                                                    <input type="text" class="form-control" name="id2" id="id2" value="<?php echo $data['id_level']; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="level2" class="col-form-label">Level:</label>
                                                    <input type="text" class="form-control" name="level2" id="level2" value="<?php echo $data['nama_level']; ?>">
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
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?php echo $data['id_level']; ?>">
                                Hapus
                            </button>
                            <div class="modal fade" id="modalHapus<?php echo $data['id_level']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <a class="btn btn-danger" href="level.php?id_level=<?php echo $data['id_level']; ?>" name="hapus">Hapus</a>
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
                    $level2 = $_POST['level2'];

                    $sql3 = mysqli_query($conn, "UPDATE tb_level SET id_level='$id2', nama_level='$level2' WHERE id_level = '$id2' ");

                    if ($sql3) {
                        echo "<meta http-equiv='refresh' content=0.1; url=apotek/level.php>";
                    }
                }

                if (isset($_GET['id_level'])) {
                    $idhapus = $_GET['id_level'];
                    $query3 = mysqli_query($conn, "DELETE FROM tb_level WHERE id_level = '$idhapus'");
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $('#tbl_level').DataTable()
    </script>
</body>

</html>