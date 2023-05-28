<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include 'config.php';



if (isset($_POST['tambah'])) {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $kategori = $_POST['kategori'];
    $rak = $_POST['rak'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    $sql = mysqli_query($conn, "INSERT INTO tb_obat (id_obat, nama_obat, id_jenis, id_kategori, id_rak, stock_obat, harga, status_obat) VALUES ('$id', '$nama', '$jenis', '$kategori', '$rak', '$stock', '$harga', '$status')");
}

$sql2 = mysqli_query($conn, "SELECT id_obat FROM tb_obat ORDER BY id_obat DESC LIMIT 1");
$row2 = mysqli_fetch_assoc($sql2);
if ($row2) {
    $lastId = $row2['id_obat'];
    $lastNumber = substr($lastId, 2);
    $newNumber = intval($lastNumber) + 1;
    $newId = "OT" . $newNumber;
} else {
    $newId = "OT1";
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apotek | Obat</title>
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
                <button class="btn btn-light w-100 dropdown-toggle active" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Data Master
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a href="obat.php" class="dropdown-item active">Obat</a></li>
                    <li><a href="jenis.php" class="dropdown-item">Jenis Obat</a></li>
                    <li><a href="kategori.php" class="dropdown-item">Kategori Obat</a></li>
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
                <a href="level.php" class="btn btn-light w-100 mb-3">Level</a>
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
        <h1 class="text-center mt-3 mb-3">Obat</h1>
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
                                <label for="id" class="col-form-label">Id obat:</label>
                                <input type="text" class="form-control" name="id" id="id" value="<?php echo $newId; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="col-form-label">Nama obat:</label>
                                <input type="text" class="form-control" name="nama" id="nama">
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="col-form-label">Jenis obat:</label>
                                <select name="jenis" id="jenis" class="form-select shadow bg-body-tertiary rounded">
                                    <?php
                                    include 'config.php';
                                    $query = mysqli_query($conn, "SELECT * FROM tb_jenis");

                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $id = $row['id_jenis'];
                                        $nama_jenis = $row['nama_jenis'];
                                        echo "<option value='$id'>$nama_jenis</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="col-form-label">Kategori obat:</label>
                                <select name="kategori" id="kategori" class="form-select shadow bg-body-tertiary rounded">
                                    <?php
                                    include 'config.php';
                                    $query = mysqli_query($conn, "SELECT * FROM tb_kategori");

                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $id = $row['id_kategori'];
                                        $nama_kategori = $row['nama_kategori'];
                                        echo "<option value='$id'>$nama_kategori</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="rak" class="col-form-label">Rak obat:</label>
                                <select name="rak" id="rak" class="form-select shadow bg-body-tertiary rounded">
                                    <?php
                                    include 'config.php';
                                    $query = mysqli_query($conn, "SELECT * FROM tb_rak");

                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $id = $row['id_rak'];
                                        $no_rak = $row['no_rak'];
                                        echo "<option value='$id'>$no_rak</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="col-form-label">Stock obat:</label>
                                <input type="text" class="form-control" name="stock" id="stock">
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="col-form-label">Harga obat:</label>
                                <input type="text" class="form-control" name="harga" id="harga">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="col-form-label">Status:</label>
                                <select name="status" id="status" class="form-select shadow bg-body-tertiary rounded">
                                    <option value="tersedia">tersedia</option>
                                    <option value="kosong">kosong</option>
                                </select>
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
        <table class="table table-striped table-bordered mt-3 mb-5" id="tbl_obat">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Kategori</th>
                    <th>Rak</th>
                    <th>Stock</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                include 'config.php';
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM tb_obat JOIN tb_jenis ON tb_obat.id_jenis = tb_jenis.id_jenis JOIN tb_kategori ON tb_obat.id_kategori = tb_kategori.id_kategori JOIN tb_rak ON tb_obat.id_rak = tb_rak.id_rak");
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td> <?php echo $data['id_obat']; ?> </td>
                        <td> <?php echo $data['nama_obat']; ?> </td>
                        <td> <?php echo $data['nama_jenis']; ?> </td>
                        <td> <?php echo $data['nama_kategori']; ?> </td>
                        <td> <?php echo $data['no_rak']; ?> </td>
                        <td> <?php echo $data['stock_obat']; ?> </td>
                        <td> <?php echo $data['harga']; ?> </td>
                        <td> <?php echo $data['status_obat']; ?> </td>
                        <td class="d-flex"> <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#modalUbah<?php echo $data['id_obat']; ?>">
                                Ubah
                            </button>
                            <form action="" method="post">
                                <div class="modal fade" id="modalUbah<?php echo $data['id_obat']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="id2" class="col-form-label">Id Obat:</label>
                                                    <input type="text" class="form-control" name="id2" id="id2" value="<?php echo $data['id_obat']; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama2" class="col-form-label">Nama Obat:</label>
                                                    <input type="text" class="form-control" name="nama2" id="nama2" value="<?php echo $data['nama_obat']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis2" class="col-form-label">Jenis Obat:</label>
                                                    <select name="jenis2" id="jenis2" class="form-select shadow bg-body-tertiary rounded">
                                                        <?php
                                                        include 'config.php';
                                                        $query2 = mysqli_query($conn, "SELECT * FROM tb_jenis");
                                                        while ($row = mysqli_fetch_array($query2)) {
                                                            $selected = null;
                                                            if ($data['id_jenis'] == $row['id_jenis']) {
                                                                $selected = 'selected';
                                                            }
                                                            $id = $row['id_jenis'];
                                                            $nama_jenis = $row['nama_jenis'];
                                                            echo "<option value='$id' $selected>$nama_jenis</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kategori2" class="col-form-label">Kategori Obat:</label>
                                                    <select name="kategori2" id="kategori2" class="form-select shadow bg-body-tertiary rounded">
                                                        <?php
                                                        include 'config.php';
                                                        $query2 = mysqli_query($conn, "SELECT * FROM tb_kategori");
                                                        while ($row = mysqli_fetch_array($query2)) {
                                                            $selected = null;
                                                            if ($data['id_kategori'] == $row['id_kategori']) {
                                                                $selected = 'selected';
                                                            }
                                                            $id = $row['id_kategori'];
                                                            $nama_kategori = $row['nama_kategori'];
                                                            echo "<option value='$id' $selected>$nama_kategori</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rak2" class="col-form-label">Rak Obat:</label>
                                                    <select name="rak2" id="rak2" class="form-select shadow bg-body-tertiary rounded">
                                                        <?php
                                                        include 'config.php';
                                                        $query2 = mysqli_query($conn, "SELECT * FROM tb_rak");
                                                        while ($row = mysqli_fetch_array($query2)) {
                                                            $selected = null;
                                                            if ($data['id_rak'] == $row['id_rak']) {
                                                                $selected = 'selected';
                                                            }
                                                            $id = $row['id_rak'];
                                                            $no_rak = $row['no_rak'];
                                                            echo "<option value='$id' $selected>$no_rak</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="stock2" class="col-form-label">Stock Obat:</label>
                                                    <input type="text" class="form-control" name="stock2" id="stock2" value="<?php echo $data['stock_obat']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="harga2" class="col-form-label">Harga Obat:</label>
                                                    <input type="text" class="form-control" name="harga2" id="harga2" value="<?php echo $data['harga']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status2" class="col-form-label">Status Obat:</label>
                                                    <select name="status2" id="status2" class="form-select shadow bg-body-tertiary rounded">
                                                        <option value="tersedia" <?php if ($data['status_obat'] == "tersedia") {
                                                                                        echo "selected";
                                                                                    } ?>>tersedia</option>
                                                        <option value="kosong" <?php if ($data['status_obat'] == "kosong") {
                                                                                    echo "selected";
                                                                                } ?>>kosong</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" name="ubah">Ubah</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?php echo $data['id_obat']; ?>">
                                Hapus
                            </button>
                            <div class="modal fade" id="modalHapus<?php echo $data['id_obat']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <a class="btn btn-danger" href="obat.php?id_obat=<?php echo $data['id_obat']; ?>" name="hapus">Hapus</a>
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
                    $nama2 = $_POST['nama2'];
                    $jenis2 = $_POST['jenis2'];
                    $kategori2 = $_POST['kategori2'];
                    $rak2 = $_POST['rak2'];
                    $stock2 = $_POST['stock2'];
                    $harga2 = $_POST['harga2'];
                    $status2 = $_POST['status2'];

                    $sql3 = mysqli_query($conn, "UPDATE tb_obat SET id_obat='$id2', nama_obat='$nama2', id_jenis='$jenis2', id_kategori='$kategori2', id_rak='$rak2', stock_obat='$stock2', harga='$harga2', status_obat='$status2' WHERE id_obat = '$id2' ");

                    if ($sql3) {
                        echo "<meta http-equiv='refresh' content=0.1; url=apotek/obat.php>";
                    }
                }

                if (isset($_GET['id_obat'])) {
                    $idhapus = $_GET['id_obat'];
                    $query3 = mysqli_query($conn, "DELETE FROM tb_obat WHERE id_obat = '$idhapus'");
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $('#tbl_obat').DataTable()
    </script>
</body>

</html>