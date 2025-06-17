<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="./dashboard.php" class="app-brand-link">
      <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">LIBRARY</span>
    </a>
    
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>
  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item">
      <a href="dashboard.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <!-- Menu Admin -->
    <?php if ($_SESSION['role'] === 'admin'): ?>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Fitur Admin</span></li>
      <li class="menu-item">
        <a href="daftar_buku.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-book"></i>
          <div>Data Buku</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="peminjaman_admin.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-bookmark-alt"></i>
          <div>Peminjaman</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="users.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div>Anggota</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="reports.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
          <div>Laporan</div>
        </a>
      </li>
    <?php endif; ?>

    <!-- Menu Anggota -->
    <?php if ($_SESSION['role'] === 'anggota'): ?>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Fitur Anggota</span></li>
      <li class="menu-item">
        <a href="daftar_buku.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-book"></i>
          <div>Daftar Buku</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="peminjaman_anggota.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-bookmark"></i>
          <div>Peminjaman Saya</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="riwayat_peminjaman.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-history"></i>
          <div>Riwayat Peminjaman</div>
        </a>
      </li>
    <?php endif; ?>

    <li class="menu-item">
      <a href="./auth/logout.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-log-out"></i>
        <div>Logout</div>
      </a>
    </li>
  </ul>
</aside>
