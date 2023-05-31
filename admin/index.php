<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: ../login.php");
  exit;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Apotek | Home Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body class="bg-light-50">

  <nav class="navbar sticky-top bg-bodytertiary bg-info bg-gradient">
    <div class="container-fluid">
      <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><span class="navbar-toggler-icon"></span></button>
      <h3 class="me-3 fw-bold">APOTEK CENTRAL</h3>
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
        <a href="index.php" class="btn btn-light w-100 active">Dashboard</a>
      </div>
      <div class="dropdown mb-3">
        <button class="btn btn-light w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Data Master
        </button>
        <ul class="dropdown-menu w-100">
          <li><a href="obat.php" class="dropdown-item ">Obat</a></li>
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
        <a href="user.php" class="btn btn-light w-100 mb-3">User</a>
      </div>
      <div class="transaksi">
        <a href="transaksi.php" class="btn btn-light w-100 mb-3">Transaksi</a>
      </div>
      <div class="logout">
        <a href="logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
      </div>
    </div>
  </div>
  <h1 class="text-center mt-3">Dashboard Admin</h1>
  <h3 class="text-center mt-2">Selamat Datang <?= $_SESSION["nama"]; ?></h3>
  <h5 class="text-center mt-5">Note*</h5>
  <p class="text-center">Refresh page setelah melakukan aksi delete</p>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>