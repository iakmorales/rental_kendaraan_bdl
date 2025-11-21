<style>
    .sidebar {
        width: 250px;
        background-color: white;
        padding: 2rem 0;
        box-shadow: 2px 0 10px rgba(0,0,0,0.05);
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .menu-item {
        padding: 0;
    }

    .menu-item a {
        padding: 0.875rem 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #666;
        font-weight: 500;
        text-decoration: none;
        transition: 0.3s ease;
        border-left: 3px solid transparent;
    }

    .menu-item a:hover {
        background-color: #FFF8E1;
        border-left-color: #FFD100;
        color: #202020;
    }

    .menu-item a.active {
        background-color: #FFEE32;
        border-left-color: #FFD100;
        color: #202020;
    }

    .menu-icon {
        width: 20px;
        display: flex;
        justify-content: center;
    }
</style>

<?php 
// ambil action sekarang agar auto-active
$current = isset($_GET['action']) ? $_GET['action'] : 'dashboard';
?>

<aside class="sidebar">
    <ul class="sidebar-menu">

        <li class="menu-item">
            <a href="index.php?action=dashboard" class="<?= $current=='dashboard'?'active':'' ?>">
                <span class="menu-icon">📊</span>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=tipe_kendaraan" class="<?= $current=='tipe_kendaraan'?'active':'' ?>">
                <span class="menu-icon">🚗</span>
                <span>Tipe Kendaraan</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=kendaraan" class="<?= $current=='kendaraan'?'active':'' ?>">
                <span class="menu-icon">🚙</span>
                <span>Kendaraan</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=sopir" class="<?= $current=='sopir'?'active':'' ?>">
                <span class="menu-icon">🧑‍✈️</span>
                <span>Sopir</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=penyewa" class="<?= $current=='penyewa'?'active':'' ?>">
                <span class="menu-icon">👤</span>
                <span>Penyewa</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=rental" class="<?= $current=='rental'?'active':'' ?>">
                <span class="menu-icon">📄</span>
                <span>Rental</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=pengembalian" class="<?= $current=='pengembalian'?'active':'' ?>">
                <span class="menu-icon">↩️</span>
                <span>Pengembalian</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=pengembalian" class="<?= $current=='pengembalian'?'active':'' ?>">
                <span class="menu-icon">↩️</span>
                <span>User</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=logout" class="<?= $current=='logout'?'active':'' ?>">
                <span class="menu-icon">🚪</span>
                <span>Logout</span>
            </a>
        </li>

    </ul>
</aside>
