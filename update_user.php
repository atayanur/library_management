<?php

require_once "include/koneksi.php";
session_start();

$sql = "SELECT * FROM user WHERE id_user='$_GET[id]'";
$result = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_assoc($result)


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit | User</title>

    
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    
    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div>Perpustakaan</div>
            </a>

            
            <hr class="sidebar-divider my-0">


            
            <hr class="sidebar-divider">

            
            <div class="sidebar-heading">
                MAIN NAVIGATION
            </div>
            
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            
            <li class="nav-item active">
                <a class="nav-link" href="tbl_user.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Data User</span></a>
            </li>

            
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Anggota</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="tbl_siswa.php">Data Siswa</a>
                        <a class="collapse-item" href="tbl_guru.php">Data Guru</a>
                    </div>
                </div>
            </li>

            
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="tbl_buku.php">Daftar Buku</a>
                        <a class="collapse-item" href="tbl_kategori.php">Kategori Buku</a>
                        <a class="collapse-item" href="tbl_rak.php">Rak Buku</a>
                    </div>
                </div>
            </li>

            
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Transaksi</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="tbl_peminjaman.php">Peminjaman Buku</a>
                        <a class="collapse-item" href="tbl_pengembalian.php">Pengembalian Buku</a>
                    </div>
                </div>
            </li>

            
            <li class="nav-item">
                <a class="nav-link" href="tbl_denda.php">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span>Denda</span></a>
            </li>


            
            <hr class="sidebar-divider d-none d-md-block">

            
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        


        
        <div id="content-wrapper" class="d-flex flex-column">

            
            <div id="content">

                
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <img class="col-md-1 profile-user-img img-responsive img-circle" src="img/logo_smk4.jpeg">

                    
                    <ul class="navbar-nav ml-auto">
                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['username']; ?></span>
                                <img class="img-profile rounded-circle" src="img/<?php echo $_SESSION['foto']; ?>">
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profil.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                
                <div class="container-fluid">

                    
                    <div class="row">

                        <div class="col-lg-12">

                            
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
                                </div>
                                <div class="card-body">



                                    <form method="POST" action="update_user_aksi.php" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label>ID User</label>
                                                <input type="text" name="id_user" class="form-control" value="<?php echo $row['id_user']; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Username</label>
                                                <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control" value="<?php echo $row['email']; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Password</label>
                                                <input type="text" name="password" class="form-control" value="<?php echo $row['password']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label>Tempat Lahir</label>
                                                <input type="text" name="tempat_lahir" class="form-control" value="<?php echo $row['tempat_lahir']; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label>Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control" required="required">
                                                    <option>- Pilih -</option>
                                                    <option>Laki - Laki</option>
                                                    <option>Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Alamat Domisili</label>
                                                <input type="text" name="alamat_domisili" class="form-control" value="<?php echo $row['alamat_domisili']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label>Nomor Hp</label>
                                                <input type="text" name="nomor_hp" class="form-control" value="<?php echo $row['nomor_hp']; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Foto</label>
                                                <input type="file" name="foto" class="form-control">
                                            </div>
                                        </div>
                                        <hr>
                                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                        <button type="reset" name="reset" class="btn btn-danger">Reset</button>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                






            </div>
            
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span><b>SISTEM INFORMASI PERPUSTAKAAN</b></span>
                    </div>
                </div>
            </footer>
           

        </div>
       

    </div>
    
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    
    <script src="js/sb-admin-2.min.js"></script>

    
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>