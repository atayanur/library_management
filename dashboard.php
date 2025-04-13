<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
include('includes/header.php');
include('includes/navbar.php');
include('includes/config.php'); 
?>

<div class="container-fluid" style="margin-top: 56px;">
    <div class="row">
        <?php include('includes/sidebar.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Buku</h5>
                            <p class="card-text">
                                <?php
                                $query = "SELECT COUNT(*) as total_buku FROM buku";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo $row['total_buku'];
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Buku Dipinjam</h5>
                            <p class="card-text">
                                <?php
                                $query = "SELECT COUNT(*) as total_dipinjam FROM peminjaman WHERE status='dipinjam'";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo $row['total_dipinjam'];
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Pengembalian</h5>
                            <p class="card-text">
                                <?php
                                $query = "SELECT COUNT(*) as total_pengembalian FROM pengembalian";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo $row['total_pengembalian'];
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('includes/footer.php'); ?>
