<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../login.php");
    exit;
}

include 'config.php';

if (isset($_POST['tambah'])) {
    $tanggal = $_POST['tanggal'];
    $user = $_POST['user'];

    $detail = $_POST['detail'];
    $id = $_POST['id'];
    $obat = $_POST['obat'];
    $qty = $_POST['qty'];
    $sub = $_POST['sub'];

    $sqll = mysqli_query($conn, "INSERT INTO tb_transaksi (id_transaksi, tgl_transaksi, id_user) VALUES ('$id', '$tanggal', '$user')");

    $sql = mysqli_query($conn, "INSERT INTO tb_detail_transaksi (id_detail, id_transaksi, id_obat, qty, sub_total) VALUES ('$detail', '$id', '$obat', '$qty', '$sub')");
}

if (isset($_POST['bayar'])) {
    // var_dump($_POST);
    // die;
    $tanggal = $_POST['tanggal'];
    $user = $_POST['user'];

    $detail = $_POST['detail'];
    $id = $_POST['id'];
    // $obat = $_POST['obat'];
    // $qty = $_POST['qty'];
    // $sub = $_POST['sub'];

    // var_dump($_POST['obat']);
    // die;
    $sqll = mysqli_query($conn, "INSERT INTO tb_transaksi (id_transaksi, tgl_transaksi, id_user) VALUES ('$id', '$tanggal', '$user')");
    // if ($sqll) {
    foreach ($_POST['obat'] as $key => $value) {
        // var_dump($_POST['sub']);
        // die;
        $qty = $_POST['qty'][$key];
        $sub = $_POST['sub'][$key];
        $sql = mysqli_query($conn, "INSERT INTO tb_detail_transaksi (id_detail, id_transaksi, id_obat, qty, sub_total) VALUES ('$detail', '$id', '$value', '$qty', '$sub')");
    }
    // } else {
    //     echo "Error inserting transaction: " . mysqli_error($conn);
    // }
}

// if (isset($_POST['bayar'])) {

//     $id = $_POST['id'];
//     $nama = $_POST['nama'];
//     $usia = $_POST['usia'];
//     $tlp = $_POST['tlp'];
//     $grand = $_POST['grand'];

//     $sql4 = mysqli_query($conn, "UPDATE tb_transaksi SET grand_total='$grand', nama_plngn='$nama', usia='$usia', no_tlp='$tlp' WHERE id_transaksi = '$id' ");
// }

$sql2 = mysqli_query($conn, "SELECT id_transaksi FROM tb_transaksi ORDER BY id_transaksi  DESC LIMIT 1");
$row2 = mysqli_fetch_assoc($sql2);
if ($row2) {
    $lastId = $row2['id_transaksi'];
    $lastNumber = substr($lastId, 4);
    $newNumber = intval($lastNumber) + 1;
    $newId = "TRNS" . $newNumber;
} else {
    $newId = "TRNS1";
}

$sql3 = mysqli_query($conn, "SELECT id_detail FROM tb_detail_transaksi ORDER BY id_detail DESC LIMIT 1");
$row3 = mysqli_fetch_assoc($sql3);
if ($row3) {
    $lastId = $row3['id_detail'];
    $newNumber = intval($lastId) + 1;
    $newId2 = $newNumber;
} else {
    $newId2 = "1";
}
?>
<!doctype html>
<html lang="en">

<head>
    <script>
        function calculateSubtotal() {
            var qty = document.getElementById("qty").value;
            var select = document.getElementById("obat");
            var hargaObat = select.options[select.selectedIndex].getAttribute("data-harga");

            var subtotal = qty * hargaObat;
            document.getElementById("sub").value = subtotal;
        }

        function calculateSubtotal2() {
            var qty2 = document.getElementById("qty2").value;
            var select2 = document.getElementById("obat2");
            var hargaObat2 = select.options[select.selectedIndex].getAttribute("data-harga2");

            var subtotal2 = qty2 * hargaObat2;
            document.getElementById("sub2").value = subtotal2;
        }
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apotek | Transaksi</title>
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
            <div class="transaksi">
                <a href="transaksi.php" class="btn btn-light w-100 mb-3 active">Transaksi</a>
            </div>
            <div class="logout">
                <a href="logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
            </div>
        </div>
    </div>
    <h1 class="text-center mt-3 mb-3">Transaksi</h1>
    <div class="container">
        <!-- <form action="" method="post">
            <div class=" d-flex flex-col justify-content-between mb-4">
                <div class="card bg-secondary mt-3" style="width: 30rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div>
                                <label for="id" class="col-form-label">Id Transaksi:</label>
                                <input type="text" class="form-control" name="id" id="id" value="<?php echo $newId ?>" readonly>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <label for="tanggal" class="col-form-label">Tanggal</label>
                                <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>" readonly>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <label for="user" class="col-form-label">User</label>
                                <select name="user" id="user" class="form-select bg-body-tertiary rounded mb-2">
                                    <option value="<?php echo $_SESSION["id"] ?>"><?= $_SESSION["nama"]; ?></option>
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card bg-secondary mt-3" style="width: 30rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div>
                                <input type="hidden" name="detail" id="detail" class="form-control" value="<?php echo $newId2; ?>">
                                <label for="obat" class="col-form-label">Obat:</label>
                                <select name="obat" id="obat" class="form-select bg-body-tertiary rounded" onchange="calculateSubtotal()">
                                    <?php
                                    include 'config.php';
                                    $query = mysqli_query($conn, "SELECT * FROM tb_obat");

                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $id = $row['id_obat'];
                                        $harga = $row['harga'];
                                        $nama_obat = $row['nama_obat'];
                                        echo '<option value="' . $id . '" data-harga="' . $harga . '">' . $nama_obat . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <label for="qty" class="col-form-label">Qty:</label>
                                <input type="text" class="form-control" name="qty" id="qty" oninput="calculateSubtotal()">
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-end">
                            <div class="w-75">
                                <label for="sub" class="col-form-label">Sub Total:</label>
                                <input type="text" class="form-control mb-2" name="sub" id="sub" readonly>
                            </div>
                            <div class=" ms-auto mb-2">
                                <button type="submit" class="btn btn-primary" name="tambah">Tambah</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class=" d-flex flex-col justify-content-between mb-5">
                <div class="card bg-secondary mt-3" style="width: 30rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div>
                                <label for="nama" class="col-form-label">Nama Pelanggan:</label>
                                <input type="text" class="form-control" name="nama" id="nama">
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <label for="usia" class="col-form-label">Usia:</label>
                                <input type="text" class="form-control" name="usia" id="usia" readonly>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <label for="tlp" class="col-form-label">No Telepon:</label>
                                <input type="text" class="form-control" name="tlp" id="tlp" readonly>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card bg-secondary mt-3" style="width: 30rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div>
                                <label for="grand" class="col-form-label">Grand Total:</label>
                                <input type="text" class="form-control" name="grand" id="grand" readonly>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <label for="cash" class="col-form-label">Cash:</label>
                                <input type="text" class="form-control" name="cash" id="cash">
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-end">
                            <div class="w-75">
                                <label for="change" class="col-form-label">Change:</label>
                                <input type="text" class="form-control" name="change" id="change" readonly>
                            </div>
                            <div class="ms-5">
                                <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
                                <button type="submit" class="btn btn-success" name="bayar">Bayar</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </form> -->
        <form action="" method="post">
            <div class="card p-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="id_transaksi">Id Transaksi</label>
                            <input type="text" name="id" id="id" class="form-control" value="<?php echo $newId ?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="user">User</label>
                            <select name="user" id="user" class="form-select bg-body-tertiary rounded mb-2">
                                <option value="<?php echo $_SESSION["id"] ?>"><?= $_SESSION["nama"]; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="nama" class="col-form-label">Nama Pelanggan:</label>
                            <input type="text" class="form-control" name="nama" id="nama">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="usia" class="col-form-label">Usia:</label>
                            <input type="text" class="form-control" name="usia" id="usia">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="tlp" class="col-form-label">No Telepon:</label>
                            <input type="text" class="form-control" name="tlp" id="tlp">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="hidden" name="detail" id="detail" class="form-control" value="<?php echo $newId2; ?>">
                            <label for="obat" class="col-form-label">Obat:</label>
                            <select name="obat[]" id="obat" class="form-select bg-body-tertiary rounded" onchange="calculateSubtotal()">
                                <?php
                                include 'config.php';
                                $query = mysqli_query($conn, "SELECT * FROM tb_obat");

                                while ($row = mysqli_fetch_assoc($query)) {
                                    $id = $row['id_obat'];
                                    $harga = $row['harga'];
                                    $nama_obat = $row['nama_obat'];
                                    echo '<option value="' . $id . '" data-harga="' . $harga . '">' . $nama_obat . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="qty" class="col-form-label">Qty:</label>
                            <input type="text" class="form-control" name="qty[]" id="qty" oninput="calculateSubtotal()">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="sub" class="col-form-label">Sub Total:</label>
                            <input type="text" class="form-control mb-2" name="sub[]" id="sub" readonly>
                        </div>
                    </div>
                    <div id="additionalInputs"></div>
                    <div class="col-lg-12 p-4">
                        <button type="button" class="btn btn-outline-primary" onclick="addInput()">Tambah Obat</button>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="grand" class="col-form-label">Grand Total:</label>
                            <input type="text" class="form-control" name="grand" id="grand" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="cash" class="col-form-label">Cash:</label>
                            <input type="text" class="form-control" name="cash" id="cash">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="change" class="col-form-label">Change:</label>
                            <input type="text" class="form-control" name="change" id="change" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 p-4">
                        <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
                        <button type="submit" class="btn btn-success" name="bayar">Bayar</button>
                    </div>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered mt-4" id="tbl_detail">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Obat</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                include 'config.php';
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM tb_detail_transaksi JOIN tb_obat ON tb_obat.id_obat = tb_detail_transaksi.id_obat JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_detail_transaksi.id_transaksi");
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td> <?php echo $data['id_detail']; ?> </td>
                        <td> <?php echo $data['nama_obat']; ?> </td>
                        <td> <?php echo $data['harga']; ?> </td>
                        <td> <?php echo $data['qty']; ?> </td>
                        <td> <?php echo $data['sub_total']; ?> </td>
                        <td class="d-flex"> <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#modalUbah<?php echo $data['id_detail']; ?>">
                                Ubah
                            </button>
                            <form action="" method="post">
                                <div class="modal fade" id="modalUbah<?php echo $data['id_detail']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="id2" class="col-form-label">Id Detail:</label>
                                                    <input type="text" class="form-control" name="id2" id="id2" value="<?php echo $data['id_detail']; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="obat2" class="col-form-label">Obat:</label>
                                                    <select name="obat2" id="obat2" class="form-select shadow bg-body-tertiary rounded" onchange="calculateSubtotal2()">
                                                        <?php
                                                        include 'config.php';
                                                        $query2 = mysqli_query($conn, "SELECT * FROM tb_obat");
                                                        while ($row = mysqli_fetch_array($query2)) {
                                                            $selected = null;
                                                            if ($data['id_obat'] == $row['id_obat']) {
                                                                $selected = 'selected';
                                                            }
                                                            $id = $row['id_obat'];
                                                            $nama_obat = $row['nama_obat'];
                                                            echo '<option value="' . $id . '" data-harga2="' . $harga . '"' . $selected . '>' . $nama_obat . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="harga2" class="col-form-label">Harga Obat:</label>
                                                    <input type="text" class="form-control" name="harga2" id="harga2" value="<?php echo $data['harga']; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="qty2" class="col-form-label">Qty:</label>
                                                    <input type="text" class="form-control" name="qty2" id="qty2" value="<?php echo $data['qty']; ?>" oninput="calculateSubtotal2()">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="sub2" class="col-form-label">Sub Total:</label>
                                                    <input type="text" class="form-control" name="sub2" id="sub2" value="<?php echo $data['sub_total']; ?>" readonly>
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
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?php echo $data['id_detail']; ?>">
                                Hapus
                            </button>
                            <div class="modal fade" id="modalHapus<?php echo $data['id_detail']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <a class="btn btn-danger" href="transaksi.php?id_detail=<?php echo $data['id_detail']; ?>" name="hapus">Hapus</a>
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

                if (isset($_GET['id_detail'])) {
                    $idhapus = $_GET['id_detail'];
                    $query3 = mysqli_query($conn, "DELETE FROM tb_detail_transaksi WHERE id_detail = '$idhapus'");
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $('#tbl_detail').DataTable()

        function addInput() {
            var count = parseInt(document.getElementById("count").value);
            var newCount = count + 1;
            document.getElementById("count").value = newCount;

            var newDiv = document.createElement("div");
            newDiv.innerHTML = `
    <div class="col-lg-4">
      <div class="form-group">
        <label for="obat${newCount}">Obat</label>
        <select class="form-control" id="obat${newCount}" name="obat${newCount}" onchange="calculateSubtotal${newCount}()">
          <option value="" selected readonly>Pilih Obat</option>
          <?php
            $query = mysqli_query($conn, "SELECT * FROM tb_obat");
            while ($row = mysqli_fetch_assoc($query)) {
                echo '<option value="' . $row['id_obat'] . '" data-harga="' . $row['harga'] . '">' . $row['nama_obat'] . '</option>';
            }
            ?>
        </select>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group">
        <label for="qty${newCount}">Qty</label>
        <input type="number" class="form-control" id="qty${newCount}" name="qty${newCount}" oninput="calculateSubtotal${newCount}()">
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group">
        <label for="sub${newCount}">Subtotal</label>
        <input type="text" class="form-control" id="sub${newCount}" name="sub${newCount}" readonly>
      </div>
    </div>
  `;

            var divContainer = document.getElementById("additionalInputs");
            divContainer.appendChild(newDiv);
        }
    </script>
</body>

</html>