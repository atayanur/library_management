<?php

$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse fixed-top">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <img src="img/logo_smk4.jpeg" alt="Logo" style="max-width: 150px;">
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'buku.php' ? 'active' : ''; ?>" href="buku.php">
                    <span data-feather="book"></span>
                    Data Buku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'peminjaman.php' ? 'active' : ''; ?>" href="peminjaman.php">
                    <span data-feather="file"></span>
                    Data Peminjaman
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'pengembalian.php' ? 'active' : ''; ?>" href="pengembalian.php">
                    <span data-feather="file"></span>
                    Data Pengembalian
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
.nav-link.active {
    background-color: #343a40; 
    color: #fff;
}
</style>
